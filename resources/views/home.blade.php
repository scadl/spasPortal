@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex flex-row">
                        <div
                            class="flex-grow-1 text-primary text-uppercase font-weight-bold"> {{ __('ui.panel') }}</div>
                        @auth
                            <div class="btn btn-sm btn-outline-primary text-right">
                                <i class="fas fa-retweet"></i>
                                {{ __('ui.rescan') }}
                            </div>
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

                            <table class="table table-striped table-bordered ">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">{{__('ui.tb_col1')}}</th>
                                    <th scope="col" style="text-align: center">{{__('ui.tb_col2')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($song_list as $song)
                                    <tr>
                                        <th scope="row">{{$song->title}}</th>
                                        <td>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="p-0">
                                            <audio id="audio_object_{{$song->id}}">
                                                <source src="{{$song->file_name}}" type="audio/mpeg">
                                                {{ __('ui.err_play') }}
                                            </audio>
                                        </td>
                                    </tr>
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
