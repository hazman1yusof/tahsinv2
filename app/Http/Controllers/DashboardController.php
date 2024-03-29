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

            if($kelas_id != 0){
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

                $user_kdb4 = DB::table('users as u')
                            ->select('kd.idno','kd.kelas_id','u.id as user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.alasan','kd.surah2','kd.ms2','kd.marked','u.name')
                            ->leftJoin('kelas_detail as kd', function($join) use ($request,$kelas_id,$jadual,$date_b4){
                                    $join = $join->on('u.id', '=', 'kd.user_id')
                                            ->where('kd.kelas_id',$kelas_id)
                                            ->where('kd.jadual_id',$jadual->idno)
                                            ->where('kd.type','weekly')
                                            ->where('kd.date',$date_b4)
                                            ->where('kd.time',$jadual->time);
                            })
                            ->where('u.kelas',$kelas_id)
                            ->orderBy('kd.pos', 'asc')
                            ->get();

                if($kd_b4->exists()){
                    $kd_b4 = $kd_b4->first();
                }else{
                    $kd_b4 = null;
                }

                $today_day = Carbon::now("Asia/Kuala_Lumpur")->format('l');
                if($today_day == $jadual->hari){
                    $date_after = Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d');
                }else{
                    $date_after = Carbon::parse("next ".$jadual->hari)->format('Y-m-d');
                }
                
                $kd_after = DB::table('kelas_detail')
                            ->where('kelas_id',$kelas_id)
                            ->where('user_id',Auth::user()->id)
                            ->where('jadual_id',$jadual->idno)
                            ->where('type','weekly')
                            ->where('date',$date_after)
                            ->where('time',$jadual->time)
                            ->orderBy('date', 'asc');

                $count_kelas = DB::table('users')
                                ->where('kelas',$kelas_id)
                                ->count();

                $user_kd = DB::table('users as u')
                            ->select('kd.idno','kd.kelas_id','u.id as user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.alasan','kd.surah2','kd.ms2','kd.marked','u.name')
                            ->leftJoin('kelas_detail as kd', function($join) use ($request,$kelas_id,$jadual,$date_after){
                                    $join = $join->on('u.id', '=', 'kd.user_id')
                                                ->where('kd.kelas_id',$kelas_id)
                                                ->where('kd.jadual_id',$jadual->idno)
                                                ->where('kd.type','weekly')
                                                ->where('kd.date',$date_after)
                                                ->where('kd.time',$jadual->time);
                            })
                            ->where('u.kelas',$kelas_id)
                            ->orderBy('kd.pos', 'asc')
                            ->get();

                if($kd_after->exists()){
                    $kd_after = $kd_after->first();
                }else{
                    $kd_after = null;
                }

            }

            $user_detail = DB::table('users as u')
                        ->select('u.id','u.username','u.password','u.name','u.kelas','u.type','u.ajar','u.setup','u.telhp','u.address','u.telno','u.postcode','u.newic','u.image','u.adduser','u.adddate','u.upduser','u.upddate','u.dob','u.gender','u.last_surah','u.last_ms', 'k.name as kelas_name')
                        ->leftJoin('kelas as k', function($join) use ($request){
                                $join = $join->on('k.idno', '=', 'u.kelas');
                        })
                        ->where('u.id',Auth::user()->id)
                        ->first();

            if(!empty($user_detail->dob)){
                $user_detail->age = Carbon::parse($user_detail->dob)->diff(Carbon::now())->format('%y');
            }else{
                $user_detail->age = '';
            }

            $count_kelas_bersemuka = DB::table('users')
                            ->count();

            $bersemuka = DB::table('kelas as k')
                                ->select('j.idno','j.kelas_id','j.title','j.type','j.hari','j.date','j.time','j.timer','j.adduser','j.adddate','j.upduser','j.upddate','k.name')
                                ->where('bersemuka','1')
                                ->leftJoin('jadual as j', function($join) use ($request){
                                        $join = $join->on('k.idno', '=', 'j.kelas_id');
                                })
                                ->first();

            $today_day = Carbon::now("Asia/Kuala_Lumpur")->format('l');
            if($today_day == $bersemuka->hari){
                $date_bersemuka = Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d');
            }else{
                $date_bersemuka = Carbon::parse("next ".$bersemuka->hari)->format('Y-m-d');
            }

            $bersemuka->date = $date_bersemuka;

            $kd_bersemuka = DB::table('kelas_detail')
                            ->where('kelas_id',$bersemuka->kelas_id)
                            ->where('user_id',Auth::user()->id)
                            ->where('jadual_id',$bersemuka->idno)
                            ->where('type','weekly')
                            ->where('date',$date_bersemuka)
                            ->where('time',$bersemuka->time)
                            ->orderBy('date', 'asc');

            if($kd_bersemuka->exists()){
                $kd_bersemuka = $kd_bersemuka->first();
            }else{
                $kd_bersemuka = null;
            }

            $user_bersemuka = DB::table('kelas_detail as kd')
                        ->select('kd.idno','kd.kelas_id','u.id as user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.alasan','kd.surah2','kd.ms2','kd.marked','u.name')
                        ->leftJoin('users as u', function($join) use ($request){
                                $join = $join->on('u.id', '=', 'kd.user_id');
                        })
                        ->where('kd.kelas_id',$bersemuka->kelas_id)
                        ->where('kd.jadual_id',$bersemuka->idno)
                        ->where('kd.type','weekly')
                        ->where('kd.date',$date_bersemuka)
                        ->where('kd.time',$bersemuka->time)
                        ->orderBy('kd.pos', 'asc')
                        ->get();

        if($kelas_id == 0){
            return view('dashboard',compact('user_detail','count_kelas_bersemuka','bersemuka','kd_bersemuka','user_bersemuka','kelas_id'));
        }

        return view('dashboard',compact('user_detail','kd_b4','date_b4','user_kdb4','kd_after','date_after','jadual','count_kelas','count_kelas_bersemuka','user_kd','bersemuka','kd_bersemuka','user_bersemuka','kelas_id'));
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