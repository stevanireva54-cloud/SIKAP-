@extends('layouts.app')
@section('title', 'Formulir MOC - SIKAP')
@section('page-title', 'Formulir MOC')
@section('page-subtitle', 'Buat Formulir Management of Change')

@push('styles')
<style>
.unified-page, .unified-page *{ box-sizing: border-box; }
.unified-page{
        --navy:#06345e;
        --navy2:#052744;
        --blue:#0f6fe8;
        --blue-dark:#095bc2;
        --blue-soft:#eef5ff;
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
            radial-gradient(circle at 86% 2%, rgba(15,111,232,.08), transparent 23%),
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
            radial-gradient(circle at 50% 50%, rgba(15,111,232,.12) 0 46%, rgba(15,111,232,.04) 47% 64%, transparent 65%);
    }
.unified-page .hero-art svg{
        position:relative;
        z-index:2;
        width:106px;
        height:106px;
        filter:drop-shadow(0 10px 16px rgba(15,111,232,.12));
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
        border:1px solid #dbe8f8!important;
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
        box-shadow:0 2px 5px rgba(15,111,232,.07)!important;
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
        box-shadow:0 0 0 3px rgba(15,111,232,.09)!important;
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
        background:#eff5fc!important;
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
        background:linear-gradient(180deg,#137cf2 0%,#0f6fe8 100%)!important;
        color:#fff!important;
        font-size:12px!important;
        font-weight:800!important;
        cursor:pointer!important;
        box-shadow:0 7px 16px rgba(15,111,232,.20)!important;
        transition:.2s ease!important;
    }
.unified-page .btn-submit:hover{
        transform:translateY(-1px)!important;
        filter:brightness(.97)!important;
    }
.unified-page .btn-pdf{
        min-height:40px!important;
        padding:10px 18px!important;
        border:1px solid #dc2626!important;
        border-radius:7px!important;
        background:#ffffff!important;
        color:#dc2626!important;
        font-size:12px!important;
        font-weight:800!important;
        cursor:pointer!important;
        box-shadow:0 5px 14px rgba(220,38,38,.08)!important;
        transition:.2s ease!important;
    }
.unified-page .btn-pdf:hover{
        background:#fff1f2!important;
        transform:translateY(-1px)!important;
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
.unified-page .approval-grid, .unified-page .approval-card, .unified-page .approval-card .form-group{
            overflow: visible !important;
        }
.unified-page .signature-picker{
            position: relative;
            width: 100%;
            overflow: visible;
        }
.unified-page .signature-picker.open{
            z-index: 9998;
        }
.unified-page .signature-search{
            width: 100%;
            padding-right: 42px !important;
            cursor: text;
            background: #fff !important;
        }
.unified-page .signature-arrow{
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #7f91a6;
            font-size: 12px;
        }
.unified-page .signature-dropdown{
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 7px);
            z-index: 9999;
            max-height: 240px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #cbd9e8;
            border-radius: 9px;
            box-shadow: 0 14px 32px rgba(16,33,58,.18);
        }
.unified-page .signature-picker.open .signature-dropdown{
            display: block;
        }
.unified-page .signature-option{
            display: block;
            width: 100%;
            border: 0;
            border-bottom: 1px solid #eef3f8;
            padding: 11px 13px;
            text-align: left;
            background: #fff;
            color: #10233e;
            cursor: pointer;
            font: inherit;
        }
.unified-page .signature-option:last-of-type{
            border-bottom: 0;
        }
.unified-page .signature-option:hover, .unified-page .signature-option.active{
            background: #eef6ff;
        }
.unified-page .signature-option strong{
            display: block;
            font-size: 12px;
        }
.unified-page .signature-option span{
            display: block;
            margin-top: 2px;
            font-size: 10px;
            color: #71849b;
        }
.unified-page .signature-empty{
            display: none;
            padding: 12px 13px;
            color: #8090a3;
            font-size: 11px;
        }
.unified-page .section:nth-of-type(9), .unified-page .section.approval-section{
            overflow: visible !important;
            position: relative !important;
            z-index: 80 !important;
        }
.unified-page .approval-grid, .unified-page .approval-card, .unified-page .approval-card .form-group, .unified-page .signature-picker{
            overflow: visible !important;
        }
.unified-page .approval-card{
            position: relative !important;
            z-index: 81 !important;
        }
.unified-page .approval-card:focus-within{
            z-index: 9997 !important;
        }
.unified-page .signature-picker{
            position: relative !important;
        }
.unified-page .signature-picker.open{
            z-index: 9998 !important;
        }
.unified-page .signature-dropdown{
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            top: calc(100% + 7px) !important;
            z-index: 9999 !important;
            max-height: 220px !important;
            overflow-y: auto !important;
            background: #fff !important;
            border: 1px solid #cbd9e8 !important;
            border-radius: 9px !important;
            box-shadow: 0 14px 32px rgba(16,33,58,.18) !important;
        }
.unified-page .section:nth-of-type(10){
            position: relative !important;
            z-index: 1 !important;
        }
.unified-page .app-brand{
        border-bottom: 1px solid #e5e7eb !important;
    }
.unified-page { width:100%; min-width:0; min-height:0; display:block; margin:0; padding:0; color:#263449; font:inherit; background:transparent; }
.unified-page > .page, .unified-page > .container, .unified-page > .content { margin:0!important; padding:0!important; max-width:none!important; width:100%!important; }
.unified-page .hero, .unified-page .hero-card, .unified-page .table-card, .unified-page .search-card, .unified-page .section, .unified-page .card, .unified-page .form-card { border-radius:16px; border-color:#e3e9f0; box-shadow:0 4px 16px rgba(23,34,48,.035); }
.unified-page input, .unified-page select, .unified-page textarea, .unified-page button { font-family:inherit; }
.unified-page .table-card { overflow-x:auto; }
.unified-page .hero h1, .unified-page .hero h2 { font-size:24px; }
@media(max-width:760px) { .unified-page .hero h1,.unified-page .hero h2 { font-size:20px; } }

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
                <rect x="29" y="22" width="62" height="78" rx="10" fill="#FFFFFF" stroke="#0F6FE8" stroke-width="5"/>
                <rect x="46" y="14" width="28" height="14" rx="6" fill="#0F6FE8"/>
                <circle cx="60" cy="20" r="4" fill="#FFFFFF"/>
                <rect x="41" y="42" width="18" height="18" rx="4" fill="#EAF3FF"/>
                <circle cx="50" cy="48" r="4" fill="#0F6FE8"/>
                <path d="M44 57C45.8 52.8 48 51 50 51C52 51 54.2 52.8 56 57" stroke="#0F6FE8" stroke-width="3" stroke-linecap="round"/>
                <rect x="64" y="43" width="16" height="4" rx="2" fill="#B9C9DC"/>
                <rect x="64" y="51" width="16" height="4" rx="2" fill="#D2DCE8"/>
                <path d="M43 70L47 74L54 66" stroke="#0F6FE8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="61" y="69" width="19" height="4" rx="2" fill="#C7D4E2"/>
                <path d="M43 83L47 87L54 79" stroke="#0F6FE8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="61" y="82" width="19" height="4" rx="2" fill="#C7D4E2"/>
                <circle cx="88" cy="87" r="18" fill="#0F6FE8"/>
                <path d="M80 87L86 93L97 80" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>


        <div class="hero-content">

            <div class="hero-badge">
                MANAGEMENT OF CHANGE
            </div>

            <h1>
                Formulir Management of Change (MOC)
            </h1>

            <p>
                Lengkapi data yang diperlukan untuk menghasilkan
                dokumen Management of Change sesuai template perusahaan.
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
        action="{{ route('moc.generate') }}"
        enctype="multipart/form-data"
    >

        @csrf


        <!-- =====================================================
             INFORMASI DOKUMEN
        ====================================================== -->

        <section class="section orange">

            <div class="section-header">

                <div class="section-number">
                    01
                </div>

                <div class="section-title">

                    <h2>
                        Informasi Dokumen
                    </h2>

                    <p>
                        Identitas dokumen MOC.
                    </p>

                </div>

            </div>

            <div class="form-group">

                <label>
                    Judul Dokumen
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="document_title"
                    value="{{ old('document_title') }}"
                    placeholder="Contoh: MOC Pergantian Personel ARJ-10"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    MOC Number
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="moc_number"
                    value="{{ old('moc_number') }}"
                    placeholder="Contoh: 313/MOC/ARJ-10/09/2026"
                    required
                >

                <div class="help">
                    Format: NOMOR/MOC/ARJ-XX/BULAN/TAHUN
                </div>

            </div>

        </section>


        <!-- =====================================================
             USULAN MOC
        ====================================================== -->

        <section class="section">

            <div class="section-header">

                <div class="section-number">
                    02
                </div>

                <div class="section-title">

                    <h2>
                        Usulan MOC
                    </h2>

                    <p>
                        Informasi pihak yang mengusulkan perubahan.
                    </p>

                </div>

            </div>


            <div class="grid-three">

                <div class="form-group">

                    <label>
                        Nama Pengusul
                    </label>

                    <input
                        type="text"
                        name="nama_pengusul"
                        value="{{ old('nama_pengusul') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Departemen
                    </label>

                    <input
                        type="text"
                        value="Operation Rig"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jabatan
                    </label>

                    <input
                        type="text"
                        value="Area Manager"
                        readonly
                    >

                </div>

            </div>

        </section>


        <!-- =====================================================
             INFORMASI PERUBAHAN
        ====================================================== -->

        <section class="section green">

            <div class="section-header">

                <div class="section-number">
                    03
                </div>

                <div class="section-title">

                    <h2>
                        Informasi Perubahan
                    </h2>

                    <p>
                        Detail area dan jenis perubahan yang dilakukan.
                    </p>

                </div>

            </div>


            <div class="grid">

                <div class="form-group">

                    <label>
                        Department
                    </label>

                    <input
                        type="text"
                        name="department"
                        value="{{ old('department') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Pekerja
                    </label>

                    <input
                        type="text"
                        value="WOWS"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Proses
                    </label>

                    <input
                        type="text"
                        name="proses"
                        value="{{ old('proses') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jenis Bahaya
                    </label>

                    <input
                        type="text"
                        name="jenis_bahaya"
                        value="{{ old('jenis_bahaya') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Peralatan
                    </label>

                    <input
                        type="text"
                        name="peralatan"
                        value="{{ old('peralatan') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Lokasi
                    </label>

                    <input
                        type="text"
                        name="lokasi"
                        value="{{ old('lokasi') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Prosedur
                    </label>

                    <input
                        type="text"
                        name="prosedur"
                        value="{{ old('prosedur') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Lain-lain
                    </label>

                    <input
                        type="text"
                        name="lain_lain"
                        value="{{ old('lain_lain') }}"
                    >

                </div>


                <div class="form-group full">

                    <label>
                        Tujuan Perubahan
                    </label>

                    <div style="
                        display:flex;
                        align-items:stretch;
                        gap:8px;
                        width:100%;
                    ">

                        <div style="
                            display:flex;
                            align-items:center;
                            flex:0 0 auto;
                            min-height:88px;
                            padding:10px 12px;
                            border:1px solid #d8e2ec;
                            border-radius:7px;
                            background:#f4f6f9;
                            color:#617087;
                            font-size:12px;
                            font-weight:700;
                            line-height:1.45;
                            white-space:nowrap;
                        ">
                            Permohonan Pergantian Sementara
                        </div>

                        <textarea
                            name="tujuan_perubahan"
                            placeholder="Masukkan lanjutan tujuan perubahan..."
                            style="flex:1; min-width:0;"
                        >{{ old('tujuan_perubahan', '{Jabatan} a/n {Nama} yang tidak masuk dikarenakan {Alasan} dan digantikan oleh {Jabatan yang gantiin} yang sudah comply QAQC & CCPM Pengganti sementara dari ARJ-{No}') }}</textarea>

                    </div>

                    <div class="help-text" style="margin-top:6px;">
                        Teks “Permohonan Pergantian Sementara” bersifat tetap. Isi hanya lanjutan keterangannya.
                    </div>

                </div>


                <div class="form-group full">

                    <label>
                        Hasil Perubahan
                    </label>

                    <textarea
                        name="hasil_perubahan"
                    >{{ old('hasil_perubahan', '{Jabatan} a/n {Nama} untuk support operation Rig ARJ-{No}') }}</textarea>

                </div>

            </div>

        </section>


        <!-- =====================================================
             PENILAIAN RISIKO
        ====================================================== -->

        <section class="section orange">

            <div class="section-header">

                <div class="section-number">
                    04
                </div>

                <div class="section-title">

                    <h2>
                        Penilaian Risiko
                    </h2>

                    <p>
                        Tentukan tingkat risiko perubahan.
                    </p>

                </div>

            </div>


            <div class="form-group full" style="margin-bottom:16px;">

                <label>
                    Penilaian / Keterangan Risiko
                </label>

                <textarea
                    name="penilaian_resiko"
                    placeholder="Contoh: Pergantian sementara personel tidak menimbulkan kendala operasional dan risiko dapat dikendalikan sesuai prosedur."
                >{{ old('penilaian_resiko', '{Jabatan} a/n {Nama} tidak ada kendala dari segi Operasi Rig ARJ-{No}') }}</textarea>

            </div>


            <div class="choice-row">

                <label class="choice">

                    <input
                        type="radio"
                        name="overall_risk"
                        value="TINGGI"
                        {{
                            old('overall_risk') === 'TINGGI'
                            ? 'checked'
                            : ''
                        }}
                    >

                    TINGGI

                </label>


                <label class="choice">

                    <input
                        type="radio"
                        name="overall_risk"
                        value="SEDANG"
                        {{
                            old('overall_risk') === 'SEDANG'
                            ? 'checked'
                            : ''
                        }}
                    >

                    SEDANG

                </label>


                <label class="choice">

                    <input
                        type="radio"
                        name="overall_risk"
                        value="RENDAH"
                        {{
                            old('overall_risk') === 'RENDAH'
                            ? 'checked'
                            : ''
                        }}
                    >

                    RENDAH

                </label>

            </div>

        </section>


        <!-- =====================================================
             PEMERIKSAAN K3LL
        ====================================================== -->

        <section class="section">

            <div class="section-header">

                <div class="section-number">
                    05
                </div>

                <div class="section-title">

                    <h2>
                        Pemeriksaan K3LL & Penilaian
                    </h2>

                    <p>
                        Pemeriksaan bahaya dan potensi insiden.
                    </p>

                </div>

            </div>


            <div class="grid">

                <div class="form-group full">

                    <label>
                        Apakah ada penelitian bahaya lebih lanjut diperlukan?
                    </label>

                    <select name="penelitian_bahaya">

                        <option value="">
                            -- Pilih --
                        </option>

                        <option
                            value="YA"
                            {{
                                old('penelitian_bahaya', 'YA') === 'YA'
                                ? 'selected'
                                : ''
                            }}
                        >
                            YA
                        </option>

                        <option
                            value="TIDAK"
                            {{
                                old('penelitian_bahaya') === 'TIDAK'
                                ? 'selected'
                                : ''
                            }}
                        >
                            TIDAK
                        </option>

                    </select>

                </div>


                <div class="form-group full">

                    <label>
                        Keterangan / Alasan Penelitian Bahaya
                        <span class="required">*</span>
                    </label>

                    <textarea
                        name="risk_register_action_plan"
                        placeholder="Contoh: Form Risk Register terlampir & Action Plan"
                        required
                    >{{ old('risk_register_action_plan', 'Form Risk Register terlampir & Action Plan') }}</textarea>

                    <div class="help">
                        Isi alasan atau keterangan untuk pilihan YA maupun TIDAK.
                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Bahaya Baru
                    </label>

                    <textarea
                        name="bahaya_baru"
                    >{{ old('bahaya_baru', 'Tidak ada') }}</textarea>

                </div>


                <div class="form-group">

                    <label>
                        Kemungkinan Insiden
                    </label>

                    <textarea
                        name="kemungkinan_insiden"
                    >{{ old('kemungkinan_insiden', 'Tidak ada') }}</textarea>

                </div>

            </div>

        </section>


        <!-- =====================================================
             DAMPAK PERUBAHAN
        ====================================================== -->

        <section class="section green">

            <div class="section-header">

                <div class="section-number">
                    06
                </div>

                <div class="section-title">

                    <h2>
                        Dampak Perubahan
                    </h2>

                    <p>
                        Isi keterangan dan status untuk masing-masing poin.
                    </p>

                </div>

            </div>


            @php
                $impactQuestions = [
                1 => 'Apakah perubahan mengakibatkan perubahan juga pada standar atau prosedur? Jika ada, pada standar atau prosedur mana?',
                2 => 'Apakah perubahan berakibat pada garansi atau pada maintenance agreement? Jika ada, apa dampaknya?',
                3 => 'Apakah perubahan berakibat pada maintenance? Bagian yang mana?',
                4 => 'Apakah perubahan mengakibatkan perubahan pada rancangan/drawing? Rancangan/drawing yang mana?',
                5 => 'Apakah perubahan mengurangi barang-barang persediaan? Jika ada, barang-barang persediaan yang mana?',
                6 => 'Apakah perubahan membutuhkan penyimpanan parts baru? Jika ada, barang/parts apakah itu?',
                7 => 'Apakah proposal mengenalkan bahan kimia baru? Jika ada, lampirkan MSDS.',
                8 => 'Apakah perubahan membutuhkan persetujuan dari pabrik pembuat alat / Original Equipment Manufacture?',
                9 => 'Apakah perubahan memiliki dampak kepada pihak lain atau dokumen pendukung? Jika YA, isi tabel di bawah ini:',

                ];
            @endphp


            <div class="form-group" style="max-width: 260px; margin-bottom: 14px !important;">

                <label for="impact-status-all">
                    Pilih Semua Status
                </label>

                <select id="impact-status-all">
                    <option value="">
                        -- Pilih Semua --
                    </option>

                    <option value="YA">
                        YA untuk semua
                    </option>

                    <option value="TIDAK">
                        TIDAK untuk semua
                    </option>

                    <option value="N/A">
                        N/A untuk semua
                    </option>
                </select>

                <div class="help">
                    Pilihan ini akan mengisi seluruh status sekaligus.
                    Setelah itu setiap baris tetap bisa diubah satu per satu.
                </div>

            </div>


            <div class="table-wrap">

                <table>

                    <thead>

                    <tr>
                        <th style="width:55px;">
                            No
                        </th>

                        <th>
                            Pertanyaan
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th style="width:160px;">
                            Status
                        </th>
                    </tr>

                    </thead>


                    <tbody>

                    @foreach($impactQuestions as $i => $question)

                        <tr>

                            <td>
                                {{ $i }}
                            </td>

                            <td>
                                {{ $question }}
                            </td>

                            <td>

                                <input
                                    type="text"
                                    name="impact[{{ $i }}][keterangan]"
                                    value="{{
                                        old(
                                            'impact.' .
                                            $i .
                                            '.keterangan'
                                        )
                                    }}"
                                >

                            </td>

                            <td>

                                <select
                                    name="impact[{{ $i }}][status]"
                                    class="impact-status-select"
                                    data-impact-status
                                >

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    @foreach(
                                        [
                                            'YA',
                                            'TIDAK',
                                            'N/A'
                                        ]
                                        as $status
                                    )

                                        <option
                                            value="{{ $status }}"
                                            {{
                                                old(
                                                    'impact.' .
                                                    $i .
                                                    '.status'
                                                ) === $status
                                                ? 'selected'
                                                : ''
                                            }}
                                        >
                                            {{ $status }}
                                        </option>

                                    @endforeach

                                </select>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </section>


        <!-- =====================================================
             PERLU DIINFORMASIKAN
        ====================================================== -->

        <section class="section orange">

            <div class="section-header">

                <div class="section-number">
                    07
                </div>

                <div class="section-title">

                    <h2>
                        Siapa yang Perlu Diinformasikan
                    </h2>

                    <p>
                        Maksimal enam pihak sesuai template.
                    </p>

                </div>

            </div>


            <div class="table-wrap">

                <table>

                    <thead>

                    <tr>
                        <th style="width:55px;">No</th>

                        <th>
                            Nama dan Jabatan
                        </th>

                        <th>
                            Departemen
                        </th>

                        <th>
                            Keterangan<br>
                            <label for="informasi-status-all">Isi semua:</label>
                            <select id="informasi-status-all" aria-label="Isi semua keterangan">
                                <option value="">-- Pilih --</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </th>
                    </tr>

                    </thead>


                    <tbody>

                    @php
                        $informasiDepartemenDefaults = [
                            'DISTRIC MANAGER',
                            'DEPUTI DW/DWO',
                            'Area Manager',
                            'Field Coordinator',
                            'HES Supt',
                            'HES Coord',
                        ];
                    @endphp

                    @for($i = 0; $i < 6; $i++)

                        <tr>

                            <td>{{ $i + 1 }}</td>

                            <td>

                                <input
                                    type="text"
                                    name="informasi[{{ $i }}][nama_jabatan]"
                                    value="{{
                                        old(
                                            'informasi.' .
                                            $i .
                                            '.nama_jabatan'
                                        )
                                    }}"
                                >

                            </td>

                            <td>

                                <input
                                    type="text"
                                    name="informasi[{{ $i }}][departemen]"
                                    value="{{
                                        old(
                                            'informasi.' .
                                            $i .
                                            '.departemen',
                                            $informasiDepartemenDefaults[$i]
                                        )
                                    }}"
                                >

                            </td>

                            <td>

                                <select
                                    name="informasi[{{ $i }}][keterangan]"
                                    data-informasi-status
                                >

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    <option
                                        value="Diterima"
                                        {{
                                            old(
                                                'informasi.' .
                                                $i .
                                                '.keterangan',
                                                'Diterima'
                                            ) === 'Diterima'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Diterima
                                    </option>

                                    <option
                                        value="Ditolak"
                                        {{
                                            old(
                                                'informasi.' .
                                                $i .
                                                '.keterangan'
                                            ) === 'Ditolak'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Ditolak
                                    </option>

                                </select>

                            </td>

                        </tr>

                    @endfor

                    </tbody>

                </table>

            </div>

        </section>


        <!-- =====================================================
             DIPERIKSA
        ====================================================== -->

        <section class="section approval-section">

            <div class="section-header">

                <div class="section-number">
                    08
                </div>

                <div class="section-title">

                    <h2>
                        Diperiksa Oleh
                    </h2>

                    <p>
                        Pemeriksa MOC sesuai format dokumen.
                    </p>

                </div>

            </div>


            <div class="table-wrap">

                <table>

                    <thead>

                    <tr>
                        <th>
                            Nama
                        </th>

                        <th>
                            Jabatan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Status
                        </th>
                    </tr>

                    </thead>


                    <tbody>

                    @for($i = 0; $i < 2; $i++)

                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="diperiksa[{{ $i }}][nama]"
                                    value="{{
                                        old(
                                            'diperiksa.' .
                                            $i .
                                            '.nama'
                                        )
                                    }}"
                                >

                            </td>


                            <td>

                                <input
                                    type="text"
                                    name="diperiksa[{{ $i }}][jabatan]"
                                    value="{{
                                        old(
                                            'diperiksa.' .
                                            $i .
                                            '.jabatan'
                                        )
                                    }}"
                                >

                            </td>


                            <td>

                                <input
                                    type="date"
                                    name="diperiksa[{{ $i }}][tanggal]"
                                    value="{{
                                        old(
                                            'diperiksa.' .
                                            $i .
                                            '.tanggal'
                                        )
                                    }}"
                                >

                            </td>


                            <td>

                                <select
                                    name="diperiksa[{{ $i }}][status]"
                                >

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    <option
                                        value="Diterima"
                                        {{
                                            old(
                                                'diperiksa.' .
                                                $i .
                                                '.status'
                                            ) === 'Diterima'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Diterima
                                    </option>

                                    <option
                                        value="Ditolak"
                                        {{
                                            old(
                                                'diperiksa.' .
                                                $i .
                                                '.status'
                                            ) === 'Ditolak'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Ditolak
                                    </option>

                                </select>

                            </td>

                        </tr>

                    @endfor

                    </tbody>

                </table>

            </div>

        </section>


        <!-- =====================================================
             DISETUJUI
        ====================================================== -->

        <section class="section green">

            <div class="section-header">

                <div class="section-number">
                    09
                </div>

                <div class="section-title">

                    <h2>
                        Disetujui Oleh
                    </h2>

                    <p>
                        Rig Superintendent dan Area Manager.
                    </p>

                </div>

            </div>


            <div class="approval-grid">


                <div class="approval-card">

                    <h3>
                        Rig Superintendent
                    </h3>

                    <div class="form-group">

                        <label>
                            Nama
                        </label>

                        <input
                            type="text"
                            name="approval[0][nama]"
                            value="{{
                                old(
                                    'approval.0.nama'
                                )
                            }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Tanda Tangan
                        </label>

                        <div
                            class="signature-picker"
                            data-signature-picker
                            data-name-input="approval[0][nama]"
                        >
                            <input
                                type="hidden"
                                name="approval[0][signature_id]"
                                value="{{ old('approval.0.signature_id') }}"
                                data-signature-value
                            >

                            <input
                                type="text"
                                class="signature-search"
                                placeholder="Cari nama atau jabatan tanda tangan..."
                                autocomplete="off"
                                data-signature-search
                            >

                            <span class="signature-arrow">▼</span>

                            <div class="signature-dropdown">

                                <button
                                    type="button"
                                    class="signature-option"
                                    data-signature-option
                                    data-id=""
                                    data-name=""
                                    data-label="-- Tanpa Tanda Tangan --"
                                    data-search="tanpa tanda tangan"
                                >
                                    -- Tanpa Tanda Tangan --
                                </button>

                                @foreach($signatures ?? [] as $signature)
                                    <button
                                        type="button"
                                        class="signature-option"
                                        data-signature-option
                                        data-id="{{ $signature->id }}"
                                        data-name="{{ $signature->name }}"
                                        data-label="{{ $signature->name }}{{ $signature->position ? ' - ' . $signature->position : '' }}"
                                        data-search="{{ strtolower($signature->name . ' ' . ($signature->position ?? '')) }}"
                                    >
                                        <strong>{{ $signature->name }}</strong>
                                        @if($signature->position)
                                            <span>{{ $signature->position }}</span>
                                        @endif
                                    </button>
                                @endforeach

                                <div class="signature-empty" data-signature-empty>
                                    Signature tidak ditemukan.
                                </div>

                            </div>
                        </div>

                    </div>

                </div>


                <div class="approval-card">

                    <h3>
                        Area Manager
                    </h3>

                    <div class="form-group">

                        <label>
                            Nama
                        </label>

                        <input
                            type="text"
                            name="approval[1][nama]"
                            value="{{
                                old(
                                    'approval.1.nama'
                                )
                            }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Tanda Tangan
                        </label>

                        <div
                            class="signature-picker"
                            data-signature-picker
                            data-name-input="approval[1][nama]"
                        >
                            <input
                                type="hidden"
                                name="approval[1][signature_id]"
                                value="{{ old('approval.1.signature_id') }}"
                                data-signature-value
                            >

                            <input
                                type="text"
                                class="signature-search"
                                placeholder="Cari nama atau jabatan tanda tangan..."
                                autocomplete="off"
                                data-signature-search
                            >

                            <span class="signature-arrow">▼</span>

                            <div class="signature-dropdown">

                                <button
                                    type="button"
                                    class="signature-option"
                                    data-signature-option
                                    data-id=""
                                    data-name=""
                                    data-label="-- Tanpa Tanda Tangan --"
                                    data-search="tanpa tanda tangan"
                                >
                                    -- Tanpa Tanda Tangan --
                                </button>

                                @foreach($signatures ?? [] as $signature)
                                    <button
                                        type="button"
                                        class="signature-option"
                                        data-signature-option
                                        data-id="{{ $signature->id }}"
                                        data-name="{{ $signature->name }}"
                                        data-label="{{ $signature->name }}{{ $signature->position ? ' - ' . $signature->position : '' }}"
                                        data-search="{{ strtolower($signature->name . ' ' . ($signature->position ?? '')) }}"
                                    >
                                        <strong>{{ $signature->name }}</strong>
                                        @if($signature->position)
                                            <span>{{ $signature->position }}</span>
                                        @endif
                                    </button>
                                @endforeach

                                <div class="signature-empty" data-signature-empty>
                                    Signature tidak ditemukan.
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             PENUTUP
        ====================================================== -->

        <section class="section orange">

            <div class="section-header">

                <div class="section-number">
                    10
                </div>

                <div class="section-title">

                    <h2>
                        Informasi Akhir
                    </h2>

                    <p>
                        Tanggal efektif dan kontak person.
                    </p>

                </div>

            </div>


            <div class="grid">

                <div class="form-group">

                    <label>
                        Tanggal Efektif
                    </label>

                    <input
                        type="date"
                        name="tanggal_efektif"
                        value="{{ old('tanggal_efektif') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Kontak Person
                    </label>

                    <input
                        type="text"
                        name="kontak_person"
                        value="{{ old('kontak_person') }}"
                    >

                </div>

            </div>

        </section>


        <div class="actions">

            <button
                type="submit"
                class="btn-submit"
                formaction="{{ route('moc.generate') }}"
            >
                Generate Formulir MOC Word &rarr;
            </button>

            <button
                type="submit"
                class="btn-pdf"
                formaction="{{ route('moc.generate-pdf') }}"
            >
                Generate Formulir MOC PDF &rarr;
            </button>

        </div>

    </form>

</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       PILIH SEMUA STATUS DAMPAK PERUBAHAN
    ========================================================= */

    const impactStatusAll = document.getElementById('impact-status-all');
    const impactStatusSelects = Array.from(
        document.querySelectorAll('[data-impact-status]')
    );

    if (impactStatusAll) {

        impactStatusAll.addEventListener('change', function () {

            const selectedValue = this.value;

            if (selectedValue === '') {
                return;
            }

            impactStatusSelects.forEach(function (select) {
                select.value = selectedValue;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        impactStatusSelects.forEach(function (select) {

            select.addEventListener('change', function () {

                const values = impactStatusSelects.map(function (item) {
                    return item.value;
                });

                const firstValue = values[0] || '';
                const allSame = values.every(function (value) {
                    return value === firstValue;
                });

                impactStatusAll.value = allSame ? firstValue : '';
            });
        });

        const initialValues = impactStatusSelects.map(function (item) {
            return item.value;
        });

        if (initialValues.length > 0) {
            const firstValue = initialValues[0] || '';
            const allSame = initialValues.every(function (value) {
                return value === firstValue;
            });

            impactStatusAll.value = allSame ? firstValue : '';
        }
    }

    const informasiStatusAll = document.getElementById('informasi-status-all');
    const informasiStatuses = Array.from(document.querySelectorAll('[data-informasi-status]'));
    if (informasiStatusAll) {
        informasiStatusAll.addEventListener('change', function () {
            informasiStatuses.forEach(function (select) {
                select.value = informasiStatusAll.value;
            });
        });
        informasiStatuses.forEach(function (select) {
            select.addEventListener('change', function () {
                const first = informasiStatuses[0].value;
                informasiStatusAll.value = informasiStatuses.every(function (item) {
                    return item.value === first;
                }) ? first : '';
            });
        });
        const first = informasiStatuses[0] && informasiStatuses[0].value;
        informasiStatusAll.value = first && informasiStatuses.every(function (item) {
            return item.value === first;
        }) ? first : '';
    }

    document.querySelectorAll('[data-signature-picker]').forEach(function (picker) {

        const search = picker.querySelector('[data-signature-search]');
        const hidden = picker.querySelector('[data-signature-value]');
        const options = Array.from(
            picker.querySelectorAll('[data-signature-option]')
        );
        const empty = picker.querySelector('[data-signature-empty]');
        const nameInputName = picker.dataset.nameInput;
        const nameInput = document.querySelector(
            'input[name="' + nameInputName + '"]'
        );

        function filterOptions() {
            const query = (search.value || '').trim().toLowerCase();
            let visible = 0;

            options.forEach(function (option) {
                const haystack = (
                    (option.dataset.search || '') + ' ' +
                    (option.dataset.label || '')
                ).toLowerCase();

                const matches =
                    query === '' ||
                    haystack.includes(query);

                option.style.display = matches ? 'block' : 'none';

                if (matches) {
                    visible++;
                }
            });

            if (empty) {
                empty.style.display = visible === 0 ? 'block' : 'none';
            }
        }

        function openPicker() {
            document.querySelectorAll(
                '[data-signature-picker].open'
            ).forEach(function (other) {
                if (other !== picker) {
                    other.classList.remove('open');
                }
            });

            picker.classList.add('open');
            filterOptions();
        }

        function closePicker() {
            picker.classList.remove('open');
        }

        const selectedId = hidden.value;

        if (selectedId) {
            const selectedOption = options.find(function (option) {
                return String(option.dataset.id) === String(selectedId);
            });

            if (selectedOption) {
                search.value = selectedOption.dataset.label || '';
                selectedOption.classList.add('active');
            }
        }

        search.addEventListener('focus', openPicker);
        search.addEventListener('click', openPicker);

        search.addEventListener('input', function () {
            hidden.value = '';

            options.forEach(function (option) {
                option.classList.remove('active');
            });

            openPicker();
        });

        options.forEach(function (option) {
            option.addEventListener('click', function () {

                const id = option.dataset.id || '';
                const label = option.dataset.label || '';
                const personName = option.dataset.name || '';

                hidden.value = id;
                search.value = label;

                options.forEach(function (item) {
                    item.classList.toggle('active', item === option);
                });

                if (id && nameInput && !nameInput.value.trim()) {
                    nameInput.value = personName;
                }

                closePicker();
            });
        });

        document.addEventListener('click', function (event) {
            if (!picker.contains(event.target)) {
                closePicker();
            }
        });
    });
});
</script>
@endpush
