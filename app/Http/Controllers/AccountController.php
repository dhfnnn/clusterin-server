<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\String\b;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function read(Request $request)
    {
        $request->validate([
            'user_token' => 'nullable|string',
            'kepala_keluarga' => 'nullable|string',
            'nik' => 'nullable|string',
        ]);

        $query = Account::query();
        if ($request->has('user_token') && $request->user_token) {
            $query->where('user_token', $request->user_token);
            $data = $query->first();
        }
        if ($request->has('kepala_keluarga') && $request->kepala_keluarga) {
            $query->where('kepala_keluarga', $request->kepala_keluarga);
            $data = $query->get();
        }
        if ($request->has('nik') && $request->nik) {
            $query->where('nik', $request->nik);
            $data = $query->first();
        }
        else{
            $data = $query->get();
        }
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Account Gagal Didapatkan',
                'data' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'message' => 'Account Berhasil Didapatkan',
            'data' => $data
        ]);
    }

    public function signin(Request $request)
    {
        $rule = [
            'nik' => 'required|string',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rule);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 401);
        }
        $getPass = Account::where('nik', $request->nik)->first();
        $data = Account::where('nik', $request->nik)->where('password', Hash::check($request->password, $getPass->password))->first();
        if (!$data){
            return response()->json([
                'success' => false,
                'message' => 'Account Tidak Terdaftar, Cek kembali data anda'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => "Account Berhasil Login",
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $rule = [
            'fullname' => 'required|string|max:50',
            'address' => 'required|string|max:200',
            'whatsapp' => 'required|string|unique:account,whatsapp',
            'nik' => 'required|string|unique:account,nik',
            'password' => 'required',
            'role' => 'required|in:RT,Satpam,Warga',
            'kepala_keluarga' => 'nullable|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'status_account' => 'required|in:Pending,Active,Inactive'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = new Account();
        $data->fullname = $request->fullname;
        $data->address = $request->address;
        $data->whatsapp = $request->whatsapp;
        $data->kepala_keluarga = $request->kepala_keluarga;
        $data->nik = $request->nik;
        $data->password = Hash::make($request->password);
        $data->role = $request->role;
        $data->gender = $request->gender;
        $data->status_account = $request->status_account;
        $data->save();

        if ($data->role == 'RT') {
            $ability = ['RT'];
        } elseif ($data->role == 'Satpam') {
            $ability = ['Satpam'];
        } else {
            $ability = ['Warga'];
        }
        
        $token = $data->createToken('token-based', $ability)->plainTextToken;
        $data->user_token = $token;
        $data->save();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal',
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran Berhasil',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function forgot(Request $request){
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
        $account = Account::where('user_token', $request->user_token)->first();
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account Tidak Ditemukan',
                'data' => null
            ], 422);
        }
        $rule = [
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }
        $data = Account::where('user_token', $request->user_token)->firstOrFail();
        $data->password = $request->password;
        $data->save();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => "Update Account $request->nik Gagal",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'Update Account Berhasil',
            'data' => $data
        ], 200);
    }
    public function update(Request $request)
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
        $account = Account::where('user_token', $request->user_token)->first();
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account Tidak Ditemukan',
                'data' => null
            ], 422);
        }


        $rule = [
            'fullname' => 'required|string|max:50',
            'address' => 'required|string|max:200',
            'nik' => 'required|string',
            'whatsapp' => 'required|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'role' => 'required|in:RT,Satpam,Warga',
            'status_account' => 'required|in:Pending,Active,Inactive'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan Parameter',
                'data' => $validator->errors()
            ], 422);
        }

        $data = Account::where('user_token', $request->user_token)->firstOrFail();
        $data->fullname = $request->fullname;
        $data->address = $request->address;
        $data->whatsapp = $request->whatsapp;
        $data->nik = $request->nik;
        $data->role = $request->role;
        $data->gender = $request->gender;
        $data->status_account = $request->status_account;
        $data->save();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => "Update Account $request->nik Gagal",
                'data' => null
            ], 422);
        }
        return response()->json([
            'success' => true,
            'message' => 'Update Account Berhasil',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
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
        $data = Account::where('user_token', $request->user_token)->first();
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
            'message' => 'Hapus Account Berhasil',
            'data' => $data
        ], 200);
    }
}
