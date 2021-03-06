<?php

namespace AloiaCms;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use AloiaCms\Collections\MediaCollection;

class Media
{

    /**
     * Get all files in the article images folder
     *
     * @return MediaCollection
     */
    public function allFiles(): MediaCollection
    {
        $image_path = $this->getImagesPath();

        $this->createImagesPathIfNotExisting($image_path);

        return new MediaCollection(
            File::allFiles($image_path)
        );
    }

    /**
     * Get the images path
     *
     * @return string
     */
    public static function getImagesPath(): string
    {
        return Config::get('aloiacms.articles.image_path');
    }

    /**
     * Convert a filename to a file title
     *
     * @param string $filename
     * @return string
     */
    public static function filenameToTitle(string $filename): string
    {
        $filename = basename($filename);

        $filename_without_extension = pathinfo($filename)['filename'];

        $title = str_replace(["_", "-"], " ", $filename_without_extension);

        return ucfirst($title);
    }

    /**
     * Convert a file title to a filename
     *
     * @param string $title
     * @return string
     */
    public static function titleToFilename(string $title): string
    {
        $filename_without_spaces = str_replace([" "], "-", $title);

        $filename = strtolower($filename_without_spaces);

        return $filename;
    }


    /**
     * Create the image path if it doesn't exist
     *
     * @param string $image_path
     */
    private function createImagesPathIfNotExisting(string $image_path)
    {
        if (! file_exists($image_path)) {
            mkdir($image_path);
        }
    }
}
