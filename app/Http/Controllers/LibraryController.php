<?php

namespace App\Http\Controllers;

use App\Console\Commands\CloneRepository;
use App\Models\Setup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LibraryController extends Controller
{
    public function cloneRepo(Request $request)
    {
        $libraryName = $request->input('library_name');
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];
        $cloneUrl = $request->input('clone_url');


        if (!file_exists($directoryPath . $libraryName)) {
            exec("git clone {$cloneUrl} {$directoryPath}{$libraryName}");
        } else {

            Log::info('Directory already exists');
        }
        return redirect()->route('repos.index');
    }

    public function deleteRepo(Request $request)
    {
        $libraryName = $request->input('library_name');
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];
        $cloneUrl = $request->input('clone_url');


        if (!file_exists($directoryPath . $libraryName)) {
            exec("git clone {$cloneUrl} {$directoryPath}{$libraryName}");
        } else {

            Log::info('Directory already exists');
        }
        return redirect()->route('repos.index');
    }
}
