<?php

namespace App\Http\Controllers;

use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function usersControl(){
        return view('users', ['user_list'=>User::all()]);
    }

    public function userSwitch(User $user){
        $user->isEnabled ^= 1;
        $user->save();
        return redirect('users');
    }

    public function userShutdown(){
        $users = User::all();
        foreach ($users as $user) {
            if(!$user->isAdmin) {
                $user->isEnabled = false;
                $user->save();
            }

        }
        return redirect('users');
    }

    public function userGreenlight(){
        $users = User::all();
        foreach ($users as $user) {
            if(!$user->isAdmin) {
                $user->isEnabled = true;
                $user->save();
            }
        }
        return redirect('users');
    }

    public function pwResetAsk(User $user, String $orig){

        return view('auth.passwords.reset', [
            'express'=>True,
            'uid' => $user->id,
            'email'=>$user->email,
            'origin' => $orig,
        ]);

    }

    public function usrUpdatePw(Request $request, User $user){

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Width() method will set a sesion variable just for one call
        return redirect($request->origin)->with('status', __('ui.pwchok'));
    }

    public function switchRegLock(Request $request){

        $state = Settings::where('key','lockdown')->first();

        if($state->value == 'no'){

            $state->value = 'yes';
            $state->save();

            $state = Settings::where('key','lockdown_msg')->first();
            $state->value = $request->message_text;
            $state->save();

            $state = Settings::where('key','srv_email')->first();
            $state->value = $request->recipient_name;
            $state->save();

            $ui_msg = 'ui.lockdown_on';

        } else {

            $state->value = 'no';
            $state->save();

            $ui_msg = 'ui.lockdown_off';
        }

        return redirect('home')->with('status', __($ui_msg));
    }

    public function userAdd(){
        return view('auth.register', ['express'=>True]);
    }

    public function addNewUser(Request $request){

        $usr = new User();
        $usr->name = $request->name;
        $usr->email = $request->email;
        $usr->password = Hash::make($request->password);
        $usr->setRememberToken(Str::random(60));
        $usr->save();

        return redirect('users')->with('status', __('ui.adduserok'));
    }
}
