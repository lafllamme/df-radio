/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//  const speech = require('@google-cloud/speech');
//  const fs = require('fs');

//  async function main() {
//      const client = new speech.SpeechClient();
//      const filename = './audio/track.mp3';

//      const file = fs.readFileSync(filename);
//      const audioBytes = file.toString('base64');

//      const audio = {
//          content: audioBytes
//      };

//      const config = {
//          encoding: 'LINEAR16',
//          sampleRateHertz: 16000,
//          languageCode: 'en-US',
//      };

//      const request = {
//          audio: audio,
//          config: config
//      };

//      const [response] = await client.recognize(request);
//      const transcription = response.results.map(result =>
//      result.alternatives[0].transcript).join('\n');
//      console.log(`Transcription: ${transcription}`);
//  }

//  main().catch(console.error);

const app = new Vue({
    el: '#app',
});
