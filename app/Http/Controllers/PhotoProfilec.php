<?php

namespace App\Http\Controllers;

use App\Models\PhotoProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoProfilec extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function read(Request $request)
    {
        $request->validate([
            'user_token' => 'nullable|string',
        ]);
        $query = PhotoProfile::query();
        if ($request->has('user_token') && $request->user_token) {
            $query->where('user_token', $request->user_token);
            $data = $query->first();
        }
        else{
            $data = $query->get();
        }

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Photo Profile Gagal Didapatkan',
                'data' => null
            ]);
        }
        if(empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Photo Profile Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'message' => 'Photo Profile Berhasil Didapatkan',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $data = new PhotoProfile();
        $data->user_token = $request->user_token;
        $data->photo = $request->photo;
        $data->save();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Photo Profil Gagal Disimpan',
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'Photo Profil Berhasil Disimpan',
            'data' => $data
        ], 200);
    }

    public function delete(Request $request)
    {
        $rules = [
            'user_token' => 'required|string'
        ];
        $validators = Validator::make($request->all(), $rules);
        if($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter user_token harus diisi',
                'data' => $validators->errors()
            ], 422);
        }
        $data = PhotoProfile::where('user_token', $request->user_token)->first();
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => "user_token $request->user_token Tidak Ditemukan",
                'data' => null
            ], 422);
        }
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus Photo Profil Berhasil',
            'data' => $data
        ], 200);
    }
}
