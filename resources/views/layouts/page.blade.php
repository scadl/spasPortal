<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('ui.h1_title') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/page.css') }}" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            <a href="/lang/en">EN</a>
            <a href="/lang/ru">RU</a>
            @auth
                <a href="{{ url('/home') }}">🎧{{ __('ui.panel') }}</a>
            @else
                <a href="{{ route('login') }}">{{ __('ui.login') }}</a>

                @if (Route::has('register'))
                    <a
                    @if($srv_state['lockdown']=='yes')
                    style="text-decoration: line-through"
                    data-toggle="modal" data-target="#noticeModal"
                    @else
                    href="{{ route('register') }}"
                    @endif
                    >
                        {{__('ui.register')}}
                    </a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        @yield('content')
    </div>

</div>

    <!-- Modal -->
    <div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="noticeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="noticeModalLabel">{{ __('ui.lockdown_on') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               {{ $srv_state['lockdown_msg'] }}
               <a href="mailto:{{ $srv_state['srv_email'] }}">{{ $srv_state['srv_email'] }}</a>
            </div>
            <div class="modal-footer">

            </div>
          </div>
        </div>
      </div>

</body>
</html>
