<?php

namespace App\Helpers;

class Helper
{
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
