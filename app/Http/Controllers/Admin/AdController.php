<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdController extends Controller
{
    public function index(): View
    {
        $ads = Ad::orderBy('slot')->orderBy('sort_order')->latest()->get()->groupBy('slot');

        return view('admin.ads.index', ['adsBySlot' => $ads, 'slots' => Ad::SLOTS]);
    }

    public function create(): View
    {
        return view('admin.ads.form', ['ad' => new Ad(['is_active' => true]), 'slots' => Ad::SLOTS, 'isEdit' => false]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        Ad::create($data);

        return redirect()->route('admin.ads.index')->with('status', 'Iklan baru berhasil ditambahkan.');
    }

    public function edit(Ad $ad): View
    {
        return view('admin.ads.form', ['ad' => $ad, 'slots' => Ad::SLOTS, 'isEdit' => true]);
    }

    public function update(Request $request, Ad $ad): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('status', 'Iklan berhasil diperbarui.');
    }

    public function destroy(Ad $ad): RedirectResponse
    {
        if ($ad->image_path) {
            Storage::disk('public')->delete($ad->image_path);
        }

        $ad->delete();

        return back()->with('status', 'Iklan berhasil dihapus.');
    }

    public function toggleActive(Ad $ad): RedirectResponse
    {
        $ad->update(['is_active' => ! $ad->is_active]);

        return back()->with('status', $ad->is_active ? 'Iklan diaktifkan.' : 'Iklan dinonaktifkan.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slot' => ['required', 'string', 'in:'.implode(',', array_keys(Ad::SLOTS))],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'target_url' => ['nullable', 'url', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:50'],
            'advertiser' => ['nullable', 'string', 'max:150'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
