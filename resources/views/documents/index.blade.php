@extends('layouts.app')
@section('title', 'Semua Dokumen - SIKAP')
@section('page-title', 'Semua Dokumen')
@section('page-subtitle', 'Seluruh dokumen yang sudah di-generate')

@push('styles')
<style>
.unified-page, .unified-page *{

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }
.unified-page{

            font-family: Arial, Helvetica, sans-serif;

            background: #f4f6f9;

            color: #1f2937;

        }
.unified-page .app{

            min-height: 100vh;

            display: flex;

        }
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
.unified-page .user-info{

            text-align: right;

        }
.unified-page .user-info strong{

            display: block;

            color: #263445;

            font-size: 12px;

        }
.unified-page .user-info span{

            color: #8994a3;

            font-size: 10px;

        }
.unified-page .content{

            padding: 30px;

        }
.unified-page .page-header{

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 18px;

            padding: 22px 24px;

            border: 1px solid #e1e7ee;

            border-radius: 10px;

            background: white;

        }
.unified-page .page-header h2{

            margin-bottom: 6px;

            color: #1d2d3d;

            font-size: 18px;

        }
.unified-page .page-header p{

            color: #83909f;

            font-size: 12px;

            line-height: 1.5;

        }
.unified-page .total-documents{

            min-width: 90px;

            padding: 12px 16px;

            border-radius: 8px;

            background: #eaf4ff;

            color: #0966b7;

            text-align: center;

        }
.unified-page .total-documents strong{

            display: block;

            font-size: 20px;

        }
.unified-page .total-documents span{

            font-size: 9px;

            font-weight: 700;

        }
.unified-page .search-card{

            margin-bottom: 18px;

            padding: 16px;

            border: 1px solid #e1e7ee;

            border-radius: 10px;

            background: white;

        }
.unified-page .search-label{

            display: block;

            margin-bottom: 8px;

            color: #344054;

            font-size: 11px;

            font-weight: 700;

        }
.unified-page .search-form{

            display: flex;

            align-items: center;

            gap: 8px;

        }
.unified-page .search-input-wrapper{

            position: relative;

            width: 100%;

            max-width: 520px;

        }
.unified-page .search-input{

            width: 100%;

            padding: 11px 14px 11px 38px;

            border: 1px solid #dce3ea;

            border-radius: 7px;

            outline: none;

            background: #ffffff;

            color: #344054;

            font-size: 11px;

            transition: .2s;

        }
.unified-page .search-input:focus{

            border-color: #0868c9;

            box-shadow:

                0 0 0 3px

                rgba(8, 104, 201, .08);

        }
.unified-page .search-icon{

            position: absolute;

            top: 50%;

            left: 13px;

            transform: translateY(-50%);

            color: #98a2b3;

            font-size: 14px;

        }
.unified-page .search-button{

            padding: 11px 18px;

            border: none;

            border-radius: 7px;

            background: #eaf3ff;

            color: #111827;

            font-size: 11px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;

        }
.unified-page .search-button:hover{

            background: #075aaa;

        }
.unified-page .search-reset{

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 11px 16px;

            border-radius: 7px;

            background: #eef1f4;

            color: #667085;

            font-size: 11px;

            font-weight: 600;

            text-decoration: none;

        }
.unified-page .search-reset:hover{

            background: #e3e7eb;

        }
.unified-page .search-result{

            margin-top: 10px;

            color: #7b8794;

            font-size: 10px;

        }
.unified-page .search-result strong{

            color: #344054;

        }
.unified-page .alert{

            margin-bottom: 18px;

            padding: 12px 15px;

            border-radius: 7px;

            font-size: 11px;

        }
.unified-page .alert-success{

            background: #eaf8ef;

            color: #247443;

        }
.unified-page .alert-error{

            background: #fdecec;

            color: #b42318;

        }
.unified-page .table-card{

            overflow: hidden;

            border: 1px solid #e1e7ee;

            border-radius: 10px;

            background: white;

        }
.unified-page table{

            width: 100%;

            border-collapse: collapse;

        }
.unified-page th, .unified-page td{

            padding: 14px 16px;

            border-bottom: 1px solid #edf0f3;

            text-align: left;

            vertical-align: middle;

        }
.unified-page th{

            background: #f8fafc;

            color: #768395;

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

        }
.unified-page td{

            color: #4b5969;

            font-size: 11px;

        }
.unified-page tbody tr:hover{

            background: #fafcfe;

        }
.unified-page tbody tr:last-child td{

            border-bottom: none;

        }
