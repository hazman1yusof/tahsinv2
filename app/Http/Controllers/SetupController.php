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

        $kelas = DB::table('kelas')
                    ->whereNull('tambahan')
                    ->get();

        return view('setup_user',compact('kelas'));
    }

    public function setup_kelas(Request $request){

        $ketua = DB::table('users')
                    ->where('type','ketua_pelajar')
                    ->get();

        $pengajar = DB::table('users')
                    ->where('ajar','1')
                    ->get();

        return view('setup_kelas',compact('ketua','pengajar'));
    }

    public function setup_jadual(Request $request){

        $kelas = DB::table('kelas')
                    ->get();

        return view('setup_jadual',compact('kelas'));
    }

    public function setup_tilawah(Request $request){
        
        $users = DB::table('users')
                    ->get();

        $effdate = DB::table('tilawah')
                    ->whereNotNull('effectivedate');
                    
        if($effdate->exists()){
            $effdate = $effdate->first()->effectivedate;
        }else{
            $effdate = null;
        }

        return view('setup_tilawah',compact('users','effdate'));
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
            case 'gettilawah':
                $this->gettilawah($request);
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
            case 'save_tilawah':
                $this->save_tilawah($request);
                break;
            case 'save_tilawah_effdate':
                $this->save_tilawah_effdate($request);
                break;
            default:
                return 'error happen..';
        }
    }

    public function getuser(Request $request){
        $users = DB::table('users as u')
                    ->select('u.id','u.username','u.password','u.name','u.kelas','u.type','u.ajar','u.setup','u.telhp','u.address','u.telno','u.postcode','u.newic','u.image','u.adduser','u.adddate','u.upduser','u.upddate','u.last_surah','u.last_ms','k.name as kelas_name')
                    ->leftJoin('kelas as k', function($join) use ($request){
                        $join = $join->on('k.idno', '=', 'u.kelas');
                    })->get();

        $responce = new stdClass();
        $responce->data = $users;

        echo json_encode($responce);
    }

    public function getkelas(Request $request){
        $kelas = DB::table('kelas as k')
                    ->select('k.idno','k.name','k.tambahan','k.terbuka','k.ketua','k.pengajar','k.adduser','k.adddate','k.upduser','k.upddate','u.username as ketua_desc','u2.username as pengajar_desc')
                    ->leftJoin('users as u', function($join) use ($request){
                        $join = $join->on('k.ketua', '=', 'u.id');
                    })
                    ->leftJoin('users as u2', function($join) use ($request){
                        $join = $join->on('k.pengajar', '=', 'u2.id');
                    })
                    ->get();

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

    public function gettilawah(Request $request){
        $tilawah = DB::table('tilawah')
                    ->orderBy('giliran', 'asc')
                    ->get();

        $responce = new stdClass();
        $responce->data = $tilawah;

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
                    ->where('id',$request->id)
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
                    ->where('id',$request->id)
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

        try {
            if($request->oper == 'add'){
                DB::table('jadual')
                    ->insert([
                        'kelas_id' => $request->kelas_id,
                        'title' => $request->title,
                        'type' => $request->type,
                        'hari' => $request->hari,
                        'date' => $request->date,
                        'time' => $request->time,
                        'adduser' => session('username'),
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('jadual')
                    ->where('idno',$request->idno)
                    ->update([
                        'title' => $request->title,
                        'type' => $request->type,
                        'hari' => $request->hari,
                        'date' => $request->date,
                        'time' => $request->time,
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

    public function save_tilawah(Request $request){
        DB::beginTransaction();
        try {
            if($request->oper == 'add'){
                DB::table('tilawah')
                    ->insert([
                        'giliran' => $request->giliran,
                        'user_id' => $request->user_id,
                        'ms1' => $request->ms1,
                        'ms2' => $request->ms2,
                        'lastuser' => session('username'),
                        'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('tilawah')
                    ->where('idno',$request->idno)
                    ->update([
                        'giliran' => $request->giliran,
                        'user_id' => $request->user_id,
                        'ms1' => $request->ms1,
                        'ms2' => $request->ms2,
                        'lastuser' => session('username'),
                        'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'del'){
                // DB::table('tilawah')
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


    public function save_tilawah_effdate(Request $request){
        DB::beginTransaction();
        try {
            DB::table('tilawah')
                ->update([
                    'effectivedate' => $request->effectivedate
                ]);

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