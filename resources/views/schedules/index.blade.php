@extends('layouts.app')

@section('title', 'Schedule Karyawan - SIKAP')

@section('page-title', 'Schedule Karyawan')

@section(
    'page-subtitle',
    'Kelola jadwal kerja karyawan berdasarkan rig, bulan, tahun, dan crew.'
)

@push('styles')
<style>
    /* =========================================================
       SCHEDULE PAGE
    ========================================================= */

    .schedule-page {
        width: 100%;
    }

    .schedule-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .schedule-header-text h2 {
        color: #172230;
        font-size: 18px;
        font-weight: 700;
    }

    .schedule-header-text p {
        margin-top: 5px;
        color: #98a2b3;
        font-size: 10px;
        line-height: 1.5;
    }

    .schedule-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .schedule-btn {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        padding: 9px 14px;

        border: 1px solid transparent;
        border-radius: 8px;

        font-size: 10px;
        font-weight: 700;

        cursor: pointer;
        text-decoration: none;

        transition: .2s ease;
    }

    .schedule-btn-primary {
        border-color: #1473e6;
        background: #1473e6;
        color: #fff;
    }

    .schedule-btn-primary:hover {
        background: #0d64ca;
    }

    .schedule-btn-light {
        border-color: #dfe4ea;
        background: #fff;
        color: #475467;
    }

    .schedule-btn-light:hover {
        background: #f8fafc;
    }

    .schedule-btn-danger {
        border-color: #fecaca;
        background: #fff;
        color: #dc2626;
    }

    .schedule-btn-danger:hover {
        background: #fff1f2;
    }


    /* =========================================================
       FILTER PANEL
    ========================================================= */

    .schedule-filter-panel {
        margin-bottom: 16px;
        padding: 16px;

        border: 1px solid #e5e9ef;
        border-radius: 13px;

        background: #fff;

        box-shadow:
            0 1px 3px
            rgba(16, 24, 40, .05);
    }

    .schedule-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(150px, 1fr)
            minmax(150px, 1fr)
            minmax(130px, .7fr)
            minmax(200px, 1.3fr);

        gap: 10px;
    }

    .schedule-field label {
        display: block;
        margin-bottom: 6px;

        color: #667085;

        font-size: 9px;
        font-weight: 700;
    }

    .schedule-control {
        width: 100%;
        min-height: 40px;

        padding: 9px 11px;

        border: 1px solid #dfe4ea;
        border-radius: 8px;

        outline: none;

        background: #fff;
        color: #344054;

        font-size: 10px;
    }

    .schedule-control:focus {
        border-color: #1473e6;

        box-shadow:
            0 0 0 3px
            rgba(20, 115, 230, .08);
    }

    .schedule-filter-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-top: 14px;

        flex-wrap: wrap;
    }


    /* =========================================================
       CREW FILTER
    ========================================================= */

    .crew-filter {
        display: flex;
        align-items: center;

        gap: 7px;

        flex-wrap: wrap;
    }

    .crew-filter-btn {
        min-height: 34px;

        padding:
            7px
            13px;

        border:
            1px solid
            #e5e9ef;

        border-radius: 8px;

        background: #f8fafc;

        color: #667085;

        font-size: 10px;
        font-weight: 700;

        cursor: pointer;

        transition: .2s ease;
    }

    .crew-filter-btn:hover {
        background: #f1f5f9;
    }

    .crew-filter-btn.active {
        border-color: #1473e6;
        background: #1473e6;
        color: #fff;
    }


    /* =========================================================
       VIEW MODE
    ========================================================= */

    .view-switch {
        display: inline-flex;

        padding: 3px;

        border: 1px solid #e5e9ef;
        border-radius: 9px;

        background: #f8fafc;
    }

    .view-switch a {
        min-height: 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            6px
            12px;

        border-radius: 6px;

        color: #667085;

        font-size: 9px;
        font-weight: 700;

        text-decoration: none;
    }

    .view-switch a.active {
        background: #fff;
        color: #1473e6;

        box-shadow:
            0 1px 4px
            rgba(16, 24, 40, .08);
    }


    /* =========================================================
       LEGEND
    ========================================================= */

    .schedule-legend {
        display: flex;
        align-items: center;

        gap: 18px;

        margin-bottom: 16px;

        padding:
            11px
            15px;

        border:
            1px solid
            #e5e9ef;

        border-radius: 11px;

        background: #fff;

        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;

        gap: 7px;

        color: #475467;

        font-size: 9px;
        font-weight: 600;
    }

    .legend-code {
        min-width: 32px;
        height: 27px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            7px;

        border-radius: 6px;

        font-size: 9px;
        font-weight: 800;
    }


    /* =========================================================
       SHIFT COLORS
    ========================================================= */

    .shift-s {
        background: #38bdf8 !important;
        color: #073b56 !important;
    }

    .shift-m {
        background: #8b5cf6 !important;
        color: #fff !important;
    }

    .shift-on {
        background: #22c55e !important;
        color: #ffffff !important;
    }

    .shift-off {
        background: #ef4444 !important;
        color: #ffffff !important;
    }

    .shift-empty {
        background: #f8fafc;
        color: #c0c7d1;
    }


    /* =========================================================
       CREW SECTION
    ========================================================= */

    .crew-section {
        margin-bottom: 16px;

        overflow: hidden;

        border:
            1px solid
            #e5e9ef;

        border-radius: 13px;

        background: #fff;

        box-shadow:
            0 1px 3px
            rgba(16, 24, 40, .04);
    }

    .crew-section-header {
        min-height: 48px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            11px
            15px;

        border-bottom:
            1px solid
            #edf0f3;

        background: #fbfcfd;

        cursor: pointer;
    }

    .crew-section-title {
        display: flex;
        align-items: center;

        gap: 8px;

        color: #172230;

        font-size: 12px;
        font-weight: 700;
    }

    .crew-chevron {
        width: 16px;
        height: 16px;

        transition:
            transform .2s ease;
    }

    .crew-section.collapsed .crew-chevron {
        transform:
            rotate(-90deg);
    }

    .crew-section.collapsed .crew-section-body {
        display: none;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .schedule-table-scroll {
        width: 100%;

        overflow-x: auto;
        overflow-y: visible;
    }

    .schedule-table {
        width: max-content;
        min-width: 100%;

        border-collapse: separate;
        border-spacing: 0;
    }

    .schedule-table th,
    .schedule-table td {
        border-right:
            1px solid
            #edf0f3;

        border-bottom:
            1px solid
            #edf0f3;

        background: #fff;
    }

    .schedule-table thead th {
        position: sticky;
        top: 0;

        z-index: 5;

        height: 51px;

        padding:
            7px
            7px;

        background: #fff;

        color: #475467;

        font-size: 9px;
        font-weight: 700;

        text-align: center;
    }

    .schedule-table tbody td {
        height: 53px;

        padding:
            6px
            7px;

        color: #475467;

        font-size: 9px;

        vertical-align: middle;
    }

    .schedule-table .col-no {
        width: 45px;
        min-width: 45px;

        text-align: center;
    }

    .schedule-table .col-employee {
        width: 205px;
        min-width: 205px;

        text-align: left;
    }

    .schedule-table .col-phone {
        width: 125px;
        min-width: 125px;

        text-align: left;
    }

    .schedule-table .col-position {
        width: 150px;
        min-width: 150px;

        text-align: left;
    }

    .schedule-table .col-action {
        width: 80px;
        min-width: 80px;

        text-align: center;
    }

    .schedule-table .day-column {
        width: 48px;
        min-width: 48px;

        padding:
            4px
            3px;
    }

    .day-number {
        display: block;

        color: #344054;

        font-size: 9px;
        font-weight: 800;
    }

    .day-name {
        display: block;

        margin-top: 2px;

        color: #98a2b3;

        font-size: 7px;
        font-weight: 700;
    }

    .employee-name {
        display: block;

        color: #344054;

        font-size: 9px;
        font-weight: 700;
    }

    .employee-nip {
        display: block;

        margin-top: 3px;

        color: #98a2b3;

        font-size: 7px;
    }


    /* =========================================================
       SCHEDULE CELL
    ========================================================= */

    .schedule-cell {
        width: 42px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: auto;

        border: none;
        border-radius: 6px;

        font-size: 8px;
        font-weight: 800;

        cursor: pointer;

        transition:
            transform .15s ease,
            box-shadow .15s ease;
    }

    .schedule-cell:hover {
        transform:
            translateY(-1px);

        box-shadow:
            0 3px 8px
            rgba(16, 24, 40, .12);
    }


    /* =========================================================
       EMPLOYEE ACTION
    ========================================================= */

    .employee-action-btn {
        min-height: 28px;

        padding:
            5px
            8px;

        border:
            1px solid
            #d9e6f5;

        border-radius: 6px;

        background: #f4f9ff;

        color: #1473e6;

        font-size: 8px;
        font-weight: 700;

        cursor: pointer;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .schedule-empty {
        padding:
            35px
            20px;

        text-align: center;

        color: #98a2b3;

        font-size: 10px;
    }


    /* =========================================================
       MODAL
    ========================================================= */

    .schedule-modal-backdrop {
        position: fixed;

        inset: 0;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 20px;

        background:
            rgba(
                15,
                23,
                42,
                .45
            );

        z-index: 9999;
    }

    .schedule-modal-backdrop.show {
        display: flex;
    }

    .schedule-modal {
        width: 100%;
        max-width: 520px;

        max-height:
            calc(
                100vh
                -
                40px
            );

        overflow-y: auto;

        border-radius: 14px;

        background: #fff;

        box-shadow:
            0 25px 60px
            rgba(15, 23, 42, .2);
    }

    .schedule-modal-small {
        max-width: 430px;
    }

    .schedule-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 15px;

        padding:
            18px
            20px;

        border-bottom:
            1px solid
            #edf0f3;
    }

    .schedule-modal-header h3 {
        color: #172230;

        font-size: 14px;
        font-weight: 700;
    }

    .schedule-modal-header p {
        margin-top: 4px;

        color: #98a2b3;

        font-size: 9px;
    }

    .modal-close {
        width: 30px;
        height: 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border: none;
        border-radius: 7px;

        background: #f2f4f7;

        color: #667085;

        font-size: 17px;

        cursor: pointer;
    }

    .schedule-modal-body {
        padding:
            18px
            20px;
    }

    .schedule-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 8px;

        padding:
            14px
            20px;

        border-top:
            1px solid
            #edf0f3;
    }

    .modal-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }

    .modal-field {
        margin-bottom: 13px;
    }

    .modal-field label {
        display: block;

        margin-bottom: 6px;

        color: #475467;

        font-size: 9px;
        font-weight: 700;
    }


    /* =========================================================
       SHIFT PICKER
    ========================================================= */

    .shift-picker {
        display: grid;

        grid-template-columns:
            repeat(2, 1fr);

        gap: 9px;
    }

    .shift-picker-btn {
        min-height: 54px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        border: none;
        border-radius: 9px;

        font-size: 10px;
        font-weight: 800;

        cursor: pointer;

        transition:
            transform .15s ease;
    }

    .shift-picker-btn:hover {
        transform:
            translateY(-1px);
    }

    .shift-picker-btn span {
        font-size: 8px;
        font-weight: 600;
    }

    .clear-schedule-btn {
        width: 100%;

        margin-top: 9px;

        min-height: 38px;

        border:
            1px dashed
            #d0d5dd;

        border-radius: 8px;

        background: #fff;

        color: #667085;

        font-size: 9px;
        font-weight: 700;

        cursor: pointer;
    }


    /* =========================================================
       YEARLY VIEW
    ========================================================= */

    .yearly-container {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 14px;
    }

    .yearly-month {
        overflow: hidden;

        border:
            1px solid
            #e5e9ef;

        border-radius: 11px;

        background: #fff;
    }

    .yearly-month-header {
        padding:
            10px
            12px;

        border-bottom:
            1px solid
            #edf0f3;

        background: #f8fafc;

        color: #344054;

        font-size: 10px;
        font-weight: 700;
    }

    .yearly-month-scroll {
        overflow-x: auto;
    }

    .yearly-mini-table {
        width: max-content;
        min-width: 100%;

        border-collapse: collapse;
    }

    .yearly-mini-table th,
    .yearly-mini-table td {
        min-width: 31px;

        padding:
            5px
            4px;

        border:
            1px solid
            #edf0f3;

        text-align: center;

        font-size: 7px;
    }

    .yearly-mini-table .yearly-name {
        min-width: 120px;

        text-align: left;

        font-weight: 700;
    }

    .yearly-shift {
        min-width: 27px;
        min-height: 22px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 3px;

        border-radius: 4px;

        font-size: 7px;
        font-weight: 800;
    }


    /* =========================================================
       LOADING / TOAST
    ========================================================= */

    .schedule-toast {
        position: fixed;

        right: 22px;
        bottom: 22px;

        display: none;

        min-width: 220px;
        max-width: 350px;

        padding:
            12px
            15px;

        border-radius: 9px;

        background: #172230;

        color: #fff;

        font-size: 9px;
        font-weight: 600;

        z-index: 11000;

        box-shadow:
            0 12px 30px
            rgba(15, 23, 42, .2);
    }

    .schedule-toast.show {
        display: block;
    }

    .schedule-toast.error {
        background: #b42318;
    }


    /* =========================================================
       SEARCHABLE EMPLOYEE SELECT
    ========================================================= */

    .employee-search-select {
        position: relative;
        width: 100%;
    }

    .employee-search-input {
        padding-right: 38px;
    }

    .employee-search-arrow {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        color: #667085;
        font-size: 12px;
        pointer-events: none;
    }

    .employee-search-dropdown {
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        right: 0;
        z-index: 10020;
        display: none;
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #dfe4ea;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
    }

    .employee-search-dropdown.show {
        display: block;
    }

    .employee-search-option {
        width: 100%;
        display: block;
        padding: 10px 12px;
        border: 0;
        border-bottom: 1px solid #f2f4f7;
        background: #fff;
        color: #344054;
        font-size: 10px;
        line-height: 1.45;
        text-align: left;
        cursor: pointer;
    }

    .employee-search-option:last-child {
        border-bottom: 0;
    }

    .employee-search-option:hover,
    .employee-search-option.active {
        background: #f4f9ff;
        color: #1473e6;
    }

    .employee-search-empty {
        display: none;
        padding: 12px;
        color: #98a2b3;
        font-size: 9px;
        text-align: center;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {

        .schedule-filter-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .yearly-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {

        .schedule-header {
            flex-direction: column;
        }

        .schedule-filter-grid {
            grid-template-columns: 1fr;
        }

        .schedule-filter-bottom {
            align-items: flex-start;
            flex-direction: column;
        }

        .modal-grid {
            grid-template-columns: 1fr;
        }

        .shift-picker {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================================
       AUTO ROSTER
    ========================================================= */
    .auto-roster-box {
        margin-top: 4px;
        padding: 13px;
        border: 1px solid #dce7f4;
        border-radius: 10px;
        background: #f8fbff;
    }

    .auto-roster-title {
        color: #172230;
        font-size: 10px;
        font-weight: 800;
    }

    .auto-roster-help {
        margin: 4px 0 12px;
        color: #667085;
        font-size: 8px;
        line-height: 1.55;
    }

    .auto-roster-example {
        padding: 9px 10px;
        border-radius: 7px;
        background: #fff;
        color: #667085;
        font-size: 8px;
        line-height: 1.55;
    }


    .continue-year-card {
        margin-top:16px;padding:17px 18px;display:flex;align-items:center;
        justify-content:space-between;gap:18px;border:1px solid #dce7f4;
        border-radius:13px;background:#fff;
    }
    .continue-year-card h3 { margin:0;color:#172230;font-size:11px;font-weight:800; }
    .continue-year-card p { margin:5px 0 0;color:#98a2b3;font-size:8px;line-height:1.55; }
    @media(max-width:700px) {
        .continue-year-card { align-items:stretch;flex-direction:column; }
    }


    /* =========================================================
       ADD SCHEDULE MODAL - INNER SPACING FIX
    ========================================================= */
    #addScheduleForm {
        padding-left: 28px;
        padding-right: 28px;
    }

    #addScheduleForm > .modal-field:first-child {
        margin-top: 20px;
    }

    #addScheduleForm .auto-roster-box {
        margin-top: 8px;
    }

    #addScheduleForm .schedule-modal-footer {
        margin-left: -28px;
        margin-right: -28px;
        padding-left: 28px !important;
        padding-right: 28px !important;
    }

    @media (max-width: 700px) {
        #addScheduleForm {
            padding-left: 18px;
            padding-right: 18px;
        }

        #addScheduleForm .schedule-modal-footer {
            margin-left: -18px;
            margin-right: -18px;
            padding-left: 18px !important;
            padding-right: 18px !important;
        }
    }

