@extends('layouts.app')

@section('title', 'Pengaturan Revisi Dokumen - SIKAP')
@section('page-title', 'Pengaturan Revisi Dokumen')

@push('styles')
<style>
    .revision-page { max-width:1040px; margin:8px auto; color:#172230; }
    .revision-page * { box-sizing:border-box; }
    .revision-hero { position:relative; overflow:hidden; display:flex; align-items:center; gap:20px; padding:28px 30px; border:1px solid #f4dfc9; border-radius:18px; background:linear-gradient(115deg,#fffaf4,#fff 75%); margin-bottom:24px; }
    .revision-hero-icon { display:grid; place-items:center; flex-shrink:0; width:62px; height:62px; border-radius:18px; color:#e77916; background:#ffead4; }
    .revision-page svg { width:24px; height:24px; fill:none; stroke:currentColor; stroke-width:1.7; stroke-linecap:round; stroke-linejoin:round; }
    .revision-hero-icon svg { width:30px; height:30px; }
    .revision-eyebrow { display:block; margin-bottom:7px; font-size:10px; letter-spacing:1.6px; color:#b96620; font-weight:800; }
    .revision-hero h2 { margin:0 0 8px; font-size:24px; font-weight:800; letter-spacing:-.5px; }
    .revision-hero p { margin:0; color:#768194; font-size:13px; line-height:1.7; max-width:580px; }
    .revision-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; }
    .revision-card { min-width:0; background:#fff; border:1px solid #e4e9f0; border-radius:16px; overflow:hidden; box-shadow:0 4px 18px rgba(23,34,48,.035); }
    .revision-card-head { display:flex; align-items:center; gap:13px; padding:23px 24px; border-bottom:1px solid #edf0f4; }
    .revision-card-icon { display:grid; place-items:center; width:44px; height:44px; flex-shrink:0; border-radius:12px; background:#fff0df; color:#ed841e; }
    .revision-card-blue .revision-card-icon { color:#4383d6; background:#eaf3ff; }
    .revision-card-head h3 { margin:0 0 4px; font-size:16px; font-weight:800; }
    .revision-card-head p { margin:0; font-size:11px; color:#8b96a6; }
    .revision-card-body { padding:24px; }
    .revision-field { display:block; margin-bottom:20px; }
    .revision-field:last-child { margin-bottom:0; }
    .revision-field-label { display:flex; justify-content:space-between; align-items:center; margin-bottom:9px; font-size:12px; font-weight:700; }
    .revision-field-label span { font-size:10px; color:#98a2b3; font-weight:500; }
    .revision-input { width:100%; min-height:48px; padding:12px 14px; background:#fafbfd; border:1px solid #dfe5ed; border-radius:9px; color:#263449; font:inherit; font-size:13px; outline:none; transition:border-color .2s,box-shadow .2s; }
    .revision-input:focus { background:#fff; border-color:#ee932e; box-shadow:0 0 0 3px rgba(238,147,46,.12); }
    .revision-input[aria-invalid="true"] { border-color:#dc2626; }
    .revision-hint { display:block; margin-top:7px; font-size:10px; color:#98a2b3; line-height:1.5; }
    .revision-card-foot { padding:13px 24px; background:#fafbfd; border-top:1px solid #edf0f4; color:#8995a5; font-size:10px; display:flex; align-items:center; gap:8px; }
    .revision-card-foot svg { width:14px; height:14px; }
    .revision-actions { margin-top:22px; padding:20px 24px; background:#fff; border:1px solid #e4e9f0; border-radius:14px; display:flex; justify-content:space-between; align-items:center; gap:22px; }
    .revision-actions p { margin:0; font-size:12px; color:#768194; line-height:1.7; }
    .revision-actions p strong { display:block; color:#344054; font-size:12px; }
    .revision-save { display:inline-flex; align-items:center; justify-content:center; gap:9px; flex-shrink:0; padding:13px 21px; border:0; border-radius:9px; background:#ee861d; color:#fff; font:inherit; font-size:12px; font-weight:700; box-shadow:0 4px 10px rgba(238,134,29,.16); cursor:pointer; transition:background .2s; }
    .revision-save:hover { background:#dc7510; }
    .revision-save:focus-visible { outline:3px solid #f8bc7b; outline-offset:3px; }
    .revision-save svg { width:17px; height:17px; }
    .revision-alert { padding:14px 18px; border-radius:11px; margin-bottom:20px; font-size:12px; line-height:1.6; }
    .revision-alert-success { background:#edf9f1; border:1px solid #ccebd7; color:#247348; }
    .revision-alert-error { background:#fff2f2; border:1px solid #f5cccc; color:#b42318; }
    .revision-alert-error ul { margin:6px 0 0; padding-left:18px; }
    @media(max-width:900px) { .revision-grid { grid-template-columns:1fr; } }
    @media(max-width:560px) { .revision-hero { padding:22px 18px; gap:13px; align-items:flex-start; } .revision-hero-icon { width:42px; height:42px; border-radius:12px; } .revision-hero-icon svg { width:23px; height:23px; } .revision-hero h2 { font-size:19px; } .revision-card-head,.revision-card-body { padding:20px; } .revision-actions { flex-direction:column; align-items:stretch; padding:20px; } .revision-save { width:100%; } }
</style>
@endpush

@section('content')
<div class="revision-page">
    <div class="revision-hero">
        <div class="revision-hero-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
        </div>
        <div>
            <span class="revision-eyebrow">PENGATURAN DOKUMEN</span>
            <h2>Kelola revisi dokumen</h2>
            <p>Perbarui tanggal dan nomor revisi agar dokumen yang dibuat mengikuti revisi terbaru.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="revision-alert revision-alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="revision-alert revision-alert-error" role="alert">
            <strong>Periksa kembali isian revisi.</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('document-revisions.update') }}">
        @csrf
        @method('PUT')
        <div class="revision-grid">
            @foreach($types as $type => $label)
                <section class="revision-card {{ $type === 'surat_tugas' ? 'revision-card-blue' : '' }}" aria-labelledby="revision-title-{{ $type }}">
                    <div class="revision-card-head">
                        <div class="revision-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 12h8M8 16h6"/></svg>
                        </div>
                        <div>
                            <h3 id="revision-title-{{ $type }}">{{ $label }}</h3>
                            <p>{{ $type === 'moc' ? 'Management of Change' : 'Penugasan karyawan' }}</p>
                        </div>
                    </div>
                    <div class="revision-card-body">
                        <label class="revision-field" for="rev-date-{{ $type }}">
                            <span class="revision-field-label">Tanggal revisi <span>Rev.Date</span></span>
                            <input class="revision-input" id="rev-date-{{ $type }}" type="date" name="revisions[{{ $type }}][rev_date]" value="{{ old('revisions.'.$type.'.rev_date', $revisions[$type]['rev_date']) }}" required aria-invalid="{{ $errors->has('revisions.'.$type.'.rev_date') ? 'true' : 'false' }}">
                            <span class="revision-hint">Tanggal revisi yang ditampilkan pada header dokumen.</span>
                        </label>
                        <label class="revision-field" for="rev-no-{{ $type }}">
                            <span class="revision-field-label">Nomor revisi <span>Rev.No</span></span>
                            <input class="revision-input" id="rev-no-{{ $type }}" type="text" name="revisions[{{ $type }}][rev_no]" value="{{ old('revisions.'.$type.'.rev_no', $revisions[$type]['rev_no']) }}" inputmode="numeric" pattern="[0-9]+" maxlength="10" placeholder="Contoh: 03" required aria-invalid="{{ $errors->has('revisions.'.$type.'.rev_no') ? 'true' : 'false' }}">
                            <span class="revision-hint">Gunakan nomor revisi yang sudah ditetapkan, misalnya 03.</span>
                        </label>
                    </div>
                    <div class="revision-card-foot">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7h.01"/></svg>
                        Berlaku untuk hasil Word dan PDF yang dibuat berikutnya.
                    </div>
                </section>
            @endforeach
        </div>
        <div class="revision-actions">
            <p><strong>Simpan sebelum membuat dokumen baru</strong>Dokumen yang sudah dibuat tetap menyimpan revisi sebelumnya.</p>
            <button class="revision-save" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12l4 4v12a2 2 0 0 1-2 2Z"/><path d="M7 3v6h10V3M7 21v-8h10v8"/></svg>
                Simpan Revisi
            </button>
        </div>
    </form>
</div>
@endsection
