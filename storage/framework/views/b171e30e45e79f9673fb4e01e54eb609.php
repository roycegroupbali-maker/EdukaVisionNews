<?php
    $articleTags = collect($article->tags_array);
    $articleImage = $article->image_url ?? asset('images/logo.png');
?>

<?php echo $__env->make('partials.header', [
    'pageTitle' => $article->title . ' — EdukaVisionNews',
    'pageDescription' => $article->excerpt,
    'ogType' => 'article',
    'ogImage' => $articleImage,
    'ogImageAlt' => $article->image_alt ?? $article->title,
    'ogAuthor' => $article->author,
    'ogPublishedTime' => $article->published_at?->toIso8601String(),
    'ogModifiedTime' => $article->updated_at?->toIso8601String(),
    'ogSection' => $article->category->name,
    'ogTags' => $articleTags,
    'ogKeywords' => $articleTags->implode(', '),
    'breadcrumbs' => [
        ['name' => 'Beranda', 'url' => route('home')],
        ['name' => $article->category->name, 'url' => route('category.show', $article->category->slug)],
        ['name' => $article->title, 'url' => route('article.show', $article->slug)],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $article->title,
    'description' => $article->excerpt,
    'image' => [$articleImage],
    'datePublished' => $article->published_at?->toIso8601String(),
    'dateModified' => $article->updated_at?->toIso8601String(),
    'inLanguage' => 'id-ID',
    'author' => [
        '@type' => 'Person',
        'name' => $article->author,
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'EdukaVisionNews',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
    'articleSection' => $article->category->name,
    'keywords' => $articleTags->implode(', ') ?: null,
    'wordCount' => str_word_count(strip_tags($article->content)),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>

</script>

<div class="section-band">
  <div class="wrap">
    <?php echo $__env->make('partials.ad-slot', ['slot' => 'leaderboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</div>

<article class="section-band article-detail">
  <div class="wrap" style="max-width:760px;">

    <nav style="font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.04em; margin-bottom:18px; color:var(--ink-soft, #667);">
      <a href="<?php echo e(route('home')); ?>">Beranda</a>
      &nbsp;/&nbsp;
      <a href="<?php echo e(route('category.show', $article->category->slug)); ?>"><?php echo e($article->category->name); ?></a>
    </nav>

    <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 12px;"><?php echo e($article->title); ?></h1>
    <p class="feature-dek" style="font-size:18px; margin-bottom:16px;"><?php echo e($article->excerpt); ?></p>

    <div class="byline" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:18px;">
      <span><?php echo e(strtoupper($article->author)); ?></span>
      <span>·</span>
      <span><?php echo e($article->readable_date); ?></span>
      <span>·</span>
      <span><?php echo e($article->read_minutes); ?> MENIT BACA</span>
      <span>·</span>
      <span><?php echo e(number_format($article->views)); ?> DIBACA</span>
      <span>·</span>
      <span id="shareCount"><?php echo e(number_format($article->shares)); ?> DIBAGIKAN</span>
    </div>

    <div class="share-row" data-article-slug="<?php echo e($article->slug); ?>" data-copy-url="<?php echo e(route('article.share.copy', $article->slug)); ?>" data-article-url="<?php echo e(route('article.show', $article->slug)); ?>">
      <span class="share-label">Bagikan:</span>
      <a class="share-btn share-whatsapp" href="<?php echo e(route('article.share', [$article->slug, 'whatsapp'])); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke WhatsApp">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.5 14.4c-.3-.15-1.7-.85-2-.95-.27-.1-.46-.15-.66.15-.2.3-.75.95-.92 1.14-.17.2-.34.22-.63.08-.3-.15-1.24-.46-2.37-1.47-.87-.78-1.47-1.74-1.64-2.04-.17-.3-.02-.46.13-.6.13-.13.3-.34.44-.5.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.08-.15-.66-1.6-.9-2.2-.24-.57-.48-.5-.66-.5h-.56c-.2 0-.5.07-.77.38-.26.3-1 1-1 2.4 0 1.42 1.03 2.8 1.17 3 .15.2 2.03 3.1 4.92 4.35.69.3 1.22.48 1.64.6.69.22 1.32.19 1.81.12.55-.08 1.7-.7 1.94-1.37.24-.68.24-1.26.17-1.38-.07-.12-.26-.2-.56-.35z"/><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.53 3.68 1.44 5.2L2 22l4.94-1.4A9.94 9.94 0 0 0 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18a8 8 0 0 1-4.32-1.27l-.31-.19-3.07.87.87-3-.2-.32A7.96 7.96 0 0 1 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8z"/></svg>
      </a>
      <a class="share-btn share-facebook" href="<?php echo e(route('article.share', [$article->slug, 'facebook'])); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke Facebook">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.5-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z"/></svg>
      </a>
      <a class="share-btn share-x" href="<?php echo e(route('article.share', [$article->slug, 'x'])); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke X">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M13.6 10.6 21 2h-2l-6.4 7.3L7.6 2H2l7.8 11.2L2 22h2l6.8-7.7L16.4 22H22l-8.4-11.4Zm-2.4 2.7-.8-1.1L4 3.5h2.6l5 7.2.8 1.1 6.9 9.7h-2.6l-5.5-7.2Z"/></svg>
      </a>
      <a class="share-btn share-telegram" href="<?php echo e(route('article.share', [$article->slug, 'telegram'])); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke Telegram">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M21.9 4.3 18.7 19.8c-.24 1.1-.87 1.36-1.76.85l-4.86-3.58-2.35 2.26c-.26.26-.48.48-.98.48l.35-4.98 9.06-8.19c.4-.35-.08-.55-.6-.2L6.2 12.8l-4.9-1.53c-1.06-.33-1.08-1.06.22-1.57L20.6 2.94c.89-.33 1.66.2 1.3 1.36Z"/></svg>
      </a>
      <button type="button" class="share-btn share-copy" data-copy-btn aria-label="Salin tautan berita">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        <span class="share-copy-label">Salin Tautan</span>
      </button>

      <?php if(config('features.likes_enabled')): ?>
        <button type="button"
                class="share-btn like-btn"
                id="likeBtn"
                data-like-url="<?php echo e(route('article.like', $article->slug)); ?>"
                data-article-slug="<?php echo e($article->slug); ?>"
                aria-pressed="false"
                aria-label="Suka berita ini"
                style="width:auto; padding:0 14px; border-radius:100px; gap:6px;">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14Z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
          <span id="likeCount"><?php echo e(number_format($article->likes)); ?></span>
        </button>
      <?php endif; ?>
    </div>

    
    <div class="feature-art" style="aspect-ratio:16/9; margin-bottom:<?php echo e($article->image_url && $article->image_caption ? '8px' : '26px'); ?>; border-radius:10px; overflow:hidden;">
      <?php if($article->image_link): ?>
        <a href="<?php echo e($article->image_link); ?>"
           target="_blank"
           rel="noopener noreferrer nofollow<?php echo e($article->is_sponsored ? ' sponsored' : ''); ?>"
           title="Buka tautan"
           style="display:block; width:100%; height:100%; cursor:pointer;">
          <?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 640 400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </a>
      <?php else: ?>
        <?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 640 400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endif; ?>
    </div>

    <?php if($article->image_url && ($article->image_caption || $article->image_source)): ?>
      <p class="image-caption">
        <?php echo e($article->image_caption); ?>

        <?php if($article->image_source): ?><span class="image-source"><?php echo e($article->image_caption ? ' — ' : ''); ?><?php echo e($article->image_source); ?></span><?php endif; ?>
      </p>
    <?php endif; ?>

    
    <div class="article-body" style="font-family:'Fraunces', serif; font-size:18px; line-height:1.8; color:var(--ink,#1a1a1a);">
      <?php echo $article->content_html; ?>

    </div>

    
    <?php if($article->youtube_id): ?>
      <?php $ytId = $article->youtube_id; ?>
      <div class="article-video" style="margin:26px 0; aspect-ratio:16/9; border-radius:10px; overflow:hidden; background:#000;">
        
        <a href="https://www.youtube.com/watch?v=<?php echo e($ytId); ?>"
           target="_blank" rel="noopener noreferrer"
           class="yt-facade"
           data-yt-id="<?php echo e($ytId); ?>"
           data-yt-title="Video: <?php echo e($article->title); ?>"
           aria-label="Putar video: <?php echo e($article->title); ?>"
           style="position:relative; display:block; width:100%; height:100%; cursor:pointer;">
          <img src="https://i.ytimg.com/vi/<?php echo e($ytId); ?>/maxresdefault.jpg"
               onerror="this.onerror=null;this.src='https://i.ytimg.com/vi/<?php echo e($ytId); ?>/hqdefault.jpg';"
               alt="" loading="lazy"
               style="width:100%; height:100%; object-fit:cover; display:block;">
          <span style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
            <svg viewBox="0 0 68 48" width="68" height="48" aria-hidden="true"><path d="M66.5 7.7a8.5 8.5 0 0 0-6-6C55.2.3 34 .3 34 .3S12.8.3 7.5 1.7a8.5 8.5 0 0 0-6 6C0 13 0 24 0 24s0 11 1.5 16.3a8.5 8.5 0 0 0 6 6C12.8 47.7 34 47.7 34 47.7s21.2 0 26.5-1.4a8.5 8.5 0 0 0 6-6C68 35 68 24 68 24s0-11-1.5-16.3z" fill="#f00"/><path d="M45 24 27 14v20z" fill="#fff"/></svg>
          </span>
        </a>
      </div>
      <script>
        document.querySelectorAll('.yt-facade').forEach(function (link) {
          link.addEventListener('click', function (e) {
            e.preventDefault();
            var box = link.parentNode;
            var iframe = document.createElement('iframe');
            iframe.src = 'https://www.youtube-nocookie.com/embed/' + link.dataset.ytId + '?autoplay=1&rel=0';
            iframe.title = link.dataset.ytTitle;
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframe.referrerPolicy = 'strict-origin-when-cross-origin';
            iframe.allowFullscreen = true;
            iframe.style.cssText = 'width:100%;height:100%;border:0;';
            box.removeChild(link);
            box.appendChild(iframe);
          });
        });
      </script>
    <?php endif; ?>

    <?php if($article->category->slug === 'resep' && ($article->recipe_minutes || $article->recipe_servings)): ?>
      <div class="recipe-meta" style="margin-top:10px;">
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_minutes ?? '-'); ?></span><span class="lbl">Menit</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_servings ?? '-'); ?></span><span class="lbl">Porsi</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_difficulty ?? '-'); ?></span><span class="lbl">Tingkat</span></div>
      </div>
    <?php endif; ?>

    <?php if(count($article->tags_array)): ?>
      <div class="article-tags">
        <?php $__currentLoopData = $article->tags_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('search', ['q' => $t])); ?>" class="tag-chip">#<?php echo e($t); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <div style="margin-top:34px;">
      <?php echo $__env->make('partials.ad-slot', ['slot' => 'midpage'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
  </div>
</article>

<?php if($related->count()): ?>
<section class="section-band alt">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Artikel Terkait</h2>
    </div>
    <div class="grid-4">
      <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $r], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(config('features.comments_enabled') && $article->comments_enabled): ?>
<section class="section-band" id="komentar">
  <div class="wrap" style="max-width:760px;">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Komentar (<?php echo e(number_format($article->approvedComments->count())); ?>)</h2>
    </div>

    <?php if(session('status')): ?>
      <div class="comment-flash"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('article.comments.store', $article->slug)); ?>" class="comment-form">
      <?php echo csrf_field(); ?>
      
      <div class="comment-honeypot" aria-hidden="true">
        <label for="commentWebsite">Website</label>
        <input type="text" id="commentWebsite" name="website" tabindex="-1" autocomplete="off">
      </div>

      <div class="comment-row">
        <div class="comment-field">
          <label for="commentName">Nama</label>
          <input type="text" id="commentName" name="name" required maxlength="100" value="<?php echo e(old('name')); ?>" placeholder="Nama kamu">
          <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="comment-field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="comment-field">
          <label for="commentBody">Komentar</label>
          <textarea id="commentBody" name="body" required minlength="3" maxlength="2000" placeholder="Tulis komentar kamu…"><?php echo e(old('body')); ?></textarea>
          <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="comment-field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <button type="submit" class="comment-submit-btn">Kirim Komentar</button>
      <p class="comment-note">Komentar akan tampil setelah disetujui moderator.</p>
    </form>

    <div class="comment-list">
      <?php $__empty_1 = true; $__currentLoopData = $article->approvedComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="comment-item">
          <div class="comment-meta">
            <span class="comment-name"><?php echo e($comment->name); ?></span>
            <span class="comment-date"><?php echo e($comment->created_at->translatedFormat('d F Y, H:i')); ?></span>
          </div>
          <p class="comment-body"><?php echo e($comment->body); ?></p>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="comment-empty">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/articles/show.blade.php ENDPATH**/ ?>