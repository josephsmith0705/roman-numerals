<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Roman Numeral Converter</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>
    <body>
        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show m-2" role="alert">
                <ul class="list-unstyled" style="margin-bottom: 0px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mt-5 px-2" style="width: 100%; text-align: center;">
            <h1 class="display-1">Roman Numeral Converter</h1>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 350px;">

            @if(!isset($message))
                <form method="POST" action="/">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="form-control" id="convert-number" placeholder="Enter number (Roman numeral or modern)" name="convert_number" style="text-align: center;">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 col-6 offset-3">Convert!</button>
                </form>
            @else
                <form>
                    @csrf

                    <div style="text-align: center">{{ $message }}</div>

                    <a href="/" type="submit" class="btn btn-primary col-6 offset-3 mt-3">Convert another</a>
            @endif
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>