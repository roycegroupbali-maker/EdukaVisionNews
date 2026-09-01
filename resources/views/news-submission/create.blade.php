@include('partials.header', [
    'pageTitle' => 'Ajukan Berita — EdukaVisionNews',
    'pageDescription' => 'Kirim usulan berita, laporan warga, atau info kejadian di sekitarmu ke redaksi EdukaVisionNews.',
    'categories' => $categories,
])

<section class="section-band news-submission-page">
  <div class="wrap" style="max-width:720px;">

    <div class="section-head" style="border:none; margin-bottom:6px;">
      <h2 class="section-title" style="border:none;"><span class="bar"></span> Ajukan Berita</h2>
    </div>
    <p class="news-submission-lead">
      Punya info, kejadian, atau kegiatan yang menurutmu layak diberitakan? Isi formulir di bawah ini.
      Tim redaksi kami akan meninjau setiap pengajuan yang masuk sebelum diangkat menjadi berita.
    </p>

    @if(session('status'))
      <div class="ns-alert ns-alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
      <div class="ns-alert ns-alert-error">
        <strong>Ada isian yang perlu diperbaiki:</strong>
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('news-submission.store') }}" enctype="multipart/form-data" class="ns-form">
      @csrf

      <div class="ns-row">
        <div class="ns-field">
          <label for="nsName">Nama Kamu</label>
          <input type="text" id="nsName" name="name" value="{{ old('name') }}" required maxlength="100" placeholder="Nama lengkap">
        </div>
        <div class="ns-field">
          <label for="nsEmail">Email</label>
          <input type="email" id="nsEmail" name="email" value="{{ old('email') }}" required maxlength="150" placeholder="email@contoh.com">
        </div>
      </div>

      <div class="ns-field">
        <label for="nsTitle">Judul Usulan Berita</label>
        <input type="text" id="nsTitle" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="mis. Banjir Rendam Permukiman di Kelurahan Sanur">
      </div>

      <div class="ns-field">
        <label for="nsContent">Isi / Ringkasan Berita</label>
        <textarea id="nsContent" name="content" required maxlength="5000" placeholder="Ceritakan kronologi, lokasi, waktu kejadian, dan pihak-pihak yang terlibat sejelas mungkin…">{{ old('content') }}</textarea>
        <div class="ns-hint">Maksimal 5000 karakter. Semakin lengkap informasi yang kamu berikan, semakin mudah tim redaksi menindaklanjuti.</div>
      </div>

      <div class="ns-field">
        <label for="nsImage">Lampiran Foto <span class="ns-optional">(opsional)</span></label>
        <input type="file" id="nsImage" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
        <div class="ns-hint">Format JPG/PNG/WEBP/GIF, maksimal 8MB.</div>
      </div>

      <button type="submit" class="ns-submit-btn">Kirim Usulan Berita</button>
    </form>

  </div>
</section>

@include('partials.footer')
