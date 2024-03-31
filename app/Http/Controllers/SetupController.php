<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setup;
use Hamcrest\Core\Set;
use Illuminate\Support\Facades\Log;

class SetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setup.index');
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

        $validated = $request->validate([
            'token' => 'required',
            'directory_path' => 'required',
        ]);

        $token = $validated['token'];
        $directoryPath = $validated['directory_path'];

        Setup::create([
            'token' => $token,
            'directory_path' => $directoryPath,
        ]);

        return redirect('/repos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('setup.edit', ['setup' => Setup::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'token' => 'required',
            'directory_path' => 'required',
        ]);

        $token = $validated['token'];
        $directoryPath = $validated['directory_path'];

        Setup::find($id)->update([
            'token' => $token,
            'directory_path' => $directoryPath,
        ]);

        return redirect('/repos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
