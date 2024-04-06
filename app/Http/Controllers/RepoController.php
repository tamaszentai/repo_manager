<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setup;
use App\Helpers\Helper;

class RepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::get()->first()->toArray();
        $token = $setup['token'];
        $response = Http::withToken($token, 'Bearer')->get('https://api.github.com/user/repos');
        if ($response->status() === 401) {

            $errorMessage = 'Access denied. Check the GitHub API token.';

            return view('repos.index', ['error' => $errorMessage, 'setup' => $setup]);
        }

        $links = Helper::getGithubReposUrls($response);

        return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup]);
    }

    public function next(Request $request)
    {
        $setup = Setup::get()->first()->toArray();
        $token = $setup['token'];
        $response = Http::withToken($token, 'Bearer')->get($request->url);
        $links = Helper::getGithubReposUrls($response);

        return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup]);
    }
}
