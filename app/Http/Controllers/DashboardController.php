<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $documentCounts = Document::query()
            ->selectRaw('document_type, COUNT(*) as total')
            ->groupBy('document_type')
            ->pluck('total', 'document_type');

        $totalMoc = (int) $documentCounts->get('moc', 0);
        $totalBeritaAcara = (int) $documentCounts->get('berita_acara', 0);
        $totalSuratTugas = (int) $documentCounts->get('surat_tugas', 0);
        $totalDocuments = (int) $documentCounts->sum();

        $employees = Employee::query()->get();

        $totalEmployees = $employees->count();
        $totalLocations = $employees->pluck('rig')->filter(fn ($v) => filled($v))->unique()->count();
        $totalPositions = $employees->pluck('jabatan')->filter(fn ($v) => filled($v))->unique()->count();

        $profileFields = [
            'foto_path' => 'Foto profil',
            'ktp_file_path' => 'Scan KTP',
            'nik_ktp' => 'NIK KTP',
            'no_telepon' => 'No. HP',
            'alamat' => 'Alamat',
            'pendidikan_terakhir' => 'Pendidikan',
            'nama_sekolah' => 'Sekolah / Universitas',
            'nama_ibu_kandung' => 'Nama ibu kandung',
            'nama_bank' => 'Nama bank',
            'nomor_rekening' => 'Nomor rekening',
            'ukuran_baju' => 'Ukuran baju',
            'ukuran_sepatu' => 'Ukuran sepatu',
            'ktp_expiry_date' => 'Masa berlaku KTP',
            'contract_end_date' => 'Akhir kontrak',
            'sim_expiry_date' => 'Masa berlaku SIM',
            'certificate_expiry_date' => 'Masa berlaku sertifikat',
        ];

        $totalChecks = $totalEmployees * count($profileFields);
        $filledChecks = 0;
        $missing = [];

        foreach ($profileFields as $field => $label) {
            $missingCount = $employees->filter(fn ($employee) => blank($employee->{$field}))->count();
            $missing[] = ['label' => $label, 'missing' => $missingCount];
            $filledChecks += $totalEmployees - $missingCount;
        }

        $profileCompletion = $totalChecks > 0
            ? (int) round(($filledChecks / $totalChecks) * 100)
            : 0;

        $incompleteEmployees = $employees->filter(function ($employee) use ($profileFields) {
            foreach (array_keys($profileFields) as $field) {
                if (blank($employee->{$field})) {
                    return true;
                }
            }
            return false;
        })->count();

        $missingProfileFields = collect($missing)->sortByDesc('missing')->take(6)->values();

        $today = Carbon::today();
        $warningUntil = $today->copy()->addDays(60);

        $allWarnings = EmployeeDocument::query()
            ->with('employee')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $warningUntil)
            ->orderBy('expiry_date')
            ->get()
            ->map(function ($document) use ($today) {
                $expiry = Carbon::parse($document->expiry_date)->startOfDay();
                $days = $today->diffInDays($expiry, false);

                return [
                    'name' => $document->document_name ?: 'Dokumen',
                    'employee' => optional($document->employee)->nama_lengkap ?: '-',
                    'expiry' => $expiry,
                    'status_text' => $days < 0
                        ? abs($days) . ' hari lewat'
                        : ($days === 0 ? 'hari ini' : $days . ' hari lagi'),
                ];
            });

        $documentWarningCount = $allWarnings->count();
        $documentWarnings = $allWarnings->take(6);

        $locationDistribution = $employees
            ->groupBy(fn ($employee) => filled($employee->rig) ? $employee->rig : 'Belum Ditentukan')
            ->map(fn ($group, $location) => ['location' => $location, 'count' => $group->count()])
            ->sortByDesc('count')
            ->values();

        return view('dashboard', compact(
            'totalMoc',
            'totalBeritaAcara',
            'totalSuratTugas',
            'totalDocuments',
            'totalEmployees',
            'totalLocations',
            'totalPositions',
            'profileCompletion',
            'incompleteEmployees',
            'missingProfileFields',
            'documentWarnings',
            'documentWarningCount',
            'locationDistribution'
        ));
    }
}
