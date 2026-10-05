<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DocumentRevision
{
    public const TYPES = ['moc' => 'Formulir MOC', 'surat_tugas' => 'Surat Tugas'];

    public static function all(): array
    {
        $defaults = [
            'moc' => ['rev_date' => '2026-10-01', 'rev_no' => '03'],
            'surat_tugas' => ['rev_date' => '2026-10-01', 'rev_no' => '03'],
        ];
        $path = storage_path('app/document-revisions.json');
        if (!is_file($path)) {
            return $defaults;
        }
        $saved = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        foreach (self::TYPES as $type => $label) {
            if (isset($saved[$type])) {
                $defaults[$type] = array_merge($defaults[$type], $saved[$type]);
            }
        }
        return $defaults;
    }

    public static function get(string $type): array
    {
        $revision = self::all()[$type];
        return [
            'rev_date' => Carbon::parse($revision['rev_date'])->locale('id')->translatedFormat('d-M-Y'),
            'rev_no' => (string) $revision['rev_no'],
        ];
    }

    public static function save(array $revisions): void
    {
        // Atomic replacement prevents generators reading partially written JSON.
        File::ensureDirectoryExists(storage_path('app'));
        File::replace(
            storage_path('app/document-revisions.json'),
            json_encode($revisions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
        );
    }
}
