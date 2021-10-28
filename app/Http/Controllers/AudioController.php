<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;

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

        $speechClient = new SpeechClient([
            'credentials' => Storage::path('public/auth.json'),
        ]);
        try {
            $encoding = AudioEncoding::FLAC;
            $sampleRateHertz = 24000;
            $languageCode = 'en-US';
            $config = new RecognitionConfig();
            $config->setEncoding($encoding);
            $config->setSampleRateHertz($sampleRateHertz);
            $config->setLanguageCode($languageCode);
            $config->setEnableWordTimeOffsets(true);

            $audio = new RecognitionAudio();
            $fileStream = file_get_contents(Storage::path('public/c.flac'), 'r');
            $audio->setContent($fileStream);
            $response = $speechClient->recognize($config, $audio);
            //dd($response);

            foreach ($response->getResults() as $result) {
                $alternatives = $result->getAlternatives();
                $mostLikely = $alternatives[0];
                $transcript = $mostLikely->getTranscript();
                $confidence = $mostLikely->getConfidence();
                //$words = $mostLikely->getWords();
                //$word = [];
                $i = 0;
                foreach ($mostLikely->getWords() as $wordInfo) {
                    $startTime = $wordInfo->getStartTime();
                    $endTime = $wordInfo->getEndTime();
                    $word['word'][] = $wordInfo->getWord();
                    $word['startTime'][] = $startTime->serializeToJsonString();
                    $word['endTime'][] = $endTime->serializeToJsonString();
                }
                $apiData['transcript'] = $transcript;
                $apiData['confidence'] = $confidence;
                $apiData['wordMetaData'] = $word;
                dd($apiData);

                return view('welcome', compact('apiData'));
            }
        } finally {

            $speechClient->close();
        }
    }
}
