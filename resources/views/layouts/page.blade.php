<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('ui.h1_title') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

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
                    style="text-decoration: line-through; cursor: pointer"
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
