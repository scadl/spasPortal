@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-row">
                        <div class="flex-grow-1 text-primary text-uppercase font-weight-bold">
                            {{ __('ui.panelC') }}
                        </div>
                            @auth
                                @if(Auth::user()->isAdmin)
                                    <div class="btn-group">
                                        <a href="{{route('home')}}" class="btn btn-sm btn-outline-primary text-right" title="{{ __('ui.back_catlog') }}">
                                            &larr;&nbsp;<i class="fas fa-walking"></i>
                                        </a>
                                        <a href="{{route('ushutdown')}}" class="btn btn-sm btn-outline-primary text-right" title="{{ __('ui.disable_all') }}">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                        <a href="{{route('ugreen')}}" class="btn btn-sm btn-outline-primary text-right" title="{{ __('ui.allow_all') }}">
                                            <i class="fas fa-user"></i>
                                        </a>
                                        <a href="{{ route('manualadd') }}" class="btn btn-sm btn-outline-primary text-right" title="{{ __('ui.register2') }}">
                                            <i class="fas fa-user-plus"></i>
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
                                    <th scope="col" class="col-8">{{__('ui.tb_uname')}}</th>
                                    <th scope="col" class="controls col-sm-1" title="{{__('ui.logs')}}"><i class="fas fa-sign-in-alt"></th>
                                    <th scope="col" class="controls col-sm-1" title="{{__('ui.tb_ctrl')}}"><i class="fas fa-wrench"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user_list as $user)
                                    <tr>
                                        <td style="text-align: left; @if(!$user->isEnabled) text-decoration:line-through @endif">
                                            {{$user->name}}
                                        </td>
                                        <td class="text-center">
                                            {{$user->numLogin}}
                                        </td>
                                        <td class="controls">
                                            @if(!$user->isAdmin)

                                                <a class="btn btn-sm btn-outline-primary"
                                                     href="{{route('uswitch', $user->id)}}">
                                                    <i class="fas @if(!$user->isEnabled)fa-user-slash @else fa-user @endif"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary"
                                                   href="{{route('asknepw', [$user->id, 'users'])}}">
                                                    <i class="fas fa-key"></i>
                                                </a>

                                        </td>
                                        @endif
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

@section('modals')
@endsection
