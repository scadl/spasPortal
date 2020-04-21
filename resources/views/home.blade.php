@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-row">
                        <div
                            class="flex-grow-1 text-primary text-uppercase font-weight-bold"> {{ __('ui.panel') }}</div>
                        @auth
                        @if(Auth::user()->isAdmin)
                        <div class="btn-group">
                            <div class="btn btn-sm btn-outline-primary text-left" id="fScan" title="{{ __('ui.rescan') }}">
                                <i class="fas fa-sync"></i>
                            </div>
                            <a href="{{route('ucontrol')}}" class="btn btn-sm btn-outline-primary text-right" title="{{ __('ui.umanage') }}">
                                <i class="fas fa-user-cog"></i>
                            </a>
                        </div>
                        @endif
                        @endauth
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @guest
                            <div class="alert alert-danger">{{ __('ui.login_req') }}</div>
                        @else

                            <div class="container">

                                <div class="row bg-dark text-light px-2 py-3 font-weight-bold">
                                    <div class="col-sm ">{{__('ui.tb_title')}}</div>
                                    <div class="col col-sm-3 controls text-truncate">
                                        {{__('ui.tb_play')}} и {{__('ui.tb_down')}}
                                    </div>
                                </div>

                                @foreach($song_list as $song)
                                    @if($song->type == 'dir')
                                        <div class="row bg-light p-2 align-items-center" >
                                            <div class="col-sm font-weight-bold">
                                                @if(Auth::user()->isAdmin)
                                                    <div class="input-group">
                                                        <input type="text" class="form-control bg-light" value="{{$song->title}}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-sm btn-outline-secondary btn_rename"
                                                                    route="{{route('mrename', $song->id)}}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                {{$song->title}}
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($song->type == 'txt')
                                        <div class="row bg-light p-2 border-top border-bottom">
                                            <div class="col-sm font-italic">{!! nl2br(e($song->description)) !!}</div>
                                        </div>
                                    @else

                                    <div class="row p-2 border-bottom align-items-center">

                                        <div class="text-left align-middle col-sm">
                                            @if(Auth::user()->isAdmin)
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="{{$song->title}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-outline-success btn_rename"
                                                                route="{{route('mrename', $song->id)}}">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                {{$song->title}}
                                            @endif
                                            <!-- real html5 audio object -->
                                                <audio id="audio_object_{{$song->id}}" audio_id="{{$song->id}}" class="audio" step="10">
                                                    <source src="{{$song->file_name}}" type="audio/mpeg">
                                                    {{ __('ui.err_play') }}
                                                </audio>
                                        </div>
                                        <!--
                                        <div class="controls col-sm col-sm-auto">
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-outline-success dw_btn"
                                                   audio_id="{{$song->id}}" route="{{route('mdown', $song->id)}}"
                                                   href="{{$song->file_name}}" target="_blank">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                                <div class="btn btn-sm btn-outline-success disabled" id="dw_num_{{$song->id}}"
                                                     title="{{__('ui.badge_down')}}">
                                                    {{ $song->downloads }}
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                        <div class="controls col-md-auto btn-group-vertical btn-toolbar">

                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-primary disabled text-nowrap">
                                                    <span id="curTime_{{$song->id}}">00:00:00</span> - <span id="trkTime_{{$song->id}}">00:00:00</span>
                                                </div>
                                                <div class="btn-group">
                                                    <div class="btn btn-sm btn-outline-primary" title="{{__('ui.fwbk_stpep')}}"
                                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-caret-square-down"></i>
                                                    </div>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" audio_id="{{$song->id}}">
                                                        <div class="dropdown-item disabled">{{__('ui.fwbk_stpep')}}</div>
                                                        <div class="dropdown-item active" vsec="10">10 {{__('ui.sec')}}</div>
                                                        <div class="dropdown-item" vsec="60">1 {{__('ui.min')}}</div>
                                                        <div class="dropdown-item" vsec="600">10 {{__('ui.min')}}</div>
                                                    </div>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary repeat_btn" audio_id="{{$song->id}}" title="{{__('ui.loop')}}">
                                                    <i class="fas fa-retweet"></i>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary disabled" id="play_num_{{$song->id}}"
                                                     title="{{__('ui.badge_play')}}">
                                                    {{ $song->played }}
                                                </div>

                                                <div class="btn btn-sm btn-outline-success disabled" id="dw_num_{{$song->id}}" style="width: 30px; flex: initial"
                                                     title="{{__('ui.badge_down')}}">
                                                    {{ $song->downloads }}
                                                </div>
                                            </div>

                                            <div class="btn-group" audio_id="{{$song->id}}">
                                                <div class="btn btn-sm btn-outline-primary s_bkw" title="{{__('ui.s_bkw')}}" direction="1">
                                                    <i class="fas fa-backward"></i>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary play_btn"
                                                     route="{{route('mplay', $song->id)}}">
                                                    <i class="fas fa-play" id="play_ctrl_{{$song->id}}"></i>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary s_fwd" title="{{__('ui.s_fwd')}}" direction="0">
                                                    <i class="fas fa-forward"></i>
                                                </div>

                                                <a class="btn btn-sm btn-outline-success dw_btn" style="width: 30px; flex: initial"
                                                   audio_id="{{$song->id}}" route="{{route('mdown', $song->id)}}"
                                                   href="{{$song->file_name}}" target="_blank">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                            </div>

                                        </div>

                                    </div>
                                    @endif
                                @endforeach
                            </div>

                        @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
