<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Employee;
use App\Services\ActivityRecorder;
use Illuminate\Database\Eloquent\Model;

class ActivityModelObserver
{
    public function created(Model $model): void
    {
        if ($model instanceof Document) {
            ActivityRecorder::record('Dokumen', 'Generate', 'Membuat dokumen: ' . $model->document_title, [
                'ID dokumen' => $model->getKey(), 'Jenis' => $model->document_type, 'Nama file' => $model->file_name,
            ]);
        } elseif ($model instanceof Employee) {
            ActivityRecorder::record('Karyawan', 'Tambah', 'Menambah karyawan: ' . $model->nama_lengkap, $this->identity($model));
        }
    }

    public function updated(Model $model): void
    {
        if (!$model instanceof Employee) {
            return;
        }
        $changes = [];
        foreach (['nip', 'nik_internal', 'nama_lengkap', 'jabatan', 'rig', 'tanggal_bergabung', 'status'] as $field) {
            if ($model->wasChanged($field)) {
                $changes[$field] = ['Sebelum' => $model->getRawOriginal($field), 'Sesudah' => $model->getAttributes()[$field] ?? null];
            }
        }
        if ($model->wasChanged(array_diff(array_keys($model->getChanges()), ['updated_at']))) {
            ActivityRecorder::record('Karyawan', 'Edit', 'Mengubah data karyawan: ' . $model->nama_lengkap,
                $this->identity($model) + ($changes ? ['Perubahan data pekerjaan' => $changes] : ['Detail' => 'Data profil diperbarui.']));
        }
    }

    public function deleted(Model $model): void
    {
        if ($model instanceof Document) {
            ActivityRecorder::record('Dokumen', 'Hapus', 'Menghapus dokumen: ' . $model->document_title, [
                'ID dokumen' => $model->getKey(), 'Jenis' => $model->document_type, 'Nama file' => $model->file_name,
            ]);
        } elseif ($model instanceof Employee) {
            ActivityRecorder::record('Karyawan', 'Hapus', 'Menghapus karyawan: ' . $model->nama_lengkap, $this->identity($model));
        }
    }

    private function identity(Employee $employee): array
    {
        return ['ID karyawan' => $employee->getKey(), 'NIP' => $employee->nip, 'Rig' => $employee->rig];
    }
}
