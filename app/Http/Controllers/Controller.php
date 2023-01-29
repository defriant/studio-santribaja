<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function random($type, $length)
    {
        $result = "";
        if ($type == 'char') {
            $char = 'ABCDEFGHJKLMNPRTUVWXYZ';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'num') {
            $char = '0123456789';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'mix') {
            $char = 'aA1bB1cC2dD2eE3fF3gG4hH4iI5jJ5kK6lL6mM7nN7oO8pP8qQ9rR9sS0tT0uU1vV2wW3xX4yY5zZ';
            $max = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        }
    }

    function multiArrSearch($val, $arr)
    {
        foreach ($arr as $arrKey => $arrVal) {
            $cek = array_search($val, $arrVal);
            if ($cek) {
                return true;
            } else {
                return false;
            }
        }
    }

    function upload_image($file, $path, $imgFor)
    {
        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        $replace = substr($file, 0, strpos($file, ',') + 1);
        $image = str_replace($replace, '', $file);
        $image = str_replace(' ', '+', $image);
        $imageName = $imgFor . '-' . time() . '-' . $this->random('mix', 5) . '.' . $extension;

        $path = public_path() . $path . $imageName;
        File::put($path, base64_decode($image));

        return $imageName;
    }


    function upload_file($file, $path, $filename)
    {
        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        $replace = substr($file, 0, strpos($file, ',') + 1);
        $image = str_replace($replace, '', $file);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '-' . $filename . '.' . $extension;

        $path = public_path() . $path . $imageName;
        File::put($path, base64_decode($image));

        return $imageName;
    }

    function upload_logo($file, $path, $filename)
    {
        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        $replace = substr($file, 0, strpos($file, ',') + 1);
        $image = str_replace($replace, '', $file);
        $image = str_replace(' ', '+', $image);
        $imageName = 'logo.' . $extension;

        $path = public_path() . $path . $imageName;
        File::put($path, base64_decode($image));

        return $imageName;
    }

    function delete_file($filename, $path)
    {
        $file = public_path() . $path . $filename;
        unlink($file);
        return;
    }

    function createDateRange($strDateFrom, $strDateTo)
    {
        $aryRange = [];

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }
}
