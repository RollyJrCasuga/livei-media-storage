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
  @if (config('app.env') == 'local')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  @else
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
  @endif
  @stack('styles')
</head>
<body>
  @include('partials.flash')
  <div class="container">
    @auth
      @include('partials.navbar')
    @endauth
    @yield('content')
  </div>
  @include('partials.footer')
  <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  @if (config('app.env') == 'local')
    <script src="{{asset('js/app.js')}}"></script>
  @else
    <script src="{{mix('js/app.js')}}"></script>
  @endif
  @stack('scripts')
</body>
</html>