<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;

class SetupController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setup_user(Request $request){

        return view('setup_user');
    }

    public function setup_kelas(Request $request){

        return view('setup_kelas');
    }

    public function table(Request $request){
        switch($request->action){
            case 'getuser':
                $this->getuser($request);
                break;
            case 'getkelas':
                $this->getkelas($request);
                break;
            case 'getjadual':
                $this->getjadual($request);
                break;
            default:
                return 'error happen..';
        }
    }


    public function form(Request $request){
        switch($request->action){
            case 'save_user':
                $this->save_user($request);
                break;
            case 'save_kelas':
                $this->save_kelas($request);
                break;
            case 'save_jadual':
                $this->save_jadual($request);
                break;
            default:
                return 'error happen..';
        }
    }

    public function getuser(Request $request){
        $users = DB::table('users')->get();

        $responce = new stdClass();
        $responce->data = $users;

        echo json_encode($responce);
    }

    public function getkelas(Request $request){
        $kelas = DB::table('kelas')->get();

        $responce = new stdClass();
        $responce->data = $kelas;

        echo json_encode($responce);
    }

    public function getjadual(Request $request){
        $kelas = DB::table('jadual')
                    ->where('kelas_id',$request->kelas_id)
                    ->get();

        $responce = new stdClass();
        $responce->data = $kelas;

        echo json_encode($responce);
    }

    public function save_user(Request $request){
        DB::beginTransaction();

        $ajar = (!empty($request->ajar))?1:null;
        $setup = (!empty($request->setup))?1:null;

        try {
            if($request->oper == 'add'){
                DB::table('users')
                    ->insert([
                        'username' => $request->username,
                        'password' => $request->username,
                        'kelas' => $request->kelas,
                        'type' => $request->type,
                        'ajar' => $ajar,
                        'setup' => $setup,
                        'adduser' => session('username'),
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('users')
                    ->where('idno',$request->idno)
                    ->update([
                        'kelas' => $request->kelas,
                        'type' => $request->type,
                        'ajar' => $ajar,
                        'setup' => $setup,
                        'upduser' => session('username'),
                        'upddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'del'){
                DB::table('users')
                    ->where('idno',$request->idno)
                    ->delete();
            }

            DB::commit();
            
            $responce = new stdClass();
            $responce->operation = 'SUCCESS';
            echo json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }

    }



    public function save_kelas(Request $request){
        DB::beginTransaction();

        $tambahan = (!empty($request->tambahan))?1:null;
        $terbuka = (!empty($request->terbuka))?1:null;

        try {
            if($request->oper == 'add'){
                DB::table('kelas')
                    ->insert([
                        'name' => $request->name,
                        'ketua' => $request->ketua,
                        'pengajar' => $request->pengajar,
                        'tambahan' => $tambahan,
                        'terbuka' => $terbuka,
                        'adduser' => session('username'),
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('kelas')
                    ->where('idno',$request->idno)
                    ->update([
                        'name' => $request->name,
                        'ketua' => $request->ketua,
                        'pengajar' => $request->pengajar,
                        'tambahan' => $tambahan,
                        'terbuka' => $terbuka,
                        'upduser' => session('username'),
                        'upddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'del'){
                // DB::table('users')
                //     ->where('idno',$request->idno)
                //     ->delete();
            }

            DB::commit();
            
            $responce = new stdClass();
            $responce->operation = 'SUCCESS';
            echo json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }

    }


    public function save_jadual(Request $request){
        DB::beginTransaction();

        if($request->type=='weekly'){
            $time = $request->time_w;
        }else{
            $time = $request->time_s;
        }

        try {
            if($request->oper == 'add'){
                DB::table('jadual')
                    ->insert([
                        'kelas_id' => $request->kelas_id,
                        'description' => $request->description,
                        'type' => $request->type,
                        'hari' => $request->hari,
                        'date' => $request->date,
                        'time' => $time,
                        'adduser' => session('username'),
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('jadual')
                    ->where('idno',$request->idno)
                    ->update([
                        'description' => $request->description,
                        'type' => $request->type,
                        'hari' => $request->hari,
                        'date' => $request->date,
                        'time' => $time,
                        'upduser' => session('username'),
                        'upddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'del'){
                // DB::table('users')
                //     ->where('idno',$request->idno)
                //     ->delete();
            }

            DB::commit();
            
            $responce = new stdClass();
            $responce->operation = 'SUCCESS';
            echo json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }

    }


}