<?php

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

function getGithubReposUrls($response)
{
    $links = $response->headers()['Link'];
    $links = explode("\n", $links);

    // A next és last linkek tárolására
    $nextUrl = null;
    $lastUrl = null;

    // A linkek kinyerése
    foreach ($response as $line) {
        // A next link kinyerése
        if (preg_match('/rel="next".+?<https:\/\/api.github.com\/user\/repos\?page=(\d+)>/i', $line, $matches)) {
            $nextUrl = "https://api.github.com/user/repos?page={$matches[1]}";
        }

        // A last link kinyerése
        if (preg_match('/rel="last".+?<https:\/\/api.github.com\/user\/repos\?page=(\d+)>/i', $line, $matches)) {
            $lastUrl = "https://api.github.com/user/repos?page={$matches[1]}";
        }
    }

    // Visszatérünk a next és last linkekkel
    return [
        'next' => $nextUrl,
        'last' => $lastUrl,
    ];
}
