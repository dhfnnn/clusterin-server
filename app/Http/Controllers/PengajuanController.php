<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function read(Request $request)
    {
        $request->validate([
            'user_token' => 'nullable|string',
            'kategori' => 'nullable|in:Pengaduan,Permohonan',
            'status' => 'nullable|in:Menunggu,Dilihat,Disetujui,Ditolak'
        ]);

        $query = Pengajuan::query();
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->has('user_token') && $request->user_token) {
            $query->where('user_token', $request->user_token);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->get();
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan Gagal Didapatkan',
                'data' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pengajuan Berhasil Didapatkan',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $rule = [
            'user_token' => 'required|string',
            'kategori' => 'required|in:Pengaduan,Permohonan',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|string',
            'reply' => 'nullable|string',
            'status' => 'required|in:Menunggu,Dilihat,Disetujui,Ditolak'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = new Pengajuan();
        $data->user_token = $request->user_token;
        $data->kategori = $request->kategori;
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        $data->file = $request->file;
        $data->reply = $request->reply;
        $data->status = $request->status;
        $data->save();
        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => "Pengajuan $request->judul, Gagal Ditambahkan",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => "Pengajuan $request->judul, Berhasil Ditambahkan",
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|string'
        ];
        $validators = Validator::make($request->all(), $rules);
        if($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter id harus diisi',
                'data' => $validators->errors()
            ], 422);
        }

        $rule = [
            'kategori' => 'required|in:Pengaduan,Permohonan',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|string',
            'reply' => 'required|string',
            'status' => 'required|in:Menunggu,Dilihat,Disetujui,Ditolak'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = Pengajuan::where('id', $request->id)->firstOrFail();
        $data->kategori = $request->kategori;
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        $data->file = $request->file;
        $data->reply = $request->reply;
        $data->status = $request->status;
        $data->save();
        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => "Pengajuan $request->judul, Gagal Diubah",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => "Pengajuan $request->judul, Berhasil Diubah",
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $data = Pengajuan::where('id', $request->id)->first();
        if(empty($data)) {
            return response()->json([
                'success' => false,
                'message' => "Pengajuan $request->judul, Tidak Ditemukan",
                'data' => null
            ], 422);
        }
        
        $data->delete();

        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => "Pengajuan $request->judul, Gagal Dihapus",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => "Pengajuan $request->judul, Berhasil Dihapus",
            'data' => $data
        ], 200);
    }
}
