<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Hash;
use Session;
use Carbon\Carbon;

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

    public function register()
    {   
        $kelas = DB::table('kelas')
                    ->whereNull('tambahan')
                    ->whereNull('bersemuka')
                    ->get();

        return view('register',compact('kelas'));
    }


    public function register_user(Request $request)
    {   
        $users = DB::table('users')
                    ->where('username',$request->username);

        if($users->exists()){
            return back()->withErrors(['Username already exists']);
        }

        DB::table('users')
            ->insert([
                'username' => $request->username,
                'name' => $request->name,
                'password' => $request->password,
                'kelas' => $request->kelas,
                'type' => 'pelajar',
                'adduser' => 'self register',
                'adddate' => Carbon::now("Asia/Kuala_Lumpur")
            ]);

        $success = 'Registration Succesfull, please login';

        return redirect('/login')->with('success', $success);
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
                return back()->withErrors(['Password entered incorrect (password are case-sensitive)']);
            }
        }else{
            return back()->withErrors(['Try again, Username incorrect']);
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
