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

    /**
     * @param $str
     * @param string $charset
     * @return string|string[]|null
     */
    public static function skipAccents( $str, $charset='utf-8' ) {

        $str = htmlentities( $str, ENT_NOQUOTES, $charset );

        $str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
        $str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
        $str = preg_replace( '#&[^;]+;#', '', $str );

        return $str;
    }
}