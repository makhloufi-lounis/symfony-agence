<?php


namespace App\Entity;
use Cocur\Slugify\Slugify;

class Tools
{

    /**
     * @param int $price
     * @return string
     */
    public static function getFormattedNumber(int $price): string
    {
        return number_format($price, 0, '', ' ');
    }

    /**
     * @param string $title
     * @return string
     */
    public static function getSlug(string $title): string
    {
        $slugify = new Slugify();
        return $slugify->slugify($title);
    }
}