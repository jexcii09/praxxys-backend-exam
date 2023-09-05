<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Option 1: CoreUI for Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-2E9/b2fZ+VJoP6eRIpzzMFkuqbh0qDkIFVLzJJwkESsdKPEwzb0n6E55enZ+Ee8V" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">

    <link rel="stylesheet" href="{{asset("css/admin-template.css")}}" />

    <title>PRAXXYS - @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    
    
    <div>
        @yield('content')
    </div>

    <!-- Option 1: CoreUI for Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.0/dist/js/coreui.bundle.min.js" integrity="sha384-Iqk8EE7ao72xAVBuuQTEwrU5N2IdvpJER5ZzM6LxwcXHqj2WstttaOvopXziv0nU" crossorigin="anonymous"></script>

    @vite('resources/js/app.js')
  </body>
</html>
</body>
</html>