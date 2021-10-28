<?php

namespace App\Http\Controllers;

use Exception;
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

        //get language and link from request
        $url = $request->link;
        $language = $request->language;

        //set filename
        $file_name = basename($url);
        //get file content
        $contents = file_get_contents($url);
        //save file to lavel storage/app folder
        Storage::disk('local')->put($file_name, $contents);
        //get filename extenson
        $extension = pathinfo(Storage::path($file_name), PATHINFO_EXTENSION);
        //get content from saved file
        $downloadedAudioFile = file_get_contents(Storage::path($file_name), 'r');

        if ($extension == 'mp3') {

            $speechClient = new SpeechClient([
                'credentials' => Storage::path('public/auth.json'),
            ]);
            
            try {
                $encoding = AudioEncoding::MP3;
                $sampleRateHertz = 24000;
                $languageCode = $language;
                $config = new RecognitionConfig();
                $config->setEncoding($encoding);
                $config->setSampleRateHertz($sampleRateHertz);
                $config->setLanguageCode($languageCode);
                $config->setEnableWordTimeOffsets(true);

                $audio = new RecognitionAudio();
                $audio->setContent($downloadedAudioFile);
                $response = $speechClient->recognize($config, $audio);


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
                    // $apiData['wordMetaData'] = $word;
                    $words = $word['word'];
                    $startTime = $word['startTime'];
                    $endTime = $word['endTime'];
                    $words = $word['word'];
                    $startTime = $word['startTime'];
                    $endTime = $word['endTime'];
                    //dd($apiData);

                    return view('welcome', compact('apiData', 'words', 'startTime', 'endTime'));
                }
            } catch (Exception $e) {
                dd($e);
            }
        }


        $speechClient = new SpeechClient([
            'credentials' => Storage::path('public/auth.json'),
        ]);
        try {
            $encoding = AudioEncoding::FLAC;
            $sampleRateHertz = 24000;
            $languageCode = $language;
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
                $words = $word['word'];
                $startTime = $word['startTime'];
                $endTime = $word['endTime'];

                //dd($apiData, $words, $startTime, $endTime);

                return view('welcome', compact('apiData', 'words', 'startTime', 'endTime'));
            }
        } finally {

            $speechClient->close();
        }
    }
}
