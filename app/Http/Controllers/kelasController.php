<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;

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

        $date = Carbon::createFromFormat('Y-m-d', $request->date);
        $kelas_detail=null;

        $kelas_detail_ = DB::table('kelas_detail')
                    ->where('kelas_id',$request->kelas_id)
                    ->where('user_id',$request->user_id)
                    ->where('jadual_id',$request->jadual_id)
                    ->where('type',$request->type)
                    ->where('date',$request->date)
                    ->where('time',$request->time)
                    ->where('status','!=','cancel');

        $jadual = DB::table('jadual')
                    ->where('idno',$request->jadual_id)
                    ->first();

        $kelas = DB::table('kelas')
                    ->where('idno',$request->kelas_id)
                    ->first();

        if($kelas_detail_->exists()){
            $oper='edit';
            $kelas_detail = $kelas_detail_->first();
        }else{
            $oper='add';
        }

        if($date->isPast()){
            $ispast=true;
        }else{
            $ispast=false;
        }

        return view('kelas_detail',compact('oper','ispast','kelas_detail','kelas','jadual','date'));
    }

    public function table(Request $request){
        switch($request->action){
            case 'fcgetkelas':
                $this->fcgetkelas($request);
                break;
            case 'fcgetkelas_weekly':
                $this->fcgetkelas_weekly($request);
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

            // $return = $jadual->get();

            // foreach ($return as $key => $value) {
            //     $url = './kelas_detail?kelas_id='.$value->kelas_id.'&user_id='.Auth::user()->id.'&jadual_id='.$value->idno.'&type='.$value->type.'&time='.$value->time;
            //     $value->url = $url;
            // }

        }
        echo json_encode($weekday);

    }

    public function confirm_kelas(Request $request){
        DB::beginTransaction();
        try {
            
            $kelas_detail = DB::table('kelas_detail')
                                ->where('kelas_id',$request->kelas_id)
                                ->where('user_id',$request->user_id)
                                ->where('jadual_id',$request->jadual_id)
                                ->where('type',$request->type)
                                ->where('date',$request->date)
                                ->where('time',$request->time);

            if($kelas_detail->exists()){
                if($request->status == 'cancel'){
                    DB::table('kelas_detail')
                        ->where('kelas_id',$request->kelas_id)
                        ->where('user_id',$request->user_id)
                        ->where('jadual_id',$request->jadual_id)
                        ->where('type',$request->type)
                        ->where('date',$request->date)
                        ->where('time',$request->time)
                        ->delete();
                }
            }else{
                DB::table('kelas_detail')
                    ->insert([
                        'kelas_id' => $request->kelas_id,
                        'user_id' => $request->user_id,
                        'jadual_id' => $request->jadual_id,
                        'type' => $request->type,
                        'date' => $request->date,
                        'time' => $request->time,
                        'status' => 'confirm',
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

            return response($e->getMessage(), 500);
        }

    }


}