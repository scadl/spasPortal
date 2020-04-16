<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
            $user->isEnabled = false;
            $user->save();
        }
        return redirect('users');
    }

    public function userGreenlight(){
        $users = User::all();
        foreach ($users as $user) {
            $user->isEnabled = true;
            $user->save();
        }
        return redirect('users');
    }
}
