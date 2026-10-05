@extends('layouts.app')

@section('title', 'Data Karyawan - SIKAP')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Kelola data dan arsip dokumen karyawan PT Arjuna Petrogas Indonesia')

@push('styles')
<style>
    .employee-page {
        width: 100%;
    }

    .employee-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .employee-toolbar h2 {
        margin: 0 0 4px;
        color: #172230;
        font-size: 17px;
    }

    .employee-toolbar p {
        margin: 0;
        color: #98a2b3;
        font-size: 10px;
    }

    .employee-add-button {
        min-height: 40px;
        padding: 10px 17px;
        border: 0;
        border-radius: 8px;
        background: #1473e6;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .employee-filter-panel {
        padding: 18px;
        margin-bottom: 18px;
    }

    .employee-filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 10px;
        align-items: end;
    }

    .filter-field label,
    .modal-field label {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 10px;
        font-weight: 700;
    }

    .filter-actions {
        display: flex;
        gap: 7px;
    }

    .filter-button,
    .filter-reset {
        min-height: 39px;
        padding: 8px 14px;
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .filter-button {
        background: #1473e6;
        color: #fff;
    }

    .filter-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f2f4f7;
        color: #475467;
        text-decoration: none;
    }

    .employee-table-panel {
        overflow: hidden;
    }

    .employee-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 17px 20px;
        border-bottom: 1px solid #e5e9ef;
    }

    .employee-table-header h3 {
        margin: 0;
        color: #172230;
        font-size: 13px;
    }

    .employee-count {
        padding: 5px 9px;
        border-radius: 20px;
        background: #edf5ff;
        color: #1473e6;
        font-size: 9px;
        font-weight: 700;
    }

    .employee-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .employee-table {
        width: 100%;
        min-width: 1180px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .employee-table th {
        padding: 10px 10px;
        border-bottom: 1px solid #e5e9ef;
        background: #f8fafc;
        color: #667085;
        font-size: 8px;
        font-weight: 800;
        line-height: 1.35;
        text-align: left;
        text-transform: uppercase;
        vertical-align: middle;
    }

    .employee-table td {
        padding: 11px 10px;
        border-bottom: 1px solid #eef1f4;
        color: #475467;
        font-size: 8px;
        line-height: 1.45;
        vertical-align: middle;
    }

    .employee-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .employee-col-person { width: 19%; }
    .employee-col-job { width: 15%; }
    .employee-col-education { width: 16%; }
    .employee-col-personal { width: 20%; }
    .employee-col-contact { width: 14%; }
    .employee-col-leave { width: 7%; }
    .employee-col-actions { width: 19%; }

    .employee-person {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .employee-photo,
    .employee-photo-placeholder {
        width: 38px;
        height: 38px;
        border-radius: 7px;
        flex: 0 0 38px;
    }

    .employee-photo {
        object-fit: cover;
        background: #edf5ff;
    }

    .employee-photo-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #edf5ff;
        color: #1473e6;
        font-size: 13px;
        font-weight: 800;
    }

    .employee-person-main {
        min-width: 0;
    }

    .employee-name-line {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 3px;
    }

    .employee-name {
        color: #172230;
        font-size: 9px;
        font-weight: 800;
        line-height: 1.25;
    }

    .employee-nip {
        display: block;
        color: #667085;
        font-size: 7px;
        line-height: 1.45;
    }

    .employee-mini {
        display: block;
        margin-top: 2px;
        color: #98a2b3;
        font-size: 7px;
        line-height: 1.4;
    }

    .employee-mini strong {
        color: #475467;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 7px;
        font-weight: 800;
        line-height: 1.25;
    }

    .status-active {
        background: #e9f8e9;
        color: #27813b;
    }

    .status-inactive {
        background: #f2f4f7;
        color: #667085;
    }

    .job-title {
        margin-bottom: 3px;
        color: #172230;
        font-size: 9px;
        font-weight: 800;
        line-height: 1.3;
    }

    .job-location,
    .education-school,
    .personal-line,
    .contact-line {
        color: #667085;
        font-size: 7px;
        line-height: 1.45;
    }

    .location-pill,
    .education-pill {
        display: inline-flex;
        align-items: center;
        margin-top: 3px;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 7px;
        font-weight: 800;
    }

    .location-pill {
        background: #eef6ec;
        color: #55744d;
    }

    .education-pill {
        margin-top: 0;
        margin-bottom: 4px;
        background: #eef5df;
        color: #61733a;
    }

    .education-school {
        color: #344054;
        font-weight: 800;
        text-transform: uppercase;
    }

    .personal-line strong,
    .contact-line strong {
        color: #344054;
        font-weight: 800;
    }

    .leave-balance {
        color: #16794b;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .employee-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
        min-width: 160px;
    }

    .action-button {
        min-height: 25px;
        padding: 5px 7px;
        border: 1px solid #e5e9ef;
        border-radius: 5px;
        background: #fff;
        color: #475467;
        font-size: 7px;
        font-weight: 800;
        line-height: 1;
        cursor: pointer;
        white-space: nowrap;
    }

    .action-detail {
        background: #eef8ef;
        border-color: #eef8ef;
        color: #376a42;
    }

    .action-id-card {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }

    .action-edit {
        background: #fff7e8;
        border-color: #fff7e8;
        color: #9b6a16;
    }

    .action-toggle {
        background: #667085;
        border-color: #667085;
        color: #fff;
    }

    .action-delete {
        background: #fff0f0;
        border-color: #fff0f0;
        color: #d64545;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state h3 {
        color: #172230;
        font-size: 13px;
    }

    .empty-state p {
        color: #98a2b3;
        font-size: 10px;
    }

    .pagination-area {
        padding: 15px 20px;
        border-top: 1px solid #e5e9ef;
    }

    /* MODAL */
    .employee-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(16, 24, 40, .55);
    }

    .employee-modal.show {
        display: flex;
    }

    .modal-card {
        width: 100%;
        max-width: 760px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 25px 70px rgba(16, 24, 40, .22);
    }

    .modal-card-large {
        max-width: 900px;
    }

    .modal-header {
        position: sticky;
        top: 0;
        z-index: 5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 22px;
        border-bottom: 1px solid #e5e9ef;
        background: #fff;
    }

    .modal-header h2 {
        margin: 0;
        color: #172230;
        font-size: 15px;
    }

    .modal-header p {
        margin: 3px 0 0;
        color: #98a2b3;
        font-size: 9px;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: #f2f4f7;
        color: #475467;
        font-size: 20px;
        cursor: pointer;
    }

    .modal-body {
        padding: 22px;
    }

    .modal-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px 18px;
    }

    .modal-field-full {
        grid-column: 1 / -1;
    }

    .modal-section-title {
        grid-column: 1 / -1;
        margin-top: 10px;
        padding: 0 0 9px;
        border-bottom: 1px solid #e5e9ef;
        color: #172230;
        font-size: 12px;
        font-weight: 800;
    }

    .modal-section-title:first-child {
        margin-top: 0;
    }

    .field-help {
        display: block;
        margin-top: 6px;
        color: #98a2b3;
        font-size: 9px;
        line-height: 1.5;
    }

    .location-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .location-row .form-input {
        flex: 1;
    }

    .location-add,
    .location-delete {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
    }

    .location-add {
        border: 0;
        background: #1473e6;
        color: #fff;
        font-size: 20px;
    }

    .location-delete {
        border: 1px solid #f1c5c5;
        background: #fff5f5;
        color: #b42318;
        font-size: 16px;
    }

    .expiry-info {
        grid-column: 1 / -1;
        padding: 11px 13px;
        border: 1px solid #f4dfb4;
        border-radius: 8px;
        background: #fff8eb;
        color: #8a5a00;
        font-size: 9px;
        line-height: 1.6;
    }

    .modal-footer {
        position: sticky;
        bottom: 0;
        z-index: 5;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 15px 22px;
        border-top: 1px solid #e5e9ef;
        background: #fff;
    }

    .modal-cancel,
    .modal-save {
        min-height: 37px;
        padding: 8px 15px;
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .modal-cancel {
        background: #f2f4f7;
        color: #475467;
    }

    .modal-save {
        background: #1473e6;
        color: #fff;
    }

    /* DETAIL */
    .detail-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 18px;
        margin-bottom: 18px;
        border-radius: 12px;
        background: #f8fafc;
    }

    .detail-avatar,
    .detail-avatar-placeholder {
        width: 65px;
        height: 65px;
        border-radius: 13px;
    }

    .detail-avatar {
        object-fit: cover;
    }

    .detail-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #edf5ff;
        color: #1473e6;
        font-size: 21px;
        font-weight: 800;
    }

    .detail-profile h3 {
        margin: 0 0 4px;
        color: #172230;
        font-size: 15px;
    }

    .detail-profile p {
        margin: 0;
        color: #667085;
        font-size: 10px;
        line-height: 1.6;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 11px;
    }

    .detail-item {
        padding: 12px 14px;
        border: 1px solid #e5e9ef;
        border-radius: 9px;
    }

    .detail-item span {
        display: block;
        margin-bottom: 5px;
        color: #98a2b3;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .detail-item strong {
        color: #344054;
        font-size: 10px;
    }

    .detail-documents {
        margin-top: 20px;
    }

    .detail-documents h3 {
        color: #172230;
        font-size: 12px;
    }

    .document-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        margin-bottom: 7px;
        border: 1px solid #e5e9ef;
        border-radius: 9px;
    }

    .document-row strong {
        display: block;
        color: #344054;
        font-size: 10px;
    }

    .document-row small {
        display: block;
        margin-top: 3px;
        color: #98a2b3;
        font-size: 8px;
    }

    .document-actions {
        display: flex;
        gap: 5px;
    }

    .document-link {
        padding: 6px 8px;
        border-radius: 6px;
        background: #edf5ff;
        color: #1473e6;
        font-size: 8px;
        font-weight: 700;
        text-decoration: none;
    }

    .validation-box {
        margin-bottom: 18px;
        padding: 13px 15px;
        border: 1px solid #fac5c5;
        border-radius: 9px;
        background: #fff0f0;
        color: #b42318;
        font-size: 10px;
    }

    @media (max-width: 1000px) {
        .employee-filter-form {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-actions {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 700px) {
        .employee-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .employee-filter-form,
        .modal-grid,
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .modal-field-full,
        .modal-section-title,
        .expiry-info {
            grid-column: auto;
        }
    }

    /* DETAIL / EDIT TABS */
    .employee-tabs {
        display: flex;
        gap: 4px;
        padding: 0 22px;
        border-bottom: 1px solid #e5e9ef;
        background: #fff;
    }
    .employee-tab-button {
        padding: 13px 15px;
        border: 0;
        border-bottom: 2px solid transparent;
        background: transparent;
        color: #667085;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }
    .employee-tab-button.active {
        border-bottom-color: #1473e6;
        color: #1473e6;
    }
    .employee-tab-panel { display: none; }
    .employee-tab-panel.active { display: block; }

    .detail-section {
        margin-top: 18px;
    }
    .detail-section-title {
        margin: 0 0 10px;
        color: #172230;
        font-size: 12px;
        font-weight: 800;
    }
    .document-card {
        padding: 14px;
        margin-bottom: 10px;
        border: 1px solid #e5e9ef;
        border-radius: 10px;
        background: #fff;
    }
    .document-card-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }
    .document-card-title {
        color: #172230;
        font-size: 11px;
        font-weight: 800;
    }
    .document-card-file {
        margin-top: 3px;
        color: #98a2b3;
        font-size: 8px;
    }
    .document-meta-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 10px;
    }
    .document-meta {
        padding: 9px;
        border-radius: 7px;
        background: #f8fafc;
    }
    .document-meta span {
        display: block;
        margin-bottom: 3px;
        color: #98a2b3;
        font-size: 8px;
        font-weight: 700;
    }
    .document-meta strong {
        color: #475467;
        font-size: 9px;
    }
    .existing-document-editor {
        padding: 15px;
        margin-bottom: 12px;
        border: 1px solid #e5e9ef;
        border-radius: 10px;
        background: #f9fafb;
    }
    .existing-document-editor-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .existing-document-editor-head strong {
        color: #172230;
        font-size: 11px;
    }
    .edit-doc-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .edit-doc-full { grid-column: 1 / -1; }

    @media (max-width: 700px) {
        .document-meta-grid,
        .edit-doc-grid {
            grid-template-columns: 1fr;
        }
        .edit-doc-full { grid-column: auto; }
    }

.filter-actions { flex-wrap: wrap; }
    .employee-export-button { background: #e7f5ee; color: #147348; white-space: nowrap; }
</style>
@endpush


@section('content')

<div class="employee-page">

    @if ($errors->any())
        <div class="validation-box">
            <strong>Data belum dapat disimpan:</strong>

            <ul style="margin:7px 0 0 17px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="employee-toolbar">
        <div>
            <h2>Daftar Karyawan</h2>
            <p>Kelola informasi karyawan dan arsip dokumen personil.</p>
        </div>

        <button
            type="button"
            class="employee-add-button"
            onclick="openEmployeeModal('addEmployeeModal')"
        >
            + Tambah Karyawan
        </button>
    </div>


    {{-- FILTER --}}
    <div class="panel employee-filter-panel">

        <form
            method="GET"
            action="{{ route('employees.index') }}"
            class="employee-filter-form"
        >

            <div class="filter-field">
                <label>Cari Karyawan</label>

                <input
                    type="text"
                    name="search"
                    class="form-input"
                    value="{{ request('search') }}"
                    placeholder="Nama, NIP, jabatan, lokasi..."
                >
            </div>

            <div class="filter-field">
                <label>Rig / Lokasi</label>

                <select name="rig" class="form-input">
                    <option value="">Semua Rig / Lokasi</option>

                    @foreach ($rigs as $rig)
                        <option
                            value="{{ $rig }}"
                            {{ request('rig') === $rig ? 'selected' : '' }}
                        >
                            {{ $rig }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label>Jabatan</label>

                <select name="jabatan" class="form-input">
                    <option value="">Semua Jabatan</option>

                    @foreach ($positions as $position)
                        <option
                            value="{{ $position }}"
                            {{ request('jabatan') === $position ? 'selected' : '' }}
                        >
                            {{ $position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label>Status</label>

                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="filter-button">
                    Cari
                </button>

                <button type="submit" class="filter-button employee-export-button"
                        formaction="{{ route('employees.export') }}">
                    Export Excel
                </button>

                <a href="{{ route('employees.index') }}" class="filter-reset">
                    Reset
                </a>
            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="panel employee-table-panel">

        <div class="employee-table-header">
            <h3>Data Karyawan</h3>

            <span class="employee-count">
                {{ $employees->total() }} Karyawan
            </span>
        </div>


        @if ($employees->count())

            <div class="employee-table-wrapper">
                <table class="employee-table">
                    <colgroup>
                        <col class="employee-col-person">
                        <col class="employee-col-job">
                        <col class="employee-col-education">
                        <col class="employee-col-personal">
                        <col class="employee-col-contact">
                        <col class="employee-col-leave">
                        <col class="employee-col-actions">
                    </colgroup>

                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Jabatan &amp; Lokasi</th>
                            <th>Pendidikan &amp; Sekolah</th>
                            <th>Data Pribadi &amp; Ibu Kandung</th>
                            <th>Kontak &amp;<br>Rekening Bank</th>
                            <th>Saldo<br>Cuti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($employees as $employee)
                        @php
                            $birthDate = $employee->tanggal_lahir
                                ? \Carbon\Carbon::parse($employee->tanggal_lahir)
                                : null;

                            $age = $birthDate ? $birthDate->age : null;
                            $statusValue = $employee->status ?: 'Aktif';
                        @endphp

                        <tr>
                            <td>
                                <div class="employee-person">
                                    @if ($employee->foto_path)
                                        <img
                                            src="{{ route('employees.photo', $employee) }}"
                                            class="employee-photo"
                                            alt="{{ $employee->nama_lengkap }}"
                                        >
                                    @else
                                        <div class="employee-photo-placeholder">
                                            {{ strtoupper(substr($employee->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="employee-person-main">
                                        <div class="employee-name-line">
                                            <span class="employee-name">
                                                {{ strtoupper($employee->nama_lengkap) }}
                                            </span>

                                            <span class="status-badge {{ $statusValue === 'Aktif' ? 'status-active' : 'status-inactive' }}">
                                                {{ $statusValue }}
                                            </span>
                                        </div>

                                        <span class="employee-nip">
                                            NIP: {{ $employee->nip ?: '-' }}
                                            @if ($employee->nik_internal)
                                                &nbsp; NIK: {{ $employee->nik_internal }}
                                            @endif
                                        </span>

                                        <span class="employee-mini">
                                            Profil BPJS
                                            @if ($employee->no_kis || $employee->no_kpj)
                                                <strong>tersedia</strong>
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="job-title">
                                    {{ strtoupper($employee->jabatan ?: '-') }}
                                </div>

                                <span class="location-pill">
                                    {{ $employee->rig ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="education-pill">
                                    {{ $employee->pendidikan_terakhir ?: '-' }}
                                </span>

                                <div class="education-school">
                                    {{ $employee->nama_sekolah ?: '-' }}
                                </div>

                                <span class="employee-mini">
                                    Tamat: {{ $employee->tahun_lulus ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="personal-line">
                                    <strong>
                                        {{ strtoupper($employee->tempat_lahir ?: '-') }}
                                    </strong>
                                    @if ($birthDate)
                                        ({{ $birthDate->format('Y-m-d') }}{{ $age !== null ? ', '.$age : '' }})
                                    @endif
                                </div>

                                <div class="personal-line">
                                    NIK KTP:
                                    <strong>{{ $employee->nik_ktp ?: '-' }}</strong>
                                </div>

                                <div class="personal-line">
                                    Alamat:
                                    {{ $employee->alamat ?: '-' }}
                                </div>

                                <div class="personal-line">
                                    Ibu:
                                    <strong>{{ $employee->nama_ibu_kandung ?: '-' }}</strong>
                                </div>
                            </td>

                            <td>
                                <div class="contact-line">
                                    <strong>{{ $employee->no_telepon ?: '-' }}</strong>
                                </div>

                                <div class="contact-line">
                                    {{ $employee->nama_bank ?: '-' }}:
                                    <strong>{{ $employee->nomor_rekening ?: '-' }}</strong>
                                </div>
                            </td>

                            <td>
                                <span class="leave-balance">
                                    {{ $employee->saldo_cuti !== null ? rtrim(rtrim(number_format((float) $employee->saldo_cuti, 1, '.', ''), '0'), '.') : '0' }}
                                    hari
                                </span>
                            </td>

                            <td>
                                <div class="employee-actions">
                                    <button
                                        type="button"
                                        class="action-button action-detail"
                                        onclick="openEmployeeModal('detailEmployee{{ $employee->id }}')"
                                    >
                                        Detail
                                    </button>

                                    <button
                                        type="button"
                                        class="action-button action-id-card"
                                        onclick="openEmployeeModal('detailEmployee{{ $employee->id }}')"
                                        title="Lihat identitas karyawan"
                                    >
                                        ID Card
                                    </button>

                                    <button
                                        type="button"
                                        class="action-button action-edit"
                                        onclick="openEmployeeModal('editEmployee{{ $employee->id }}')"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        class="action-button action-toggle"
                                        onclick="openEmployeeModal('editEmployee{{ $employee->id }}')"
                                        title="Ubah status karyawan melalui menu Edit"
                                    >
                                        {{ $statusValue === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('employees.destroy', $employee) }}"
                                        onsubmit="return confirm('Hapus data karyawan ini?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button action-delete"
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
            </div>

            @if ($employees->hasPages())
                <div class="pagination-area">
                    {{ $employees->links() }}
                </div>
            @endif

        @else

            <div class="empty-state">
                <h3>Belum Ada Data Karyawan</h3>

                <p>
                    Klik + Tambah Karyawan untuk memasukkan data karyawan pertama.
                </p>
            </div>

        @endif

    </div>

</div>


{{-- ============================================================
     TAMBAH KARYAWAN
============================================================ --}}
<div class="employee-modal" id="addEmployeeModal">

    <div class="modal-card modal-card-large">

        <form
            method="POST"
            action="{{ route('employees.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="modal-header">
                <div>
                    <h2>Tambah Karyawan</h2>
                    <p>Masukkan data lengkap karyawan baru.</p>
                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeEmployeeModal('addEmployeeModal')"
                >
                    &times;
                </button>
            </div>


            <div class="modal-body">

                <div class="modal-grid">

                    {{-- FOTO --}}
                    <div class="modal-section-title">
                        Foto & Identitas
                    </div>

                    <div class="modal-field modal-field-full">
                        <label>📷 Upload Foto Profil Karyawan</label>

                        <input
                            type="file"
                            name="foto"
                            class="form-input"
                            accept=".jpg,.jpeg,.png"
                        >

                        <span class="field-help">
                            Format JPG, JPEG, atau PNG.
                        </span>
                    </div>

                    <div class="modal-field modal-field-full">
                        <label>🪪 Upload Foto / Scan KTP Karyawan</label>

                        <input
                            type="file"
                            name="ktp_file"
                            class="form-input"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                        <span class="field-help">
                            Format PDF, JPG, JPEG, atau PNG.
                        </span>
                    </div>


                    {{-- DATA PEKERJAAN --}}
                    <div class="modal-section-title">
                        Data Pekerjaan
                    </div>

                    <div class="modal-field">
                        <label>NIP (Nomor Induk Pegawai) *</label>

                        <input
                            type="text"
                            name="nip"
                            class="form-input"
                            value="{{ old('nip') }}"
                            required
                        >
                    </div>

                    <div class="modal-field">
                        <label>NIK Karyawan API (ID Internal)</label>

                        <input
                            type="text"
                            name="nik_internal"
                            class="form-input"
                            value="{{ old('nik_internal') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Nama Lengkap *</label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            class="form-input"
                            value="{{ old('nama_lengkap') }}"
                            required
                        >
                    </div>

                    <div class="modal-field">
                        <label>Jabatan</label>

                        <input
                            type="text"
                            name="jabatan"
                            class="form-input"
                            value="{{ old('jabatan') }}"
                        >
                    </div>

                    <div class="modal-field modal-field-full">
                        <label>Lokasi Kerja / Field</label>

                        <div class="location-row">

                            <select
                                name="rig"
                                id="addEmployeeLocation"
                                class="form-input"
                            >
                                <option value="">Pilih lokasi</option>

                                @foreach ([
                                    'ARJ-02',
                                    'ARJ-06',
                                    'ARJ-07',
                                    'ARJ-09',
                                    'ARJ-10',
                                    'ARJ-11',
                                    'ARJ-15',
                                    'CREW SUPPORT'
                                ] as $location)

                                    <option
                                        value="{{ $location }}"
                                        {{ old('rig') === $location ? 'selected' : '' }}
                                    >
                                        {{ $location }}
                                    </option>

                                @endforeach
                            </select>

                            <button
                                type="button"
                                class="location-add"
                                onclick="addEmployeeLocationOption()"
                                title="Tambah lokasi"
                            >
                                +
                            </button>

                            <button
                                type="button"
                                class="location-delete"
                                onclick="removeEmployeeLocationOption()"
                                title="Hapus lokasi"
                            >
                                &#128465;
                            </button>

                        </div>

                        <span class="field-help">
                            Tambah lokasi dengan +. Lokasi tambahan dapat dihapus dengan tombol tempat sampah.
                        </span>
                    </div>

                    <div class="modal-field">
                        <label>Tanggal Bergabung (Joint Date)</label>

                        <input
                            type="date"
                            name="tanggal_bergabung"
                            class="form-input"
                            value="{{ old('tanggal_bergabung') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Nama Ibu Kandung</label>

                        <input
                            type="text"
                            name="nama_ibu_kandung"
                            class="form-input"
                            value="{{ old('nama_ibu_kandung') }}"
                        >
                    </div>


                    {{-- PENDIDIKAN --}}
                    <div class="modal-section-title">
                        Pendidikan
                    </div>

                    <div class="modal-field">
                        <label>Pendidikan Terakhir</label>

                        <select
                            name="pendidikan_terakhir"
                            class="form-input"
                        >
                            <option value="">
                                Pilih pendidikan terakhir
                            </option>

                            @foreach ([
                                'SD',
                                'SMP',
                                'SMA',
                                'SMK',
                                'STM',
                                'DIPLOMA I',
                                'DIPLOMA II',
                                'DIPLOMA III',
                                'DIPLOMA IV',
                                'S1',
                                'S2',
                                'S3'
                            ] as $education)

                                <option
                                    value="{{ $education }}"
                                    {{ old('pendidikan_terakhir') === $education ? 'selected' : '' }}
                                >
                                    {{ $education }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Nama Sekolah / Universitas</label>

                        <input
                            type="text"
                            name="nama_sekolah"
                            class="form-input"
                            value="{{ old('nama_sekolah') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Tahun Tamat / Lulus</label>

                        <input
                            type="number"
                            name="tahun_lulus"
                            class="form-input"
                            value="{{ old('tahun_lulus') }}"
                            min="1950"
                            max="{{ date('Y') }}"
                            placeholder="Contoh: 2024"
                        >
                    </div>


                    {{-- DATA PRIBADI --}}
                    <div class="modal-section-title">
                        Data Pribadi
                    </div>

                    <div class="modal-field">
                        <label>Agama</label>

                        <select name="agama" class="form-input">
                            <option value="">Pilih agama</option>

                            @foreach ([
                                'ISLAM',
                                'KRISTEN PROTESTAN',
                                'KATOLIK',
                                'HINDU',
                                'BUDDHA',
                                'KONGHUCU'
                            ] as $religion)

                                <option
                                    value="{{ $religion }}"
                                    {{ old('agama') === $religion ? 'selected' : '' }}
                                >
                                    {{ $religion }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Status Pernikahan</label>

                        <select
                            name="status_pernikahan"
                            class="form-input"
                        >
                            <option value="">
                                Pilih status pernikahan
                            </option>

                            @foreach ([
                                'BELUM MENIKAH',
                                'MENIKAH',
                                'CERAI HIDUP',
                                'CERAI MATI'
                            ] as $marriage)

                                <option
                                    value="{{ $marriage }}"
                                    {{ old('status_pernikahan') === $marriage ? 'selected' : '' }}
                                >
                                    {{ $marriage }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Jumlah Anak</label>

                        <input
                            type="number"
                            name="jumlah_anak"
                            class="form-input"
                            value="{{ old('jumlah_anak', 0) }}"
                            min="0"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Tempat Lahir</label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            class="form-input"
                            value="{{ old('tempat_lahir') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Tanggal Lahir</label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            class="form-input"
                            value="{{ old('tanggal_lahir') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>NIK KTP (16 Digit)</label>

                        <input
                            type="text"
                            name="nik_ktp"
                            class="form-input"
                            value="{{ old('nik_ktp') }}"
                            maxlength="16"
                            inputmode="numeric"
                            pattern="[0-9]{16}"
                            placeholder="16 digit NIK"
                        >
                    </div>

                    <div class="modal-field modal-field-full">
                        <label>Alamat Lengkap</label>

                        <textarea
                            name="alamat"
                            class="form-input"
                            rows="3"
                        >{{ old('alamat') }}</textarea>
                    </div>

                    <div class="modal-field">
                        <label>No. Telepon / HP</label>

                        <input
                            type="text"
                            name="no_telepon"
                            class="form-input"
                            value="{{ old('no_telepon') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                        >
                    </div>


                    {{-- BPJS --}}
                    <div class="modal-section-title">
                        BPJS & Pajak
                    </div>

                    <div class="modal-field">
                        <label>No. KIS (BPJS Kesehatan)</label>

                        <input
                            type="text"
                            name="no_kis"
                            class="form-input"
                            value="{{ old('no_kis') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>No. KPJ (BPJS Ketenagakerjaan)</label>

                        <input
                            type="text"
                            name="no_kpj"
                            class="form-input"
                            value="{{ old('no_kpj') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Nomor NPWP</label>

                        <input
                            type="text"
                            name="npwp"
                            class="form-input"
                            value="{{ old('npwp') }}"
                        >
                    </div>


                    {{-- BANK --}}
                    <div class="modal-section-title">
                        Data Bank
                    </div>

                    <div class="modal-field">
                        <label>Nama Bank</label>

                        <input
                            type="text"
                            name="nama_bank"
                            class="form-input"
                            value="{{ old('nama_bank') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Nama Pemilik Rekening Bank</label>

                        <input
                            type="text"
                            name="nama_pemilik_rekening"
                            class="form-input"
                            value="{{ old('nama_pemilik_rekening') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Nomor Rekening Bank</label>

                        <input
                            type="text"
                            name="nomor_rekening"
                            class="form-input"
                            value="{{ old('nomor_rekening') }}"
                        >
                    </div>


                    {{-- CUTI --}}
                    <div class="modal-section-title">
                        Cuti & Perlengkapan
                    </div>

                    <div class="modal-field">
                        <label>Saldo Cuti (hari)</label>

                        <input
                            type="number"
                            name="saldo_cuti"
                            class="form-input"
                            value="{{ old('saldo_cuti', 0) }}"
                            min="0"
                            step="0.5"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Ukuran Baju / Seragam</label>

                        <select name="ukuran_baju" class="form-input">
                            <option value="">Pilih ukuran baju</option>

                            @foreach ([
                                'S',
                                'M',
                                'L',
                                'XL',
                                'XXL',
                                'XXXL'
                            ] as $shirtSize)

                                <option
                                    value="{{ $shirtSize }}"
                                    {{ old('ukuran_baju') === $shirtSize ? 'selected' : '' }}
                                >
                                    {{ $shirtSize }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Ukuran Sepatu Safety</label>

                        <select
                            name="ukuran_sepatu"
                            class="form-input"
                        >
                            <option value="">
                                Pilih ukuran sepatu
                            </option>

                            @foreach (range(36, 46) as $shoeSize)

                                <option
                                    value="{{ $shoeSize }}"
                                    {{ (string) old('ukuran_sepatu') === (string) $shoeSize ? 'selected' : '' }}
                                >
                                    {{ $shoeSize }}
                                </option>

                            @endforeach
                        </select>
                    </div>


                    {{-- MASA BERLAKU --}}
                    <div class="modal-section-title">
                        Masa Berlaku Dokumen
                    </div>

                    <div class="expiry-info">
                        Masa Berlaku Dokumen — isi untuk mengaktifkan
                        peringatan otomatis.
                    </div>

                    <div class="modal-field">
                        <label>Masa Berlaku KTP</label>

                        <input
                            type="date"
                            name="ktp_expiry_date"
                            class="form-input"
                            value="{{ old('ktp_expiry_date') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Akhir Kontrak Kerja</label>

                        <input
                            type="date"
                            name="contract_end_date"
                            class="form-input"
                            value="{{ old('contract_end_date') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Masa Berlaku SIM</label>

                        <input
                            type="date"
                            name="sim_expiry_date"
                            class="form-input"
                            value="{{ old('sim_expiry_date') }}"
                        >
                    </div>

                    <div class="modal-field">
                        <label>Masa Berlaku Sertifikat</label>

                        <input
                            type="date"
                            name="certificate_expiry_date"
                            class="form-input"
                            value="{{ old('certificate_expiry_date') }}"
                        >
                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="modal-cancel"
                    onclick="closeEmployeeModal('addEmployeeModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="modal-save"
                >
                    Simpan Data Karyawan
                </button>

            </div>

        </form>

    </div>
</div>


{{-- ============================================================
     DETAIL + EDIT KARYAWAN
============================================================ --}}
@foreach ($employees as $employee)

    {{-- DETAIL --}}
    <div class="employee-modal" id="detailEmployee{{ $employee->id }}">
        <div class="modal-card modal-card-large">

            <div class="modal-header">
                <div>
                    <h2>Detail Karyawan</h2>
                    <p>Informasi lengkap dan arsip dokumen karyawan.</p>
                </div>
                <button type="button" class="modal-close"
                        onclick="closeEmployeeModal('detailEmployee{{ $employee->id }}')">
                    &times;
                </button>
            </div>

            <div class="detail-profile" style="margin:18px 22px 0;">
                @if ($employee->foto_path)
                    <img src="{{ route('employees.photo', $employee) }}"
                         class="detail-avatar"
                         alt="{{ $employee->nama_lengkap }}">
                @else
                    <div class="detail-avatar-placeholder">
                        {{ strtoupper(substr($employee->nama_lengkap, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h3>{{ $employee->nama_lengkap }}</h3>
                    <p>{{ $employee->jabatan ?: '-' }} &bull; {{ $employee->rig ?: '-' }}</p>
                    <p>NIP {{ $employee->nip }} &bull; {{ $employee->status ?: 'Aktif' }}</p>
                </div>
            </div>

            <div class="employee-tabs">
                <button type="button"
                        class="employee-tab-button active"
                        onclick="switchEmployeeTab(this, 'detailData{{ $employee->id }}')">
                    Data Karyawan
                </button>
                <button type="button"
                        class="employee-tab-button"
                        onclick="switchEmployeeTab(this, 'detailDocuments{{ $employee->id }}')">
                    Kontak &amp; Data Karyawan
                </button>
            </div>

            <div class="modal-body">
                <div id="detailData{{ $employee->id }}" class="employee-tab-panel active">
                    <div class="detail-grid">
                        @php
                            $detailFields = [
                                'NIP' => $employee->nip,
                                'NIK Karyawan API' => $employee->nik_internal,
                                'Nama Lengkap' => $employee->nama_lengkap,
                                'Jabatan' => $employee->jabatan,
                                'Lokasi Kerja / Field' => $employee->rig,
                                'Tanggal Bergabung' => $employee->tanggal_bergabung ? \Carbon\Carbon::parse($employee->tanggal_bergabung)->format('d/m/Y') : null,
                                'Nama Ibu Kandung' => $employee->nama_ibu_kandung,
                                'Pendidikan Terakhir' => $employee->pendidikan_terakhir,
                                'Sekolah / Universitas' => $employee->nama_sekolah,
                                'Tahun Lulus' => $employee->tahun_lulus,
                                'Agama' => $employee->agama,
                                'Status Pernikahan' => $employee->status_pernikahan,
                                'Jumlah Anak' => $employee->jumlah_anak,
                                'Tempat Lahir' => $employee->tempat_lahir,
                                'Tanggal Lahir' => $employee->tanggal_lahir ? \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d/m/Y') : null,
                                'NIK KTP' => $employee->nik_ktp,
                                'Alamat Lengkap' => $employee->alamat,
                                'No. Telepon / HP' => $employee->no_telepon,
                                'Email' => $employee->email,
                                'No. KIS' => $employee->no_kis,
                                'No. KPJ' => $employee->no_kpj,
                                'NPWP' => $employee->npwp,
                                'Nama Bank' => $employee->nama_bank,
                                'Pemilik Rekening' => $employee->nama_pemilik_rekening,
                                'Nomor Rekening' => $employee->nomor_rekening,
                                'Saldo Cuti' => $employee->saldo_cuti !== null ? $employee->saldo_cuti . ' hari' : null,
                                'Ukuran Baju' => $employee->ukuran_baju,
                                'Ukuran Sepatu Safety' => $employee->ukuran_sepatu,
                                'Masa Berlaku KTP' => $employee->ktp_expiry_date ? \Carbon\Carbon::parse($employee->ktp_expiry_date)->format('d/m/Y') : null,
                                'Akhir Kontrak Kerja' => $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('d/m/Y') : null,
                                'Masa Berlaku SIM' => $employee->sim_expiry_date ? \Carbon\Carbon::parse($employee->sim_expiry_date)->format('d/m/Y') : null,
                                'Masa Berlaku Sertifikat' => $employee->certificate_expiry_date ? \Carbon\Carbon::parse($employee->certificate_expiry_date)->format('d/m/Y') : null,
                            ];
                        @endphp

                        @foreach ($detailFields as $label => $value)
                            <div class="detail-item">
                                <span>{{ $label }}</span>
                                <strong>{{ ($value !== null && $value !== '') ? $value : '-' }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="detailDocuments{{ $employee->id }}" class="employee-tab-panel">
                    <div class="detail-section" style="margin-top:0;">
                        <h3 class="detail-section-title">Kontak &amp; Data Karyawan</h3>

                        <div class="detail-grid" style="margin-bottom:18px;">
                            <div class="detail-item">
                                <span>No. Telepon / HP</span>
                                <strong>{{ $employee->no_telepon ?: '-' }}</strong>
                            </div>
                            <div class="detail-item">
                                <span>Email</span>
                                <strong>{{ $employee->email ?: '-' }}</strong>
                            </div>
                            <div class="detail-item">
                                <span>Alamat</span>
                                <strong>{{ $employee->alamat ?: '-' }}</strong>
                            </div>
                            <div class="detail-item">
                                <span>NIK KTP</span>
                                <strong>{{ $employee->nik_ktp ?: '-' }}</strong>
                            </div>
                        </div>

                        <h3 class="detail-section-title">
                            Dokumen Karyawan ({{ $employee->documents->count() }})
                        </h3>

                        @forelse ($employee->documents as $document)
                            <div class="document-card">
                                <div class="document-card-head">
                                    <div>
                                        <div class="document-card-title">{{ $document->document_name }}</div>
                                        <div class="document-card-file">{{ $document->file_name }}</div>
                                    </div>
                                    <div class="document-actions">
                                        <a href="{{ route('employees.documents.view', $document) }}"
                                           target="_blank"
                                           class="document-link">Lihat</a>
                                        <a href="{{ route('employees.documents.download', $document) }}"
                                           class="document-link">Download</a>
                                    </div>
                                </div>

                                <div class="document-meta-grid">
                                    <div class="document-meta">
                                        <span>Nomor Dokumen</span>
                                        <strong>{{ $document->document_number ?: '-' }}</strong>
                                    </div>
                                    <div class="document-meta">
                                        <span>Tanggal Terbit</span>
                                        <strong>{{ $document->issue_date ? \Carbon\Carbon::parse($document->issue_date)->format('d/m/Y') : '-' }}</strong>
                                    </div>
                                    <div class="document-meta">
                                        <span>Tanggal Expired</span>
                                        <strong>{{ $document->expiry_date ? \Carbon\Carbon::parse($document->expiry_date)->format('d/m/Y') : '-' }}</strong>
                                    </div>
                                </div>

                                @if ($document->notes)
                                    <div class="document-meta" style="margin-top:8px;">
                                        <span>Keterangan</span>
                                        <strong>{{ $document->notes }}</strong>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p style="color:#98a2b3;font-size:10px;">
                                Belum ada dokumen karyawan. Dokumen seperti CV, MCU, QAQC,
                                sertifikat, KTP, ijazah, dan dokumen lainnya dapat ditambahkan
                                melalui menu Edit.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT --}}
    <div class="employee-modal" id="editEmployee{{ $employee->id }}">
        <div class="modal-card modal-card-large">
            <form method="POST"
                  action="{{ route('employees.update', $employee) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <div>
                        <h2>Edit Data Karyawan</h2>
                        <p>Edit informasi karyawan dan kelola seluruh dokumennya.</p>
                    </div>
                    <button type="button" class="modal-close"
                            onclick="closeEmployeeModal('editEmployee{{ $employee->id }}')">
                        &times;
                    </button>
                </div>

                <div class="employee-tabs">
                    <button type="button"
                            class="employee-tab-button active"
                            onclick="switchEmployeeTab(this, 'editData{{ $employee->id }}')">
                        Data Karyawan
                    </button>
                    <button type="button"
                            class="employee-tab-button"
                            onclick="switchEmployeeTab(this, 'editDocuments{{ $employee->id }}')">
                        Kontak &amp; Data Karyawan
                    </button>
                </div>

                <div class="modal-body">
                    <div id="editData{{ $employee->id }}" class="employee-tab-panel active">
                        <div class="modal-grid">
                            <div class="modal-section-title">Foto &amp; Identitas</div>

                            <div class="modal-field modal-field-full">
                                <label>Ganti Foto Profil</label>
                                <input type="file" name="foto" class="form-input" accept=".jpg,.jpeg,.png">
                                @if ($employee->foto_path)
                                    <span class="field-help">Foto profil saat ini sudah tersimpan.</span>
                                @endif
                            </div>

                            <div class="modal-section-title">Data Pekerjaan</div>

                            <div class="modal-field">
                                <label>NIP (Nomor Induk Pegawai) *</label>
                                <input type="text" name="nip" class="form-input"
                                       value="{{ $employee->nip }}" required>
                            </div>

                            <div class="modal-field">
                                <label>NIK Karyawan API (ID Internal)</label>
                                <input type="text" name="nik_internal" class="form-input"
                                       value="{{ $employee->nik_internal }}">
                            </div>

                            <div class="modal-field">
                                <label>Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" class="form-input"
                                       value="{{ $employee->nama_lengkap }}" required>
                            </div>

                            <div class="modal-field">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" class="form-input"
                                       value="{{ $employee->jabatan }}">
                            </div>

                            <div class="modal-field modal-field-full">
                                <label>Lokasi Kerja / Field</label>
                                <select name="rig" class="form-input">
                                    <option value="">Pilih lokasi</option>
                                    @foreach (['ARJ-02','ARJ-06','ARJ-07','ARJ-09','ARJ-10','ARJ-11','ARJ-15','CREW SUPPORT'] as $location)
                                        <option value="{{ $location }}"
                                            {{ $employee->rig === $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                    @if ($employee->rig && !in_array($employee->rig, ['ARJ-02','ARJ-06','ARJ-07','ARJ-09','ARJ-10','ARJ-11','ARJ-15','CREW SUPPORT']))
                                        <option value="{{ $employee->rig }}" selected>{{ $employee->rig }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="modal-field">
                                <label>Tanggal Bergabung (Joint Date)</label>
                                <input type="date" name="tanggal_bergabung" class="form-input"
                                       value="{{ $employee->tanggal_bergabung ? \Carbon\Carbon::parse($employee->tanggal_bergabung)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>Nama Ibu Kandung</label>
                                <input type="text" name="nama_ibu_kandung" class="form-input"
                                       value="{{ $employee->nama_ibu_kandung }}">
                            </div>

                            <div class="modal-section-title">Pendidikan</div>

                            <div class="modal-field">
                                <label>Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" class="form-input">
                                    <option value="">Pilih pendidikan terakhir</option>
                                    @foreach (['SD','SMP','SMA','SMK','STM','DIPLOMA I','DIPLOMA II','DIPLOMA III','DIPLOMA IV','S1','S2','S3'] as $education)
                                        <option value="{{ $education }}"
                                            {{ $employee->pendidikan_terakhir === $education ? 'selected' : '' }}>
                                            {{ $education }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-field">
                                <label>Nama Sekolah / Universitas</label>
                                <input type="text" name="nama_sekolah" class="form-input"
                                       value="{{ $employee->nama_sekolah }}">
                            </div>

                            <div class="modal-field">
                                <label>Tahun Tamat / Lulus</label>
                                <input type="number" name="tahun_lulus" class="form-input"
                                       value="{{ $employee->tahun_lulus }}" min="1950" max="{{ date('Y') }}">
                            </div>

                            <div class="modal-section-title">Data Pribadi</div>

                            <div class="modal-field">
                                <label>Agama</label>
                                <select name="agama" class="form-input">
                                    <option value="">Pilih agama</option>
                                    @foreach (['ISLAM','KRISTEN PROTESTAN','KATOLIK','HINDU','BUDDHA','KONGHUCU'] as $religion)
                                        <option value="{{ $religion }}"
                                            {{ $employee->agama === $religion ? 'selected' : '' }}>
                                            {{ $religion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-field">
                                <label>Status Pernikahan</label>
                                <select name="status_pernikahan" class="form-input">
                                    <option value="">Pilih status pernikahan</option>
                                    @foreach (['BELUM MENIKAH','MENIKAH','CERAI HIDUP','CERAI MATI'] as $marriage)
                                        <option value="{{ $marriage }}"
                                            {{ $employee->status_pernikahan === $marriage ? 'selected' : '' }}>
                                            {{ $marriage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-field">
                                <label>Jumlah Anak</label>
                                <input type="number" name="jumlah_anak" class="form-input"
                                       value="{{ $employee->jumlah_anak ?? 0 }}" min="0">
                            </div>

                            <div class="modal-field">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-input"
                                       value="{{ $employee->tempat_lahir }}">
                            </div>

                            <div class="modal-field">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-input"
                                       value="{{ $employee->tanggal_lahir ? \Carbon\Carbon::parse($employee->tanggal_lahir)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>NIK KTP (16 Digit)</label>
                                <input type="text" name="nik_ktp" class="form-input"
                                       value="{{ $employee->nik_ktp }}"
                                       maxlength="16" inputmode="numeric" pattern="[0-9]{16}">
                            </div>

                            <div class="modal-field modal-field-full">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" class="form-input" rows="3">{{ $employee->alamat }}</textarea>
                            </div>

                            <div class="modal-section-title">Kontak</div>

                            <div class="modal-field">
                                <label>No. Telepon / HP</label>
                                <input type="text" name="no_telepon" class="form-input"
                                       value="{{ $employee->no_telepon }}">
                            </div>

                            <div class="modal-field">
                                <label>Email</label>
                                <input type="email" name="email" class="form-input"
                                       value="{{ $employee->email }}">
                            </div>

                            <div class="modal-section-title">BPJS &amp; Pajak</div>

                            <div class="modal-field">
                                <label>No. KIS (BPJS Kesehatan)</label>
                                <input type="text" name="no_kis" class="form-input"
                                       value="{{ $employee->no_kis }}">
                            </div>

                            <div class="modal-field">
                                <label>No. KPJ (BPJS Ketenagakerjaan)</label>
                                <input type="text" name="no_kpj" class="form-input"
                                       value="{{ $employee->no_kpj }}">
                            </div>

                            <div class="modal-field">
                                <label>Nomor NPWP</label>
                                <input type="text" name="npwp" class="form-input"
                                       value="{{ $employee->npwp }}">
                            </div>

                            <div class="modal-section-title">Data Bank</div>

                            <div class="modal-field">
                                <label>Nama Bank</label>
                                <input type="text" name="nama_bank" class="form-input"
                                       value="{{ $employee->nama_bank }}">
                            </div>

                            <div class="modal-field">
                                <label>Nama Pemilik Rekening Bank</label>
                                <input type="text" name="nama_pemilik_rekening" class="form-input"
                                       value="{{ $employee->nama_pemilik_rekening }}">
                            </div>

                            <div class="modal-field">
                                <label>Nomor Rekening Bank</label>
                                <input type="text" name="nomor_rekening" class="form-input"
                                       value="{{ $employee->nomor_rekening }}">
                            </div>

                            <div class="modal-section-title">Cuti &amp; Perlengkapan</div>

                            <div class="modal-field">
                                <label>Saldo Cuti (hari)</label>
                                <input type="number" name="saldo_cuti" class="form-input"
                                       value="{{ $employee->saldo_cuti ?? 0 }}" min="0" step="0.5">
                            </div>

                            <div class="modal-field">
                                <label>Ukuran Baju / Seragam</label>
                                <select name="ukuran_baju" class="form-input">
                                    <option value="">Pilih ukuran baju</option>
                                    @foreach (['S','M','L','XL','XXL','XXXL'] as $shirtSize)
                                        <option value="{{ $shirtSize }}"
                                            {{ $employee->ukuran_baju === $shirtSize ? 'selected' : '' }}>
                                            {{ $shirtSize }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-field">
                                <label>Ukuran Sepatu Safety</label>
                                <select name="ukuran_sepatu" class="form-input">
                                    <option value="">Pilih ukuran sepatu</option>
                                    @foreach (range(36, 46) as $shoeSize)
                                        <option value="{{ $shoeSize }}"
                                            {{ (string)$employee->ukuran_sepatu === (string)$shoeSize ? 'selected' : '' }}>
                                            {{ $shoeSize }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-section-title">Masa Berlaku Dokumen</div>
                            <div class="expiry-info">
                                Isi tanggal untuk membantu pemantauan masa berlaku dokumen.
                            </div>

                            <div class="modal-field">
                                <label>Masa Berlaku KTP</label>
                                <input type="date" name="ktp_expiry_date" class="form-input"
                                       value="{{ $employee->ktp_expiry_date ? \Carbon\Carbon::parse($employee->ktp_expiry_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>Akhir Kontrak Kerja</label>
                                <input type="date" name="contract_end_date" class="form-input"
                                       value="{{ $employee->contract_end_date ? \Carbon\Carbon::parse($employee->contract_end_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>Masa Berlaku SIM</label>
                                <input type="date" name="sim_expiry_date" class="form-input"
                                       value="{{ $employee->sim_expiry_date ? \Carbon\Carbon::parse($employee->sim_expiry_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>Masa Berlaku Sertifikat</label>
                                <input type="date" name="certificate_expiry_date" class="form-input"
                                       value="{{ $employee->certificate_expiry_date ? \Carbon\Carbon::parse($employee->certificate_expiry_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="modal-field">
                                <label>Status Karyawan</label>
                                <select name="status" class="form-input">
                                    <option value="Aktif" {{ ($employee->status ?: 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ $employee->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="editDocuments{{ $employee->id }}" class="employee-tab-panel">
                        <div class="modal-section-title" style="margin-top:0;">
                            Kontak &amp; Data Karyawan
                        </div>

                        <p class="field-help" style="margin-bottom:15px;">
                            Kelola arsip seperti KTP, CV, MCU, QAQC, sertifikat, ijazah,
                            First Aid, H2S, IADC, dan dokumen lain. Nama dokumen bebas diisi.
                        </p>

                        @forelse ($employee->documents as $document)
                            <div class="existing-document-editor">
                                <div class="existing-document-editor-head">
                                    <div>
                                        <strong>{{ $document->document_name }}</strong>
                                        <div class="document-card-file">{{ $document->file_name }}</div>
                                    </div>

                                    <div class="document-actions">
                                        <a href="{{ route('employees.documents.view', $document) }}"
                                           target="_blank" class="document-link">Lihat</a>
                                        <a href="{{ route('employees.documents.download', $document) }}"
                                           class="document-link">Download</a>
                                    </div>
                                </div>

                                <div class="edit-doc-grid">
                                    <div class="modal-field edit-doc-full">
                                        <label>Nama Dokumen *</label>
                                        <input type="text"
                                               name="existing_documents[{{ $document->id }}][document_name]"
                                               class="form-input"
                                               value="{{ $document->document_name }}"
                                               required>
                                    </div>

                                    <div class="modal-field edit-doc-full">
                                        <label>Ganti File</label>
                                        <input type="file"
                                               name="existing_documents[{{ $document->id }}][file]"
                                               class="form-input"
                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <span class="field-help">
                                            Kosongkan jika file lama tidak ingin diganti.
                                        </span>
                                    </div>

                                    <div class="modal-field">
                                        <label>Nomor Dokumen / Sertifikat</label>
                                        <input type="text"
                                               name="existing_documents[{{ $document->id }}][document_number]"
                                               class="form-input"
                                               value="{{ $document->document_number }}">
                                    </div>

                                    <div></div>

                                    <div class="modal-field">
                                        <label>Tanggal Terbit</label>
                                        <input type="date"
                                               name="existing_documents[{{ $document->id }}][issue_date]"
                                               class="form-input"
                                               value="{{ $document->issue_date ? \Carbon\Carbon::parse($document->issue_date)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="modal-field">
                                        <label>Tanggal Expired</label>
                                        <input type="date"
                                               name="existing_documents[{{ $document->id }}][expiry_date]"
                                               class="form-input"
                                               value="{{ $document->expiry_date ? \Carbon\Carbon::parse($document->expiry_date)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="modal-field edit-doc-full">
                                        <label>Keterangan</label>
                                        <textarea name="existing_documents[{{ $document->id }}][notes]"
                                                  class="form-input"
                                                  rows="2">{{ $document->notes }}</textarea>
                                    </div>
                                </div>

                                <label style="display:inline-flex;align-items:center;gap:7px;margin-top:10px;color:#b42318;font-size:9px;font-weight:700;">
                                    <input type="checkbox"
                                           name="existing_documents[{{ $document->id }}][delete]"
                                           value="1">
                                    Hapus dokumen ini saat menyimpan
                                </label>
                            </div>
                        @empty
                            <p style="color:#98a2b3;font-size:10px;">
                                Belum ada dokumen tersimpan.
                            </p>
                        @endforelse

                        <div id="newDocuments{{ $employee->id }}"></div>

                        <button type="button"
                                class="action-button action-edit"
                                onclick="addDocumentField({{ $employee->id }})">
                            + Tambah Dokumen
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="modal-cancel"
                            onclick="closeEmployeeModal('editEmployee{{ $employee->id }}')">
                        Batal
                    </button>
                    <button type="submit" class="modal-save">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endforeach


@endsection


@push('scripts')
<script>
    function openEmployeeModal(id) {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }


    function closeEmployeeModal(id) {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');
        document.body.style.overflow = '';
    }


    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('employee-modal')) {
            event.target.classList.remove('show');
            document.body.style.overflow = '';
        }
    });


    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        document
            .querySelectorAll('.employee-modal.show')
            .forEach(function (modal) {
                modal.classList.remove('show');
            });

        document.body.style.overflow = '';
    });


    /*
    |--------------------------------------------------------------------------
    | TAMBAH LOKASI
    |--------------------------------------------------------------------------
    */
    function addEmployeeLocationOption() {
        const select = document.getElementById('addEmployeeLocation');

        if (!select) {
            return;
        }

        const locationName = prompt('Masukkan nama lokasi / field baru:');

        if (!locationName) {
            return;
        }

        const cleanName = locationName.trim().toUpperCase();

        if (!cleanName) {
            return;
        }

        const existingOption = Array
            .from(select.options)
            .find(function (option) {
                return option.value.toUpperCase() === cleanName;
            });

        if (existingOption) {
            select.value = existingOption.value;

            alert('Lokasi tersebut sudah tersedia.');

            return;
        }

        const option = document.createElement('option');

        option.value = cleanName;
        option.textContent = cleanName;
        option.selected = true;
        option.dataset.customLocation = '1';

        select.appendChild(option);
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS LOKASI TAMBAHAN
    |--------------------------------------------------------------------------
    */
    function removeEmployeeLocationOption() {
        const select = document.getElementById('addEmployeeLocation');

        if (!select) {
            return;
        }

        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            alert('Pilih lokasi yang ingin dihapus.');
            return;
        }

        if (option.dataset.customLocation !== '1') {
            alert('Lokasi bawaan tidak dapat dihapus dari form ini.');
            return;
        }

        if (!confirm('Hapus lokasi ' + option.value + '?')) {
            return;
        }

        option.remove();
        select.value = '';
    }



    function switchEmployeeTab(button, panelId) {
        const modal = button.closest('.employee-modal');
        if (!modal) return;

        modal.querySelectorAll('.employee-tab-button').forEach(function (item) {
            item.classList.remove('active');
        });

        modal.querySelectorAll('.employee-tab-panel').forEach(function (panel) {
            panel.classList.remove('active');
        });

        button.classList.add('active');

        const panel = document.getElementById(panelId);
        if (panel) {
            panel.classList.add('active');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DOKUMEN KARYAWAN
    |--------------------------------------------------------------------------
    */
    const employeeDocumentIndexes = {};


    function addDocumentField(employeeId) {

        if (typeof employeeDocumentIndexes[employeeId] === 'undefined') {
            employeeDocumentIndexes[employeeId] = 0;
        }

        const index = employeeDocumentIndexes[employeeId]++;

        const container = document.getElementById(
            'newDocuments' + employeeId
        );

        if (!container) {
            return;
        }

        const wrapper = document.createElement('div');

        wrapper.style.cssText = `
            padding:15px;
            margin-bottom:12px;
            border:1px solid #e5e9ef;
            border-radius:10px;
            background:#f9fafb;
        `;

        wrapper.innerHTML = `
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:13px;
            ">
                <strong style="
                    color:#172230;
                    font-size:11px;
                ">
                    Dokumen Baru
                </strong>

                <button
                    type="button"
                    class="action-button action-delete remove-document"
                >
                    Hapus
                </button>
            </div>

            <div style="
                display:grid;
                grid-template-columns:repeat(2,1fr);
                gap:12px;
            ">

                <div style="grid-column:1/-1;">
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        Nama Dokumen *
                    </label>

                    <input
                        type="text"
                        name="new_documents[${index}][document_name]"
                        class="form-input"
                        placeholder="Contoh: CV, MCU 2026, Sertifikat Migas..."
                        required
                    >
                </div>

                <div style="grid-column:1/-1;">
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        File *
                    </label>

                    <input
                        type="file"
                        name="new_documents[${index}][file]"
                        class="form-input"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        required
                    >
                </div>

                <div>
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        Nomor Dokumen / Sertifikat
                    </label>

                    <input
                        type="text"
                        name="new_documents[${index}][document_number]"
                        class="form-input"
                    >
                </div>

                <div></div>

                <div>
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        Tanggal Terbit
                    </label>

                    <input
                        type="date"
                        name="new_documents[${index}][issue_date]"
                        class="form-input"
                    >
                </div>

                <div>
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        Tanggal Expired
                    </label>

                    <input
                        type="date"
                        name="new_documents[${index}][expiry_date]"
                        class="form-input"
                    >
                </div>

                <div style="grid-column:1/-1;">
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:10px;
                        font-weight:700;
                    ">
                        Keterangan
                    </label>

                    <textarea
                        name="new_documents[${index}][notes]"
                        class="form-input"
                        rows="3"
                    ></textarea>
                </div>

            </div>
        `;

        const removeButton = wrapper.querySelector('.remove-document');

        removeButton.addEventListener('click', function () {
            wrapper.remove();
        });

        container.appendChild(wrapper);
    }


    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            openEmployeeModal('addEmployeeModal');
        });
    @endif
</script>
@endpush