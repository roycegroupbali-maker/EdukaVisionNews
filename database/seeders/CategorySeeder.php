<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita Terkini', 'slug' => 'berita', 'tag_class' => 'berita', 'bar_color' => 'var(--pulse)', 'anchor' => 'berita', 'sort_order' => 1],
            ['name' => 'Dunia', 'slug' => 'dunia', 'tag_class' => 'dunia', 'bar_color' => 'var(--violet)', 'anchor' => 'dunia', 'sort_order' => 2],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'tag_class' => 'bisnis', 'bar_color' => 'var(--ink)', 'anchor' => 'bisnis', 'sort_order' => 3],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'tag_class' => 'olahraga', 'bar_color' => 'var(--navy2)', 'anchor' => 'olahraga', 'sort_order' => 4],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'tag_class' => 'lifestyle', 'bar_color' => 'var(--teal)', 'anchor' => 'lifestyle', 'sort_order' => 5],
            ['name' => 'Edukasi', 'slug' => 'edukasi', 'tag_class' => 'edukasi', 'bar_color' => 'var(--gold-deep)', 'anchor' => 'edukasi', 'sort_order' => 6],
            ['name' => 'Resep Masakan', 'slug' => 'resep', 'tag_class' => 'resep', 'bar_color' => 'var(--rust)', 'anchor' => 'resep', 'sort_order' => 7],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'tag_class' => 'berita', 'bar_color' => 'var(--navy2)', 'anchor' => null, 'sort_order' => 8],
            ['name' => 'Hiburan', 'slug' => 'hiburan', 'tag_class' => 'lifestyle', 'bar_color' => 'var(--violet)', 'anchor' => null, 'sort_order' => 9],
            ['name' => 'Opini', 'slug' => 'opini', 'tag_class' => 'edukasi', 'bar_color' => 'var(--gold-deep)', 'anchor' => null, 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
