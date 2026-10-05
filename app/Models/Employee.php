<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        // Identitas pekerjaan
        'nip',
        'nik_internal',
        'nama_lengkap',
        'jabatan',
        'rig',
        'tanggal_bergabung',
        'status',

        // File utama
        'foto_path',
        'ktp_file_path',

        // Pendidikan & keluarga
        'nama_ibu_kandung',
        'pendidikan_terakhir',
        'nama_sekolah',
        'tahun_lulus',
        'agama',
        'status_pernikahan',
        'jumlah_anak',

        // Data pribadi
        'tempat_lahir',
        'tanggal_lahir',
        'nik_ktp',
        'alamat',
        'no_telepon',
        'email',

        // BPJS & pajak
        'no_kis',
        'no_kpj',
        'npwp',

        // Bank
        'nama_bank',
        'nama_pemilik_rekening',
        'nomor_rekening',

        // Cuti & perlengkapan
        'saldo_cuti',
        'ukuran_baju',
        'ukuran_sepatu',

        // Masa berlaku dokumen
        'ktp_expiry_date',
        'contract_end_date',
        'sim_expiry_date',
        'certificate_expiry_date',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
        'tanggal_lahir' => 'date',

        'ktp_expiry_date' => 'date',
        'contract_end_date' => 'date',
        'sim_expiry_date' => 'date',
        'certificate_expiry_date' => 'date',

        'tahun_lulus' => 'integer',
        'jumlah_anak' => 'integer',
        'saldo_cuti' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP DOKUMEN KARYAWAN
    |--------------------------------------------------------------------------
    |
    | Satu karyawan dapat memiliki banyak dokumen:
    | CV, MCU, QAQC, Sertifikat, dan dokumen lain.
    |
    */

    public function documents()
    {
        return $this->hasMany(
            EmployeeDocument::class,
            'employee_id'
        );
    }
}