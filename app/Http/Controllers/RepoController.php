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
        $isFirstPage = true;
        $response = Http::withToken($token, 'Bearer')->get('https://api.github.com/user/repos');
        if ($response->status() === 401) {

            $errorMessage = 'Access denied. Check the GitHub API token.';

            return view('repos.index', ['error' => $errorMessage, 'setup' => $setup]);
        }

        $links = Helper::getGithubReposUrls($response);

        return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup, 'isFirstPage' => $isFirstPage]);
    }

    // Github API doesn't support searching for repositories for a user. In Repo manager 2 I will implement this feature client side search using Vue.js.
    // public function search(Request $request)
    // {
    //     $validated = $request->validate([
    //         'search' => 'required'
    //     ]);
    //     $setup = Setup::get()->first()->toArray();
    //     $token = $setup['token'];
    //     $isFirstPage = true;
    //     $search = $validated['search'];
    //     $response = Http::withToken($token, 'Bearer')->get('https://api.github.com/user/repos?q=' . $search);
    //     dd($response->json());
    //     $links = Helper::getGithubReposUrls($response);


    //     return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup, 'isFirstPage' => $isFirstPage]);
    // }

    public function previous(Request $request)
    {
        $setup = Setup::get()->first()->toArray();
        $token = $setup['token'];
        $isFirstPage = false;
        $url = $request->url;
        $url = explode('page=', $url);
        $pageNumber = (int)$url[1] - 2;
        $url = $url[0] . 'page=' . $pageNumber;
        if ($pageNumber <= 1) {
            return redirect()->route('repos.index');
        }
        $response = Http::withToken($token, 'Bearer')->get($url);
        $links = Helper::getGithubReposUrls($response);

        return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup, 'isFirstPage' => $isFirstPage]);
    }

    public function next(Request $request)
    {
        $setup = Setup::get()->first()->toArray();
        $token = $setup['token'];
        $isFirstPage = false;
        $url = $request->url;
        $url = explode('page=', $url);
        $response = Http::withToken($token, 'Bearer')->get($request->url);
        $links = Helper::getGithubReposUrls($response);

        return view('repos.index', ['repos' => $response->json(), 'links' => $links, 'setup' => $setup, 'isFirstPage' => $isFirstPage]);
    }
}
