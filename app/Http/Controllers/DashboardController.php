<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }   


    public function dashboard(Request $request){
            $kelas_id = Auth::user()->kelas;
            $jadual = DB::table('jadual as j')
                        ->select('j.idno','j.kelas_id','j.title','j.type','j.hari','j.date','j.time','k.name')
                        ->leftJoin('kelas as k', function($join) use ($request){
                                $join = $join->on('k.idno', '=', 'j.kelas_id');
                        })
                        ->where('kelas_id',$kelas_id)
                        ->where('type','weekly')
                        ->first();

            $date_b4 = Carbon::parse("last ".$jadual->hari)->format('Y-m-d');
            $kd_b4 = DB::table('kelas_detail')
                        ->where('kelas_id',$kelas_id)
                        ->where('user_id',Auth::user()->id)
                        ->where('jadual_id',$jadual->idno)
                        ->where('type','weekly')
                        ->where('date',$date_b4)
                        ->where('time',$jadual->time);

            if($kd_b4->exists()){
                $kd_b4 = $kd_b4->first();
            }else{
                $kd_b4 = null;
            }

            $date_after = Carbon::parse("next ".$jadual->hari)->format('Y-m-d');
            $kd_after = DB::table('kelas_detail')
                        ->where('kelas_id',$kelas_id)
                        ->where('user_id',Auth::user()->id)
                        ->where('jadual_id',$jadual->idno)
                        ->where('type','weekly')
                        ->where('date',$date_after)
                        ->where('time',$jadual->time);

            $count_kelas = DB::table('users')
                            ->where('kelas',$request->kelas_id)
                            ->count();

            $user_kd = DB::table('kelas_detail as kd')
                        ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.surah2','kd.ms2','kd.marked','u.name')
                        ->leftJoin('users as u', function($join) use ($request){
                                $join = $join->on('u.id', '=', 'kd.user_id');
                        })
                        ->where('kd.kelas_id',$kelas_id)
                        ->where('kd.jadual_id',$jadual->idno)
                        ->where('kd.type','weekly')
                        ->where('kd.date',$date_after)
                        ->where('kd.time',$jadual->time)
                        ->orderBy('kd.pos', 'asc')
                        ->get();

            if($kd_after->exists()){
                $kd_after = $kd_after->first();
            }else{
                $kd_after = null;
            }

            $user_detail = DB::table('users as u')
                        ->select('u.id','u.username','u.password','u.name','u.kelas','u.type','u.ajar','u.setup','u.telhp','u.address','u.telno','u.postcode','u.newic','u.image','u.adduser','u.adddate','u.upduser','u.upddate','u.dob','u.gender','u.last_surah','u.last_ms', 'k.name as kelas_name')
                        ->leftJoin('kelas as k', function($join) use ($request){
                                $join = $join->on('k.idno', '=', 'u.kelas');
                        })
                        ->where('u.id',Auth::user()->id)
                        ->first();
        return view('dashboard',compact('user_detail','kd_b4','date_b4','kd_after','date_after','jadual','count_kelas','user_kd'));
    }

    public function upd_user(Request $request){
        $user_detail = DB::table('users as u')
                    ->select('u.id','u.username','u.password','u.name','u.kelas','u.type','u.ajar','u.setup','u.telhp','u.address','u.telno','u.postcode','u.newic','u.image','u.adduser','u.adddate','u.upduser','u.upddate','u.dob','u.gender','u.last_surah','u.last_ms', 'k.name as kelas_name')
                    ->leftJoin('kelas as k', function($join) use ($request){
                            $join = $join->on('k.idno', '=', 'u.kelas');
                    })
                    ->where('u.id',Auth::user()->id)
                    ->first();

        return view('upd_user',compact('user_detail'));
    }

    public function upd_user_post(Request $request){
        DB::table('users')
                ->where('id',Auth::user()->id)
                ->update([
                    'password' => $request->password,
                    'name' => $request->name,
                    'telhp' => $request->telhp,
                    'newic' => $request->newic,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'upduser' => session('username'),
                    'upddate' => Carbon::now("Asia/Kuala_Lumpur")
                ]);

        return redirect()->route('upd_user');
    }

    public function table(Request $request){
        switch($request->action){
            case 'getuser':
                $this->getuser($request);
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
                        'setup' => $setup
                        // 'lastuser' => $request->masa_hingga,
                        // 'lastdate' => $request->masa_hingga
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('users')
                    ->where('idno',$request->idno)
                    ->update([
                        'kelas' => $request->kelas,
                        'type' => $request->type,
                        'ajar' => $ajar,
                        'setup' => $setup
                    ]);
            }else if($request->oper == 'del'){
                DB::table('jadual')
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


}