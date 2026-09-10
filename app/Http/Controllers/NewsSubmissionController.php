<?php

namespace App\Http\Controllers;

use App\Mail\NewsSubmissionAdminNotification;
use App\Mail\NewsSubmissionReceived;
use App\Models\Category;
use App\Models\NewsSubmission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class NewsSubmissionController extends Controller
{
    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('news-submission.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{8,20}$/'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'],
        ], [
            'phone.regex' => 'Format nomor telepon tidak valid.',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news-submissions', 'public');
        }

        unset($data['image']);
        $data['status'] = NewsSubmission::STATUS_PENDING;

        $submission = NewsSubmission::create($data);

        try {
            Mail::to($submission->email)->send(new NewsSubmissionReceived($submission));
        } catch (Throwable $e) {
            Log::warning('Gagal mengirim email konfirmasi permohonan berita: '.$e->getMessage(), [
                'submission_id' => $submission->id,
            ]);
        }

        $adminEmails = User::where('is_admin', true)
            ->where('is_active', true)
            ->pluck('email');

        if ($adminEmails->isNotEmpty()) {
            try {
                Mail::to($adminEmails->all())->send(new NewsSubmissionAdminNotification($submission));
            } catch (Throwable $e) {
                Log::warning('Gagal mengirim email notifikasi admin untuk permohonan berita: '.$e->getMessage(), [
                    'submission_id' => $submission->id,
                ]);
            }
        } else {
            Log::warning('Tidak ada akun admin aktif untuk menerima notifikasi permohonan berita.', [
                'submission_id' => $submission->id,
            ]);
        }

        return redirect()
            ->route('news-submission.create')
            ->with('status', 'Terima kasih! Usulan berita kamu sudah kami terima dan akan ditinjau oleh redaksi. Konfirmasi juga sudah kami kirim ke email kamu.');
    }
}