.unified-page .document-title{

            margin-bottom: 3px;

            color: #1f2f40;

            font-size: 12px;

            font-weight: 700;

        }
.unified-page .employee-name{

            margin-bottom: 3px;

            color: #5f6d7a;

            font-size: 10px;

        }
.unified-page .file-name{

            color: #98a1ad;

            font-size: 9px;

        }
.unified-page .badge{

            display: inline-block;

            padding: 5px 8px;

            border-radius: 5px;

            font-size: 9px;

            font-weight: 700;

        }
.unified-page .badge-moc{

            background: #eaf4ff;

            color: #0966b7;

        }
.unified-page .badge-ba{

            background: #fff2df;

            color: #b56500;

        }
.unified-page .badge-st{

            background: #edf8ee;

            color: #287a36;

        }
.unified-page .actions{

            display: flex;

            align-items: center;

            gap: 6px;

        }
.unified-page .btn{

            display: inline-block;

            padding: 7px 10px;

            border: none;

            border-radius: 5px;

            font-size: 10px;

            font-weight: 600;

            text-decoration: none;

            cursor: pointer;

        }
.unified-page .btn-download{

            background: #e8f4ff;

            color: #0868c9;

        }
.unified-page .btn-download:hover{

            background: #dceefe;

        }
.unified-page .btn-delete{

            background: #feecec;

            color: #c62828;

        }
.unified-page .btn-delete:hover{

            background: #fadede;

        }
.unified-page .empty{

            padding: 55px 20px;

            color: #97a3b0;

            text-align: center;

            font-size: 12px;

        }
.unified-page .empty strong{

            display: block;

            margin-bottom: 6px;

            color: #667085;

            font-size: 13px;

        }
@media (max-width: 950px){.unified-page .table-card{

                overflow-x: auto;

            }
.unified-page table{

                min-width: 850px;

            }
.unified-page .search-form{

                flex-wrap: wrap;

            }}
@media (max-width: 720px){.unified-page .content{

                padding-left: 18px;

                padding-right: 18px;

            }
.unified-page .page-header{

                align-items: flex-start;

                flex-direction: column;

            }
.unified-page .search-input-wrapper{

                max-width: none;

            }}
