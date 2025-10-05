<?php

declare(strict_types=1);

namespace App\Helper;

final class ArrayHelper
{
    public static function encodeArrayData(array $items)
    {
        return array_map(fn($arr) => array_map(
            fn($arr1) => htmlentities(null !== $arr1 ? (string)$arr1 : '', ENT_QUOTES)
            , $arr),
            $items);
    }
}
