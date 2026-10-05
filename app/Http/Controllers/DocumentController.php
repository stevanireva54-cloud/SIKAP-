<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ZipArchive;

class DocumentController extends Controller
{
    private const TYPES = [
        'moc' => 'Formulir MOC',
        'berita_acara' => 'Berita Acara',
        'surat_tugas' => 'Surat Tugas',
    ];

    private function filters(Request $request): array
    {
        $request->validate([
            'search' => ['nullable', 'string'],
            'month' => ['nullable', 'date_format:Y-m'],
        ]);
        return [trim((string) $request->input('search', '')), (string) $request->input('month', '')];
    }

    private function query(string $search, string $month, ?string $type = null)
    {
        $query = Document::with('user');
        if ($type !== null) {
            $query->where('document_type', $type);
        }
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('document_title', 'like', '%' . $search . '%')
                    ->orWhere('employee_name', 'like', '%' . $search . '%')
                    ->orWhere('file_name', 'like', '%' . $search . '%');
            });
        }
        if ($month !== '') {
            $start = Carbon::createFromFormat('!Y-m', $month)->startOfMonth();
            $query->where('created_at', '>=', $start)
                ->where('created_at', '<', $start->copy()->addMonth());
        }
        return $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function index(Request $request)
    {
        [$search, $month] = $this->filters($request);
        $documents = $this->query($search, $month)->get();
        return view('documents.index', compact('documents', 'search', 'month'));
    }

    private function byType(Request $request, string $documentType)
    {
        [$search, $month] = $this->filters($request);
        $documents = $this->query($search, $month, $documentType)->get();
        $pageTitle = self::TYPES[$documentType];
        return view('documents.by-type', compact('documents', 'pageTitle', 'documentType', 'search', 'month'));
    }

    public function beritaAcara(Request $request) { return $this->byType($request, 'berita_acara'); }
    public function moc(Request $request) { return $this->byType($request, 'moc'); }
    public function suratTugas(Request $request) { return $this->byType($request, 'surat_tugas'); }

    public function export(Request $request)
    {
        [$search, $month] = $this->filters($request);
        $request->validate(['type' => ['nullable', Rule::in(array_keys(self::TYPES))]]);
        $type = $request->filled('type') ? $request->input('type') : null;
        if (!class_exists(ZipArchive::class)) {
            return back()->with('error', 'Export Excel membutuhkan ekstensi ZIP PHP. Aktifkan extension=zip di php.ini lalu restart Laravel.');
        }
        $documents = $this->query($search, $month, $type)->get();
        $path = \App\Services\DocumentExcelExport::write($documents, $type);
        $title = self::TYPES[$type] ?? 'Semua Dokumen';
        $filename = 'Rekap ' . $title . ' - ' . ($month ?: 'Semua Bulan') . '.xlsx';
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function download(Document $document)
    {
        $path = storage_path('app/' . $document->file_path);
        if (!file_exists($path)) { return back()->with('error', 'File dokumen tidak ditemukan.'); }
        return response()->download($path, $document->file_name);
    }

    public function destroy(Document $document)
    {
        $path = storage_path('app/' . $document->file_path);
        if (file_exists($path)) { unlink($path); }
        $document->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
