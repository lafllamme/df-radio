<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->

</head>

<body>
    <section class="hero is-info">
        <div class="hero-body">
            <p class="title">
                DLF Radio Live Transcribator </p>
            <p class="subtitle">
                Using Google Cloud Speech Api
            </p>
        </div>
    </section>
    <div class="container is-widescreen">
        <section class="section is-small">
            <div class="container">
                <form action="{{route('postAudio')}}" method="post">
                    @csrf
                    <div class="notification is-info">
                        <div class="field">
                            <label class="label">Transcribe File from URL (max 1. min)</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Enter a link" name="link" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Choose Language</label>
                            <div class="control">
                                <div class="select">
                                    <select required name="language">
                                        <option value="en-US">en-US</option>
                                        <option value="de-DE">es-ES</option>
                                        <option value="de-DE">de-DE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="file has-name is-fullwidth" id="file-js">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="filename">
                                    <span class="file-cta">
                                        <span class="material-icons">
                                            upload_file
                                        </span>
                                        <span>Upload</span>
                                    </span>
                                    <span class="file-name">
                                        Filename
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" onClick="checkStatus(this)">
                                    I agree to the <a href="#">terms and conditions</a>
                                </label>
                            </div>
                        </div>


                        <div class="field is-grouped">
                            <div class="control">
                                <button disabled class="button is-link" id="checked" type="submit">Submit</button>
                            </div>
                            <div class="control">
                                <button class="button is-link is-danger" onclick="this.form.reset();">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if(!empty($apiData))
            <div class="notification">
                <button class="delete" onclick="this.parentElement.style.display='none'"></button>
                <p> Trancript:{{$apiData['transcript']}}</p>
                <br>
                <p> Confidence:{{$apiData['confidence']}}</p>
                <br>
            </div>


            <table class="table">
                <tr>
                    <th>Number</th>
                    <th>Words</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                @foreach($words as $word)
                <tr>
                    <td> {{ $loop->iteration }}
                    </td>
                    <td>{{$word}}</td>
                    <td>{{$startTime[$loop->index]}}</td>
                    <td>{{$endTime[$loop->index]}}</td>

                </tr>
                @endforeach
                </tr>
            </table>
            @endif

            @if(!empty($downloadLink))
            <div class="notification">
                <button class="delete" onclick="this.parentElement.style.display='none'"></button>
                <a href="{{$downloadLink}}"> {{$downloadLink}}
                </a>
            </div>
            @endif


        </section>
    </div>


    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>
    </div>
    </div>
    </div>
</body>

<script src="{{ mix('/js/app.js') }}"></script>
<script>
    const fileInput = document.querySelector('#file-js input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js .file-name');
            fileName.textContent = fileInput.files[0].name;
        }
    }
    checkStatus = (elem) => {
        if (elem.checked == true)
            document.getElementById("checked").disabled = false;
        else
            document.getElementById("checked").disabled = true;

    }
</script>

</html>