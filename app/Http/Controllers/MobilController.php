<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobilController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peminjaman-mobil.data-pinjam.data-mobil.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peminjaman-mobil.data-pinjam.data-mobil.create');
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
    public function show(string $id)
    {
        return view('peminjaman-mobil.data-pinjam.data-mobil.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
