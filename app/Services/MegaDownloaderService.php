<?php
namespace App\Services;

use Exception;

/**
 * Class MegaDownloaderService
 * @package App\Services
 */
class MegaDownloaderService
{
    /**
     * Url builder
     * @param $url
     * @return string
     */
    public function buildUrl($url){
        $base = "https://mega.nz/#!";
        $p = explode('#', $url);
        $n = collect(explode('/', $p[0]))->last();
        $newUrl = $base . $n ."!". $p[1];
        return $newUrl;
    }

    /**
     * Validate url format
     * @param $url
     * @return string
     * @throws Exception
     */
    public function validateUrl($url){
        // url from mega.nz
        $valid = strpos(strtolower($url), 'https://mega.nz');
        if ($valid === false) {
            throw new Exception("The mega url is invalid, the url must contains https://mega.nz");
        }

        // Url contains /file
        $valid = strpos(strtolower($url), '/file');
        if ($valid) {
            $url = self::buildUrl($url);
        }

        // Url contains /file
        $valid = strpos($url, '#F!');
        if ($valid) {
            throw new Exception("The mega url is invalid, the url must be a final link to download \nexample: https://mega.nz/#!9gJkgCwR!H6ZUW6BFhfMBlncMzti46pXF_WHA9fBrWp1uhZqdkpY", 500);
        }

        // Url contains /folder
        $valid = strpos(strtolower($url), '/folder');
        if ($valid) {
            throw new Exception("The mega url is invalid, the url must havent /file or /folder");
        }

        return $url;
    }

    /**
     * Download file
     * @param $url
     * @return string
     */
    public function download($url) {
        // Validate url
        $url = self::validateUrl($url);

        // initial var
        $output = null;
        $isError = null;

        // command
        $command = "megadl '" . $url ."' --path " . public_path('storage/');

        // Download file
        $path = exec($command, $output, $isError);

        if ($isError || !isset($output[0])) {
            throw new Exception("An error has been occurred fetching file. ", 509);
        }

        // get filename
        $filename = trim(collect(explode('loaded ', $output[0]))->last());

        // get full path
        $path = public_path('storage/') . $filename;

        // return path
        return $path;
    }

}
