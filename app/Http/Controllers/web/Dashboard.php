<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function read(Request $request)
    {
        $accounts = Account::latest()->get();
        $permohonan = Pengajuan::where('kategori', 'Permohonan')->orderBy('id', 'desc')->first();
        $pengaduan = Pengajuan::where('kategori', 'Pengaduan')->orderBy('id', 'desc')->first();

        if ($request->wantsJson()) {
            // Jika request dari fetch/ajax, kirim JSON
            return response()->json(compact('accounts', 'permohonan', 'pengaduan'));
        }

        // Jika akses langsung browser, tampilkan blade
        return view('dashboard', compact('accounts', 'permohonan', 'pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        //
    }
}
