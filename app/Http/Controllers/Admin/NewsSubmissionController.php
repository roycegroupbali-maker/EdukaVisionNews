<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsSubmissionStatusUpdated;
use App\Models\NewsSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class NewsSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $submissions = NewsSubmission::query()
            ->when($request->filled('status'), fn ($q) => $q->status($request->get('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pendingCount = NewsSubmission::status(NewsSubmission::STATUS_PENDING)->count();

        return view('admin.news-submissions.index', compact('submissions', 'pendingCount'));
    }

    public function show(NewsSubmission $newsSubmission): View
    {
        if ($newsSubmission->status === NewsSubmission::STATUS_PENDING) {
            $previousStatus = $newsSubmission->status;
            $newsSubmission->update(['status' => NewsSubmission::STATUS_REVIEWED]);

            try {
                Mail::to($newsSubmission->email)->send(
                    new NewsSubmissionStatusUpdated($newsSubmission, $previousStatus)
                );
            } catch (Throwable $e) {
                Log::warning('Gagal mengirim email update status permohonan berita: '.$e->getMessage(), [
                    'submission_id' => $newsSubmission->id,
                ]);
            }
        }

        return view('admin.news-submissions.show', ['submission' => $newsSubmission]);
    }

    public function updateStatus(Request $request, NewsSubmission $newsSubmission): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(NewsSubmission::STATUSES))],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $previousStatus = $newsSubmission->status;

        $newsSubmission->update($data);

        $statusChanged = $previousStatus !== $newsSubmission->status;

        if ($statusChanged) {
            try {
                Mail::to($newsSubmission->email)->send(
                    new NewsSubmissionStatusUpdated($newsSubmission, $previousStatus)
                );
            } catch (Throwable $e) {
                Log::warning('Gagal mengirim email update status permohonan berita: '.$e->getMessage(), [
                    'submission_id' => $newsSubmission->id,
                ]);
            }
        }

        return back()->with('status', $statusChanged
            ? 'Status pengajuan berita berhasil diperbarui dan notifikasi sudah dikirim ke email pengirim.'
            : 'Catatan pengajuan berita berhasil disimpan.');
    }

    public function destroy(NewsSubmission $newsSubmission): RedirectResponse
    {
        if ($newsSubmission->image_path) {
            Storage::disk('public')->delete($newsSubmission->image_path);
        }

        $newsSubmission->delete();

        return redirect()->route('admin.news-submissions.index')->with('status', 'Pengajuan berita berhasil dihapus.');
    }
}
