<?php
namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;

class ImportDocumentDetails extends Command
{
    protected $signature = 'documents:import-details {--apply : Simpan detail hasil pembacaan dokumen lama}';
    protected $description = 'Pulihkan detail dokumen lama berdasarkan file_path dan SHA256 tanpa menimpa detail yang sudah ada';

    public function handle(): int
    {
        $path = storage_path('app/detail-dokumen-lama.json');
        if (!is_file($path)) { $this->error('Letakkan detail-dokumen-lama.json di storage/app.'); return self::FAILURE; }
        $records = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $matched = 0; $saved = 0; $skipped = 0; $failed = 0;
        foreach ($records as $record) {
            $relative = $record['file_path'];
            if (!str_starts_with($relative, 'generated/') || str_contains($relative, '..')) {
                $failed++; continue;
            }
            $documents = Document::where('file_path', $relative)
                ->where('document_type', $record['document_type'])->get();
            if ($documents->isEmpty()) { continue; }
            $file = storage_path('app/' . $relative);
            if (!is_file($file) || !hash_equals($record['sha256'], hash_file('sha256', $file))) {
                $this->warn('File tidak cocok atau tidak tersedia: ' . $relative); $failed++; continue;
            }
            foreach ($documents as $document) {
                if (!empty($document->form_data)) { $skipped++; continue; }
                $matched++;
                if ($this->option('apply')) {
                    // Conditional update avoids overwriting a concurrent save. Preserve timestamps.
                    $saved += Document::whereKey($document->id)->whereNull('form_data')
                        ->toBase()->update(['form_data' => json_encode($record['form_data'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)]);
                }
            }
        }
        $this->info("Cocok: {$matched}; tersimpan: {$saved}; detail sudah ada: {$skipped}; file gagal diverifikasi: {$failed}.");
        if (!$this->option('apply')) { $this->info('Ini pemeriksaan saja. Jalankan dengan --apply untuk menyimpan.'); }
        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
