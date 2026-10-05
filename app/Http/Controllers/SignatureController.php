<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    // Halaman daftar tanda tangan
    public function index()
    {
        $signatures = Signature::orderBy('name', 'asc')->get();

        return view('signatures.index', compact('signatures'));
    }

    // Simpan tanda tangan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'signature' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $path = $request->file('signature')->store(
            'signatures',
            'local'
        );

        Signature::create([
            'name' => $request->name,
            'position' => $request->position,
            'file_path' => $path,
        ]);

        return redirect()
            ->route('signatures.index')
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }

    // Menampilkan gambar tanda tangan
    public function image(Signature $signature)
    {
        if (!Storage::disk('local')->exists($signature->file_path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('local')->path($signature->file_path)
        );
    }

    // Hapus tanda tangan
    public function destroy(Signature $signature)
    {
        if (Storage::disk('local')->exists($signature->file_path)) {
            Storage::disk('local')->delete($signature->file_path);
        }

        $signature->delete();

        return redirect()
            ->route('signatures.index')
            ->with('success', 'Tanda tangan berhasil dihapus.');
    }
}