</style>
@endpush


@section('content')

@php

    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $dayNames = [
        0 => 'MG',
        1 => 'SN',
        2 => 'SL',
        3 => 'RB',
        4 => 'KM',
        5 => 'JM',
        6 => 'SB',
    ];

    $crewNames = [
        'RIG_SUPERINTENDENT' => 'Rig Superintendent',
        'A' => 'Crew A',
        'B' => 'Crew B',
        'C' => 'Crew C',
    ];

@endphp


<div class="schedule-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="schedule-header">

        <div class="schedule-header-text">

            <h2>
                Working Schedule
            </h2>

            <p>
                Atur schedule kerja karyawan berdasarkan
                lokasi, crew, bulan, dan tahun.
            </p>

        </div>


        <div class="schedule-header-actions">
            <a
                href="{{ route('schedules.export', [
                    'rig' => $selectedRig,
                    'crew' => $selectedCrew,
                    'year' => $year,
                    'month' => $month,
                    'view' => $viewMode,
                    'search' => $search,
                ]) }}"
                class="schedule-btn schedule-btn-primary"
                style="text-decoration: none;"
            >
                Export Excel
            </a>


            <button
                type="button"
                class="
                    schedule-btn
                    schedule-btn-primary
                "
                onclick="openAddScheduleModal()"
            >
                + Tambah Schedule Karyawan
            </button>

        </div>

    </div>


    <!-- =====================================================
         FILTER
    ====================================================== -->

    <div class="schedule-filter-panel">

        <form
            method="GET"
            action="{{ route('schedules.index') }}"
            id="scheduleFilterForm"
        >

            <input
                type="hidden"
                name="crew"
                id="crewFilterInput"
                value="{{ $selectedCrew }}"
            >

            <input
                type="hidden"
                name="view"
                value="{{ $viewMode }}"
            >


            <div class="schedule-filter-grid">


                <!-- RIG -->

                <div class="schedule-field">

                    <label>
                        Lokasi / Rig
                    </label>

                    <select
                        name="rig"
                        class="schedule-control"
                        onchange="submitScheduleFilter()"
                    >

                        @foreach($rigs as $rig)

                            <option
                                value="{{ $rig }}"
                                {{ $selectedRig === $rig ? 'selected' : '' }}
                            >
                                {{ $rig }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- MONTH -->

                <div class="schedule-field">

                    <label>
                        Bulan
                    </label>

                    <select
                        name="month"
                        class="schedule-control"
                        onchange="submitScheduleFilter()"
                    >

                        @foreach($monthNames as $monthNumber => $monthName)

                            <option
                                value="{{ $monthNumber }}"
                                {{ (int) $month === (int) $monthNumber ? 'selected' : '' }}
                            >
                                {{ $monthName }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- YEAR -->

                <div class="schedule-field">

                    <label>
                        Tahun
                    </label>

                    <select
                        name="year"
                        class="schedule-control"
                        onchange="submitScheduleFilter()"
                    >

                        @foreach($years as $yearOption)

                            <option
                                value="{{ $yearOption }}"
                                {{ (int) $year === (int) $yearOption ? 'selected' : '' }}
                            >
                                {{ $yearOption }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- SEARCH -->

                <div class="schedule-field">

                    <label>
                        Cari Karyawan
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="schedule-control"
                        value="{{ $search }}"
                        placeholder="Nama, NIP, jabatan, No. HP..."
                    >

                </div>

            </div>


            <div class="schedule-filter-bottom">


                <!-- CREW -->

                <div class="crew-filter">

                    <button
                        type="button"
                        class="
                            crew-filter-btn
                            {{ $selectedCrew === 'ALL' ? 'active' : '' }}
                        "
                        onclick="selectCrewFilter('ALL')"
                    >
                        Semua Crew
                    </button>

                    <button
                        type="button"
                        class="
                            crew-filter-btn
                            {{ $selectedCrew === 'A' ? 'active' : '' }}
                        "
                        onclick="selectCrewFilter('A')"
                    >
                        Crew A
                    </button>

                    <button
                        type="button"
                        class="
                            crew-filter-btn
                            {{ $selectedCrew === 'B' ? 'active' : '' }}
                        "
                        onclick="selectCrewFilter('B')"
                    >
                        Crew B
                    </button>

                    <button
                        type="button"
                        class="
                            crew-filter-btn
                            {{ $selectedCrew === 'C' ? 'active' : '' }}
                        "
                        onclick="selectCrewFilter('C')"
                    >
                        Crew C
                    </button>

                </div>


                <!-- VIEW -->

                <div class="view-switch">

                    <a
                        href="{{
                            route(
                                'schedules.index',
                                [
                                    'rig' => $selectedRig,
                                    'month' => $month,
                                    'year' => $year,
                                    'crew' => $selectedCrew,
                                    'search' => $search,
                                    'view' => 'monthly',
                                ]
                            )
                        }}"
                        class="{{ $viewMode === 'monthly' ? 'active' : '' }}"
                    >
                        Bulanan
                    </a>

                    <a
                        href="{{
                            route(
                                'schedules.index',
                                [
                                    'rig' => $selectedRig,
                                    'month' => $month,
                                    'year' => $year,
                                    'crew' => $selectedCrew,
                                    'search' => $search,
                                    'view' => 'yearly',
                                ]
                            )
                        }}"
                        class="{{ $viewMode === 'yearly' ? 'active' : '' }}"
                    >
                        Tahunan
                    </a>

                </div>

            </div>

        </form>

    </div>


    <!-- =====================================================
         LEGEND
    ====================================================== -->

    <div class="schedule-legend">

        <div class="legend-item">

            <span class="legend-code shift-s">
                S
            </span>

            Siang

        </div>


        <div class="legend-item">

            <span class="legend-code shift-m">
                M
            </span>

            Malam

        </div>


        <div class="legend-item">

            <span class="legend-code shift-on">
                ON
            </span>

            Standby Lapangan 24 Jam

        </div>


        <div class="legend-item">

            <span class="legend-code shift-off">
                OFF
            </span>

            Libur / Off

        </div>

    </div>


    <!-- =====================================================
         MONTHLY VIEW
    ====================================================== -->

    @if($viewMode === 'monthly')

        @foreach($crewNames as $crewCode => $crewLabel)

            @php
                $crewEmployees =
                    $groupedAssignments[$crewCode]
                    ?? collect();
            @endphp


            @if(
                $selectedCrew === 'ALL'
                ||
                $selectedCrew === $crewCode
            )

                <div
                    class="crew-section"
                    id="crew-section-{{ $crewCode }}"
                >


                    <!-- HEADER -->

                    <div
                        class="crew-section-header"
                        onclick="toggleCrewSection('{{ $crewCode }}')"
                    >

                        <div class="crew-section-title">

                            <svg
                                class="crew-chevron"
                                viewBox="0 0 24 24"
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M6 9L12 15L18 9"></path>
                            </svg>

                            {{ $crewLabel }}

                        </div>

                    </div>


                    <!-- BODY -->

                    <div class="crew-section-body">

                        @if($crewEmployees->count() > 0)

                            <div class="schedule-table-scroll">

                                <table class="schedule-table">

                                    <thead>

                                    <tr>

                                        <th class="col-no">
                                            No
                                        </th>

                                        <th class="col-employee">
                                            Karyawan
                                        </th>

                                        <th class="col-phone">
                                            No. HP
                                        </th>

                                        <th class="col-position">
                                            Jabatan
                                        </th>

                                        <th class="col-action">
                                            Aksi
                                        </th>


                                        @for(
                                            $day = 1;
                                            $day <= $daysInMonth;
                                            $day++
                                        )

                                            @php

                                                $date =
                                                    \Carbon\Carbon::create(
                                                        $year,
                                                        $month,
                                                        $day
                                                    );

                                                $dayCode =
                                                    $dayNames[
                                                        $date->dayOfWeek
                                                    ];

                                            @endphp

                                            <th class="day-column">

                                                <span class="day-number">

                                                    {{
                                                        str_pad(
                                                            $day,
                                                            2,
                                                            '0',
                                                            STR_PAD_LEFT
                                                        )
                                                    }}

                                                </span>

                                                <span class="day-name">
                                                    {{ $dayCode }}
                                                </span>

                                            </th>

                                        @endfor

                                    </tr>

                                    </thead>


                                    <tbody>

                                    @foreach($crewEmployees as $rowIndex => $assignment)

                                        @php

                                            $scheduleMap =
                                                $assignment
                                                    ->schedules
                                                    ->keyBy(
                                                        function ($schedule) {
                                                            return $schedule
                                                                ->schedule_date
                                                                ->format('Y-m-d');
                                                        }
                                                    );

                                        @endphp


                                        <tr>

                                            <td class="col-no">
                                                {{ $rowIndex + 1 }}
                                            </td>


                                            <!-- EMPLOYEE -->

                                            <td class="col-employee">

                                                <span class="employee-name">

                                                    {{
                                                        $assignment
                                                            ->employee
                                                            ->nama_lengkap
                                                        ?? '-'
                                                    }}

                                                </span>

                                                <span class="employee-nip">

                                                    {{
                                                        $assignment
                                                            ->employee
                                                            ->nip
                                                        ?? '-'
                                                    }}

                                                </span>

                                            </td>


                                            <!-- PHONE -->

                                            <td class="col-phone">

                                                {{
                                                    $assignment
                                                        ->employee
                                                        ->no_telepon
                                                    ?? '-'
                                                }}

                                            </td>


                                            <!-- POSITION -->

                                            <td class="col-position">

                                                {{
                                                    $assignment
                                                        ->employee
                                                        ->jabatan
                                                    ?? '-'
                                                }}

                                            </td>


                                            <!-- ACTION -->

                                            <td class="col-action">

                                                <button
                                                    type="button"
                                                    class="employee-action-btn"

                                                    data-assignment-id="{{ $assignment->id }}"
                                                    data-employee="{{ $assignment->employee->nama_lengkap ?? '-' }}"
                                                    data-rig="{{ $assignment->rig }}"
                                                    data-crew="{{ $assignment->crew }}"
                                                    onclick="openAssignmentModalFromButton(this)" 
                                                >
                                                    Atur
                                                </button>

                                            </td>


                                            <!-- DAYS -->

                                            @for(
                                                $day = 1;
                                                $day <= $daysInMonth;
                                                $day++
                                            )

                                                @php

                                                    $dateString =
                                                        \Carbon\Carbon::create(
                                                            $year,
                                                            $month,
                                                            $day
                                                        )
                                                        ->format(
                                                            'Y-m-d'
                                                        );

                                                    $schedule =
                                                        $scheduleMap
                                                            ->get(
                                                                $dateString
                                                            );

                                                    $shiftCode =
                                                        $schedule
                                                            ? $schedule
                                                                ->shift_code
                                                            : '';

                                                    $shiftClass =
                                                        match(
                                                            $shiftCode
                                                        ) {
                                                            'S'
                                                                => 'shift-s',

                                                            'M'
                                                                => 'shift-m',

                                                            'ON'
                                                                => 'shift-on',

                                                            'OFF'
                                                                => 'shift-off',

                                                            default
                                                                => 'shift-empty',
                                                        };

                                                @endphp


                                                <td class="day-column">

                                                    <button
                                                        type="button"

                                                        class="
                                                            schedule-cell
                                                            {{ $shiftClass }}
                                                        "

                                                        id="
                                                            schedule-cell-
                                                            {{ $assignment->id }}
                                                            -
                                                            {{ $dateString }}
                                                        "

                                                        data-assignment-id="{{ $assignment->id }}"
                                                        data-date="{{ $dateString }}"
                                                        data-shift="{{ $shiftCode }}"

                                                        onclick="openShiftModal(
                                                            this
                                                        )"
                                                    >

                                                        {{
                                                            $shiftCode !== ''
                                                                ? $shiftCode
                                                                : '+'
                                                        }}

                                                    </button>

                                                </td>

                                            @endfor

                                        </tr>

                                    @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="schedule-empty">

                                Belum ada karyawan pada
                                {{ $crewLabel }}
                                untuk
                                {{ $selectedRig }}
                                tahun
                                {{ $year }}.

                            </div>

                        @endif

                    </div>

                </div>

            @endif

        @endforeach

    @endif


    <!-- =====================================================
         YEARLY VIEW
    ====================================================== -->

    @if($viewMode === 'yearly')

        @if($assignments->count() > 0)

            <div class="yearly-container">

                @foreach($monthNames as $yearMonth => $yearMonthName)

                    @php

                        $yearMonthDays =
                            \Carbon\Carbon::create(
                                $year,
                                $yearMonth,
                                1
                            )
                            ->daysInMonth;

                    @endphp


                    <div class="yearly-month">

                        <div class="yearly-month-header">

                            {{ $yearMonthName }}
                            {{ $year }}

                        </div>


                        <div class="yearly-month-scroll">

                            <table class="yearly-mini-table">

                                <thead>

                                <tr>

                                    <th class="yearly-name">
                                        Karyawan
                                    </th>

                                    @for(
                                        $day = 1;
                                        $day <= $yearMonthDays;
                                        $day++
                                    )

                                        <th>
                                            {{ $day }}
                                        </th>

                                    @endfor

                                </tr>

                                </thead>


                                <tbody>

                                @foreach($assignments as $assignment)

                                    @php

                                        $yearScheduleMap =
                                            $assignment
                                                ->schedules
                                                ->keyBy(
                                                    function ($schedule) {
                                                        return $schedule
                                                            ->schedule_date
                                                            ->format(
                                                                'Y-m-d'
                                                            );
                                                    }
                                                );

                                    @endphp


                                    <tr>

                                        <td class="yearly-name">

                                            {{
                                                $assignment
                                                    ->employee
                                                    ->nama_lengkap
                                                ?? '-'
                                            }}

                                        </td>


                                        @for(
                                            $day = 1;
                                            $day <= $yearMonthDays;
                                            $day++
                                        )

                                            @php

                                                $dateString =
                                                    \Carbon\Carbon::create(
                                                        $year,
                                                        $yearMonth,
                                                        $day
                                                    )
                                                    ->format(
                                                        'Y-m-d'
                                                    );

                                                $schedule =
                                                    $yearScheduleMap
                                                        ->get(
                                                            $dateString
                                                        );

                                                $shiftCode =
                                                    $schedule
                                                        ? $schedule
                                                            ->shift_code
                                                        : '';

                                                $shiftClass =
                                                    match(
                                                        $shiftCode
                                                    ) {
                                                        'S'
                                                            => 'shift-s',

                                                        'M'
                                                            => 'shift-m',

                                                        'ON'
                                                            => 'shift-on',

                                                        'OFF'
                                                            => 'shift-off',

                                                        default
                                                            => 'shift-empty',
                                                    };

                                            @endphp


                                            <td>

                                                <span
                                                    class="
                                                        yearly-shift
                                                        {{ $shiftClass }}
                                                    "
                                                >

                                                    {{
                                                        $shiftCode !== ''
                                                            ? $shiftCode
                                                            : '-'
                                                    }}

                                                </span>

                                            </td>

                                        @endfor

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="crew-section">

                <div class="schedule-empty">

                    Belum ada schedule untuk
                    {{ $selectedRig }}
                    tahun
                    {{ $year }}.

                </div>

            </div>

        @endif

    @endif

