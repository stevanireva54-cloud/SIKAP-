<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityRecorder
{
    public static function record(string $category, string $action, string $description, array $details = []): void
    {
        // Import dan proses CLI tidak diperlakukan sebagai aktivitas pengguna web.
        if (app()->runningInConsole() || !Auth::check()) {
            return;
        }

        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?: 'Pengguna',
                'category' => $category,
                'action' => $action,
                'description' => $description,
                'details' => $details,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Kegagalan log tidak menggagalkan penyimpanan pekerjaan pengguna.
            Log::error('Riwayat aktivitas gagal disimpan.', ['exception' => $e]);
        }
    }
}
