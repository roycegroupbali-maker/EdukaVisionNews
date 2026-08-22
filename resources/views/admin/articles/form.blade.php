@php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store');
@endphp

<x-admin-layout :page-title="$isEdit ? 'Edit Berita' : 'Tulis Berita Baru'" :page-subtitle="'Pilih kategori lalu isi konten beritanya'">

  <form method="POST" action="{{ $action }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Konten Berita</h3>

          <div class="field">
            <label for="titleInput">Judul Berita</label>
            <input type="text" id="titleInput" name="title" value="{{ old('title', $article->title) }}" required maxlength="255" placeholder="Judul berita yang menarik…">
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="slugInput">Slug URL <span style="font-weight:400; color:var(--muted-2);">(opsional, otomatis dari judul)</span></label>
            <input type="text" id="slugInput" name="slug" value="{{ old('slug', $article->slug) }}" maxlength="255" placeholder="judul-berita-otomatis">
            @error('slug')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="excerptInput">Ringkasan / Excerpt</label>
            <textarea id="excerptInput" name="excerpt" required maxlength="500" style="min-height:80px;" placeholder="Ringkasan singkat yang tampil di daftar berita…">{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="contentInput">Isi Berita</label>
            <textarea id="contentInput" name="content" required style="min-height:320px;" placeholder="Tulis isi berita di sini. Pisahkan tiap paragraf dengan baris kosong.">{{ old('content', $article->content) }}</textarea>
            <div class="field-hint">Pisahkan paragraf dengan baris kosong (Enter dua kali) agar tampil rapi di halaman berita.</div>
            @error('content')<div class="field-error">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="form-card">
          <h3>Khusus Resep Masakan <span style="font-weight:400; font-size:12.5px; color:var(--muted-2);">(isi jika kategori Resep Masakan)</span></h3>
          <div class="form-row">
            <div class="field">
              <label for="recipeMinutes">Waktu Masak (menit)</label>
              <input type="number" id="recipeMinutes" name="recipe_minutes" min="1" max="600" value="{{ old('recipe_minutes', $article->recipe_minutes) }}">
            </div>
            <div class="field">
              <label for="recipeServings">Porsi</label>
              <input type="number" id="recipeServings" name="recipe_servings" min="1" max="100" value="{{ old('recipe_servings', $article->recipe_servings) }}">
            </div>
          </div>
          <div class="field">
            <label for="recipeDifficulty">Tingkat Kesulitan</label>
            <input type="text" id="recipeDifficulty" name="recipe_difficulty" maxlength="50" value="{{ old('recipe_difficulty', $article->recipe_difficulty) }}" placeholder="Mudah / Sedang / Sulit">
          </div>
        </div>
      </div>

      <div class="sticky-side">
        <div class="form-card">
          <h3>Kategori &amp; Publikasi</h3>

          <div class="field">
            <label for="categorySelect">Kategori</label>
            <select id="categorySelect" name="category_id" required>
              <option value="">— Pilih kategori —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected((string) old('category_id', $article->category_id) === (string) $cat->id)>{{ $cat->name }}</option>
              @endforeach
            </select>
            @error('category_id')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="subcategoryInput">Label Sub-kategori <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="text" id="subcategoryInput" name="subcategory" maxlength="100" value="{{ old('subcategory', $article->subcategory) }}" placeholder="mis. Ekonomi, Sains">
          </div>

          <div class="field">
            <label for="authorInput">Penulis</label>
            <input type="text" id="authorInput" name="author" maxlength="100" value="{{ old('author', $article->author) }}" placeholder="Redaksi EdukaVisionNews">
          </div>

          <div class="field">
            <label for="readMinutes">Estimasi Baca (menit)</label>
            <input type="number" id="readMinutes" name="read_minutes" min="1" max="60" value="{{ old('read_minutes', $article->read_minutes) }}">
          </div>

          <div class="field">
            <label for="publishedAt">Jadwal Tayang</label>
            <input type="datetime-local" id="publishedAt" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}">
            <div class="field-hint">Kosongkan &amp; centang "Tayangkan sekarang" untuk publikasi langsung, atau isi tanggal untuk dijadwalkan.</div>
          </div>

          <div class="field checkbox-field">
            <input type="checkbox" id="publishNow" name="publish_now" value="1">
            <label for="publishNow" style="margin:0;">Tayangkan sekarang</label>
          </div>
          <div class="field checkbox-field">
            <input type="checkbox" id="isFeatured" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured))>
            <label for="isFeatured" style="margin:0;">Jadikan berita headline (hero)</label>
          </div>
          <div class="field checkbox-field">
            <input type="checkbox" id="isSponsored" name="is_sponsored" value="1" @checked(old('is_sponsored', $article->is_sponsored))>
            <label for="isSponsored" style="margin:0;">Tandai sebagai Konten Bersponsor</label>
          </div>
        </div>

        <div class="form-card">
          <h3>Gambar Artikel (Generatif)</h3>
          <div class="art-preview">
            <svg id="artPreviewSvg" viewBox="0 0 300 225" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
              <rect width="300" height="225" fill="{{ old('art_color1', $article->art_color1) }}"/>
            </svg>
          </div>

          <div class="field">
            <label>Warna</label>
            <div class="color-row">
              <input type="color" id="artColor1" name="art_color1" value="{{ old('art_color1', $article->art_color1) }}">
              <input type="color" id="artColor2" name="art_color2" value="{{ old('art_color2', $article->art_color2) }}">
              <span class="field-hint" style="margin:0;">Warna dasar &amp; aksen</span>
            </div>
          </div>

          <div class="field">
            <label>Pola</label>
            <div class="pattern-grid">
              @foreach(['wave' => 'Gelombang', 'circles' => 'Lingkaran', 'triangle' => 'Segitiga', 'grid' => 'Kotak', 'dots' => 'Titik', 'arrow' => 'Panah'] as $val => $label)
                <label class="pattern-option">
                  <input type="radio" name="art_pattern" value="{{ $val }}" @checked(old('art_pattern', $article->art_pattern) === $val)>
                  <span class="pattern-box">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-accent">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}</button>
        </div>
      </div>
    </div>
  </form>

</x-admin-layout>
