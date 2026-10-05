@extends('layouts.app')
@section('title', 'Berita Acara - SIKAP')
@section('page-title', 'Berita Acara')
@section('page-subtitle', 'Buat Berita Acara Pergantian Sementara Personel')

@push('styles')
<style>
.unified-page, .unified-page *{ box-sizing: border-box; }
.unified-page{

        --navy:#06345e;

        --navy2:#052744;

        --blue:#ff7a00;

        --blue-dark:#e96d00;

        --blue-soft:#fff3e8;

        --text:#10213a;

        --muted:#718096;

        --line:#d9e3ee;

        --bg:#f7faff;

        --white:#fff;

        --danger:#ef4444;

    }
.unified-page{ scroll-behavior:smooth; }
.unified-page{

        margin:0;

        min-height:100vh;

        padding-left: 187px;

        padding-top:62px;

        font-family:Inter,"Segoe UI",Arial,sans-serif;

        color:var(--text);

        background:

            radial-gradient(circle at 86% 2%, rgba(255,122,0,.08), transparent 23%),

            linear-gradient(180deg,#ffffff 0%,#f7faff 100%);

    }
.unified-page a{ color:inherit; }
.unified-page .brand{

            display: flex;

            align-items: center;

            justify-content: flex-start;

            width: 100%;

            padding: 6px 6px 18px;

            margin-bottom: 14px;

            border-bottom: 1px solid #e5e7eb;

        }
.unified-page .brand-image{

            display: block;

            width: 148px;

            max-width: 100%;

            height: auto;

            object-fit: contain;

            object-position: left center;

        }
.unified-page .page{

        width:calc(100% - 44px);

        max-width:1040px;

        margin:0 auto;

        padding:24px 0 56px;

    }
.unified-page .back{

        display:inline-flex!important;

        align-items:center!important;

        justify-content:center!important;

        gap:7px!important;

        min-height:38px!important;

        margin:0 0 20px!important;

        padding:8px 13px!important;

        border:1px solid #cfd9e5!important;

        border-radius:7px!important;

        background:#fff!important;

        color:#20364f!important;

        font-size:12px!important;

        font-weight:700!important;

        text-decoration:none!important;

        box-shadow:0 2px 6px rgba(16,33,58,.04)!important;

        transition:.2s ease!important;

    }
.unified-page .back:hover{

        border-color:var(--blue)!important;

        color:var(--blue)!important;

        background:#f8fbff!important;

        transform:translateY(-1px)!important;

    }
.unified-page .hero{

        position:relative;

        min-height:132px;

        margin:0 0 16px!important;

        padding:8px 185px 12px 4px!important;

        overflow:hidden;

        border:0!important;

        border-radius:0!important;

        background:transparent!important;

        color:var(--text)!important;

        box-shadow:none!important;

    }
.unified-page .hero-content{

        position:relative;

        z-index:2;

        padding-top:6px;

    }
.unified-page .hero-badge{ display:none!important; }
.unified-page .hero h1{

        margin:0 0 10px!important;

        color:var(--text)!important;

        font-size:30px!important;

        line-height:1.15!important;

        font-weight:800!important;

        letter-spacing:-.55px!important;

    }
.unified-page .hero p{

        margin:0!important;

        max-width:650px;

        color:#66758a!important;

        font-size:13px!important;

        line-height:1.55!important;

    }
.unified-page .hero-art{

        position:absolute;

        right:16px;

        top:0;

        width:150px;

        height:128px;

        z-index:1;

        display:flex;

        align-items:center;

        justify-content:center;

    }
.unified-page .hero-art::before{

        content:"";

        position:absolute;

        width:128px;

        height:128px;

        border-radius:50%;

        background:

            radial-gradient(circle at 50% 50%, rgba(255,122,0,.12) 0 46%, rgba(255,122,0,.04) 47% 64%, transparent 65%);

    }
.unified-page .hero-art svg{

        position:relative;

        z-index:2;

        width:106px;

        height:106px;

        filter:drop-shadow(0 10px 16px rgba(255,122,0,.12));

    }
.unified-page .alert{

        margin-bottom:14px!important;

        padding:11px 13px!important;

        border:1px solid #fecaca!important;

        border-radius:7px!important;

        background:#fff1f2!important;

        color:#b42318!important;

        font-size:11px!important;

    }
.unified-page .section{

        position:relative!important;

        overflow:hidden!important;

        margin:0 0 14px!important;

        padding:20px 22px!important;

        border:1px solid #f4dfc9!important;

        border-radius:9px!important;

        background:#fff!important;

        box-shadow:0 5px 14px rgba(28,56,92,.055)!important;

        transition:.2s ease!important;

    }
.unified-page .section::before{

        content:""!important;

        position:absolute!important;

        left:0!important;

        top:0!important;

        bottom:0!important;

        width:3px!important;

        background:var(--blue)!important;

    }
.unified-page .section:hover{

        transform:translateY(-1px)!important;

        box-shadow:0 8px 20px rgba(28,56,92,.075)!important;

    }
.unified-page .section-header{

        display:flex!important;

        align-items:center!important;

        gap:12px!important;

        margin:0 0 18px!important;

        padding:0!important;

        border:0!important;

    }
.unified-page .section-number{

        width:34px!important;

        height:34px!important;

        min-width:34px!important;

        min-height:34px!important;

        display:flex!important;

        align-items:center!important;

        justify-content:center!important;

        padding:0!important;

        border:1.8px solid var(--blue)!important;

        border-radius:7px!important;

        background:#fff!important;

        color:var(--blue)!important;

        font-size:12px!important;

        font-weight:800!important;

        line-height:1!important;

        box-shadow:0 2px 5px rgba(255,122,0,.07)!important;

    }
.unified-page .section-title h2{

        margin:0!important;

        color:var(--blue)!important;

        font-size:16px!important;

        line-height:1.25!important;

        font-weight:800!important;

    }
.unified-page .section-title p{

        margin:3px 0 0!important;

        color:#8190a3!important;

        font-size:10px!important;

        line-height:1.4!important;

    }
.unified-page .grid{

        display:grid!important;

        grid-template-columns:repeat(2,minmax(0,1fr))!important;

        gap:14px 16px!important;

    }
.unified-page .grid-three{

        display:grid!important;

        grid-template-columns:repeat(3,minmax(0,1fr))!important;

        gap:14px 16px!important;

    }
.unified-page .approval-grid{

        display:grid!important;

        grid-template-columns:repeat(2,minmax(0,1fr))!important;

        gap:14px 16px!important;

    }
.unified-page .form-group{

        margin-bottom:14px!important;

        min-width:0;

    }
.unified-page .grid .form-group, .unified-page .grid-three .form-group, .unified-page .approval-grid .form-group{

        margin-bottom:0!important;

    }
.unified-page .full{ grid-column:1/-1; }
.unified-page label{

        display:block!important;

        margin-bottom:7px!important;

        color:#14253d!important;

        font-size:12px!important;

        line-height:1.35!important;

        font-weight:700!important;

    }
.unified-page .required{ color:#ef4444!important; }
.unified-page .jabatan-picker{ display:flex; gap:10px; align-items:center; }
.unified-page .jabatan-picker select{ min-width:0; flex:1; }
.unified-page .jabatan-picker .jabatan-other{ min-width:0; flex:1; }
.unified-page .jabatan-picker .jabatan-other[hidden]{ display:none!important; }
.unified-page input, .unified-page select, .unified-page textarea{

        width:100%!important;

        min-height:42px!important;

        padding:10px 12px!important;

        border:1px solid #d8e2ec!important;

        border-radius:7px!important;

        outline:none!important;

        background:#fff!important;

        color:#26364b!important;

        font-size:12px!important;

        box-shadow:none!important;

        transition:.2s ease!important;

    }
.unified-page textarea{

        min-height:88px!important;

        resize:vertical!important;

    }
.unified-page input:focus, .unified-page select:focus, .unified-page textarea:focus{

        border-color:var(--blue)!important;

        box-shadow:0 0 0 3px rgba(255,122,0,.09)!important;

    }
.unified-page input[readonly]{

        background:#f4f6f9!important;

        color:#617087!important;

    }
.unified-page .choice-row{

        display:flex!important;

        flex-wrap:wrap!important;

        gap:8px!important;

    }
.unified-page .choice{

        min-width:132px!important;

        display:flex!important;

        align-items:center!important;

        gap:7px!important;

        padding:10px 12px!important;

        border:1px solid #dce4ed!important;

        border-radius:7px!important;

        background:#fff!important;

        color:#2a3b52!important;

        font-size:11px!important;

        font-weight:700!important;

    }
.unified-page .choice input{

        width:auto!important;

        min-height:auto!important;

        padding:0!important;

        accent-color:var(--blue)!important;

    }
.unified-page .table-wrap{ overflow-x:auto!important; }
.unified-page table{

        width:100%!important;

        border-collapse:separate!important;

        border-spacing:0!important;

        overflow:hidden!important;

        border:1px solid #e1e8ef!important;

        border-radius:7px!important;

        background:#fff!important;

    }
.unified-page th{

        padding:9px 10px!important;

        border:0!important;

        border-bottom:1px solid #e2e8ef!important;

        background:#fff5eb!important;

        color:#506176!important;

        font-size:10px!important;

        font-weight:800!important;

        text-align:left!important;

    }
.unified-page td{

        padding:8px 10px!important;

        border:0!important;

        border-bottom:1px solid #edf1f5!important;

        color:#4b596d!important;

        font-size:10px!important;

    }
.unified-page tbody tr:last-child td{ border-bottom:0!important; }
.unified-page .approval-card{

        position:relative!important;

        padding:15px!important;

        border:1px solid #e0e7ef!important;

        border-radius:8px!important;

        background:#fbfcfe!important;

    }
.unified-page .approval-card::before{

        content:"";

        position:absolute;

        left:0;

        right:0;

        top:0;

        height:3px;

        border-radius:8px 8px 0 0;

        background:var(--blue);

    }
.unified-page .approval-card h3{

        margin:0 0 12px!important;

        color:#15263e!important;

        font-size:12px!important;

        font-weight:800!important;

    }
.unified-page .help, .unified-page .help-text, .unified-page .hint, .unified-page .note{

        color:#8290a2!important;

        font-size:10px!important;

        line-height:1.5!important;

    }
.unified-page .actions{

        display:flex!important;

        justify-content:flex-end!important;

        align-items:center!important;

        gap:9px!important;

        margin-top:18px!important;

    }
.unified-page .btn-submit{

        min-height:40px!important;

        padding:10px 18px!important;

        border:0!important;

        border-radius:7px!important;

        background:linear-gradient(180deg,#ff8a14 0%,#ff7a00 100%)!important;

        color:#fff!important;

        font-size:12px!important;

        font-weight:800!important;

        cursor:pointer!important;

        box-shadow:0 7px 16px rgba(255,122,0,.20)!important;

        transition:.2s ease!important;

    }
.unified-page .btn-submit:hover{

        transform:translateY(-1px)!important;

        filter:brightness(.97)!important;

    }
@media(max-width:980px){.unified-page{ padding-left:178px; }
.unified-page .app-brand img{ width:138px; }
.unified-page .grid-three{ grid-template-columns:repeat(2,minmax(0,1fr))!important; }}
@media(max-width:760px){.unified-page{

            padding-left:0;

            padding-top:58px;

        }
.unified-page .page{

            width:calc(100% - 24px);

            padding-top:18px;

        }
.unified-page .hero{

            min-height:112px;

            padding-right:105px!important;

        }
.unified-page .hero h1{ font-size:24px!important; }
.unified-page .hero p{ font-size:12px!important; }
.unified-page .hero-art{

            right:0;

            width:100px;

            height:105px;

        }
.unified-page .hero-art::before{

            width:92px;

            height:92px;

        }
.unified-page .hero-art svg{

            width:72px;

            height:72px;

        }
.unified-page .grid, .unified-page .grid-three, .unified-page .approval-grid{

            grid-template-columns:1fr!important;

        }
.unified-page .section{

            padding:18px 16px!important;

        }}
.unified-page .app-brand{

        border-bottom:1px solid #e5e7eb !important;

    }
.unified-page .signature-search-wrap{

    position: relative;

    width: 100%;

}
.unified-page .signature-search-input{

    width: 100% !important;

    min-height: 42px !important;

    padding: 10px 38px 10px 12px !important;

    border: 1px solid #d8e2ec !important;

    border-radius: 7px !important;

    outline: none !important;

    background: #ffffff !important;

    color: #26364b !important;

    font-size: 12px !important;

    cursor: text !important;

    transition: .2s ease !important;

}
.unified-page .signature-search-input:focus{

    border-color: var(--blue) !important;

    box-shadow: 0 0 0 3px rgba(20,115,230,.08) !important;

}
.unified-page .signature-search-wrap::after{

    content: "";

    position: absolute;

    right: 14px;

    top: 17px;

    width: 7px;

    height: 7px;

    border-right: 1.5px solid #667085;

    border-bottom: 1.5px solid #667085;

    transform: rotate(45deg);

    pointer-events: none;

    z-index: 2;

}
.unified-page .signature-search-results{

    position: absolute;

    left: 0;

    right: 0;

    top: calc(100% + 5px);

    z-index: 1500;

    display: none;

    max-height: 220px;

    overflow-y: auto;

    padding: 5px;

    border: 1px solid #d8e2ec;

    border-radius: 8px;

    background: #ffffff;

    box-shadow: 0 12px 28px rgba(16,33,58,.14);

}
.unified-page .signature-search-results.open{

    display: block;

}
.unified-page .signature-search-option{

    display: block;

    width: 100%;

    padding: 10px 11px;

    border: 0;

    border-radius: 6px;

    background: transparent;

    color: #26364b;

    font-family: inherit;

    font-size: 11px;

    line-height: 1.4;

    text-align: left;

    cursor: pointer;

}
.unified-page .signature-search-option:hover, .unified-page .signature-search-option.active{

    background: var(--blue-soft);

    color: var(--blue-dark);

}
.unified-page .signature-search-option.signature-empty{

    color: #667085;

}
.unified-page .signature-search-no-result{

    padding: 11px;

    color: #98a2b3;

    font-size: 11px;

    text-align: center;

}
.unified-page .signature-select.signature-search-native{

    position: absolute !important;

    width: 1px !important;

    height: 1px !important;

    min-height: 1px !important;

    padding: 0 !important;

    margin: 0 !important;

    opacity: 0 !important;

    pointer-events: none !important;

}
.unified-page { width:100%; min-width:0; min-height:0; display:block; margin:0; padding:0; color:#263449; font:inherit; background:transparent; }
.unified-page > .page, .unified-page > .container, .unified-page > .content { margin:0!important; padding:0!important; max-width:none!important; width:100%!important; }
.unified-page .hero, .unified-page .hero-card, .unified-page .table-card, .unified-page .search-card, .unified-page .section, .unified-page .card, .unified-page .form-card { border-radius:16px; border-color:#e3e9f0; box-shadow:0 4px 16px rgba(23,34,48,.035); }
.unified-page input, .unified-page select, .unified-page textarea, .unified-page button { font-family:inherit; }
.unified-page .table-card { overflow-x:auto; }
.unified-page .hero h1, .unified-page .hero h2 { font-size:24px; }
@media(max-width:760px) { .unified-page .hero h1,.unified-page .hero h2 { font-size:20px; } }


/* Dropdown tanda tangan dapat keluar dari batas card. */
.unified-page .section:has(.signature-search-wrap),
.unified-page .section:has(.signature-search-results) { overflow:visible!important; position:relative; }
.unified-page .signature-search-wrap { position:relative; }
.unified-page .signature-search-results { z-index:100; }

</style>
@endpush

@section('content')
<div class="unified-page">
<div class="page">

    <a

        href="{{ route('dashboard') }}"

        class="back"

    >

        ← Kembali ke Dashboard

    </a>

    <div class="hero">

        <div class="hero-art" aria-hidden="true">

            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">

                <rect x="29" y="22" width="62" height="78" rx="10" fill="#FFFFFF" stroke="#FF7A00" stroke-width="5"/>

                <rect x="46" y="14" width="28" height="14" rx="6" fill="#FF7A00"/>

                <circle cx="60" cy="20" r="4" fill="#FFFFFF"/>

                <circle cx="46" cy="45" r="6" fill="#FFF0E2"/>

                <path d="M42 52C44 48 48 48 50 52" stroke="#FF7A00" stroke-width="3" stroke-linecap="round"/>

                <rect x="58" y="41" width="22" height="4" rx="2" fill="#E6C5A5"/>

                <rect x="58" y="50" width="22" height="4" rx="2" fill="#F0D8C0"/>

                <rect x="40" y="64" width="40" height="4" rx="2" fill="#E9CDB1"/>

                <rect x="40" y="75" width="32" height="4" rx="2" fill="#E9CDB1"/>

                <rect x="40" y="86" width="26" height="4" rx="2" fill="#E9CDB1"/>

                <path d="M82 78L97 63" stroke="#FF7A00" stroke-width="7" stroke-linecap="round"/>

                <path d="M78 88L82 78L89 85L78 88Z" fill="#FF7A00"/>

            </svg>

        </div>

<div class="hero-content">

            <div class="hero-badge">

                PERSONNEL REPLACEMENT

            </div>

            <h1>

                Berita Acara Pergantian Sementara Personel

            </h1>

            <p>

                Isi data berikut untuk membuat dokumen

                Berita Acara sesuai template perusahaan.

            </p>

        </div>

    </div>

    @if(session('error'))

        <div class="alert">

            {{ session('error') }}

        </div>

    @endif

    @if($errors->any())

        <div class="alert">

            <strong>

                Periksa kembali data berikut:

            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>

                        {{ $error }}

                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    <form

        method="POST"

        action="{{ route('berita-acara.generate') }}"

    >

        @csrf

        <!-- =====================================================

             INFORMASI DOKUMEN

        ====================================================== -->

        <section class="section">

            <div class="section-header">

                <div class="section-number">

                    01

                </div>

                <div class="section-title">

                    <h2>

                        Informasi Dokumen

                    </h2>

                    <p>

                        Identitas utama Berita Acara.

                    </p>

                </div>

            </div>

            <div class="grid">

                <div class="form-group">

                    <label>

                        Judul Dokumen

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="document_title"

                        value="{{ old('document_title') }}"

                        placeholder="Contoh: Berita Acara Pergantian Asmara Hadi ARJ-10"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Rig

                        <span class="required">*</span>

                    </label>

                    <select

                        name="rig"

                        required

                    >

                        <option value="">

                            -- Pilih Rig --

                        </option>

                        @foreach(

                            [

                                'ARJ-06',

                                'ARJ-07',

                                'ARJ-09',

                                'ARJ-10',

                                'ARJ-11',

                                'ARJ-15'

                            ]

                            as $rig

                        )

                            <option

                                value="{{ $rig }}"

                                {{

                                    old('rig') === $rig

                                    ? 'selected'

                                    : ''

                                }}

                            >

                                {{ $rig }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </section>

        <!-- =====================================================

             PERSONEL TIDAK HADIR

        ====================================================== -->

        <section class="section green">

            <div class="section-header">

                <div class="section-number">

                    02

                </div>

                <div class="section-title">

                    <h2>

                        Personel Tidak Hadir

                    </h2>

                    <p>

                        Data personel yang akan digantikan sementara.

                    </p>

                </div>

            </div>

            <div class="grid">

                <div class="form-group">

                    <label>

                        Nama

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="tidak_nama"

                        value="{{ old('tidak_nama') }}"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Jabatan

                        <span class="required">*</span>

                    </label>

                    <div class="jabatan-picker" data-jabatan-picker>

                        <input type="hidden" name="tidak_jabatan" value="{{ old('tidak_jabatan') }}">

                        <select aria-label="Pilih jabatan personel tidak hadir" required>

                            <option value="">Pilih jabatan</option>

                        </select>

                        <input type="text" class="jabatan-other" placeholder="Isi jabatan lainnya" aria-label="Jabatan lainnya personel tidak hadir" maxlength="255" hidden>

                    </div>

                </div>

                <div class="form-group">

                    <label>

                        Crew

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="tidak_crew"

                        value="{{ old('tidak_crew') }}"

                        placeholder="Contoh: C"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Schedule

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="tidak_schedule"

                        value="{{ old('tidak_schedule') }}"

                        placeholder="Contoh: Schedule Siang Hari ke 1"

                        required

                    >

                </div>

            </div>

        </section>

        <!-- =====================================================

             KETERANGAN TIDAK HADIR

        ====================================================== -->

        <section class="section blue">

            <div class="section-header">

                <div class="section-number">

                    03

                </div>

                <div class="section-title">

                    <h2>

                        Keterangan Tidak Hadir

                    </h2>

                    <p>

                        Alasan dan periode personel tidak hadir.

                    </p>

                </div>

            </div>

            <div class="grid">

                <div class="form-group full">

                    <label>

                        Alasan

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="alasan"

                        value="{{ old('alasan') }}"

                        placeholder="Contoh: Cuti"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Tanggal Mulai

                        <span class="required">*</span>

                    </label>

                    <input

                        type="date"

                        id="tanggal_mulai"

                        name="tanggal_mulai"

                        value="{{ old('tanggal_mulai') }}"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Tanggal Selesai (Opsional)

                    </label>

                    <input

                        type="date"

                        id="tanggal_selesai"

                        name="tanggal_selesai"

                        value="{{ old('tanggal_selesai') }}"

                        min="{{ old('tanggal_mulai') }}"

                    >

                </div>

            </div>

            <p class="help-text">

                Kosongkan Tanggal Selesai untuk 1 hari. Jika lebih dari 1 hari,

                pilih tanggal akhir; jumlah hari dihitung otomatis.

            </p>

        </section>

        <!-- =====================================================

             PERSONEL PENGGANTI

        ====================================================== -->

        <section class="section">

            <div class="section-header">

                <div class="section-number">

                    04

                </div>

                <div class="section-title">

                    <h2>

                        Personel Pengganti

                    </h2>

                    <p>

                        Data personel yang menggantikan sementara.

                    </p>

                </div>

            </div>

            <div class="grid">

                <div class="form-group">

                    <label>

                        Nama

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="pengganti_nama"

                        value="{{ old('pengganti_nama') }}"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Jabatan

                        <span class="required">*</span>

                    </label>

                    <div class="jabatan-picker" data-jabatan-picker>

                        <input type="hidden" name="pengganti_jabatan" value="{{ old('pengganti_jabatan') }}">

                        <select aria-label="Pilih jabatan personel pengganti" required>

                            <option value="">Pilih jabatan</option>

                        </select>

                        <input type="text" class="jabatan-other" placeholder="Isi jabatan lainnya" aria-label="Jabatan lainnya personel pengganti" maxlength="255" hidden>

                    </div>

                </div>

                <div class="form-group">

                    <label>

                        Rig Asal

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="pengganti_rig"

                        value="{{ old('pengganti_rig') }}"

                        placeholder="Contoh: ARJ-15"

                        required

                    >

                </div>

                <div class="form-group">

                    <label>

                        Crew

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="pengganti_crew"

                        value="{{ old('pengganti_crew') }}"

                        required

                    >

                </div>

                <div class="form-group full">

                    <label>

                        Schedule

                        <span class="required">*</span>

                    </label>

                    <input

                        type="text"

                        name="pengganti_schedule"

                        value="{{ old('pengganti_schedule') }}"

                        placeholder="Contoh: Schedule Malam hari ke 7 (Rig ARJ-15 Yearly Maintenance)"

                        required

                    >

                </div>

            </div>

        </section>

        <!-- =====================================================

             ONBOARDING / HSSE

        ====================================================== -->

        <section class="section green">

            <div class="section-header">

                <div class="section-number">

                    05

                </div>

                <div class="section-title">

                    <h2>

                        Onboarding / HSSE

                    </h2>

                    <p>

                        Informasi familiarisasi personel pengganti.

                    </p>

                </div>

            </div>

            <div class="form-group">

                <label>

                    Objek Familiarisasi

                    <span class="required">*</span>

                </label>

                <input

                    type="text"

                    name="familirisasi"

                    value="{{ old('familirisasi') }}"

                    placeholder="Contoh: unit vacuum"

                    required

                >

            </div>

        </section>

        <!-- =====================================================

             TANGGAL

        ====================================================== -->

        <section class="section blue">

            <div class="section-header">

                <div class="section-number">

                    06

                </div>

                <div class="section-title">

                    <h2>

                        Tanggal Berita Acara

                    </h2>

                    <p>

                        Tanggal dokumen diterbitkan.

                    </p>

                </div>

            </div>

            <div class="form-group">

                <label>

                    Tanggal

                    <span class="required">*</span>

                </label>

                <input

                    type="date"

                    name="tanggal_surat"

                    value="{{ old('tanggal_surat') }}"

                    required

                >

            </div>

        </section>

        <!-- =====================================================

             PENANDATANGAN

        ====================================================== -->

        <section class="section">

            <div class="section-header">

                <div class="section-number">

                    07

                </div>

                <div class="section-title">

                    <h2>

                        Penandatangan

                    </h2>

                    <p>

                        Pilih tanda tangan yang sudah tersimpan

                        di Signature Library.

                    </p>

                </div>

            </div>

            <div class="grid-four">

                <!-- FIELD COORDINATOR -->

                <div class="person-card">

                    <h3>

                        Field Coordinator

                    </h3>

                    <div class="form-group">

                        <label>

                            Tanda Tangan

                        </label>

                        <select

                            name="field_coordinator_signature_id"

                            class="signature-select"

                        >

                            <option value="">

                                -- Pilih Signature --

                            </option>

                            @foreach($signatures ?? [] as $signature)

                                <option

                                    value="{{ $signature->id }}"

                                    {{

                                        old(

                                            'field_coordinator_signature_id'

                                        ) == $signature->id

                                        ? 'selected'

                                        : ''

                                    }}

                                >

                                    {{ $signature->name }}

                                    @if($signature->position)

                                        - {{ $signature->position }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- RIG SUPT -->

                <div class="person-card">

                    <h3>

                        Rig Supt

                    </h3>

                    <div class="form-group">

                        <label>

                            Tanda Tangan

                        </label>

                        <select

                            name="rig_supt_signature_id"

                            class="signature-select"

                        >

                            <option value="">

                                -- Pilih Signature --

                            </option>

                            @foreach($signatures ?? [] as $signature)

                                <option

                                    value="{{ $signature->id }}"

                                    {{

                                        old(

                                            'rig_supt_signature_id'

                                        ) == $signature->id

                                        ? 'selected'

                                        : ''

                                    }}

                                >

                                    {{ $signature->name }}

                                    @if($signature->position)

                                        - {{ $signature->position }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- GENERAL MANAGER -->

                <div class="person-card">

                    <h3>

                        General Manager

                    </h3>

                    <div class="form-group">

                        <label>

                            Tanda Tangan

                        </label>

                        <select

                            name="general_manager_signature_id"

                            class="signature-select"

                        >

                            <option value="">

                                -- Pilih Signature --

                            </option>

                            @foreach($signatures ?? [] as $signature)

                                <option

                                    value="{{ $signature->id }}"

                                    {{

                                        old(

                                            'general_manager_signature_id'

                                        ) == $signature->id

                                        ? 'selected'

                                        : ''

                                    }}

                                >

                                    {{ $signature->name }}

                                    @if($signature->position)

                                        - {{ $signature->position }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- WSR -->

                <div class="person-card">

                    <h3>

                        WSR

                    </h3>

                    <div class="form-group">

                        <label>

                            Tanda Tangan

                        </label>

                        <select

                            name="wsr_signature_id"

                            class="signature-select"

                        >

                            <option value="">

                                -- Pilih Signature --

                            </option>

                            @foreach($signatures ?? [] as $signature)

                                <option

                                    value="{{ $signature->id }}"

                                    {{

                                        old(

                                            'wsr_signature_id'

                                        ) == $signature->id

                                        ? 'selected'

                                        : ''

                                    }}

                                >

                                    {{ $signature->name }}

                                    @if($signature->position)

                                        - {{ $signature->position }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </section>

        <div class="actions">

            <button

                type="submit"

                class="btn-submit"

            >

                Generate Berita Acara Word &rarr;

            </button>

            <button

                type="submit"

                formaction="{{ route('berita-acara.generate-pdf') }}"

                class="btn-submit"

                style="

                    background:linear-gradient(180deg,#e65353 0%,#d83f3f 100%)!important;

                    box-shadow:0 7px 16px rgba(216,63,63,.20)!important;

                "

            >

                Generate Berita Acara PDF &rarr;

            </button>

        </div>

    </form>

</div>
</div>
@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    const jabatanOptions = [

        'Tool Pusher', 'Driller', 'Asst. Driller', 'HFO',

        'Derrickman', 'Floorman', 'Roustabout', 'Rig Clerk',

        'Tandem Operator', 'Tandem Swamper', 'Vacum Operator',

        'Vacum Swamper', 'Foco Operator',

        'Chief Mechanic / Electrict', 'Foco Swamper', 'Truck Pusher'

    ];

    document.querySelectorAll('[data-jabatan-picker]').forEach(function (picker) {

        const valueField = picker.querySelector('input[type="hidden"]');

        const select = picker.querySelector('select');

        const other = picker.querySelector('.jabatan-other');

        const previousValue = valueField.value.trim();

        jabatanOptions.forEach(function (jabatan) {

            select.add(new Option(jabatan, jabatan));

        });

        select.add(new Option('Other', '__other__'));

        if (previousValue) {

            const match = jabatanOptions.find(function (jabatan) {

                return jabatan.toLowerCase() === previousValue.toLowerCase();

            });

            if (match) {

                select.value = match;

            } else {

                select.value = '__other__';

                other.value = previousValue;

            }

        }

        function syncJabatan() {

            const isOther = select.value === '__other__';

            other.hidden = !isOther;

            other.required = isOther;

            valueField.value = isOther ? other.value.trim() : select.value;

        }

        select.addEventListener('change', syncJabatan);

        other.addEventListener('input', syncJabatan);

        syncJabatan();

    });

    const signatureSelects = document.querySelectorAll(

        'select[name$="_signature_id"]'

    );

    signatureSelects.forEach(function (select) {

        if (select.dataset.searchableReady === '1') {

            return;

        }

        select.dataset.searchableReady = '1';

        select.classList.add('signature-search-native');

        const wrapper = document.createElement('div');

        wrapper.className = 'signature-search-wrap';

        const input = document.createElement('input');

        input.type = 'text';

        input.className = 'signature-search-input';

        input.autocomplete = 'off';

        input.placeholder = 'Cari nama tanda tangan...';

        const results = document.createElement('div');

        results.className = 'signature-search-results';

        select.parentNode.insertBefore(wrapper, select);

        wrapper.appendChild(input);

        wrapper.appendChild(results);

        wrapper.appendChild(select);

        const options = Array.from(select.options).map(function (option) {

            return {

                value: option.value,

                text: option.textContent.trim()

            };

        });

        function selectedText() {

            const selected = select.options[select.selectedIndex];

            if (!selected || !selected.value) {

                return '';

            }

            return selected.textContent.trim();

        }

        function closeResults() {

            results.classList.remove('open');

        }

        function chooseOption(item) {

            select.value = item.value;

            select.dispatchEvent(new Event('change', { bubbles: true }));

            input.value = item.value ? item.text : '';

            closeResults();

        }

        function renderResults(keyword) {

            const query = (keyword || '').trim().toLowerCase();

            results.innerHTML = '';

            const filtered = options.filter(function (item) {

                if (!item.value) {

                    return query === '';

                }

                return item.text.toLowerCase().includes(query);

            });

            if (filtered.length === 0) {

                const empty = document.createElement('div');

                empty.className = 'signature-search-no-result';

                empty.textContent = 'Nama tanda tangan tidak ditemukan';

                results.appendChild(empty);

            } else {

                filtered.forEach(function (item) {

                    const button = document.createElement('button');

                    button.type = 'button';

                    button.className = 'signature-search-option';

                    if (!item.value) {

                        button.classList.add('signature-empty');

                    }

                    button.textContent = item.value

                        ? item.text

                        : 'Tanpa Tanda Tangan';

                    button.addEventListener('mousedown', function (event) {

                        event.preventDefault();

                        chooseOption(item);

                    });

                    results.appendChild(button);

                });

            }

            results.classList.add('open');

        }

        input.value = selectedText();

        input.addEventListener('focus', function () {

            input.select();

            renderResults('');

        });

        input.addEventListener('click', function () {

            renderResults(input.value === selectedText() ? '' : input.value);

        });

        input.addEventListener('input', function () {

            select.value = '';

            renderResults(input.value);

        });

        input.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                input.value = selectedText();

                closeResults();

                input.blur();

            }

            if (event.key === 'Enter') {

                const firstOption = results.querySelector(

                    '.signature-search-option'

                );

                if (firstOption && results.classList.contains('open')) {

                    event.preventDefault();

                    firstOption.dispatchEvent(

                        new MouseEvent('mousedown', { bubbles: true })

                    );

                }

            }

        });

        input.addEventListener('blur', function () {

            window.setTimeout(function () {

                if (!select.value) {

                    input.value = '';

                } else {

                    input.value = selectedText();

                }

                closeResults();

            }, 120);

        });

        select.addEventListener('change', function () {

            input.value = selectedText();

        });

    });

    document.addEventListener('click', function (event) {

        document.querySelectorAll('.signature-search-wrap').forEach(

            function (wrapper) {

                if (!wrapper.contains(event.target)) {

                    const results = wrapper.querySelector(

                        '.signature-search-results'

                    );

                    if (results) {

                        results.classList.remove('open');

                    }

                }

            }

        );

    });

});

</script>
@endpush
