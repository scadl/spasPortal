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
                            <div class="btn btn-sm btn-outline-primary text-right" id="fScan">
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

                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">{{__('ui.tb_title')}}</th>
                                    <th scope="col" class="controls col-sm-1"><i class="fas fa-play-circle"></i> {{__('ui.tb_play')}}</th>
                                    <th scope="col" class="controls col-sm-1"><i class="fas fa-file-audio"></i> {{__('ui.tb_down')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($song_list as $song)
                                    @if($song->type == 'dir')
                                        <tr class="thead-light">
                                            <th colspan="4">{{$song->title}}</th>
                                        </tr>
                                        @elseif($song->type == 'txt')
                                        <tr class="thead-light">
                                            <th colspan="4" class="font-weight-lighter">{{$song->description}}</th>
                                        </tr>
                                    @else
                                    <tr>
                                        <td style="text-align: left">
                                            {{$song->title}}
                                        </td>
                                        <td class="controls">
                                            <div class="btn-group">
                                                <div class="btn btn-sm btn-outline-primary play_btn"
                                                     audio_id="{{$song->id}}" route="{{route('mplay', $song->id)}}">
                                                    <i class="fas fa-play" id="play_ctrl_{{$song->id}}"></i>
                                                </div>
                                                <div class="btn btn-sm btn-outline-primary disabled" id="play_num_{{$song->id}}"
                                                     title="{{__('ui.tb_col3')}}">
                                                    {{ $song->played }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="controls">
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-outline-success dw_btn"
                                                     audio_id="{{$song->id}}" route="{{route('mdown', $song->id)}}"
                                                   href="{{$song->file_name}}" target="_blank">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                                <div class="btn btn-sm btn-outline-success disabled" id="dw_num_{{$song->id}}"
                                                     title="{{__('ui.tb_col4')}}">
                                                    {{ $song->downloads }}
                                                </div>
                                            </div>
                                            <!-- audio object -->
                                            <audio id="audio_object_{{$song->id}}">
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
