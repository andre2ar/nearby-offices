<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nearby Offices</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <h1>Import list of offices: </h1>

        <form
            action="{{route('nearby-offices.store')}}"
            method="post"
            enctype="multipart/form-data"
        >
            @csrf
            <input required name="offices" type="file" accept="text/plain" />

            <button type="submit">Send</button>
        </form>


        @if(isset($nearbyOffices))
            <hr />
            <table>
                @foreach($nearbyOffices as $office)
                <tr>
                    <td>{{$office->affiliate_id}}</td>
                    <td>{{$office->name}}</td>
                </tr>
                @endforeach
            </table>
        @endif
    </body>
</html>
