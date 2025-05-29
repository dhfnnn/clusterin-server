<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function read(Request $request)
    {
        $request->validate([
            'id' => 'nullable|string',
            'status' => 'nullable|in:Masuk,Keluar',
            'gets' => 'nullable|integer'
        ]);

        $query = Guest::query();
        if ($request->has('id') && $request->id) {
            $query->where('id', $request->id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('gets') && $request->gets) {
            $data = $query->OrderBy('id', 'desc')->first();
        }
        else{
            $data = $query->OrderBy('id', 'desc')->get();
        }
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu Gagal Didapatkan',
                'data' => null
            ]);
        }
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak Ada Tamu yang Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tamu Berhasil Didapatkan',
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $rule = [
            'nik' => 'required|string',
            'fullname' => 'required|string',
            'address' => 'required|string',
            'destination' => 'required|string',
            'reason' => 'required|string',
            'checkin' => 'required|string',
            'checkout' => 'nullable|string',
            'whatsapp' => 'required|string',
            'status' => 'required|in:Masuk,Keluar'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = new Guest();
        $data->nik = $request->nik;
        $data->fullname = $request->fullname;
        $data->address = $request->address;
        $data->destination = $request->destination;
        $data->reason = $request->reason;
        $data->checkin = $request->checkin;
        $data->checkout = $request->checkout;
        $data->whatsapp = $request->whatsapp;
        $data->status = $request->status;
        $data->save();

        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => "Tamu $request->fullname, Gagal Ditambahkan",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => "Tamu $request->fullname, Berhasil Ditambahkan",
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
            'checkout' => 'required|string',
            'status' => 'required|in:Masuk,Keluar'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = Guest::where('id', $request->id)->first();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu Tidak Ditemukan',
                'data' => null
            ], 422);
        }
        $data->checkout = $request->checkout;
        $data->status = $request->status;
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Tamu Berhasil Diubah',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
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
        $data = Guest::where('id', $request->id)->first();
        if(empty($data)) {
            return response()->json([
                'success' => false,
                'message' => "Tamu $request->id, Tidak Ditemukan",
                'data' => null
            ], 422);
        }
        
        $data->delete();

        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => "Tamu $request->id, Gagal Dihapus",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => "Tamu $request->id, Berhasil Dihapus",
            'data' => $data
        ], 200);
    }
}
