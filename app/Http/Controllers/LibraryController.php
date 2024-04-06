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
        $validated = $request->validate([
            'library_name' => 'required',
            'clone_url' => 'required',
        ]);

        $libraryName = $validated['library_name'];
        $cloneUrl = $validated['clone_url'];
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];



        if (!file_exists($directoryPath . $libraryName)) {
            exec("git clone {$cloneUrl} {$directoryPath}{$libraryName}");
        } else {

            Log::info('Directory already exists');
        }
        return redirect()->route('repos.index');
    }

    public function deleteRepo(Request $request)
    {
        $validated = $request->validate([
            'library_name' => 'required',
        ]);
        $libraryName = $validated['library_name'];
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];

        delete_directory($directoryPath . $libraryName);

        return redirect()->route('repos.index');
    }

    public function installDependencies(Request $request)
    {
        $libraryName = $request->input('library_name');
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];
        $language = $request->input('language');

        switch (strtolower($language)) {
            case 'php':
                exec("cd {$directoryPath}{$libraryName} && composer install");
                break;
            case 'javascript':
                exec("cd {$directoryPath}{$libraryName} && npm install");
                break;
            case 'node':
                exec("cd {$directoryPath}{$libraryName} && npm install");
                break;
            case 'vue':
                exec("cd {$directoryPath}{$libraryName} && npm install");
                break;
            default:
                break;
        }
        return redirect()->route('repos.index');
    }

    public function removeDependencies(Request $request)
    {
        $validated = $request->validate([
            'library_name' => 'required',
            'language' => 'required',
        ]);

        $libraryName = $validated['library_name'];
        $language = $validated['language'];
        $directoryPath = Setup::get()->first()->toArray()['directory_path'];

        switch (strtolower($language)) {
            case 'typescript':
                exec("cd {$directoryPath}{$libraryName} && rm -rf node_modules");
                break;
            case 'javascript':
                exec("cd {$directoryPath}{$libraryName} && rm -rf node_modules");
                break;
            case 'node':
                exec("cd {$directoryPath}{$libraryName} && rm -rf node_modules");
                break;
            case 'vue':
                exec("cd {$directoryPath}{$libraryName} && rm -rf node_modules");
                break;
            default:
                break;
        }
        return redirect()->route('repos.index');
    }
}

function delete_directory($dir)
{
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $filePath = $dir . "/" . $file;
            if (is_dir($filePath)) {
                delete_directory($filePath);
            } else {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (in_array($extension, ["git", "idx", "pack"])) {
                    chmod($filePath, 0644);
                }
                unlink($filePath);
            }
        }
    }

    rmdir($dir);
}
