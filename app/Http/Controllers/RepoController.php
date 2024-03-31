<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setup;

class RepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::get()->first()->toArray();
        $token = $setup['token'];
        $repos = Http::withToken($token, 'Bearer')->get('https://api.github.com/user/repos');
        if ($repos->status() === 401) {

            $errorMessage = 'Access denied. Check the GitHub API token.';

            return view('repos.index', ['error' => $errorMessage, 'setup' => $setup['id']]);
        }

        return view('repos.index', ['repos' => $repos->json(), 'setup' => $setup['id']]);
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

    /**
     * Clone the specified repository if doesn't exist in directory.
     */
    public function clone(string $id)
    {
    }
}
