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
                            <div class="btn btn-sm btn-outline-primary text-left" id="fScan">
                                <i class="fas fa-retweet"></i>
                                {{ __('ui.rescan') }}
                            </div>
                            <a href="{{route('ucontrol')}}" class="btn btn-sm btn-outline-primary text-right">
                                <i class="fas fa-user-cog"></i>
                                {{ __('ui.umanage') }}
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

                            <table class="table ">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="col-8">{{__('ui.tb_title')}}</th>
                                    <th scope="col" class="controls col-2"><i class="fas fa-play-circle"></i> {{__('ui.tb_play')}}</th>
                                    <th scope="col" class="controls col-1" title="{{__('ui.tb_down')}}"><i class="fas fa-file-audio"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($song_list as $song)
                                    @if($song->type == 'dir')
                                        <tr class="thead-light">
                                            <th colspan="4">
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
                                            </th>
                                        </tr>
                                        @elseif($song->type == 'txt')
                                        <tr class="thead-light">
                                            <th colspan="4" class="font-weight-lighter">{!! nl2br(e($song->description)) !!}</th>
                                        </tr>
                                    @else
                                    <tr>
                                        <td style="text-align: left;" class="text-left align-middle">
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
                                        </td>
                                        <td class="controls btn-toolbar btn-group-vertical">
                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-primary disabled text-nowrap">
                                                    <span id="curTime_{{$song->id}}">00:00:00</span> - <span id="trkTime_{{$song->id}}">00:00:00</span>
                                                </div>
                                                <div class="btn-group">
                                                    <div class="btn btn-sm btn-outline-primary dropdown-toggle" title="{{__('ui.fwbk_stpep')}}"
                                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </div>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" audio_id="{{$song->id}}">
                                                        <div class="dropdown-item disabled">{{__('ui.fwbk_stpep')}}</div>
                                                        <div class="dropdown-item active" vsec="10">10 {{__('ui.sec')}}</div>
                                                        <div class="dropdown-item" vsec="60">1 {{__('ui.min')}}</div>
                                                        <div class="dropdown-item" vsec="600">10 {{__('ui.min')}}</div>
                                                    </div>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary repeat_btn" audio_id="{{$song->id}}" title="{{__('ui.loop')}}">
                                                    <i class="fas fa-sync-alt"></i>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary disabled" id="play_num_{{$song->id}}"
                                                     title="{{__('ui.badge_play')}}">
                                                    {{ $song->played }}
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
                                            </div>
                                        </td>
                                        <td class="controls">
                                            <div class="btn-group-vertical">
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
                                            <!-- real html5 audio object -->
                                            <audio id="audio_object_{{$song->id}}" audio_id="{{$song->id}}" class="audio" step="10">
                                                <source src="{{$song->file_name}}" type="audio/mpeg">
                                                {{ __('ui.err_play') }}
                                            </audio>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                        @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