</div>



    @if($viewMode === 'yearly')
        <div class="continue-year-card">
            <div>
                <h3>Lanjutkan Schedule ke Tahun {{ $year + 1 }}</h3>
                <p>
                    Semua karyawan tahun {{ $year }} akan otomatis dibuatkan schedule
                    {{ $year + 1 }}. Rig, Crew, dan urutan roster dilanjutkan dari
                    tanggal terakhir tanpa reset.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('schedules.continue-year') }}"
                onsubmit="return confirm('Lanjutkan semua schedule dari {{ $year }} ke {{ $year + 1 }}?');"
            >
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">

                <button type="submit" class="schedule-btn schedule-btn-primary">
                    + Lanjutkan Semua Schedule ke {{ $year + 1 }}
                </button>
            </form>
        </div>
    @endif


<!-- =========================================================
     ADD SCHEDULE MODAL
========================================================= -->

<div
    class="schedule-modal-backdrop"
    id="addScheduleModal"
>

    <div class="schedule-modal">

        <form
                method="POST"
                action="{{ route('schedules.assignments.store') }}"
                id="addScheduleForm"
            >
                @csrf

<div class="modal-field">

                    <label>
                        Karyawan *
                    </label>

                    <div class="employee-search-select" id="employeeSearchSelect">

                        <input
                            type="hidden"
                            name="employee_id"
                            id="employeeIdInput"
                            required
                        >

                        <input
                            type="text"
                            id="employeeSearchInput"
                            class="schedule-control employee-search-input"
                            placeholder="Ketik nama, NIP, atau jabatan..."
                            autocomplete="off"
                            onfocus="openEmployeeDropdown()"
                            oninput="filterEmployeeOptions()"
                        >

                        <span class="employee-search-arrow">⌄</span>

                        <div
                            class="employee-search-dropdown"
                            id="employeeSearchDropdown"
                        >

                            @foreach($employees as $employee)

                                @php
                                    $employeeLabel = $employee->nama_lengkap;

                                    if ($employee->nip) {
                                        $employeeLabel .= ' - ' . $employee->nip;
                                    }

                                    if ($employee->jabatan) {
                                        $employeeLabel .= ' - ' . $employee->jabatan;
                                    }
                                @endphp

                                <button
                                    type="button"
                                    class="employee-search-option"
                                    data-id="{{ $employee->id }}"
                                    data-label="{{ $employeeLabel }}"
                                    data-search="{{ strtolower($employeeLabel) }}"
                                    onclick="selectEmployeeOption(this)"
                                >
                                    {{ $employeeLabel }}
                                </button>

                            @endforeach

                            <div
                                class="employee-search-empty"
                                id="employeeSearchEmpty"
                            >
                                Karyawan tidak ditemukan.
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Lokasi / Rig</label>
                        <select
                            name="rig"
                            class="schedule-control"
                            required
                        >
                            @foreach($rigs as $rig)
                                <option
                                    value="{{ $rig }}"
                                    {{ old('rig', $selectedRig) === $rig ? 'selected' : '' }}
                                >
                                    {{ $rig }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Bagian / Crew</label>
                        <select
                            name="crew"
                            id="addScheduleCrew"
                            class="schedule-control"
                            required
                            onchange="updateAutoRosterFields()"
                        >
                            <option value="RIG_SUPERINTENDENT">Rig Superintendent</option>
                            <option value="A">Crew A</option>
                            <option value="B">Crew B</option>
                            <option value="C">Crew C</option>
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Tahun Schedule</label>
                        <select
                            name="year"
                            id="addScheduleYear"
                            class="schedule-control"
                            required
                            onchange="syncAnchorDateYear()"
                        >
                            @foreach($years as $yearOption)
                                <option
                                    value="{{ $yearOption }}"
                                    {{ (int) old('year', $year) === (int) $yearOption ? 'selected' : '' }}
                                >
                                    {{ $yearOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-field">
                        <label>Tanggal Acuan</label>
                        <input
                            type="date"
                            name="anchor_date"
                            id="addScheduleAnchorDate"
                            class="schedule-control"
                            value="{{ old('anchor_date', \Carbon\Carbon::create($year, $month, 1)->format('Y-m-d')) }}"
                            required
                        >
                    </div>
                </div>

                <div class="auto-roster-box">
                    <div class="auto-roster-title">
                        Posisi Schedule pada Tanggal Acuan
                    </div>

                    <div class="auto-roster-help" id="autoRosterHelp">
                        Rig Superintendent: 14 hari ON, lalu 14 hari OFF, kemudian berulang mengikuti tanggal.
                    </div>

                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>Status / Shift Saat Ini</label>
                            <select
                                name="anchor_shift"
                                id="addScheduleAnchorShift"
                                class="schedule-control"
                                required
                            ></select>
                        </div>

                        <div class="modal-field">
                            <label>Hari Ke-</label>
                            <select
                                name="anchor_day"
                                id="addScheduleAnchorDay"
                                class="schedule-control"
                                required
                            ></select>
                        </div>
                    </div>

                    <div class="auto-roster-example" id="autoRosterExample"></div>
                </div>

                <div class="schedule-modal-footer">
                    <button
                        type="button"
                        class="schedule-btn schedule-btn-light"
                        onclick="closeAddScheduleModal()"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="schedule-btn schedule-btn-primary"
                    >
                        Tambah & Susun Schedule
                    </button>
                </div>
            </form>

    </div>

</div>


<!-- =========================================================
     SHIFT PICKER MODAL
========================================================= -->

<div
    class="schedule-modal-backdrop"
    id="shiftModal"
>

    <div
        class="
            schedule-modal
            schedule-modal-small
        "
    >

        <div class="schedule-modal-header">

            <div>

                <h3>
                    Pilih Schedule
                </h3>

                <p id="shiftModalDate">
                    -
                </p>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeModal('shiftModal')"
            >
                &times;
            </button>

        </div>


        <div class="schedule-modal-body">

            <div class="shift-picker">


                <button
                    type="button"
                    class="
                        shift-picker-btn
                        shift-s
                    "
                    onclick="saveSelectedShift('S')"
                >
                    S
                    <span>Siang</span>
                </button>


                <button
                    type="button"
                    class="
                        shift-picker-btn
                        shift-m
                    "
                    onclick="saveSelectedShift('M')"
                >
                    M
                    <span>Malam</span>
                </button>


                <button
                    type="button"
                    class="
                        shift-picker-btn
                        shift-on
                    "
                    onclick="saveSelectedShift('ON')"
                >
                    ON
                    <span>Standby 24 Jam</span>
                </button>


                <button
                    type="button"
                    class="
                        shift-picker-btn
                        shift-off
                    "
                    onclick="saveSelectedShift('OFF')"
                >
                    OFF
                    <span>Libur</span>
                </button>

            </div>


            <button
                type="button"
                class="clear-schedule-btn"
                onclick="clearSelectedShift()"
            >
                Kosongkan Schedule
            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     ASSIGNMENT MODAL
========================================================= -->

<div
    class="schedule-modal-backdrop"
    id="assignmentModal"
>

    <div
        class="
            schedule-modal
            schedule-modal-small
        "
    >

        <form
            method="POST"
            id="assignmentUpdateForm"
        >

            @csrf
            @method('PUT')


            <div class="schedule-modal-header">

                <div>

                    <h3>
                        Atur Penempatan Karyawan
                    </h3>

                    <p id="assignmentEmployeeName">
                        -
                    </p>

                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeModal('assignmentModal')"
                >
                    &times;
                </button>

            </div>


            <div class="schedule-modal-body">


                <div class="modal-field">

                    <label>
                        Lokasi / Rig
                    </label>

                    <select
                        name="rig"
                        id="assignmentRig"
                        class="schedule-control"
                        required
                    >

                        @foreach($rigs as $rig)

                            <option value="{{ $rig }}">
                                {{ $rig }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="modal-field">

                    <label>
                        Crew / Kelompok
                    </label>

                    <select
                        name="crew"
                        id="assignmentCrew"
                        class="schedule-control"
                        required
                    >

                        <option value="RIG_SUPERINTENDENT">
                            Rig Superintendent
                        </option>

                        <option value="A">
                            Crew A
                        </option>

                        <option value="B">
                            Crew B
                        </option>

                        <option value="C">
                            Crew C
                        </option>

                    </select>

                </div>

            </div>


            <div class="schedule-modal-footer">

                <button
                    type="button"
                    class="
                        schedule-btn
                        schedule-btn-danger
                    "
                    onclick="deleteAssignment()"
                >
                    Hapus dari Schedule
                </button>

                <button
                    type="button"
                    class="
                        schedule-btn
                        schedule-btn-light
                    "
                    onclick="closeModal('assignmentModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="
                        schedule-btn
                        schedule-btn-primary
                    "
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>


<!-- DELETE ASSIGNMENT FORM -->

<form
    method="POST"
    id="assignmentDeleteForm"
    style="display:none;"
>
    @csrf
    @method('DELETE')
</form>


<!-- TOAST -->

<div
    class="schedule-toast"
    id="scheduleToast"
></div>


<script>
    function updateAutoRosterFields()
    {
        const crew = document.getElementById('addScheduleCrew');
        const shift = document.getElementById('addScheduleAnchorShift');
        const day = document.getElementById('addScheduleAnchorDay');
        const help = document.getElementById('autoRosterHelp');
        const example = document.getElementById('autoRosterExample');

        if (!crew || !shift || !day) {
            return;
        }

        const isSuperintendent = crew.value === 'RIG_SUPERINTENDENT';

        shift.innerHTML = '';

        const shifts = isSuperintendent
            ? [
                ['ON', 'ON - Standby Lapangan 24 Jam'],
                ['OFF', 'OFF - Libur']
            ]
            : [
                ['S', 'S - Siang'],
                ['M', 'M - Malam'],
                ['OFF', 'OFF - Libur']
            ];

        shifts.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item[0];
            option.textContent = item[1];
            shift.appendChild(option);
        });

        day.innerHTML = '';

        const maxDay = isSuperintendent ? 14 : 7;

        for (let i = 1; i <= maxDay; i++) {
            const option = document.createElement('option');
            option.value = String(i);
            option.textContent = 'Hari ke-' + i;
            day.appendChild(option);
        }

        if (help) {
            help.textContent = isSuperintendent
                ? 'Rig Superintendent: 14 hari ON lalu 14 hari OFF. Siklus terus berlanjut mengikuti tanggal, termasuk saat berganti tahun.'
                : 'Crew A/B/C: 7 hari Siang, 7 hari Malam, lalu 7 hari OFF. Siklus 14 hari kerja / 7 hari libur terus berlanjut mengikuti tanggal.';
        }

        if (example) {
            example.textContent = isSuperintendent
                ? 'Contoh: jika tanggal acuan adalah ON hari ke-11, sistem melanjutkan ON sampai hari ke-14, kemudian OFF 14 hari, lalu ON lagi.'
                : 'Contoh: jika tanggal acuan adalah S hari ke-4, sistem melanjutkan S hari ke-5 sampai 7, lalu M 7 hari, OFF 7 hari, lalu kembali S.';
        }
    }

    function syncAnchorDateYear()
    {
        const year = document.getElementById('addScheduleYear');
        const date = document.getElementById('addScheduleAnchorDate');

        if (!year || !date || !date.value) {
            return;
        }

        const parts = date.value.split('-');

        if (parts.length === 3) {
            date.value = year.value + '-' + parts[1] + '-' + parts[2];
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateAutoRosterFields();
    });
</script>


@endsection


@push('scripts')

<script>
    /*
    |--------------------------------------------------------------------------
    | GLOBAL
    |--------------------------------------------------------------------------
    */

    let selectedScheduleCell = null;
    let selectedAssignmentId = null;
    let selectedScheduleDate = null;

    let activeAssignmentId = null;


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');


    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    function submitScheduleFilter() {

        document
            .getElementById('scheduleFilterForm')
            .submit();

    }


    function selectCrewFilter(crew) {

        document
            .getElementById('crewFilterInput')
            .value = crew;

        submitScheduleFilter();

    }


    /*
    |--------------------------------------------------------------------------
    | CREW COLLAPSE
    |--------------------------------------------------------------------------
    */

    function toggleCrewSection(crew) {

        const section =
            document.getElementById(
                'crew-section-' + crew
            );

        if (!section) {
            return;
        }

        section.classList.toggle(
            'collapsed'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL
    |--------------------------------------------------------------------------
    */

    function openModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        document.body.style.overflow =
            'hidden';

    }


    function closeModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        document.body.style.overflow =
            '';

    }


    function openAddScheduleModal() {

        const employeeInput =
            document.getElementById(
                'employeeSearchInput'
            );

        const employeeIdInput =
            document.getElementById(
                'employeeIdInput'
            );

        if (employeeInput) {
            employeeInput.value = '';
        }

        if (employeeIdInput) {
            employeeIdInput.value = '';
        }

        filterEmployeeOptions();

        const dropdown =
            document.getElementById(
                'employeeSearchDropdown'
            );

        if (dropdown) {
            dropdown.classList.remove('show');
        }

        openModal(
            'addScheduleModal'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCHABLE EMPLOYEE SELECT
    |--------------------------------------------------------------------------
    */

    function openEmployeeDropdown() {

        const dropdown =
            document.getElementById(
                'employeeSearchDropdown'
            );

        if (dropdown) {
            dropdown.classList.add('show');
        }

    }


    function filterEmployeeOptions() {

        const input =
            document.getElementById(
                'employeeSearchInput'
            );

        const hiddenInput =
            document.getElementById(
                'employeeIdInput'
            );

        const dropdown =
            document.getElementById(
                'employeeSearchDropdown'
            );

        const emptyState =
            document.getElementById(
                'employeeSearchEmpty'
            );

        if (!input || !dropdown) {
            return;
        }

        const keyword =
            input.value
                .trim()
                .toLowerCase();

        if (hiddenInput) {
            hiddenInput.value = '';
        }

        let visibleCount = 0;

        dropdown
            .querySelectorAll(
                '.employee-search-option'
            )
            .forEach(function (option) {

                const searchText =
                    (option.dataset.search || '')
                        .toLowerCase();

                const isMatch =
                    keyword === ''
                    ||
                    searchText.includes(keyword);

                option.style.display =
                    isMatch
                        ? 'block'
                        : 'none';

                if (isMatch) {
                    visibleCount++;
                }

            });

        if (emptyState) {
            emptyState.style.display =
                visibleCount === 0
                    ? 'block'
                    : 'none';
        }

        dropdown.classList.add('show');

    }


    function selectEmployeeOption(option) {

        const input =
            document.getElementById(
                'employeeSearchInput'
            );

        const hiddenInput =
            document.getElementById(
                'employeeIdInput'
            );

        const dropdown =
            document.getElementById(
                'employeeSearchDropdown'
            );

        if (!input || !hiddenInput || !option) {
            return;
        }

        hiddenInput.value =
            option.dataset.id || '';

        input.value =
            option.dataset.label || '';

        if (dropdown) {
            dropdown.classList.remove('show');
        }

    }


    document.addEventListener(
        'click',
        function (event) {

            const wrapper =
                document.getElementById(
                    'employeeSearchSelect'
                );

            const dropdown =
                document.getElementById(
                    'employeeSearchDropdown'
                );

            if (
                wrapper
                &&
                dropdown
                &&
                !wrapper.contains(event.target)
            ) {
                dropdown.classList.remove('show');
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CLICK OUTSIDE MODAL
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.schedule-modal-backdrop'
        )
        .forEach(function (backdrop) {

            backdrop.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target
                        ===
                        backdrop
                    ) {

                        closeModal(
                            backdrop.id
                        );

                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | SHIFT MODAL
    |--------------------------------------------------------------------------
    */

    function openShiftModal(button) {

        selectedScheduleCell =
            button;

        selectedAssignmentId =
            button.dataset.assignmentId;

        selectedScheduleDate =
            button.dataset.date;


        const dateObject =
            new Date(
                selectedScheduleDate
                +
                'T00:00:00'
            );


        const formattedDate =
            new Intl.DateTimeFormat(
                'id-ID',
                {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }
            )
            .format(
                dateObject
            );


        document
            .getElementById(
                'shiftModalDate'
            )
            .textContent =
                formattedDate;


        openModal(
            'shiftModal'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SAVE SHIFT
    |--------------------------------------------------------------------------
    */

    async function saveSelectedShift(
        shiftCode
    ) {

        if (
            !selectedAssignmentId
            ||
            !selectedScheduleDate
        ) {
            return;
        }


        const url =
            "{{ url('/schedule/assignment') }}"
            +
            '/'
            +
            selectedAssignmentId
            +
            '/day';


        try {

            const response =
                await fetch(
                    url,
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken
                        },

                        body:
                            JSON.stringify({
                                schedule_date:
                                    selectedScheduleDate,

                                shift_code:
                                    shiftCode
                            })
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message
                    ||
                    'Schedule gagal disimpan.'
                );

            }


            updateScheduleCell(
                selectedScheduleCell,
                shiftCode
            );


            closeModal(
                'shiftModal'
            );


            showToast(
                'Schedule berhasil disimpan.'
            );

        } catch (error) {

            showToast(
                error.message,
                true
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR SHIFT
    |--------------------------------------------------------------------------
    */

    async function clearSelectedShift() {

        if (
            !selectedAssignmentId
            ||
            !selectedScheduleDate
        ) {
            return;
        }


        const url =
            "{{ url('/schedule/assignment') }}"
            +
            '/'
            +
            selectedAssignmentId
            +
            '/day';


        try {

            const response =
                await fetch(
                    url,
                    {
                        method: 'DELETE',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken
                        },

                        body:
                            JSON.stringify({
                                schedule_date:
                                    selectedScheduleDate
                            })
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message
                    ||
                    'Schedule gagal dikosongkan.'
                );

            }


            updateScheduleCell(
                selectedScheduleCell,
                ''
            );


            closeModal(
                'shiftModal'
            );


            showToast(
                'Schedule berhasil dikosongkan.'
            );

        } catch (error) {

            showToast(
                error.message,
                true
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CELL
    |--------------------------------------------------------------------------
    */

    function updateScheduleCell(
        button,
        shiftCode
    ) {

        if (!button) {
            return;
        }


        button.classList.remove(
            'shift-s',
            'shift-m',
            'shift-on',
            'shift-off',
            'shift-empty'
        );


        if (shiftCode === 'S') {

            button.classList.add(
                'shift-s'
            );

        } else if (
            shiftCode === 'M'
        ) {

            button.classList.add(
                'shift-m'
            );

        } else if (
            shiftCode === 'ON'
        ) {

            button.classList.add(
                'shift-on'
            );

        } else if (
            shiftCode === 'OFF'
        ) {

            button.classList.add(
                'shift-off'
            );

        } else {

            button.classList.add(
                'shift-empty'
            );

        }


        button.textContent =
            shiftCode !== ''
                ? shiftCode
                : '+';


        button.dataset.shift =
            shiftCode;

    }


    /*
    |--------------------------------------------------------------------------
    | ASSIGNMENT MODAL
    |--------------------------------------------------------------------------
    */

    function openAssignmentModalFromButton(button) {

        openAssignmentModal({
            id: button.dataset.assignmentId,
            employee: button.dataset.employee,
            rig: button.dataset.rig,
            crew: button.dataset.crew
        });

    }


    function openAssignmentModal(data) {

        activeAssignmentId =
            data.id;


        document
            .getElementById(
                'assignmentEmployeeName'
            )
            .textContent =
                data.employee;


        document
            .getElementById(
                'assignmentRig'
            )
            .value =
                data.rig;


        document
            .getElementById(
                'assignmentCrew'
            )
            .value =
                data.crew;


        document
            .getElementById(
                'assignmentUpdateForm'
            )
            .action =
                "{{ url('/schedule/assignment') }}"
                +
                '/'
                +
                data.id;


        document
            .getElementById(
                'assignmentDeleteForm'
            )
            .action =
                "{{ url('/schedule/assignment') }}"
                +
                '/'
                +
                data.id;


        openModal(
            'assignmentModal'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DELETE ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    function deleteAssignment() {

        if (!activeAssignmentId) {
            return;
        }


        const confirmed =
            confirm(
                'Hapus karyawan ini dari schedule?\n\n'
                +
                'Schedule milik karyawan pada tahun ini juga akan terhapus.'
            );


        if (!confirmed) {
            return;
        }


        document
            .getElementById(
                'assignmentDeleteForm'
            )
            .submit();

    }


    /*
    |--------------------------------------------------------------------------
    | TOAST
    |--------------------------------------------------------------------------
    */

    function showToast(
        message,
        isError = false
    ) {

        const toast =
            document.getElementById(
                'scheduleToast'
            );


        toast.textContent =
            message;


        toast.classList.remove(
            'error'
        );


        if (isError) {

            toast.classList.add(
                'error'
            );

        }


        toast.classList.add(
            'show'
        );


        setTimeout(
            function () {

                toast.classList.remove(
                    'show'
                );

            },
            2500
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESC CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key
                !==
                'Escape'
            ) {
                return;
            }


            document
                .querySelectorAll(
                    '.schedule-modal-backdrop.show'
                )
                .forEach(
                    function (modal) {

                        closeModal(
                            modal.id
                        );

                    }
                );

        }
    );

</script>

@endpush