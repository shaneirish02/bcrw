<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

//GEMINI LINK NAKO NA INYO BASEHAN: https://g.co/gemini/share/4db7470fa22b

class GatewayController extends Controller
{
    //MAO NI ANG API LINK NINYO: https://rapidapi.com/dfskGT/api/book-finder1

    public function searchBooks(Request $request)
    {
        $series = $request->query('series');
        $book_type = $request->query('book_type');
        $author = $request->query('author');

        $apiKey = 'd65d60b83bmshe7a3bdac0822f3bp1eed37jsn31d08f8210bd'; //IBUTANG ANG API KEY -- MAG REGISTER RAMO DIDTO SA RAPIDAPI.COM PARA MAKA KUHA MO SAINYO APIKEY

        $client = new Client();

        try {
            $response = $client->get('https://book-finder1.p.rapidapi.com/api/search', [
                'query' => [
                    'series' => $series,
                    'book_type' => $book_type,
                    'author' => $author,
                ],
                'headers' => [
                    'X-RapidAPI-Host' => 'book-finder1.p.rapidapi.com',
                    'X-RapidAPI-Key' => $apiKey,
                ],
                'verify' => false, // *Disable SSL verification for development only*
            ]);

            if ($response->getStatusCode() === 200) {
                return $response->getBody();
            } else {
                return response()->json([
                    'message' => 'Error fetching books: ' . $response->getStatusCode(),
                ], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getFreeEbooks(string $keyword)
    {
        $client = new Client();

        $apiKey = 'ba1deebabcmsh955b1ce5d6aa0e6p1f0d7bjsn675e90de3bfd'; // Replace with your actual RapidAPI key

        $url = 'https://freebooks-api2.p.rapidapi.com/fetchEbooks/' . urlencode($keyword);

        $headers = [
            'X-RapidAPI-Host' => 'freebooks-api2.p.rapidapi.com',
            'X-RapidAPI-Key' => $apiKey,
        ];

        try {
            $response = $client->get($url, [
                'headers' => $headers,
            ]);

            if ($response->getStatusCode() === 200) {
                return $response->getBody();
            } else {
                return response()->json(['error' => 'Failed to fetch free ebooks'], $response->getStatusCode());
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}