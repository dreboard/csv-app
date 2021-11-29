<?php

namespace App\Helpers;

/**
 *
 */
class ContactArrayHelper
{

    private array $start_array;


    /**
     * @param array $start_array
     */
    public function __construct(array $start_array)
    {
        $this->start_array = $start_array;
    }


    /**
     * Format all string data
     *
     * @param $string
     * @return string
     */
    public static function stringData($string){
        $string = trim($string);
        return ucfirst(strtolower($string));

    }

    /**
     * Convert CSV path to an array
     *
     * @param $path
     * @return array
     */
    public static function csvToArray($path): array
    {
        $assoc_array = [];
        if (($handle = fopen($path, "r")) !== false) {
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {         // extract header data
                $keys = $data;
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $assoc_array[] = array_combine($keys, array_map('self::stringData', $data ));
            }
            fclose($handle);
        }
        return $assoc_array;
    }

    /**
     * Check empty array values and unset key
     *
     * @param array $array
     * @return array
     */
    private function checkEmptyValues(array $array): array
    {
        foreach($array as $key => $val) {
            if($val['first_name'] === '' || $val['last_name'] === '' || $val['email'] === '' || $val['phone'] === ''){
                unset($array[$key]);
            }
        }
        return $this->validEmail($array);
    }

    /**
     * Perform email string validation
     *
     * @param array $array
     * @return array
     */
    private function validEmail(array $array): array
    {
        foreach($array as $key => $val) {
            if(!filter_var($val['email'], FILTER_VALIDATE_EMAIL) ){
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Perform US phone number validation
     *
     * @param array $array
     * @return array
     */
    private function validPhone(array $array): array
    {
        foreach($array as $key => $val) {
            if(!preg_match('/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/m', $val['phone'] )){
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Extract duplicates from assoc array
     *
     * @param $array
     * @param $key
     * @return array
     */
    private function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

}
