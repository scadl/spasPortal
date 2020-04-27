@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-row">
                        <div
                            class="flex-grow-1 text-primary text-uppercase font-weight-bold">
                            <i class="fas fa-music"></i>
                            {{ __('ui.panel') }}
                        </div>
                        @auth
                        @if(Auth::user()->isAdmin)
                        <div class="btn-group">
                            <div class="btn btn-sm btn-outline-primary text-left text-truncate" id="fScan" title="{{ __('ui.rescan') }}">
                                <i class="fas fa-sync"></i>
                            </div>
                            <a href="{{route('ucontrol')}}" class="btn btn-sm btn-outline-primary text-right text-truncate" title="{{ __('ui.umanage') }}">
                                <i class="fas fa-user-cog"></i>
                            </a>
                            <button data-toggle="modal" data-target="@if($srv_state['lockdown']=='yes')#exitLockdownModal @else#lockdownModal @endif"
                                    class="btn btn-sm btn-outline-primary text-right text-truncate" title="{{__('ui.lockreg')}}">
                                <i class="fas @if($srv_state['lockdown']=='yes') fa-unlock-alt @else fa-lock @endif"></i>
                            </button>
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



@section('modals')
    <div class="modal fade" id="exitLockdownModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('ui.lockreg')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('ui.lockdown_ask')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{__('ui.cancel')}}</button>
                    <a href="{{route('lockregoff')}}" type="button" class="btn btn-primary">{{__('ui.ok')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lockdownModal" tabindex="-1" role="dialog" aria-labelledby="lockdownModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lockdownModalLabel">{{__('ui.lockreg')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('lockregon')}}" method="post" id="srvModeParam">
                        @csrf
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{__('ui.lock_msg')}}:</label>
                            <textarea class="form-control" name="message_text">{{$srv_state['lockdown_msg']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{__('ui.srv_email')}}:</label>
                            <input type="text" class="form-control" name="recipient_name"
                                   value="{{$srv_state['srv_email']}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{__('ui.cancel')}}</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault();
                                                        document.getElementById('srvModeParam').submit();">
                        {{__('ui.ok')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
