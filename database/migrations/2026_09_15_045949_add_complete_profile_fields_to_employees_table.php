<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | FOTO / FILE
            |--------------------------------------------------------------------------
            */

            // foto_path sudah ada dari migration employees pertama

            $table->string('ktp_file_path')
                ->nullable()
                ->after('foto_path');


            /*
            |--------------------------------------------------------------------------
            | DATA PRIBADI
            |--------------------------------------------------------------------------
            */

            $table->string('nama_ibu_kandung')
                ->nullable()
                ->after('ktp_file_path');

            $table->string('tempat_lahir')
                ->nullable()
                ->after('nama_ibu_kandung');

            $table->date('tanggal_lahir')
                ->nullable()
                ->after('tempat_lahir');

            $table->string('nik_ktp', 16)
                ->nullable()
                ->after('tanggal_lahir');

            $table->text('alamat')
                ->nullable()
                ->after('nik_ktp');

            $table->string('no_telepon', 30)
                ->nullable()
                ->after('alamat');

            $table->string('email')
                ->nullable()
                ->after('no_telepon');

            $table->string('agama', 50)
                ->nullable()
                ->after('email');

            $table->string('status_pernikahan', 50)
                ->nullable()
                ->after('agama');

            $table->unsignedInteger('jumlah_anak')
                ->nullable()
                ->default(0)
                ->after('status_pernikahan');


            /*
            |--------------------------------------------------------------------------
            | PENDIDIKAN
            |--------------------------------------------------------------------------
            */

            $table->string('pendidikan_terakhir', 50)
                ->nullable()
                ->after('jumlah_anak');

            $table->string('nama_sekolah')
                ->nullable()
                ->after('pendidikan_terakhir');

            $table->unsignedSmallInteger('tahun_lulus')
                ->nullable()
                ->after('nama_sekolah');


            /*
            |--------------------------------------------------------------------------
            | BPJS / PAJAK
            |--------------------------------------------------------------------------
            */

            $table->string('no_kis', 100)
                ->nullable()
                ->after('tahun_lulus');

            $table->string('no_kpj', 100)
                ->nullable()
                ->after('no_kis');

            $table->string('npwp', 100)
                ->nullable()
                ->after('no_kpj');


            /*
            |--------------------------------------------------------------------------
            | DATA BANK
            |--------------------------------------------------------------------------
            */

            $table->string('nama_bank', 100)
                ->nullable()
                ->after('npwp');

            $table->string('nama_pemilik_rekening')
                ->nullable()
                ->after('nama_bank');

            $table->string('nomor_rekening', 100)
                ->nullable()
                ->after('nama_pemilik_rekening');


            /*
            |--------------------------------------------------------------------------
            | CUTI & PERLENGKAPAN
            |--------------------------------------------------------------------------
            */

            $table->decimal('saldo_cuti', 6, 2)
                ->nullable()
                ->default(0)
                ->after('nomor_rekening');

            $table->string('ukuran_baju', 20)
                ->nullable()
                ->after('saldo_cuti');

            $table->string('ukuran_sepatu', 20)
                ->nullable()
                ->after('ukuran_baju');


            /*
            |--------------------------------------------------------------------------
            | MASA BERLAKU DOKUMEN
            |--------------------------------------------------------------------------
            */

            $table->date('ktp_expiry_date')
                ->nullable()
                ->after('ukuran_sepatu');

            $table->date('contract_end_date')
                ->nullable()
                ->after('ktp_expiry_date');

            $table->date('sim_expiry_date')
                ->nullable()
                ->after('contract_end_date');

            $table->date('certificate_expiry_date')
                ->nullable()
                ->after('sim_expiry_date');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->dropColumn([
                'ktp_file_path',

                'nama_ibu_kandung',
                'tempat_lahir',
                'tanggal_lahir',
                'nik_ktp',
                'alamat',
                'no_telepon',
                'email',
                'agama',
                'status_pernikahan',
                'jumlah_anak',

                'pendidikan_terakhir',
                'nama_sekolah',
                'tahun_lulus',

                'no_kis',
                'no_kpj',
                'npwp',

                'nama_bank',
                'nama_pemilik_rekening',
                'nomor_rekening',

                'saldo_cuti',
                'ukuran_baju',
                'ukuran_sepatu',

                'ktp_expiry_date',
                'contract_end_date',
                'sim_expiry_date',
                'certificate_expiry_date',
            ]);
        });
    }
};s