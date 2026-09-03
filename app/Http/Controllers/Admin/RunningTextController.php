<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RunningText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RunningTextController extends Controller
{
    public function index(): View
    {
        $runningTexts = RunningText::ordered()->get();

        return view('admin.running-texts.index', compact('runningTexts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['sort_order'] = $data['sort_order'] ?? ((int) RunningText::max('sort_order') + 1);
        $data['is_active'] = $request->boolean('is_active', true);

        RunningText::create($data);

        return back()->with('status', 'Running text baru berhasil ditambahkan.');
    }

    public function update(Request $request, RunningText $runningText): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        $runningText->update($data);

        return back()->with('status', 'Running text berhasil diperbarui.');
    }

    public function destroy(RunningText $runningText): RedirectResponse
    {
        $runningText->delete();

        return back()->with('status', 'Running text berhasil dihapus.');
    }

    public function toggleActive(RunningText $runningText): RedirectResponse
    {
        $runningText->update(['is_active' => ! $runningText->is_active]);

        return back()->with('status', $runningText->is_active ? 'Running text diaktifkan.' : 'Running text dinonaktifkan.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
