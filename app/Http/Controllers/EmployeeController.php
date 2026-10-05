<?php



namespace App\Http\Controllers;



use App\Models\Employee;

use App\Models\EmployeeDocument;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;



class EmployeeController extends Controller

{

    /**

     * Daftar karyawan.

     */

    public function export(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string'], 'rig' => ['nullable', 'string'],
            'jabatan' => ['nullable', 'string'], 'status' => ['nullable', 'string'],
        ]);
        if (!class_exists(\ZipArchive::class)) {
            return back()->with('error', 'Export Excel membutuhkan ekstensi ZIP PHP.');
        }
        $query = Employee::query()

            ->with('documents')

            ->withCount('documents');



        /*

        |--------------------------------------------------------------------------

        | SEARCH

        |--------------------------------------------------------------------------

        */

        if ($request->filled('search')) {

            $search = trim($request->search);



            $query->where(function ($q) use ($search) {

                $q->where('nama_lengkap', 'like', "%{$search}%")

                    ->orWhere('nip', 'like', "%{$search}%")

                    ->orWhere('nik_internal', 'like', "%{$search}%")

                    ->orWhere('jabatan', 'like', "%{$search}%")

                    ->orWhere('rig', 'like', "%{$search}%");

            });

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER LOKASI

        |--------------------------------------------------------------------------

        */

        if ($request->filled('rig')) {

            $query->where('rig', $request->rig);

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER JABATAN

        |--------------------------------------------------------------------------

        */

        if ($request->filled('jabatan')) {

            $query->where('jabatan', $request->jabatan);

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER STATUS

        |--------------------------------------------------------------------------

        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }




        $employees = $query->latest()->orderBy('id', 'desc')->get();
        $path = \App\Services\EmployeeExcelExport::write($employees);
        $rig = $request->filled('rig') ? (string) $request->input('rig') : 'Semua Rig';
        $rig = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $rig);
        return response()->download($path, 'Data Karyawan - ' . $rig . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function index(Request $request)

    {

        $query = Employee::query()

            ->with('documents')

            ->withCount('documents');



        /*

        |--------------------------------------------------------------------------

        | SEARCH

        |--------------------------------------------------------------------------

        */

        if ($request->filled('search')) {

            $search = trim($request->search);



            $query->where(function ($q) use ($search) {

                $q->where('nama_lengkap', 'like', "%{$search}%")

                    ->orWhere('nip', 'like', "%{$search}%")

                    ->orWhere('nik_internal', 'like', "%{$search}%")

                    ->orWhere('jabatan', 'like', "%{$search}%")

                    ->orWhere('rig', 'like', "%{$search}%");

            });

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER LOKASI

        |--------------------------------------------------------------------------

        */

        if ($request->filled('rig')) {

            $query->where('rig', $request->rig);

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER JABATAN

        |--------------------------------------------------------------------------

        */

        if ($request->filled('jabatan')) {

            $query->where('jabatan', $request->jabatan);

        }



        /*

        |--------------------------------------------------------------------------

        | FILTER STATUS

        |--------------------------------------------------------------------------

        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }



        $employees = $query

            ->latest()

            ->paginate(10)

            ->withQueryString();



        $rigs = Employee::query()

            ->whereNotNull('rig')

            ->where('rig', '!=', '')

            ->distinct()

            ->orderBy('rig')

            ->pluck('rig');



        $positions = Employee::query()

            ->whereNotNull('jabatan')

            ->where('jabatan', '!=', '')

            ->distinct()

            ->orderBy('jabatan')

            ->pluck('jabatan');



        return view('employees.index', compact(

            'employees',

            'rigs',

            'positions'

        ));

    }





    /**

     * Tambah karyawan.

     */

    public function store(Request $request)

    {

        /*

        |--------------------------------------------------------------------------

        | VALIDASI

        |--------------------------------------------------------------------------

        */

        $validated = $request->validate([

            'nip' => [

                'required',

                'string',

                'max:100',

                'unique:employees,nip',

            ],



            'nik_internal' => [

                'nullable',

                'string',

                'max:100',

                'unique:employees,nik_internal',

            ],



            'nama_lengkap' => [

                'required',

                'string',

                'max:255',

            ],



            'jabatan' => [

                'nullable',

                'string',

                'max:255',

            ],



            'rig' => [

                'nullable',

                'string',

                'max:100',

            ],



            'tanggal_bergabung' => [

                'nullable',

                'date',

            ],



            /*

            |--------------------------------------------------------------------------

            | FOTO & KTP

            |--------------------------------------------------------------------------

            */



            'foto' => [

                'nullable',

                'file',

                'mimes:jpg,jpeg,png',

                'max:5120',

            ],



            'ktp_file' => [

                'nullable',

                'file',

                'mimes:pdf,jpg,jpeg,png',

                'max:10240',

            ],



            /*

            |--------------------------------------------------------------------------

            | DATA PRIBADI

            |--------------------------------------------------------------------------

            */



            'nama_ibu_kandung' => [

                'nullable',

                'string',

                'max:255',

            ],



            'pendidikan_terakhir' => [

                'nullable',

                'string',

                'max:50',

            ],



            'nama_sekolah' => [

                'nullable',

                'string',

                'max:255',

            ],



            'tahun_lulus' => [

                'nullable',

                'integer',

                'min:1950',

                'max:' . date('Y'),

            ],



            'agama' => [

                'nullable',

                'string',

                'max:50',

            ],



            'status_pernikahan' => [

                'nullable',

                'string',

                'max:50',

            ],



            'jumlah_anak' => [

                'nullable',

                'integer',

                'min:0',

            ],



            'tempat_lahir' => [

                'nullable',

                'string',

                'max:255',

            ],



            'tanggal_lahir' => [

                'nullable',

                'date',

            ],



            'nik_ktp' => [

                'nullable',

                'digits:16',

            ],



            'alamat' => [

                'nullable',

                'string',

            ],



            'no_telepon' => [

                'nullable',

                'string',

                'max:30',

            ],



            'email' => [

                'nullable',

                'email',

                'max:255',

            ],



            /*

            |--------------------------------------------------------------------------

            | BPJS / PAJAK

            |--------------------------------------------------------------------------

            */



            'no_kis' => [

                'nullable',

                'string',

                'max:100',

            ],



            'no_kpj' => [

                'nullable',

                'string',

                'max:100',

            ],



            'npwp' => [

                'nullable',

                'string',

                'max:100',

            ],



            /*

            |--------------------------------------------------------------------------

            | BANK

            |--------------------------------------------------------------------------

            */



            'nama_bank' => [

                'nullable',

                'string',

                'max:100',

            ],



            'nama_pemilik_rekening' => [

                'nullable',

                'string',

                'max:255',

            ],



            'nomor_rekening' => [

                'nullable',

                'string',

                'max:100',

            ],



            /*

            |--------------------------------------------------------------------------

            | CUTI & PERLENGKAPAN

            |--------------------------------------------------------------------------

            */



            'saldo_cuti' => [

                'nullable',

                'numeric',

                'min:0',

            ],



            'ukuran_baju' => [

                'nullable',

                'string',

                'max:20',

            ],



            'ukuran_sepatu' => [

                'nullable',

                'string',

                'max:20',

            ],



            /*

            |--------------------------------------------------------------------------

            | MASA BERLAKU

            |--------------------------------------------------------------------------

            */



            'ktp_expiry_date' => [

                'nullable',

                'date',

            ],



            'contract_end_date' => [

                'nullable',

                'date',

            ],



            'sim_expiry_date' => [

                'nullable',

                'date',

            ],



            'certificate_expiry_date' => [

                'nullable',

                'date',

            ],

        ]);





        /*

        |--------------------------------------------------------------------------

        | UPLOAD FOTO PROFIL

        |--------------------------------------------------------------------------

        */

        $fotoPath = null;



        if ($request->hasFile('foto')) {

            $fotoPath = $request

                ->file('foto')

                ->store('employees/photos');

        }





        /*

        |--------------------------------------------------------------------------

        | UPLOAD SCAN KTP

        |--------------------------------------------------------------------------

        */

        $ktpFilePath = null;



        if ($request->hasFile('ktp_file')) {

            $ktpFilePath = $request

                ->file('ktp_file')

                ->store('employees/ktp');

        }





        /*

        |--------------------------------------------------------------------------

        | SIMPAN KARYAWAN

        |--------------------------------------------------------------------------

        |

        | Status tidak diminta di form Tambah.

        | Semua karyawan baru otomatis Aktif.

        |

        */



        Employee::create([

            'nip' => $validated['nip'],



            'nik_internal' =>

                $validated['nik_internal'] ?? null,



            'nama_lengkap' =>

                $validated['nama_lengkap'],



            'jabatan' =>

                $validated['jabatan'] ?? null,



            'rig' =>

                $validated['rig'] ?? null,



            /*

             * Crew dan Schedule sengaja tidak digunakan.

             */



            'tanggal_bergabung' =>

                $validated['tanggal_bergabung'] ?? null,



            'status' => 'Aktif',



            'foto_path' => $fotoPath,



            'ktp_file_path' => $ktpFilePath,



            'nama_ibu_kandung' =>

                $validated['nama_ibu_kandung'] ?? null,



            'pendidikan_terakhir' =>

                $validated['pendidikan_terakhir'] ?? null,



            'nama_sekolah' =>

                $validated['nama_sekolah'] ?? null,



            'tahun_lulus' =>

                $validated['tahun_lulus'] ?? null,



            'agama' =>

                $validated['agama'] ?? null,



            'status_pernikahan' =>

                $validated['status_pernikahan'] ?? null,



            'jumlah_anak' =>

                $validated['jumlah_anak'] ?? 0,



            'tempat_lahir' =>

                $validated['tempat_lahir'] ?? null,



            'tanggal_lahir' =>

                $validated['tanggal_lahir'] ?? null,



            'nik_ktp' =>

                $validated['nik_ktp'] ?? null,



            'alamat' =>

                $validated['alamat'] ?? null,



            'no_telepon' =>

                $validated['no_telepon'] ?? null,



            'email' =>

                $validated['email'] ?? null,



            'no_kis' =>

                $validated['no_kis'] ?? null,



            'no_kpj' =>

                $validated['no_kpj'] ?? null,



            'npwp' =>

                $validated['npwp'] ?? null,



            'nama_bank' =>

                $validated['nama_bank'] ?? null,



            'nama_pemilik_rekening' =>

                $validated['nama_pemilik_rekening'] ?? null,



            'nomor_rekening' =>

                $validated['nomor_rekening'] ?? null,



            'saldo_cuti' =>

                $validated['saldo_cuti'] ?? 0,



            'ukuran_baju' =>

                $validated['ukuran_baju'] ?? null,



            'ukuran_sepatu' =>

                $validated['ukuran_sepatu'] ?? null,



            'ktp_expiry_date' =>

                $validated['ktp_expiry_date'] ?? null,



            'contract_end_date' =>

                $validated['contract_end_date'] ?? null,



            'sim_expiry_date' =>

                $validated['sim_expiry_date'] ?? null,



            'certificate_expiry_date' =>

                $validated['certificate_expiry_date'] ?? null,

        ]);





        return redirect()

            ->route('employees.index')

            ->with(

                'success',

                'Data karyawan berhasil ditambahkan.'

            );

    }





    /**

     * Update data karyawan.

     */

    public function update(

        Request $request,

        Employee $employee

    ) {

        $validated = $request->validate([

            'nip' => [

                'required',

                'string',

                'max:100',

                Rule::unique('employees', 'nip')

                    ->ignore($employee->id),

            ],



            'nik_internal' => [

                'nullable',

                'string',

                'max:100',

                Rule::unique('employees', 'nik_internal')

                    ->ignore($employee->id),

            ],



            'nama_lengkap' => [

                'required',

                'string',

                'max:255',

            ],



            'jabatan' => [

                'nullable',

                'string',

                'max:255',

            ],



            'rig' => [

                'nullable',

                'string',

                'max:100',

            ],



            'tanggal_bergabung' => [

                'nullable',

                'date',

            ],



            'status' => [

                'nullable',

                Rule::in([

                    'Aktif',

                    'Nonaktif',

                ]),

            ],



            'foto' => [

                'nullable',

                'file',

                'mimes:jpg,jpeg,png',

                'max:5120',

            ],



            'ktp_file' => [

                'nullable',

                'file',

                'mimes:pdf,jpg,jpeg,png',

                'max:10240',

            ],



            'nama_ibu_kandung' => [

                'nullable',

                'string',

                'max:255',

            ],



            'pendidikan_terakhir' => [

                'nullable',

                'string',

                'max:50',

            ],



            'nama_sekolah' => [

                'nullable',

                'string',

                'max:255',

            ],



            'tahun_lulus' => [

                'nullable',

                'integer',

                'min:1950',

                'max:' . date('Y'),

            ],



            'agama' => [

                'nullable',

                'string',

                'max:50',

            ],



            'status_pernikahan' => [

                'nullable',

                'string',

                'max:50',

            ],



            'jumlah_anak' => [

                'nullable',

                'integer',

                'min:0',

            ],



            'tempat_lahir' => [

                'nullable',

                'string',

                'max:255',

            ],



            'tanggal_lahir' => [

                'nullable',

                'date',

            ],



            'nik_ktp' => [

                'nullable',

                'digits:16',

            ],



            'alamat' => [

                'nullable',

                'string',

            ],



            'no_telepon' => [

                'nullable',

                'string',

                'max:30',

            ],



            'email' => [

                'nullable',

                'email',

                'max:255',

            ],



            'no_kis' => [

                'nullable',

                'string',

                'max:100',

            ],



            'no_kpj' => [

                'nullable',

                'string',

                'max:100',

            ],



            'npwp' => [

                'nullable',

                'string',

                'max:100',

            ],



            'nama_bank' => [

                'nullable',

                'string',

                'max:100',

            ],



            'nama_pemilik_rekening' => [

                'nullable',

                'string',

                'max:255',

            ],



            'nomor_rekening' => [

                'nullable',

                'string',

                'max:100',

            ],



            'saldo_cuti' => [

                'nullable',

                'numeric',

                'min:0',

            ],



            'ukuran_baju' => [

                'nullable',

                'string',

                'max:20',

            ],



            'ukuran_sepatu' => [

                'nullable',

                'string',

                'max:20',

            ],



            'ktp_expiry_date' => [

                'nullable',

                'date',

            ],



            'contract_end_date' => [

                'nullable',

                'date',

            ],



            'sim_expiry_date' => [

                'nullable',

                'date',

            ],



            'certificate_expiry_date' => [

                'nullable',

                'date',

            ],



            /*

            |--------------------------------------------------------------------------

            | DOKUMEN BARU DARI MODAL EDIT

            |--------------------------------------------------------------------------

            */



            'new_documents' => [

                'nullable',

                'array',

            ],



            'new_documents.*.document_name' => [

                'required_with:new_documents.*.file',

                'nullable',

                'string',

                'max:255',

            ],



            'new_documents.*.document_number' => [

                'nullable',

                'string',

                'max:255',

            ],



            'new_documents.*.issue_date' => [

                'nullable',

                'date',

            ],



            'new_documents.*.expiry_date' => [

                'nullable',

                'date',

            ],



            'new_documents.*.notes' => [

                'nullable',

                'string',

            ],



            'new_documents.*.file' => [

                'nullable',

                'file',

                'mimes:pdf,jpg,jpeg,png,doc,docx',

                'max:10240',

            ],

        ]);





        /*

        |--------------------------------------------------------------------------

        | UPDATE FOTO

        |--------------------------------------------------------------------------

        */

        if ($request->hasFile('foto')) {



            if (

                $employee->foto_path &&

                Storage::exists($employee->foto_path)

            ) {

                Storage::delete($employee->foto_path);

            }



            $employee->foto_path = $request

                ->file('foto')

                ->store('employees/photos');

        }





        /*

        |--------------------------------------------------------------------------

        | UPDATE SCAN KTP

        |--------------------------------------------------------------------------

        */

        if ($request->hasFile('ktp_file')) {



            if (

                $employee->ktp_file_path &&

                Storage::exists($employee->ktp_file_path)

            ) {

                Storage::delete($employee->ktp_file_path);

            }



            $employee->ktp_file_path = $request

                ->file('ktp_file')

                ->store('employees/ktp');

        }





        /*

        |--------------------------------------------------------------------------

        | UPDATE DATA

        |--------------------------------------------------------------------------

        */



        $employee->nip =

            $validated['nip'];



        $employee->nik_internal =

            $validated['nik_internal'] ?? null;



        $employee->nama_lengkap =

            $validated['nama_lengkap'];



        $employee->jabatan =

            $validated['jabatan'] ?? null;



        $employee->rig =

            $validated['rig'] ?? null;



        $employee->tanggal_bergabung =

            $validated['tanggal_bergabung'] ?? null;



        /*

         * Kalau Edit tidak mengirim status,

         * status lama tidak berubah.

         */

        if (!empty($validated['status'])) {

            $employee->status =

                $validated['status'];

        }



        $employee->nama_ibu_kandung =

            $validated['nama_ibu_kandung'] ?? null;



        $employee->pendidikan_terakhir =

            $validated['pendidikan_terakhir'] ?? null;



        $employee->nama_sekolah =

            $validated['nama_sekolah'] ?? null;



        $employee->tahun_lulus =

            $validated['tahun_lulus'] ?? null;



        $employee->agama =

            $validated['agama'] ?? null;



        $employee->status_pernikahan =

            $validated['status_pernikahan'] ?? null;



        $employee->jumlah_anak =

            $validated['jumlah_anak'] ?? 0;



        $employee->tempat_lahir =

            $validated['tempat_lahir'] ?? null;



        $employee->tanggal_lahir =

            $validated['tanggal_lahir'] ?? null;



        $employee->nik_ktp =

            $validated['nik_ktp'] ?? null;



        $employee->alamat =

            $validated['alamat'] ?? null;



        $employee->no_telepon =

            $validated['no_telepon'] ?? null;



        $employee->email =

            $validated['email'] ?? null;



        $employee->no_kis =

            $validated['no_kis'] ?? null;



        $employee->no_kpj =

            $validated['no_kpj'] ?? null;



        $employee->npwp =

            $validated['npwp'] ?? null;



        $employee->nama_bank =

            $validated['nama_bank'] ?? null;



        $employee->nama_pemilik_rekening =

            $validated['nama_pemilik_rekening'] ?? null;



        $employee->nomor_rekening =

            $validated['nomor_rekening'] ?? null;



        $employee->saldo_cuti =

            $validated['saldo_cuti'] ?? 0;



        $employee->ukuran_baju =

            $validated['ukuran_baju'] ?? null;



        $employee->ukuran_sepatu =

            $validated['ukuran_sepatu'] ?? null;



        $employee->ktp_expiry_date =

            $validated['ktp_expiry_date'] ?? null;



        $employee->contract_end_date =

            $validated['contract_end_date'] ?? null;



        $employee->sim_expiry_date =

            $validated['sim_expiry_date'] ?? null;



        $employee->certificate_expiry_date =

            $validated['certificate_expiry_date'] ?? null;



        $employee->save();





        /*

        |--------------------------------------------------------------------------

        | TAMBAH DOKUMEN KARYAWAN

        |--------------------------------------------------------------------------

        */



        if ($request->has('new_documents')) {



            foreach (

                $request->input('new_documents', [])

                as $index => $documentData

            ) {



                $file = $request->file(

                    "new_documents.{$index}.file"

                );



                if (!$file) {

                    continue;

                }



                $documentName = trim(

                    $documentData['document_name'] ?? ''

                );



                if ($documentName === '') {

                    continue;

                }



                $path = $file->store(

                    'employees/documents/' . $employee->id

                );



                EmployeeDocument::create([

                    'employee_id' =>

                        $employee->id,



                    'document_name' =>

                        $documentName,



                    'document_number' =>

                        $documentData['document_number'] ?? null,



                    'issue_date' =>

                        $documentData['issue_date'] ?? null,



                    'expiry_date' =>

                        $documentData['expiry_date'] ?? null,



                    'file_name' =>

                        $file->getClientOriginalName(),



                    'file_path' =>

                        $path,



                    'notes' =>

                        $documentData['notes'] ?? null,

                ]);

            }

        }





        return redirect()

            ->route('employees.index')

            ->with(

                'success',

                'Data karyawan berhasil diperbarui.'

            );

    }





    /**

     * Hapus karyawan.

     */

    public function destroy(Employee $employee)

    {

        $employee->load('documents');





        /*

        |--------------------------------------------------------------------------

        | HAPUS FOTO

        |--------------------------------------------------------------------------

        */

        if (

            $employee->foto_path &&

            Storage::exists($employee->foto_path)

        ) {

            Storage::delete($employee->foto_path);

        }





        /*

        |--------------------------------------------------------------------------

        | HAPUS SCAN KTP

        |--------------------------------------------------------------------------

        */

        if (

            $employee->ktp_file_path &&

            Storage::exists($employee->ktp_file_path)

        ) {

            Storage::delete($employee->ktp_file_path);

        }





        /*

        |--------------------------------------------------------------------------

        | HAPUS FILE DOKUMEN

        |--------------------------------------------------------------------------

        */

        foreach ($employee->documents as $document) {



            if (

                $document->file_path &&

                Storage::exists($document->file_path)

            ) {

                Storage::delete($document->file_path);

            }

        }





        $employee->delete();





        return redirect()

            ->route('employees.index')

            ->with(

                'success',

                'Data karyawan berhasil dihapus.'

            );

    }





    /**

     * Menampilkan foto profil.

     */

    public function photo(Employee $employee)

    {

        abort_unless(

            $employee->foto_path &&

            Storage::exists($employee->foto_path),

            404

        );



        return response()->file(

            Storage::path($employee->foto_path)

        );

    }





    /**

     * Lihat dokumen.

     */

    public function viewDocument(

        EmployeeDocument $document

    ) {

        abort_unless(

            $document->file_path &&

            Storage::exists($document->file_path),

            404

        );



        return response()->file(

            Storage::path($document->file_path),

            [

                'Content-Disposition' =>

                    'inline; filename="' .

                    $document->file_name .

                    '"',

            ]

        );

    }





    /**

     * Download dokumen.

     */

    public function downloadDocument(

        EmployeeDocument $document

    ) {

        abort_unless(

            $document->file_path &&

            Storage::exists($document->file_path),

            404

        );



        return Storage::download(

            $document->file_path,

            $document->file_name

        );

    }





    /**

     * Update metadata / file dokumen.

     */

    public function updateDocument(

        Request $request,

        EmployeeDocument $document

    ) {

        $validated = $request->validate([

            'document_name' => [

                'required',

                'string',

                'max:255',

            ],



            'document_number' => [

                'nullable',

                'string',

                'max:255',

            ],



            'issue_date' => [

                'nullable',

                'date',

            ],



            'expiry_date' => [

                'nullable',

                'date',

            ],



            'notes' => [

                'nullable',

                'string',

            ],



            'file' => [

                'nullable',

                'file',

                'mimes:pdf,jpg,jpeg,png,doc,docx',

                'max:10240',

            ],

        ]);





        /*

        |--------------------------------------------------------------------------

        | GANTI FILE

        |--------------------------------------------------------------------------

        */

        if ($request->hasFile('file')) {



            if (

                $document->file_path &&

                Storage::exists($document->file_path)

            ) {

                Storage::delete($document->file_path);

            }



            $file = $request->file('file');



            $document->file_path = $file->store(

                'employees/documents/' .

                $document->employee_id

            );



            $document->file_name =

                $file->getClientOriginalName();

        }





        $document->document_name =

            $validated['document_name'];



        $document->document_number =

            $validated['document_number'] ?? null;



        $document->issue_date =

            $validated['issue_date'] ?? null;



        $document->expiry_date =

            $validated['expiry_date'] ?? null;



        $document->notes =

            $validated['notes'] ?? null;



        $document->save();





        return redirect()

            ->route('employees.index')

            ->with(

                'success',

                'Dokumen karyawan berhasil diperbarui.'

            );

    }





    /**

     * Hapus dokumen.

     */

    public function destroyDocument(

        EmployeeDocument $document

    ) {

        if (

            $document->file_path &&

            Storage::exists($document->file_path)

        ) {

            Storage::delete($document->file_path);

        }



        $document->delete();





        return redirect()

            ->route('employees.index')

            ->with(

                'success',

                'Dokumen karyawan berhasil dihapus.'

            );

    }

}