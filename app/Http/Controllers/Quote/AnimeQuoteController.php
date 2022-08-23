<?php

namespace App\Http\Controllers\Quote;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeQuoteController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if($request->action == 'fetch'){

            $client = new Client();
            $response = $client->get(config('api.anime_quote_url'), ['verify' => false]);
            $data = json_decode($response->getBody()->getContents(), true);
        }
        return view('quote.index', compact('data'));
    }
}
