<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Google\Cloud\Speech\V1\SpeechClient;


class AudioController extends Controller
{
    public function getData(Request $request)
    {
        //$url = Storage::download('public/track.mp3');
        $url = asset('storage/test.flac');

        //$file = Storage::disk('public')->get('track.mp3');
        //$download = new Response($file, 200);


        // dd($request->all(), $url);
        return view('welcome')->with('downloadLink', $url);
    }

    public function transcribedText(Request $request)
    {

        $recognitionConfig = new RecognitionConfig();
        $recognitionConfig->setEncoding(AudioEncoding::FLAC);
        $recognitionConfig->setSampleRateHertz(44100);
        $recognitionConfig->setLanguageCode('en-US');
        $config = new StreamingRecognitionConfig();
        $config->setConfig($recognitionConfig);
        $auth = Storage::disk('public')->get('auth.json');
        $test = Storage::path('public/auth.json');
        //dd(file_get_contents($test, true));
        //dd(json_decode($auth));
        //putenv('GOOGLE_APPLICATION_CREDENTIALS='.$auth);
        $speechClient = new SpeechClient([
            'credentials' => Storage::path('public/auth.json'),
        ]);
        $file = Storage::disk('public')->get('test.flac');


        // $audioResource = fopen('path/to/audio.flac', 'r');

        $responses = $speechClient->recognizeAudioStream($config, $file);

        foreach ($responses as $element) {
            dd($element);
        }
    }
}
