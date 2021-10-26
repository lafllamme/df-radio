<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    // const speech = require('@google-cloud/speech');
    // const fs = rquire('fs');

    // async function main() {
    //     const client = new speech.SpeechClient();
    //     const filename = './resources/track.mp3';

    //     const file = fs.readFileSync(filename);
    //     const audioBytes = file.toString('base64');

    //     const audio = {
    //         content: audioBytes
    //     };

    //     const config = {
    //         encoding: 'LINEAR16',
    //         sampleRateHertz: 16000,
    //         languageCode: 'en-US',
    //     };

    //     const request = {
    //         audio: audio,
    //         config: config
    //     };

    //     const [response] = await client.recognize(request);
    //     const transcription = response.results.map(result =>
    //     result.alternatives[0].transcript).join('\n');
    //     console.log(`Transcription: ${transcription}`);
    // }

    // main().catch(console.error);
    
</script>
