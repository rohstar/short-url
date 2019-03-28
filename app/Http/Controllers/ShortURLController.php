<?php

namespace App\Http\Controllers;

use App\ShortURL;
use App\URLShortener;
use Illuminate\Http\Request;

class ShortURLController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!$request->has('url')){

            return redirect()->back('404');

        }

        $code = (new URLShortener())->generateShortURL($request->input('url'));

        return back()->with(['url' => url('') . $code]);


    }

    public function forward(Request $request){


        //check to see if this exists in our db

        $codes = ShortURL::where('short_url_slug', $request->code)->first();

        //We could also do a check for the length of the request->code
        //option as a first check to reduce load on the server.
        //possibly our code generator can generate between a
        //range of length and we can search through inputs
        //only between that range.

        if($codes == null){

            return redirect()->home();

        }

       /** RECORD ANALYTICS FOR THIS URL
        * I would here create a Click Model in laravel
        * and associate it to the URL. The ShortURL
        * model would own many clicks.
        *
        * Click would have paramters that would help get
        * important analytics data, like time of click,
        * header information as a raw file, maybe
        * even the raw request, geolocation and
        * ip, etc.
        *
        */

       return redirect()->to($codes->original_url);

    }

}
