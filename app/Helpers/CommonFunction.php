<?php

namespace App\Helpers;

use DateTime;
use DatePeriod;
use DateInterval;
use Image;

// Model
use App\Models\ErrorLogs;

class CommonFunction {

    public function __construct() {
        
    }

    public static function createSlug($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function getNameInitials($name) {
        $name_array = explode(' ',$name);

        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array)-1];

        return mb_substr($firstWord[0],0,1)."".mb_substr($lastWord[0],0,1);
    }

    public static function getFirstWordInitial($name) {
        $name_array = explode(' ',$name);

        $firstWord = $name_array[0];

        return mb_substr($firstWord[0],0,1);
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function generateRandomNumber($length_of_string = 10) {
        // String of all alphanumeric character 
        $str_result = '0123456789';

        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public static function generateErrorLog($errorData, $input = [], $userId = 0) {
        try {
            $count = ErrorLogs::where('file', $errorData->getFile())
                        ->where('line', $errorData->getLine())
                        ->count();
            
            if($count == 0):
                $errorLogs = new ErrorLogs;
                $errorLogs->code            = $errorData->getCode();
                $errorLogs->file            = $errorData->getFile();
                $errorLogs->line            = $errorData->getLine();
                $errorLogs->message         = $errorData->getMessage();

                if(count($input) > 0):
                    $errorLogs->input_request = json_encode($input);
                endif;

                if($userId != 0):
                    $errorLogs->created_by = $userId;
                endif;

                $errorLogs->save();
            else:
                $errorLogs = ErrorLogs::where('file', $errorData->getFile())
                                ->where('line', $errorData->getLine())
                                ->first();
            
                $errorLogs->count = $errorLogs->count + 1;
                $errorLogs->save();
            endif;
                    
                    
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public static function createSlot($startTime, $endTime, $slot) {
        $interval = DateInterval::createFromDateString($slot . ' minutes');

        $begin = new DateTime($startTime);
        $end = new DateTime($endTime);
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        $end->add($interval);

        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));

        $start = array_shift($periods);

        $timeSlot = array();
        foreach ($periods as $time) {
            $timeSlot[] = $start->format('H:i A') . ' - ' . $time->format('H:iA');
            $start = $time;
        }
        
        return $timeSlot;
    }

    public static function compressImage($image, $height) {
        try {
            $destinationPath = public_path("/temp");
            $filename = $height . '_' . time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);

            $return = [
                "status" => true,
                "data" => [
                    "image_url" => $destinationPath . '/' . $filename,
                    "image_name" => $filename
                ]
            ];
        } catch (Exception $ex) {
            $return = [
                "status" => false,
                "data" => []
            ];
        }
        
        return $return;
    }
    
}
