<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('articles')->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:categories,slug'],
            'tag_class' => ['nullable', 'string', 'max:50'],
            'bar_color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = $data['slug'] ?? '' ?: Str::slug($data['name']);
        $data['tag_class'] = $data['tag_class'] ?? '' ?: 'berita';
        $data['bar_color'] = $data['bar_color'] ?? '' ?: 'var(--red)';
        $data['sort_order'] = $data['sort_order'] ?? (Category::max('sort_order') + 1);

        Category::create($data);

        return back()->with('status', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:categories,slug,'.$category->id],
            'tag_class' => ['nullable', 'string', 'max:50'],
            'bar_color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $category->update($data);

        return back()->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->articles()->exists()) {
            return back()->withErrors(['category' => 'Kategori tidak bisa dihapus karena masih memiliki berita. Pindahkan atau hapus beritanya dulu.']);
        }

        $category->delete();

        return back()->with('status', 'Kategori berhasil dihapus.');
    }
}