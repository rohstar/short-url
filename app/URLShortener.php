<?php
/**
 * Created by PhpStorm.
 * User: rohanmaheshwari
 * Date: 3/14/19
 * Time: 12:54 PM
 */

namespace App;

use Exception;

class URLShortener
{



    protected const CHARS = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    protected const CODE_LEN = 6;

    private $code = '';

    public function generateShortURL($url){

        //first see if the url already exists in
        //our system. if so, return the code

        $record = ShortURL::where('original_url', $url)->first();

        if($record){

            return $record->short_url_slug;

        }

        $this->generateCode();

        ShortURL::create([

            'created_by' => auth()->id(),
            'original_url' => $url,
            'short_url_slug' => $this->code

        ]);

        return '/' . $this->code;

    }

    public function generateCode(){


        //add a function to not generate any strings that
        //the internal URL structure uses, like
        // /login, or /home, or /signin....

        $characters = str_split(self::CHARS);

        for($i = 0 ; $i < self::CODE_LEN ;$i++){

            $this->code .= $characters[random_int(0, count($characters) - 1)];

        }

    }



}