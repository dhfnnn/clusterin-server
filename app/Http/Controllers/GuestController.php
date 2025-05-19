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
            'status' => 'nullable|in:Masuk,Keluar'
        ]);

        $query = Guest::query();
        if ($request->has('id') && $request->id) {
            $query->where('id', $request->id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->get();
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu Gagal Didapatkan',
                'data' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tamu Berhasil Didapatkan',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $rule = [
            'fullname' => 'required|string',
            'destination_address' => 'required|string',
            'reason' => 'required|string',
            'checkin_date' => 'nullable|string',
            'checkout_date' => 'nullable|string',
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
        $data->fullname = $request->fullname;
        $data->destination_address = $request->destination_address;
        $data->reason = $request->reason;
        $data->checkin_date = $request->checkin_date;
        $data->checkout_date = $request->checkout_date;
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
