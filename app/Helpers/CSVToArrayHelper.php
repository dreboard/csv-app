<?php

namespace App\Helpers;

abstract class CSVToArrayHelper
{

    public static function stringData($string){
        $string = trim($string);
        return ucfirst(strtolower($string));

    }

    public static function csvToArray($path): array
    {
        $assoc_array = [];
        if (($handle = fopen($path, "r")) !== false) {                 // open for reading
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {         // extract header data
                $keys = $data;                                             // save as keys
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {      // loop remaining rows of data
                $assoc_array[] = array_combine($keys, array_map('self::stringData', $data ));              // push associative subarrays
            }
            fclose($handle);                                               // close when done
        }
        return $assoc_array;
    }

}
