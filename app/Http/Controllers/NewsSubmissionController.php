<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news-submissions', 'public');
        }

        unset($data['image']);
        $data['status'] = NewsSubmission::STATUS_PENDING;

        NewsSubmission::create($data);

        return redirect()
            ->route('news-submission.create')
            ->with('status', 'Terima kasih! Usulan berita kamu sudah kami terima dan akan ditinjau oleh redaksi.');
    }
}
