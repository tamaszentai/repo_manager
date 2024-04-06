<?php

namespace App\Helpers;

class Helper
{

    public static function delete_directory($dir)
    {
        $files = scandir($dir);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $dir . "/" . $file;
                if (is_dir($filePath)) {
                    Helper::delete_directory($filePath);
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
    public static function getGithubReposUrls($response)
    {
        // <https://api.github.com/user/repos?page=2>; rel="next", <https://api.github.com/user/repos?page=5>; rel="last"

        $links = $response->header('Link');
        $links = explode(',', $links);
        $links = array_map('trim', $links);

        $links = array_reduce($links, function ($acc, $link) {
            preg_match('/<(.*)>; rel="(.*)"/', $link, $matches);
            $acc[$matches[2]] = $matches[1];
            return $acc;
        }, []);

        return $links;
    }
}
