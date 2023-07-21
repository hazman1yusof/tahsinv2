<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;
use DateTimeZone;

class kelasController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function kelas(Request $request){
        return view('kelas');
    }

    public function kelas_detail(Request $request){
        
        $iskelasbersemuka = $this->iskelasbersemuka($request);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $request->date.' '.$request->time, new DateTimeZone('Asia/Kuala_Lumpur'));
        $kelas_detail=null;

        $kelas_detail_ = DB::table('kelas_detail')
                        ->where('kelas_id',$request->kelas_id)
                        ->where('user_id',$request->user_id)
                        ->where('jadual_id',$request->jadual_id)
                        ->where('type',$request->type)
                        ->where('date',$request->date)
                        ->where('time',$request->time);

        if($kelas_detail_->exists()){
            $kelas_detail = $kelas_detail_->first();
        }

        $jadual = DB::table('jadual as j')
                    ->select('j.idno','j.kelas_id','j.title','j.type','j.hari','j.date','j.time','k.name')
                    ->leftJoin('kelas as k', function($join) use ($request){
                            $join = $join->on('k.idno', '=', 'j.kelas_id');
                    })
                    ->where('j.idno',$request->jadual_id)
                    ->first();


        if($iskelasbersemuka){
            $count_kelas = DB::table('users')
                            ->count();
        }else{
            $count_kelas = DB::table('users')
                            ->where('kelas',$request->kelas_id)
                            ->count();
        }

        // $user_kd = DB::table('kelas_detail as kd')
        //                 ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.surah2','kd.ms2','kd.marked','u.name')
        //                 ->leftJoin('users as u', function($join) use ($request){
        //                         $join = $join->on('u.id', '=', 'kd.user_id');
        //                 })
        //                 ->where('kd.kelas_id',$request->kelas_id)
        //                 ->where('kd.jadual_id',$request->jadual_id)
        //                 ->where('kd.type',$request->type)
        //                 ->where('kd.date',$request->date)
        //                 ->where('kd.time',$request->time)
        //                 ->orderBy('kd.pos', 'asc')
        //                 ->get();


        $user_kd = DB::table('users as u')
                    ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.alasan','kd.surah2','kd.ms2','kd.marked','u.name')
                    ->leftJoin('kelas_detail as kd', function($join) use ($request){
                            $join = $join->on('u.id', '=', 'kd.user_id')
                                        ->where('kd.kelas_id',$request->kelas_id)
                                        ->where('kd.jadual_id',$request->jadual_id)
                                        ->where('kd.type',$request->type)
                                        ->where('kd.date',$request->date)
                                        ->where('kd.time',$request->time);
                    });
                    if(!$iskelasbersemuka){
                        $user_kd = $user_kd->where('u.kelas',$request->kelas_id);
                    }
                    $user_kd = $user_kd->orderBy('kd.pos', 'asc')->get();

        if($date->isPast()){
            $ispast=true;
        }else{
            $ispast=false;
        }

        return view('kelas_detail',compact('ispast','kelas_detail','jadual','date','count_kelas','user_kd','iskelasbersemuka'));
    }

    public function table(Request $request){
        switch($request->action){
            case 'fcgetkelas':
                $this->fcgetkelas($request);
                break;
            case 'fcgetkelas_weekly':
                $this->fcgetkelas_weekly($request);
                break;
            case 'fcgetkelas_bersemuka':
                $this->fcgetkelas_bersemuka($request);
                break;
            default:
                return 'error happen..';
        }
    }


    public function form(Request $request){
        switch($request->action){
            case 'confirm_kelas':
                $this->confirm_kelas($request);
                break;
            default:
                return 'error happen..';
        }
    }

    public function fcgetkelas(Request $request){

        $return = [];
        if(!empty(Auth::user()->kelas)){
            $mykelas = Auth::user()->kelas;
            $jadual = DB::table('jadual as j')
                        ->select('j.idno','j.kelas_id','j.title','j.type','j.hari','j.date','j.time','kd.status')
                        ->leftJoin('kelas_detail as kd', function($join) use ($request){
                            $join = $join->on('kd.kelas_id', '=', 'j.kelas_id')
                                        ->where('kd.user_id', '=', Auth::user()->id)
                                        ->on('kd.jadual_id', '=', 'j.idno')
                                        ->on('kd.type', '=', 'j.type')
                                        ->on('kd.date', '=', 'j.date')
                                        ->on('kd.time', '=', 'j.time');
                        })
                        ->whereDate('j.date','>=',$request->start)
                        ->whereDate('j.date','<=',$request->end)
                        ->where('j.type','date')
                        ->where('j.kelas_id',$mykelas);

            $return = $jadual->get();

            foreach ($return as $key => $value) {
                $url = './kelas_detail?kelas_id='.$value->kelas_id.'&user_id='.Auth::user()->id.'&jadual_id='.$value->idno.'&type='.$value->type.'&time='.$value->time;
                $value->url = $url;
            }

        }

        echo $return;

    }

    public function fcgetkelas_weekly(Request $request){
        $weekday = [];
        $loopdate = Carbon::parse($request->start);
        $until = Carbon::parse($request->end);

        if(!empty(Auth::user()->kelas)){
            $mykelas = Auth::user()->kelas;

            $jadual = DB::table('jadual')
                    ->where('type','weekly')
                    ->where('kelas_id',$mykelas)
                    ->first();

            while ($loopdate->lte($until)) {


                $loopdate = $loopdate->next($jadual->hari);

                $responce = new stdClass();
                $responce->date = $loopdate->format('Y-m-d');
                $responce->time = $jadual->time;
                $responce->title = $jadual->title;
                $responce->url = './kelas_detail?kelas_id='.$mykelas.'&user_id='.Auth::user()->id.'&jadual_id='.$jadual->idno.'&type='.$jadual->type.'&time='.$jadual->time;

                $kelas_detail = DB::table('kelas_detail')
                        ->where('kelas_id',$mykelas)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('jadual_id',$jadual->idno)
                        ->where('type','weekly')
                        ->whereDate('date','=',$loopdate->format('Y-m-d'));

                if($kelas_detail->exists()){
                    $kelas_detail_first = $kelas_detail->first();
                    $responce->status = $kelas_detail_first->status;
                }

                array_push($weekday, $responce);
            }

        }
        echo json_encode($weekday);

    }

    public function fcgetkelas_bersemuka(Request $request){
        $weekday = [];
        $loopdate = Carbon::parse($request->start);
        $until = Carbon::parse($request->end);

        if(!empty(Auth::user()->kelas)){

            $jadual = DB::table('jadual')
                    ->where('type','weekly')
                    ->where('kelas_id',2)//idno 2 utk bersemuka
                    ->first();

            while ($loopdate->lte($until)) {

                $loopdate = $loopdate->next($jadual->hari);

                $responce = new stdClass();
                $responce->date = $loopdate->format('Y-m-d');
                $responce->time = $jadual->time;
                $responce->title = $jadual->title;
                $responce->url = './kelas_detail?kelas_id='.'2'.'&user_id='.Auth::user()->id.'&jadual_id='.$jadual->idno.'&type='.$jadual->type.'&time='.$jadual->time;

                $kelas_detail = DB::table('kelas_detail')
                        ->where('kelas_id',2)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('jadual_id',$jadual->idno)
                        ->where('type','weekly')
                        ->whereDate('date','=',$loopdate->format('Y-m-d'));

                if($kelas_detail->exists()){
                    $kelas_detail_first = $kelas_detail->first();
                    $responce->status = $kelas_detail_first->status;
                }

                array_push($weekday, $responce);
            }

        }
        echo json_encode($weekday);

    }

    public function confirm_kelas(Request $request){
        DB::beginTransaction();
        try {

            //tgk pos dah ada org amik
            $chk_pos = DB::table('kelas_detail')
                        ->where('kelas_id',$request->kelas_id)
                        ->where('user_id','!=',$request->user_id)
                        ->where('jadual_id',$request->jadual_id)
                        ->where('type',$request->type)
                        ->where('date',$request->date)
                        ->where('time',$request->time)
                        ->where('pos',$request->pos);

            if($chk_pos->exists()){
                throw new \Exception("Giliran yang anda pilih sudah penuh",500);
            }
            
            $kelas_detail = DB::table('kelas_detail')
                                ->where('kelas_id',$request->kelas_id)
                                ->where('user_id',$request->user_id)
                                ->where('jadual_id',$request->jadual_id)
                                ->where('type',$request->type)
                                ->where('date',$request->date)
                                ->where('time',$request->time);

            if($request->status == 'Tidak Hadir'){
                $pos = 0;
            }else{
                $pos = $request->pos;
            }

            if($kelas_detail->exists()){
                    DB::table('kelas_detail')
                        ->where('kelas_id',$request->kelas_id)
                        ->where('user_id',$request->user_id)
                        ->where('jadual_id',$request->jadual_id)
                        ->where('type',$request->type)
                        ->where('date',$request->date)
                        ->where('time',$request->time)
                        ->update([
                            'status' => $request->status,
                            'alasan' => $request->alasan,
                            'pos' => $pos,
                            'surah' => $request->surah,
                            'ms' => $request->ms
                        ]);
            }else{
                DB::table('kelas_detail')
                    ->insert([
                        'kelas_id' => $request->kelas_id,
                        'user_id' => $request->user_id,
                        'jadual_id' => $request->jadual_id,
                        'type' => $request->type,
                        'date' => $request->date,
                        'time' => $request->time,
                        'surah' => $request->surah,
                        'ms' => $request->ms,
                        'status' =>  $request->status,
                        'pos' => $pos,
                        'alasan' => $request->alasan,
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'adduser' => session('username')
                    ]);
            }
            

            DB::commit();
            
            $responce = new stdClass();
            $responce->operation = 'SUCCESS';
            echo json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();


            $responce = new stdClass();
            $responce->operation = 'FAILURE';
            $responce->msg = $e->getMessage();
            echo json_encode($responce);

        }

    }

    public function iskelasbersemuka(Request $request){
        $kelas = DB::table('kelas')
                    ->where('idno',$request->kelas_id)
                    ->where('bersemuka','1');

        return $kelas->exists();
    }


}