.unified-page .export-month{display:flex; flex-direction:column; gap:5px; color:#334155; font-size:12px;}
.unified-page .export-month input{padding:12px; border:1px solid #d8e2ef; border-radius:10px; font:inherit; background:white;}
.unified-page .search-form{flex-wrap:wrap; align-items:center;}
.unified-page .export-button{background:#e7f5ee; color:#147348; white-space:nowrap;}
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
<!-- CONTENT -->

        <div class="content">

            <!-- ALERT SUCCESS -->

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <!-- ALERT ERROR -->

            @if(session('error'))

                <div class="alert alert-error">

                    {{ session('error') }}

                </div>

            @endif

            <!-- =====================================================

                 PAGE HEADER

            ====================================================== -->

            <div class="page-header">

                <div>

                    <h2>

                        Semua Dokumen

                    </h2>

                    <p>

                        Semua Berita Acara, Formulir MOC,

                        dan Surat Tugas ditampilkan dalam

                        satu daftar berdasarkan tanggal dibuat.

                    </p>

                </div>

                <div class="total-documents">

                    <strong>

                        {{ $documents->count() }}

                    </strong>

                    <span>

                        DOKUMEN

                    </span>

                </div>

            </div>

            <!-- =====================================================

                 SEARCH

            ====================================================== -->

            <div class="search-card">

                <label class="search-label">

                    Cari Dokumen

                </label>

                <form

                    method="GET"

                    action="{{ route('documents.index') }}"

                    class="search-form"

                >

                    <div class="search-input-wrapper">

                        <span class="search-icon">

                            🔍

                        </span>

                        <input

                            type="text"

                            name="search"

                            class="search-input"

                            value="{{ $search ?? '' }}"

                            placeholder="Cari berdasarkan judul dokumen atau nama karyawan..."

                            autocomplete="off"

                        >

                    </div>

<label class="export-month">Bulan dan Tahun

    <input type="month" name="month" value="{{ $month ?? '' }}" aria-label="Bulan dan tahun dokumen">

</label>

<button

                        type="submit"

                        class="search-button"

                    >

                        Cari

                    </button>

                    @if(!empty($search) || !empty($month))

                        <a

                            href="{{ route('documents.index') }}"

                            class="search-reset"

                        >

                            Reset

                        </a>

                    @endif

<button type="submit" class="search-button export-button" formaction="{{ route('documents.export') }}">Export Excel</button>

</form>

                @if(!empty($search))

                    <div class="search-result">

                        Hasil pencarian untuk:

                        <strong>

                            "{{ $search }}"

                        </strong>

                        — ditemukan

                        <strong>

                            {{ $documents->count() }}

                        </strong>

                        dokumen.

                    </div>

                @endif

            </div>

            <!-- =====================================================

                 TABLE

            ====================================================== -->

            <div class="table-card">

                @if($documents->count() > 0)

                    <table>

                        <thead>

                        <tr>

                            <th>

                                Nama Dokumen

                            </th>

                            <th>

                                Nama Karyawan

                            </th>

                            <th>

                                Jenis

                            </th>

                            <th>

                                Dibuat Oleh

                            </th>

                            <th>

                                Tanggal Dibuat

                            </th>

                            <th>

                                Aksi

                            </th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($documents as $document)

                            <tr>

                                <!-- =================================================

                                     JUDUL DOKUMEN

                                ================================================== -->

                                <td>

                                    <div class="document-title">

                                        {{

                                            $document->document_title

                                            ?? '-'

                                        }}

                                    </div>

                                    <div class="file-name">

                                        {{

                                            $document->file_name

                                            ?? '-'

                                        }}

                                    </div>

                                </td>

                                <!-- =================================================

                                     NAMA KARYAWAN

                                ================================================== -->

                                <td>

                                    <div class="employee-name">

                                        {{

                                            $document->employee_name

                                            ?: '-'

                                        }}

                                    </div>

                                </td>

                                <!-- =================================================

                                     JENIS DOKUMEN

                                ================================================== -->

                                <td>

                                    @if(

                                        $document->document_type

                                        === 'berita_acara'

                                    )

                                        <span

                                            class="badge badge-ba"

                                        >

                                            Berita Acara

                                        </span>

                                    @elseif(

                                        $document->document_type

                                        === 'moc'

                                    )

                                        <span

                                            class="badge badge-moc"

                                        >

                                            Formulir MOC

                                        </span>

                                    @elseif(

                                        $document->document_type

                                        === 'surat_tugas'

                                    )

                                        <span

                                            class="badge badge-st"

                                        >

                                            Surat Tugas

                                        </span>

                                    @else

                                        <span class="badge">

                                            Dokumen

                                        </span>

                                    @endif

                                </td>

                                <!-- =================================================

                                     DIBUAT OLEH

                                ================================================== -->

                                <td>

                                    {{

                                        $document->user?->name

                                        ?? '-'

                                    }}

                                </td>

                                <!-- =================================================

                                     TANGGAL

                                ================================================== -->

                                <td>

                                    @if($document->created_at)

                                        {{

                                            $document

                                                ->created_at

                                                ->format(

                                                    'd/m/Y H:i'

                                                )

                                        }}

                                    @else

                                        -

                                    @endif

                                </td>

                                <!-- =================================================

                                     AKSI

                                ================================================== -->

                                <td>

                                    <div class="actions">

                                        <!-- DOWNLOAD -->

                                        <a

                                            href="{{

                                                route(

                                                    'documents.download',

                                                    $document

                                                )

                                            }}"

                                            class="

                                                btn

                                                btn-download

                                            "

                                        >

                                            Download

                                        </a>

                                        <!-- DELETE -->

                                        <form

                                            method="POST"

                                            action="{{

                                                route(

                                                    'documents.destroy',

                                                    $document

                                                )

                                            }}"

                                            onsubmit="

                                                return confirm(

                                                    'Apakah kamu yakin ingin menghapus dokumen ini?'

                                                );

                                            "

                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button

                                                type="submit"

                                                class="

                                                    btn

                                                    btn-delete

                                                "

                                            >

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                @else

                    <!-- =================================================

                         EMPTY SEARCH

                    ================================================== -->

                    @if(!empty($search))

                        <div class="empty">

                            <strong>

                                Dokumen tidak ditemukan

                            </strong>

                            Tidak ada dokumen dengan judul

                            atau nama karyawan

                            "{{ $search }}".

                        </div>

                    @else

                        <!-- =================================================

                             EMPTY DOCUMENT

                        ================================================== -->

                        <div class="empty">

                            <strong>

                                Belum ada dokumen

                            </strong>

                            Dokumen yang sudah di-generate

                            akan muncul di halaman ini.

                        </div>

                    @endif

                @endif

            </div>

        </div>
</div>
@endsection
