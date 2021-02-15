<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Drive - Livei.com</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  @stack('styles')
</head>
<body>
  <div class="container">
    @include('partials.navbar')
    @yield('content')
  </div>
  @include('partials.footer')
  <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  
  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>