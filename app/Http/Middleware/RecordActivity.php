<?php

namespace App\Http\Middleware;

use App\Services\ActivityRecorder;
use App\Services\DocumentRevision;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $beforeRevision = null;
        // Route tersedia setelah SubstituteBindings; snapshot sebelum controller.
        $revisionRequest = $request->is('pengaturan/revisi-dokumen') && $request->isMethod('PUT');
        if ($revisionRequest) {
            $beforeRevision = DocumentRevision::all();
        }
        $assignment = $request->route('assignment');
        $context = is_object($assignment) ? [
            'ID assignment' => $assignment->getKey(),
            'Karyawan' => optional($assignment->employee)->nama_lengkap,
            'Rig' => $assignment->rig,
            'Crew' => $assignment->crew,
        ] : [];

        $response = $next($request);
        if (!$request->user() || $response->getStatusCode() >= 400) {
            return $response;
        }
        if ($response instanceof \Illuminate\Http\JsonResponse && ($response->getData(true)['success'] ?? null) === false) {
            return $response;
        }
        if ($response->isRedirection() && (!$request->hasSession() || !$request->session()->has('success') || $request->session()->has('error') || $request->session()->has('errors'))) {
            return $response;
        }
        $name = $request->route()?->getName() ?? '';
        if (in_array($name, ['documents.export', 'employees.export', 'schedules.export'], true) && $response->isSuccessful()) {
            $label = ['documents.export' => 'dokumen', 'employees.export' => 'data karyawan', 'schedules.export' => 'schedule'][$name];
            ActivityRecorder::record('Export', 'Export', 'Membuat file Excel ' . $label, $request->only(['month', 'year', 'type', 'rig', 'crew', 'view', 'status']));
        } elseif (str_starts_with($name, 'schedules.') && !$request->isMethod('GET')) {
            $actions = [
                'schedules.assignments.store' => 'Menambah karyawan ke schedule',
                'schedules.assignments.update' => 'Mengubah rig / crew schedule',
                'schedules.assignments.destroy' => 'Menghapus karyawan dari schedule',
                'schedules.day.save' => 'Menyimpan shift harian',
                'schedules.day.clear' => 'Mengosongkan shift harian',
                'schedules.bulk.save' => 'Menyimpan schedule karyawan secara massal',
                'schedules.continue-year' => 'Melanjutkan schedule ke tahun berikutnya',
            ];
            ActivityRecorder::record('Schedule', $request->isMethod('DELETE') ? 'Hapus' : 'Simpan', $actions[$name] ?? 'Menyimpan schedule crew', $context + $request->only([
                'employee_id', 'rig', 'crew', 'year', 'month', 'schedule_date', 'shift_code',
                'start_date', 'end_date', 'date_from', 'date_to', 'source_year', 'target_year',
            ]));
        } elseif ($revisionRequest && $beforeRevision !== null) {
            $after = DocumentRevision::all();
            if ($beforeRevision !== $after) {
                ActivityRecorder::record('Revisi', 'Edit', 'Mengubah revisi dokumen', ['Sebelum' => $beforeRevision, 'Sesudah' => $after]);
            }
        }
        return $response;
    }
}
