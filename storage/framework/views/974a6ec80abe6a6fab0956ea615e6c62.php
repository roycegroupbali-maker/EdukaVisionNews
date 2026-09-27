<?php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store');
    $me = auth()->user();
    $canPublish = $me->hasPermission('articles.publish');
?>

<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => $isEdit ? 'Edit Berita' : 'Tulis Berita Baru','pageSubtitle' => 'Pilih kategori lalu isi konten beritanya']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isEdit ? 'Edit Berita' : 'Tulis Berita Baru'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Pilih kategori lalu isi konten beritanya')]); ?>

  <?php if($isEdit && $article->status === \App\Models\Article::STATUS_REVISION && $article->review_note): ?>
    <div class="admin-flash error">
      <strong>Catatan revisi dari editor:</strong> <?php echo e($article->review_note); ?>

    </div>
  <?php endif; ?>
  <?php if($isEdit && $article->status === \App\Models\Article::STATUS_PENDING): ?>
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Berita ini sedang <strong>menunggu tinjauan editor</strong>. Anda masih bisa mengubahnya, tapi tidak perlu mengajukan ulang kecuali diminta.
    </div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" id="articleForm">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <input type="hidden" name="workflow_action" id="workflowAction" value="draft">

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Konten Berita</h3>

          <div class="field">
            <label for="titleInput">Judul Berita</label>
            <input type="text" id="titleInput" name="title" value="<?php echo e(old('title', $article->title)); ?>" required maxlength="255" placeholder="Judul berita yang menarik…">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="slugInput">Slug URL <span style="font-weight:400; color:var(--muted-2);">(opsional, otomatis dari judul)</span></label>
            <input type="text" id="slugInput" name="slug" value="<?php echo e(old('slug', $article->slug)); ?>" maxlength="255" placeholder="judul-berita-otomatis">
            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="excerptInput">Ringkasan / Excerpt</label>
            <textarea id="excerptInput" name="excerpt" required maxlength="500" style="min-height:80px;" placeholder="Ringkasan singkat yang tampil di daftar berita…"><?php echo e(old('excerpt', $article->excerpt)); ?></textarea>
            <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="contentInput">Isi Berita</label>
            <textarea id="contentInput" name="content" required style="min-height:320px;" placeholder="Tulis isi berita di sini. Pisahkan tiap paragraf dengan baris kosong."><?php echo e(old('content', $article->content)); ?></textarea>
            <div class="field-hint">Pisahkan paragraf dengan baris kosong (Enter dua kali) agar tampil rapi di halaman berita.</div>
            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="youtubeUrl">Video YouTube <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="url" id="youtubeUrl" name="youtube_url" maxlength="255" value="<?php echo e(old('youtube_url', $article->youtube_url)); ?>" placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx">
            <div class="field-hint">Video akan disematkan (embed) di bawah isi berita. Mendukung link youtube.com/watch, youtu.be, dan Shorts.</div>
            <div id="ytPreview" style="display:none; margin-top:10px;">
              <div style="position:relative; aspect-ratio:16/9; max-width:320px; border-radius:8px; overflow:hidden; background:#000;">
                <img id="ytPreviewImg" alt="Preview thumbnail video" style="width:100%; height:100%; object-fit:cover; display:block;">
                <span style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; pointer-events:none;">
                  <svg viewBox="0 0 68 48" width="48" height="34" aria-hidden="true"><path d="M66.5 7.7a8.5 8.5 0 0 0-6-6C55.2.3 34 .3 34 .3S12.8.3 7.5 1.7a8.5 8.5 0 0 0-6 6C0 13 0 24 0 24s0 11 1.5 16.3a8.5 8.5 0 0 0 6 6C12.8 47.7 34 47.7 34 47.7s21.2 0 26.5-1.4a8.5 8.5 0 0 0 6-6C68 35 68 24 68 24s0-11-1.5-16.3z" fill="#f00"/><path d="M45 24 27 14v20z" fill="#fff"/></svg>
                </span>
              </div>
              <div class="field-hint" style="margin-top:6px;">Preview thumbnail video. Jika tidak ada foto berita, thumbnail ini juga dipakai sebagai gambar utama dan gambar di daftar berita.</div>
            </div>
            <div id="ytPreviewError" class="field-error" style="display:none;">Link ini belum dikenali sebagai video YouTube. Pastikan formatnya youtube.com/watch?v=…, youtu.be/…, atau youtube.com/shorts/…</div>
            <?php $__errorArgs = ['youtube_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>

        <div class="form-card">
          <h3>Khusus Resep Masakan <span style="font-weight:400; font-size:12.5px; color:var(--muted-2);">(isi jika kategori Resep Masakan)</span></h3>
          <div class="form-row">
            <div class="field">
              <label for="recipeMinutes">Waktu Masak (menit)</label>
              <input type="number" id="recipeMinutes" name="recipe_minutes" min="1" max="600" value="<?php echo e(old('recipe_minutes', $article->recipe_minutes)); ?>">
            </div>
            <div class="field">
              <label for="recipeServings">Porsi</label>
              <input type="number" id="recipeServings" name="recipe_servings" min="1" max="100" value="<?php echo e(old('recipe_servings', $article->recipe_servings)); ?>">
            </div>
          </div>
          <div class="field">
            <label for="recipeDifficulty">Tingkat Kesulitan</label>
            <input type="text" id="recipeDifficulty" name="recipe_difficulty" maxlength="50" value="<?php echo e(old('recipe_difficulty', $article->recipe_difficulty)); ?>" placeholder="Mudah / Sedang / Sulit">
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
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php if((string) old('category_id', $article->category_id) === (string) $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="subcategoryInput">Label Sub-kategori <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="text" id="subcategoryInput" name="subcategory" maxlength="100" value="<?php echo e(old('subcategory', $article->subcategory)); ?>" placeholder="mis. Ekonomi, Sains">
          </div>

          <div class="field">
            <label for="authorInput">Penulis</label>
            <input type="text" id="authorInput" name="author" maxlength="100" value="<?php echo e(old('author', $article->author)); ?>" placeholder="Redaksi EdukaVisionNews">
          </div>

          <div class="field">
            <label for="readMinutes">Estimasi Baca (menit)</label>
            <input type="number" id="readMinutes" name="read_minutes" min="1" max="60" value="<?php echo e(old('read_minutes', $article->read_minutes)); ?>">
          </div>

          <?php if($canPublish): ?>
            <div class="field">
              <label for="publishedAt">Jadwal Tayang</label>
              <input type="datetime-local" id="publishedAt" name="published_at" value="<?php echo e(old('published_at', optional($article->published_at)->format('Y-m-d\TH:i'))); ?>">
              <div class="field-hint">Kosongkan &amp; centang "Tayangkan sekarang" untuk publikasi langsung, atau isi tanggal untuk dijadwalkan.</div>
            </div>

            <div class="field checkbox-field">
              <input type="checkbox" id="publishNow" name="publish_now" value="1">
              <label for="publishNow" style="margin:0;">Tayangkan sekarang</label>
            </div>
          <?php else: ?>
            <div class="field">
              <div class="field-hint">Jabatan Anda tidak bisa menayangkan berita langsung. Ajukan berita ini untuk ditinjau editor — berita akan tayang setelah disetujui.</div>
            </div>
          <?php endif; ?>
          <div class="field checkbox-field">
            <input type="checkbox" id="isFeatured" name="is_featured" value="1" <?php if(old('is_featured', $article->is_featured)): echo 'checked'; endif; ?>>
            <label for="isFeatured" style="margin:0;">Jadikan berita headline (hero)</label>
          </div>
          <div class="field checkbox-field">
            <input type="checkbox" id="isSponsored" name="is_sponsored" value="1" <?php if(old('is_sponsored', $article->is_sponsored)): echo 'checked'; endif; ?>>
            <label for="isSponsored" style="margin:0;">Tandai sebagai Konten Bersponsor</label>
          </div>
        </div>

        <div class="form-card">
          <h3>Foto Berita <span style="font-weight:400; font-size:12.5px; color:var(--muted-2);">(opsional — dipakai menggantikan gambar generatif di bawah)</span></h3>

          <div class="field">
            <label for="articleImageInput">Gambar Berita</label>
            <?php if($isEdit && $article->image_path): ?>
              <img id="articleImagePreview" src="<?php echo e($article->image_url); ?>" alt="<?php echo e($article->image_alt ?: $article->title); ?>" class="ad-image-preview">
            <?php else: ?>
              <img id="articleImagePreview" src="" alt="" class="ad-image-preview" style="display:none;">
            <?php endif; ?>
            <input type="file" id="articleImageInput" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <div class="field-hint">Format JPG/PNG/WEBP/GIF, maksimal 8MB. Rasio disarankan 16:9.</div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($isEdit && $article->image_path): ?>
              <div class="field checkbox-field" style="margin-top:10px;">
                <input type="checkbox" id="removeImage" name="remove_image" value="1">
                <label for="removeImage" style="margin:0;">Hapus gambar ini &amp; pakai gambar generatif lagi</label>
              </div>
            <?php endif; ?>
          </div>

          <div class="form-row">
            <div class="field">
              <label for="imageCaption">Keterangan Gambar <span style="font-weight:400; color:var(--muted-2);">(caption)</span></label>
              <input type="text" id="imageCaption" name="image_caption" value="<?php echo e(old('image_caption', $article->image_caption)); ?>" maxlength="255" placeholder="mis. Warga memadati lokasi kejadian, Selasa (1/9).">
              <?php $__errorArgs = ['image_caption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="field">
              <label for="imageSource">Sumber / Kredit Foto</label>
              <input type="text" id="imageSource" name="image_source" value="<?php echo e(old('image_source', $article->image_source)); ?>" maxlength="150" placeholder="mis. Foto: Antara / Dok. Istimewa">
              <?php $__errorArgs = ['image_source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div class="field">
            <label for="imageAlt">Teks Alternatif (Alt Text) <span style="font-weight:400; color:var(--muted-2);">(untuk SEO &amp; aksesibilitas)</span></label>
            <input type="text" id="imageAlt" name="image_alt" value="<?php echo e(old('image_alt', $article->image_alt)); ?>" maxlength="255" placeholder="mis. Petugas BPBD mengevakuasi warga terdampak banjir di Sanur">
            <?php $__errorArgs = ['image_alt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="imageLink">Tautan Gambar <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="url" id="imageLink" name="image_link" maxlength="500" value="<?php echo e(old('image_link', $article->image_link)); ?>" placeholder="https://contoh.com/halaman-tujuan">
            <div class="field-hint">Jika diisi, gambar berita bisa diklik dan akan membuka tautan ini di tab baru.</div>
            <?php $__errorArgs = ['image_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="tagsInput">Tag Berita <span style="font-weight:400; color:var(--muted-2);">(pisahkan dengan koma)</span></label>
            <input type="text" id="tagsInput" name="tags" value="<?php echo e(old('tags', $article->tags)); ?>" maxlength="500" placeholder="mis. banjir, sanur, bencana alam, denpasar">
            <div class="field-hint">Tag akan ditampilkan sebagai chip di akhir halaman berita, seperti portal berita pada umumnya.</div>
            <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>

        <div class="form-card">
          <h3>Gambar Artikel (Generatif) <span style="font-weight:400; font-size:12.5px; color:var(--muted-2);">(dipakai kalau tidak ada foto di atas)</span></h3>
          <div class="art-preview">
            <svg id="artPreviewSvg" viewBox="0 0 300 225" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
              <rect width="300" height="225" fill="<?php echo e(old('art_color1', $article->art_color1)); ?>"/>
            </svg>
          </div>

          <div class="field">
            <label>Warna</label>
            <div class="color-row">
              <input type="color" id="artColor1" name="art_color1" value="<?php echo e(old('art_color1', $article->art_color1)); ?>">
              <input type="color" id="artColor2" name="art_color2" value="<?php echo e(old('art_color2', $article->art_color2)); ?>">
              <span class="field-hint" style="margin:0;">Warna dasar &amp; aksen</span>
            </div>
          </div>

          <div class="field">
            <label>Pola</label>
            <div class="pattern-grid">
              <?php $__currentLoopData = ['wave' => 'Gelombang', 'circles' => 'Lingkaran', 'triangle' => 'Segitiga', 'grid' => 'Kotak', 'dots' => 'Titik', 'arrow' => 'Panah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="pattern-option">
                  <input type="radio" name="art_pattern" value="<?php echo e($val); ?>" <?php if(old('art_pattern', $article->art_pattern) === $val): echo 'checked'; endif; ?>>
                  <span class="pattern-box"><?php echo e($label); ?></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>

        <div class="form-actions">
          <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-ghost">Batal</a>
          <?php if($canPublish): ?>
            <button type="submit" class="btn btn-ghost" onclick="document.getElementById('workflowAction').value='draft';">Simpan sebagai Draf</button>
            <button type="submit" class="btn btn-accent" onclick="document.getElementById('workflowAction').value='publish';">Simpan & Tayangkan</button>
          <?php else: ?>
            <button type="submit" class="btn btn-ghost" onclick="document.getElementById('workflowAction').value='draft';">Simpan sebagai Draf</button>
            <button type="submit" class="btn btn-accent" onclick="document.getElementById('workflowAction').value='submit';">Ajukan untuk Ditinjau</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </form>

  <script>
    (function () {
      var input = document.getElementById('youtubeUrl');
      var box = document.getElementById('ytPreview');
      var img = document.getElementById('ytPreviewImg');
      var err = document.getElementById('ytPreviewError');
      if (!input || !box || !img || !err) return;

      // Pola yang sama dengan accessor getYoutubeIdAttribute() di model Article
      var pattern = /(?:youtu\.be\/|youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/|v\/))([A-Za-z0-9_-]{11})/;

      function update() {
        var value = input.value.trim();
        var match = value.match(pattern);

        if (match) {
          img.src = 'https://i.ytimg.com/vi/' + match[1] + '/hqdefault.jpg';
          box.style.display = 'block';
          err.style.display = 'none';
        } else {
          img.removeAttribute('src');
          box.style.display = 'none';
          err.style.display = value ? 'block' : 'none';
        }
      }

      input.addEventListener('input', update);
      update(); // tampilkan preview saat halaman edit dibuka
    })();
  </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/articles/form.blade.php ENDPATH**/ ?>