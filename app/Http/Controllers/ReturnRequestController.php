<?php

namespace App\Http\Controllers;

use App\Models\ReturnRequest;
use Illuminate\Http\Request;

class ReturnRequestController extends Controller
{
    /**
     * Simpan pengajuan return baru (publik — guest).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pesanan' => 'required|string|max:30',
            'nama_pembeli' => 'required|string|max:100',
            'whatsapp'     => 'required|string|max:20',
            'alasan'       => 'required|in:barang_rusak,barang_berbeda,barang_tidak_sesuai_deskripsi,lainnya',
            'deskripsi'    => 'required|string|max:2000',
            'info_rekening'=> 'nullable|string|max:255',
            'bukti_foto'   => 'nullable|image|max:5120',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $imageType = $file->getClientMimeType();
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
            $buktiPath = 'data:' . $imageType . ';base64,' . $imageData;
        }

        ReturnRequest::create([
            'kode_pesanan' => strtoupper($validated['kode_pesanan']),
            'nama_pembeli' => $validated['nama_pembeli'],
            'whatsapp'     => $validated['whatsapp'],
            'alasan'       => $validated['alasan'],
            'deskripsi'    => $validated['deskripsi'],
            'info_rekening'=> $validated['info_rekening'] ?? null,
            'bukti_foto'   => $buktiPath,
            'status'       => 'pending',
        ]);

        return back()->with('return_success', 'Pengajuan return Anda telah berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp dalam 1×24 jam.');
    }

    /**
     * Cek status pengajuan return berdasarkan kode pesanan (AJAX).
     */
    public function status(Request $request)
    {
        $kode = strtoupper(trim($request->input('kode_pesanan', '')));
        if (!$kode) {
            return response()->json(['found' => false]);
        }

        $returnReq = ReturnRequest::where('kode_pesanan', $kode)->latest()->first();
        if (!$returnReq) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found'         => true,
            'kode_pesanan'  => $returnReq->kode_pesanan,
            'nama_pembeli'  => $returnReq->nama_pembeli,
            'alasan_label'  => $returnReq->alasan_label,
            'status'        => $returnReq->status,
            'status_label'  => $returnReq->status_label,
            'catatan_admin' => $returnReq->catatan_admin,
            'created_at'    => $returnReq->created_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * Admin: list semua return requests.
     */
    public function adminIndex()
    {
        $returns = ReturnRequest::latest()->get();
        return view('admin.returns', compact('returns'));
    }

    /**
     * Admin: update status return request.
     */
    public function adminUpdate(Request $request, $id)
    {
        $returnReq = ReturnRequest::findOrFail($id);
        $validated = $request->validate([
            'status'        => 'required|in:pending,diproses,disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);
        $returnReq->update($validated);

        return back()->with('success', 'Status return berhasil diperbarui.');
    }

    /**
     * Admin: hapus return request.
     */
    public function destroy($id)
    {
        $returnReq = ReturnRequest::findOrFail($id);
        $returnReq->delete();

        return back()->with('success', 'Pengajuan return berhasil dihapus.');
    }
}
