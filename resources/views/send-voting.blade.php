<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body>
        <h1>Hej!</h1>
        <div>
            <span>{{ $voting->user->name }} önskar om att få din hjälp med några formuleringar.<br />Du kan rösta genom att ladda ner appen här eller klicka på någon av alternativen nedan.</span>
        </div>
        <div>
            <ul>
                @for ($i = 0; $i < count($voting->suggestions); $i++)
                    <li>
                        <div>
                            <span><a href="http://localhost:8000/api/vote/{{ $voting->suggestions[$i]->uuid }}/{{ $vote->email }}">Alt. {{ $i + 1 }}</a></span>
                        </div>
                        <div>
                            <span>{{ $voting->suggestions[$i]->text }}</span>
                        </div>
                    </li>
                    @endfor
            </ul>
        </div>
        </div>
    </body>
</html>
