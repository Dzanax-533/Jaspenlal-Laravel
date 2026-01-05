<?php

namespace App\Http\Controllers\Klien;
use App\Http\Controllers\Controller;
use App\Models\DokumenPersyaratan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Fitur: Unggah Dokumen oleh Klien
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftarans,id',
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|mimes:pdf,jpg,png,jpeg|max:2048', // Batas 2MB
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');

            // Nama file unik: ID_Pendaftaran_Timestamp_NamaAsli
            $filename = $request->id_pendaftaran . '_' . time() . '_' . $file->getClientOriginalName();

            // Simpan ke folder 'uploads/dokumen' di disk public
            $path = $file->storeAs('uploads/dokumen', $filename, 'public');

            DokumenPersyaratan::create([
                'id_pendaftaran' => $request->id_pendaftaran,
                'nama_dokumen'   => $request->nama_dokumen,
                'jenis_dokumen'  => 'Persyaratan Umum',
                'file_path'      => $path,
                'status_validasi'=> 'pending',
                'tanggal_upload' => now(),
            ]);

            return back()->with('success', 'Dokumen "' . $request->nama_dokumen . '" berhasil diunggah!');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Fitur: Verifikasi Dokumen oleh Konsultan/Admin
     * Catatan: Fungsi ini nantinya bisa dipindah ke KonsultanController jika ingin lebih spesifik
     */
    public function verifikasi(Request $request)
    {
        $request->validate([
            'id_dokumen' => 'required|exists:dokumen_persyaratans,id',
            'status' => 'required|in:valid,perbaikan', // Gunakan enum yang konsisten
            'catatan' => 'nullable|string'
        ]);

        $doc = DokumenPersyaratan::findOrFail($request->id_dokumen);

        $doc->update([
            'status_validasi' => $request->status,
            'catatan_validasi' => $request->catatan,
            'validated_by' => auth()->id(),
            'tanggal_validasi' => now(),
        ]);

        return back()->with('success', 'Status dokumen "' . $doc->nama_dokumen . '" berhasil diperbarui!');
    }

    public function reupload(Request $request, $id)
    {
        $request->validate([
            'file_dokumen' => 'required|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $doc = DokumenPersyaratan::findOrFail($id);

        if ($request->hasFile('file_dokumen')) {
            // 1. Hapus file lama dari storage agar tidak memenuhi server
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }

            // 2. Simpan file baru
            $file = $request->file('file_dokumen');
            $filename = $doc->id_pendaftaran . '_rev_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/dokumen', $filename, 'public');

            // 3. Update data dan kembalikan status ke PENDING
            $doc->update([
                'file_path' => $path,
                'status_validasi' => 'pending', // Otomatis jadi pending lagi
                'tanggal_upload' => now(),
                'catatan_validasi' => null, // Hapus catatan lama karena sudah diperbaiki
            ]);

            return back()->with('success', 'Dokumen berhasil diperbarui. Menunggu validasi ulang dari konsultan.');
        }

        return back()->with('error', 'Gagal memperbarui dokumen.');
    }
}
