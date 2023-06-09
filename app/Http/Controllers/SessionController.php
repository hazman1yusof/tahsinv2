<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Hash;
use Session;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('login');
    }

    public function login(Request $request)
    {   
        $remember = false;

        $user = User::where('username',request('username'))
                    ->where('password',request('password'));

        if($user->exists()){

            $request->session()->put('username', request('username'));
            $request->session()->put('kelas', request('username'));
            
            // if($user->first()->status == 'Inactive'){
            //     return back()->withErrors(['Sorry, your account is inactive, contact admin to activate it again']);
            // }
            
            if ($request->password == $user->first()->password) {
                Auth::login($user->first(),$remember);
                return redirect('/dashboard');

            }else{
                return back()->withErrors(['Try again, Password entered incorrect']);
            }
        }else{
            return back()->withErrors(['Try again, Username or Password incorrect']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        // dd('sdsd');
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
