@extends('layouts.app')
@section('title', 'Surat Tugas - SIKAP')
@section('page-title', 'Surat Tugas')
@section('page-subtitle', 'Buat Surat Tugas untuk penempatan atau pergantian personel')

@push('styles')
<style>
.unified-page, .unified-page *{ box-sizing: border-box; }
.unified-page{
        --navy:#06345e;
        --navy2:#052744;
        --blue:#4b9b45;
        --blue-dark:#3f853a;
        --blue-soft:#eef8ec;
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
            radial-gradient(circle at 86% 2%, rgba(75,155,69,.08), transparent 23%),
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
            radial-gradient(circle at 50% 50%, rgba(75,155,69,.12) 0 46%, rgba(75,155,69,.04) 47% 64%, transparent 65%);
    }
.unified-page .hero-art svg{
        position:relative;
        z-index:2;
        width:106px;
        height:106px;
        filter:drop-shadow(0 10px 16px rgba(75,155,69,.12));
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
        border:1px solid #dcebd9!important;
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
        box-shadow:0 2px 5px rgba(75,155,69,.07)!important;
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
.unified-page .date-grid{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
.unified-page .jabatan-picker{ display:flex; align-items:center; gap:10px; }
.unified-page .jabatan-picker select, .unified-page .jabatan-picker .jabatan-other{ flex:1; min-width:0; }
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
        box-shadow:0 0 0 3px rgba(75,155,69,.09)!important;
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
.unified-page .yes-no-choice{
        display:inline-flex!important;
        align-items:center!important;
        gap:8px!important;
        margin:0!important;
        padding:7px 10px!important;
        border:1px solid #dce4ed!important;
        border-radius:7px!important;
        font-size:11px!important;
        cursor:pointer;
    }
.unified-page .yes-no-choice input[type="checkbox"]{
        width:16px!important;
        height:16px!important;
        min-height:0!important;
        padding:0!important;
        margin:0!important;
        accent-color:var(--blue)!important;
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
        background:#f1f8ef!important;
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
        background:linear-gradient(180deg,#58aa51 0%,#4b9b45 100%)!important;
        color:#fff!important;
        font-size:12px!important;
        font-weight:800!important;
        cursor:pointer!important;
        box-shadow:0 7px 16px rgba(75,155,69,.20)!important;
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
.unified-page form{ counter-reset: docsection; }
.unified-page .card > h2{
    counter-increment: docsection;
    position: relative !important;
    min-height: 34px !important;
    display: flex !important;
    align-items: center !important;
    margin: 0 0 18px !important;
    padding: 0 0 0 47px !important;
    color: #4b9b45 !important;
    font-size: 16px !important;
    font-weight: 800 !important;
    line-height: 1.25 !important;
}
.unified-page .card > h2::before{
    content: counter(docsection, decimal-leading-zero) !important;
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    width: 34px !important;
    height: 34px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: 1.8px solid #4b9b45 !important;
    border-radius: 7px !important;
    background: #ffffff !important;
    color: #4b9b45 !important;
    font-size: 12px !important;
    font-weight: 800 !important;
    line-height: 1 !important;
    box-shadow: 0 2px 5px rgba(75,155,69,.07) !important;
}
.unified-page .card::before{
    background: #4b9b45 !important;
}
.unified-page .btn-primary, .unified-page .btn-submit{
    background: linear-gradient(180deg,#58aa51 0%,#4b9b45 100%) !important;
    box-shadow: 0 7px 16px rgba(75,155,69,.20) !important;
}
.unified-page .library-link{ color:#4b9b45 !important; }
@media(max-width:760px){.unified-page .card > h2{
        padding-left: 45px !important;
        font-size: 15px !important;
    }}
.unified-page .page, .unified-page .container{
    width: calc(100% - 44px) !important;
    max-width: 1040px !important;
    margin: 0 auto !important;
    padding: 24px 0 56px !important;
}
.unified-page .back{
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 7px !important;

    min-height: 38px !important;

    margin: 0 0 20px !important;
    padding: 8px 13px !important;

    border: 1px solid #cfd9e5 !important;
    border-radius: 7px !important;

    background: #ffffff !important;
    color: #20364f !important;

    font-size: 12px !important;
    font-weight: 700 !important;

    text-decoration: none !important;

    box-shadow: 0 2px 6px rgba(16,33,58,.04) !important;
    transition: .2s ease !important;
}
.unified-page .back:hover{
    border-color: #4b9b45 !important;
    color: #4b9b45 !important;
    background: #f8fcf7 !important;
    transform: translateY(-1px) !important;
}
.unified-page .hero{
    margin: 0 0 16px !important;
    padding-top: 8px !important;
}
.unified-page .card, .unified-page .section{
    margin-bottom: 14px !important;
}
@media (max-width: 760px){.unified-page .page, .unified-page .container{
        width: calc(100% - 24px) !important;
        padding-top: 18px !important;
    }}
.unified-page .app-brand{
    border-bottom: 1px solid #e5e7eb !important;
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
.unified-page .signature-search-wrap > select.signature-search-native{
    position: absolute !important;
    left: -99999px !important;
    top: auto !important;
    width: 1px !important;
    height: 1px !important;
    min-width: 1px !important;
    min-height: 1px !important;
    max-width: 1px !important;
    max-height: 1px !important;
    padding: 0 !important;
    margin: 0 !important;
    border: 0 !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    overflow: hidden !important;
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
<div class="container">


    <a
        href="{{ route('dashboard') }}"
        class="back"
    >
        ← Kembali ke Dashboard
    </a>

    <div class="hero">
        <div class="hero-art" aria-hidden="true">
            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="29" y="22" width="62" height="78" rx="10" fill="#FFFFFF" stroke="#4B9B45" stroke-width="5"/>
                <rect x="46" y="14" width="28" height="14" rx="6" fill="#4B9B45"/>
                <circle cx="60" cy="20" r="4" fill="#FFFFFF"/>
                <circle cx="47" cy="45" r="8" fill="#EEF8EC"/>
                <path d="M47 39V46" stroke="#4B9B45" stroke-width="3" stroke-linecap="round"/>
                <circle cx="47" cy="50" r="1.8" fill="#4B9B45"/>
                <rect x="61" y="42" width="20" height="4" rx="2" fill="#C6D8C3"/>
                <rect x="61" y="51" width="17" height="4" rx="2" fill="#D6E4D4"/>
                <rect x="40" y="66" width="40" height="4" rx="2" fill="#C9DCC7"/>
                <rect x="40" y="77" width="34" height="4" rx="2" fill="#C9DCC7"/>
                <rect x="40" y="88" width="27" height="4" rx="2" fill="#C9DCC7"/>
                <circle cx="88" cy="87" r="18" fill="#4B9B45"/>
                <path d="M80 87L86 93L97 80" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="hero-content">
            <h1>Surat Tugas</h1>
            <p>Isi data sesuai Surat Tugas personel.</p>
        </div>
    </div>



    @if(session('error'))

        <div class="alert-error">
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <strong>
                Ada data yang perlu diperbaiki:
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
        action="{{ route('surat-tugas.generate') }}"
        method="POST"
    >

        @csrf


        {{-- ============================================================= --}}
        {{-- INFORMASI DOKUMEN --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Informasi Dokumen
            </h2>


            <div class="grid-2">

                <div class="form-group">

                    <label>
                        Judul Dokumen
                    </label>

                    <input
                        type="text"
                        name="document_title"
                        value="{{ old('document_title') }}"
                        placeholder="Contoh: Surat Tugas Asmara Hadi ARJ-10"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Rig
                    </label>

                    <select
                        name="rig"
                        required
                    >

                        <option value="">
                            -- Pilih Rig --
                        </option>

                        @foreach([
                            'ARJ-06',
                            'ARJ-07',
                            'ARJ-09',
                            'ARJ-10',
                            'ARJ-11',
                            'ARJ-15'
                        ] as $rig)

                            <option
                                value="{{ $rig }}"
                                {{ old('rig') === $rig ? 'selected' : '' }}
                            >
                                {{ $rig }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- STATUS --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Status Personel
            </h2>

            <div class="form-group">

                <label>
                    Status
                </label>

                <select
                    name="status_personel"
                    required
                >

                    <option value="">
                        -- Pilih --
                    </option>

                    <option
                        value="Tidak hadir"
                        {{ old('status_personel') === 'Tidak hadir' ? 'selected' : '' }}
                    >
                        Tidak hadir
                    </option>

                    <option
                        value="Di actingkan"
                        {{ old('status_personel') === 'Di actingkan' ? 'selected' : '' }}
                    >
                        Di actingkan
                    </option>

                </select>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- PERSONEL YANG DIGANTI --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Personel yang Diganti
            </h2>

            <div class="grid-2">

                <div class="form-group">

                    <label>
                        Nama
                    </label>

                    <input
                        type="text"
                        name="old_name"
                        value="{{ old('old_name') }}"
                        placeholder="Contoh: Zaresmon Hendra"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jabatan
                    </label>

                    <div class="jabatan-picker" data-jabatan-picker>
                        <input type="hidden" name="old_job" value="{{ old('old_job') }}">
                        <select aria-label="Pilih jabatan personel yang diganti" required>
                            <option value="">Pilih jabatan</option>
                        </select>
                        <input type="text" class="jabatan-other" placeholder="Isi jabatan lainnya" aria-label="Jabatan lain personel yang diganti" maxlength="255" hidden>
                    </div>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Alasan
                </label>

                <input
                    type="text"
                    name="reason"
                    value="{{ old('reason') }}"
                    placeholder="Contoh: Cuti"
                    required
                >

            </div>


            <div class="grid-2 date-grid">

                <div class="form-group">

                    <label>
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        min="{{ old('start_date') }}"
                    >

                    <div class="hint" style="margin-top:6px;">
                        Opsional. Kosongkan jika hanya 1 hari.
                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- PERSONEL PENGGANTI --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Personel Pengganti
            </h2>

            <div class="grid-2">

                <div class="form-group">

                    <label>
                        Nama
                    </label>

                    <input
                        type="text"
                        name="new_name"
                        value="{{ old('new_name') }}"
                        placeholder="Contoh: Asmara Hadi"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jabatan
                    </label>

                    <div class="jabatan-picker" data-jabatan-picker>
                        <input type="hidden" name="new_job" value="{{ old('new_job') }}">
                        <select aria-label="Pilih jabatan personel pengganti" required>
                            <option value="">Pilih jabatan</option>
                        </select>
                        <input type="text" class="jabatan-other" placeholder="Isi jabatan lainnya" aria-label="Jabatan lain personel pengganti" maxlength="255" hidden>
                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- MENTOR --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Mentor
            </h2>

            <p class="hint">
                Isi jika personel merupakan SSE.
            </p>


            <div class="grid-2">

                <div class="form-group">

                    <label>
                        Nama Mentor
                    </label>

                    <input
                        type="text"
                        name="mentor_name"
                        value="{{ old('mentor_name') }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jabatan Mentor
                    </label>

                    <input
                        type="text"
                        name="mentor_job"
                        value="{{ old('mentor_job') }}"
                    >

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- CHECKLIST --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Checklist Kelengkapan Dokumen Karyawan
            </h2>

            <p class="hint">
                V = Ada,
                X = Tidak Ada,
                T/P = Tidak Diperlukan.
            </p>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th style="width:56px;">
                                No.
                            </th>

                            <th>
                                Dokumen
                            </th>

                            <th style="width:230px;">
                                <div style="display:flex; flex-direction:column; gap:8px;">
                                    <span>Status</span>

                                    <select
                                        id="checklist-select-all"
                                        style="width:100%;"
                                    >
                                        <option value="">
                                            -- Pilih Semua --
                                        </option>

                                        <option value="V">
                                            V - Ada
                                        </option>

                                        <option value="X">
                                            X - Tidak Ada
                                        </option>

                                        <option value="T/P">
                                            T/P - Tidak Diperlukan
                                        </option>
                                    </select>

                                </div>
                            </th>

                            <th style="width:210px;">
                                Yes / No
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        {{-- 1. BADGE --}}
                        <tr>
                            <td>
                                1.
                            </td>

                            <td>
                                <strong>Badge</strong>
                            </td>

                            <td>
                                <select
                                    name="badge"
                                    class="checklist-status-select"
                                >
                                    <option value="">-- Pilih --</option>

                                    <option
                                        value="V"
                                        {{ old('badge') === 'V' ? 'selected' : '' }}
                                    >
                                        V - Ada
                                    </option>

                                    <option
                                        value="X"
                                        {{ old('badge') === 'X' ? 'selected' : '' }}
                                    >
                                        X - Tidak Ada
                                    </option>

                                    <option
                                        value="T/P"
                                        {{ old('badge') === 'T/P' ? 'selected' : '' }}
                                    >
                                        T/P - Tidak Diperlukan
                                    </option>
                                </select>
                            </td>

                            <td>
                                -
                            </td>
                        </tr>


                        {{-- 2. SERTIFIKAT --}}
                        <tr>
                            <td style="vertical-align:top;">
                                2.
                            </td>

                            <td colspan="3">

                                <div style="font-weight:800; margin-bottom:12px;">
                                    Sertifikat
                                </div>


                                {{-- MIGAS --}}
                                <div style="
                                    display:grid;
                                    grid-template-columns:70px repeat(7,minmax(72px,1fr));
                                    gap:8px;
                                    align-items:end;
                                    margin-bottom:12px;
                                ">

                                    <div style="font-weight:700; padding-bottom:12px;">
                                        Migas
                                    </div>

                                    @foreach([
                                        'iadc' => 'IADC',
                                        'apps' => 'APPS',
                                        'oups' => 'OUPS',
                                        'omps' => 'OMPS',
                                        'olps' => 'OLPS',
                                        'tkbt' => 'TKBT',
                                        'lop' => 'LOP',
                                        'k3' => 'K3',
                                        'sim' => 'SIM',
                                        'apb' => 'APB',
                                        'jb' => 'JB',
                                        'olb' => 'OLB',
                                        'omb' => 'OMB',
                                        'sio' => 'SIO',
                                    ] as $field => $label)

                                        @if($field === 'k3')
                                            <div aria-hidden="true"></div>
                                        @endif

                                        <div>

                                            <label style="font-size:10px;">
                                                {{ $label }}
                                            </label>

                                            <select
                                                name="{{ $field }}"
                                                class="checklist-status-select"
                                            >
                                                <option value="">-- Pilih --</option>

                                                <option
                                                    value="V"
                                                    {{ old($field) === 'V' ? 'selected' : '' }}
                                                >
                                                    V - Ada
                                                </option>

                                                <option
                                                    value="X"
                                                    {{ old($field) === 'X' ? 'selected' : '' }}
                                                >
                                                    X - Tidak Ada
                                                </option>

                                                <option
                                                    value="T/P"
                                                    {{ old($field) === 'T/P' ? 'selected' : '' }}
                                                >
                                                    T/P - Tidak Diperlukan
                                                </option>
                                            </select>

                                        </div>

                                    @endforeach

                                </div>


                                {{-- DISNAKER --}}
                                <div style="
                                    display:grid;
                                    grid-template-columns:70px minmax(130px,1fr) minmax(130px,1fr) minmax(220px,2fr);
                                    gap:10px;
                                    align-items:end;
                                ">

                                    <div style="font-weight:700; padding-bottom:12px;">
                                        Disnaker
                                    </div>


                                    <div>

                                        <label style="font-size:10px;">
                                            K3PAA
                                        </label>

                                        <select
                                            name="k3_disnaker"
                                            class="checklist-status-select"
                                        >
                                            <option value="">-- Pilih --</option>

                                            <option
                                                value="V"
                                                {{ old('k3_disnaker') === 'V' ? 'selected' : '' }}
                                            >
                                                V - Ada
                                            </option>

                                            <option
                                                value="X"
                                                {{ old('k3_disnaker') === 'X' ? 'selected' : '' }}
                                            >
                                                X - Tidak Ada
                                            </option>

                                            <option
                                                value="T/P"
                                                {{ old('k3_disnaker') === 'T/P' ? 'selected' : '' }}
                                            >
                                                T/P - Tidak Diperlukan
                                            </option>
                                        </select>

                                    </div>


                                    <div>

                                        <label style="font-size:10px;">
                                            Rigger
                                        </label>

                                        <select
                                            name="rigger"
                                            class="checklist-status-select"
                                        >
                                            <option value="">-- Pilih --</option>

                                            <option
                                                value="V"
                                                {{ old('rigger') === 'V' ? 'selected' : '' }}
                                            >
                                                V - Ada
                                            </option>

                                            <option
                                                value="X"
                                                {{ old('rigger') === 'X' ? 'selected' : '' }}
                                            >
                                                X - Tidak Ada
                                            </option>

                                            <option
                                                value="T/P"
                                                {{ old('rigger') === 'T/P' ? 'selected' : '' }}
                                            >
                                                T/P - Tidak Diperlukan
                                            </option>
                                        </select>

                                    </div>


                                    <div>

                                        <label style="font-size:10px;">
                                            Lain-Lain
                                        </label>

                                        <input
                                            type="text"
                                            name="other_certificate"
                                            value="{{ old('other_certificate') }}"
                                            placeholder="Masukkan sertifikat lain bila ada"
                                        >

                                    </div>

                                </div>

                            </td>
                        </tr>


                        {{-- 3. MCU --}}
                        <tr>
                            <td>3.</td>
                            <td><strong>MCU</strong></td>

                            <td>
                                <select
                                    name="mcu"
                                    class="checklist-status-select"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="V" {{ old('mcu') === 'V' ? 'selected' : '' }}>V - Ada</option>
                                    <option value="X" {{ old('mcu') === 'X' ? 'selected' : '' }}>X - Tidak Ada</option>
                                    <option value="T/P" {{ old('mcu') === 'T/P' ? 'selected' : '' }}>T/P - Tidak Diperlukan</option>
                                </select>
                            </td>

                            <td>-</td>
                        </tr>


                        {{-- 4. KP --}}
                        <tr>
                            <td>4.</td>
                            <td><strong>KP</strong></td>

                            <td>
                                <select
                                    name="kp"
                                    class="checklist-status-select"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="V" {{ old('kp') === 'V' ? 'selected' : '' }}>V - Ada</option>
                                    <option value="X" {{ old('kp') === 'X' ? 'selected' : '' }}>X - Tidak Ada</option>
                                    <option value="T/P" {{ old('kp') === 'T/P' ? 'selected' : '' }}>T/P - Tidak Diperlukan</option>
                                </select>
                            </td>

                            <td>-</td>
                        </tr>


                        {{-- 5. MCU --}}
                        <tr>
                            <td>5.</td>
                            <td><strong>MCU</strong></td>

                            <td>
                                <select
                                    name="mcu_vaccine"
                                    class="checklist-status-select"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="V" {{ old('mcu_vaccine') === 'V' ? 'selected' : '' }}>V - Ada</option>
                                    <option value="X" {{ old('mcu_vaccine') === 'X' ? 'selected' : '' }}>X - Tidak Ada</option>
                                    <option value="T/P" {{ old('mcu_vaccine') === 'T/P' ? 'selected' : '' }}>T/P - Tidak Diperlukan</option>
                                </select>
                            </td>

                            <td>-</td>
                        </tr>


                        {{-- 6. SELF DECLARATION --}}
                        <tr>
                            <td>6.</td>
                            <td><strong>Self Declaration</strong></td>

                            <td>
                                <select
                                    name="self_declaration"
                                    class="checklist-status-select"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="V" {{ old('self_declaration') === 'V' ? 'selected' : '' }}>V - Ada</option>
                                    <option value="X" {{ old('self_declaration') === 'X' ? 'selected' : '' }}>X - Tidak Ada</option>
                                    <option value="T/P" {{ old('self_declaration') === 'T/P' ? 'selected' : '' }}>T/P - Tidak Diperlukan</option>
                                </select>
                            </td>

                            <td>-</td>
                        </tr>


                        {{-- 7. SSE --}}
                        <tr>
                            <td>7.</td>
                            <td><strong>SSE</strong></td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="sse" value="Yes"
                                        {{ old('sse_yes_no') === 'Yes' ? 'checked' : '' }}>
                                    YES
                                </label>
                            </td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="sse" value="No"
                                        {{ old('sse_yes_no') === 'No' ? 'checked' : '' }}>
                                    NO
                                </label>
                                <input type="hidden" name="sse_yes_no"
                                    value="{{ old('sse_yes_no', '') }}" data-yes-no-value="sse">
                            </td>
                        </tr>


                        {{-- 8. APD MANDATORY --}}
                        <tr>
                            <td>8.</td>
                            <td><strong>APD Mandatory</strong></td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="apd" value="Yes"
                                        {{ old('apd_yes_no') === 'Yes' ? 'checked' : '' }}>
                                    YES
                                </label>
                            </td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="apd" value="No"
                                        {{ old('apd_yes_no') === 'No' ? 'checked' : '' }}>
                                    NO
                                </label>
                                <input type="hidden" name="apd_yes_no"
                                    value="{{ old('apd_yes_no', '') }}" data-yes-no-value="apd">
                            </td>
                        </tr>


                        {{-- 9. TRAINING MANDATORY SWP --}}
                        <tr>
                            <td>9.</td>
                            <td><strong>Training Mandatory SWP</strong></td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="training" value="Yes"
                                        {{ old('training_yes_no') === 'Yes' ? 'checked' : '' }}>
                                    YES
                                </label>
                            </td>
                            <td>
                                <label class="yes-no-choice">
                                    <input type="checkbox" data-yes-no="training" value="No"
                                        {{ old('training_yes_no') === 'No' ? 'checked' : '' }}>
                                    NO
                                </label>
                                <input type="hidden" name="training_yes_no"
                                    value="{{ old('training_yes_no', '') }}" data-yes-no-value="training">
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- TANGGAL --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Tanggal Surat
            </h2>

            <div class="form-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    name="document_date"
                    value="{{ old('document_date') }}"
                    required
                >

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- SIGNATURE LIBRARY --}}
        {{-- ============================================================= --}}

        <div class="card">

            <h2>
                Tanda Tangan
            </h2>

            <p>
                Pilih tanda tangan yang sudah ada
                di Signature Library.
            </p>

            <a
                href="{{ route('signatures.index') }}"
                target="_blank"
                class="library-link"
            >
                + Kelola / Tambah Tanda Tangan
            </a>


            <br><br>


            <div class="grid-2">


                {{-- FIELD COORDINATOR --}}

                <div class="signature-box">

                    <h3>
                        Field Coordinator
                    </h3>

                    <div class="form-group">

                        <label>
                            Pilih Tanda Tangan
                        </label>

                        <select
                            name="field_coordinator_signature_id"
                        >

                            <option value="">
                                -- Tanpa Tanda Tangan --
                            </option>

                            @foreach($signatures as $signature)

                                <option
                                    value="{{ $signature->id }}"
                                    {{ old('field_coordinator_signature_id') == $signature->id ? 'selected' : '' }}
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


                {{-- TOOL PUSHER --}}

                <div class="signature-box">

                    <h3>
                        Tool Pusher
                    </h3>

                    <div class="form-group">

                        <label>
                            Pilih Tanda Tangan
                        </label>

                        <select
                            name="tool_pusher_signature_id"
                        >

                            <option value="">
                                -- Tanpa Tanda Tangan --
                            </option>

                            @foreach($signatures as $signature)

                                <option
                                    value="{{ $signature->id }}"
                                    {{ old('tool_pusher_signature_id') == $signature->id ? 'selected' : '' }}
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


                {{-- RIG SUPT --}}

                <div class="signature-box">

                    <h3>
                        Rig Supt
                    </h3>

                    <div class="form-group">

                        <label>
                            Pilih Tanda Tangan
                        </label>

                        <select
                            name="rig_supt_signature_id"
                        >

                            <option value="">
                                -- Tanpa Tanda Tangan --
                            </option>

                            @foreach($signatures as $signature)

                                <option
                                    value="{{ $signature->id }}"
                                    {{ old('rig_supt_signature_id') == $signature->id ? 'selected' : '' }}
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


                {{-- AREA MANAGER --}}

                <div class="signature-box">

                    <h3>
                        Area Manager
                    </h3>

                    <div class="form-group">

                        <label>
                            Pilih Tanda Tangan
                        </label>

                        <select
                            name="area_manager_signature_id"
                        >

                            <option value="">
                                -- Tanpa Tanda Tangan --
                            </option>

                            @foreach($signatures as $signature)

                                <option
                                    value="{{ $signature->id }}"
                                    {{ old('area_manager_signature_id') == $signature->id ? 'selected' : '' }}
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

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn-submit"
                formaction="{{ route('surat-tugas.generate') }}"
                formmethod="POST"
            >
                Generate Surat Tugas Word &rarr;
            </button>

            <button
                type="submit"
                class="btn-submit"
                formaction="{{ route('surat-tugas.generate-pdf') }}"
                formmethod="POST"
            >
                Generate Surat Tugas PDF &rarr;
            </button>

        </div>

    </form>

</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    ['sse', 'apd', 'training'].forEach(function (key) {
        const choices = Array.from(document.querySelectorAll('[data-yes-no="' + key + '"]'));
        const valueInput = document.querySelector('[data-yes-no-value="' + key + '"]');
        if (!valueInput || choices.length !== 2) return;
        choices.forEach(function (choice) {
            choice.addEventListener('change', function () {
                if (choice.checked) {
                    choices.forEach(function (other) {
                        if (other !== choice) other.checked = false;
                    });
                    valueInput.value = choice.value;
                } else {
                    valueInput.value = '';
                }
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('checklist-select-all');
    const checklistSelects = Array.from(
        document.querySelectorAll('.checklist-status-select')
    );

    if (!selectAll || checklistSelects.length === 0) {
        return;
    }

    selectAll.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === '') {
            return;
        }

        checklistSelects.forEach(function (select) {
            select.value = selectedValue;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });

    checklistSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            const firstValue = checklistSelects[0].value;
            const allSame = checklistSelects.every(function (item) {
                return item.value === firstValue;
            });

            if (allSame && firstValue !== '') {
                selectAll.value = firstValue;
            } else {
                selectAll.value = '';
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    if (!startDateInput || !endDateInput) {
        return;
    }

    function syncEndDateMinimum() {
        const startValue = startDateInput.value || '';

        endDateInput.min = startValue;

        if (
            startValue &&
            endDateInput.value &&
            endDateInput.value < startValue
        ) {
            endDateInput.value = '';
        }
    }

    startDateInput.addEventListener('change', syncEndDateMinimum);
    syncEndDateMinimum();
});
</script>
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
            select.value = match || '__other__';
            if (!match) other.value = previousValue;
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
});
</script>
@endpush
