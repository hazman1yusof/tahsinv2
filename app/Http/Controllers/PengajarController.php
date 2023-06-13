<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;

class PengajarController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pengajar(Request $request){
        $jadual = null;
        if(!empty(Auth::user()->kelas)){
            $mykelas = Auth::user()->kelas;
            $jadual = DB::table('jadual')
                    ->where('type','weekly')
                    ->where('kelas_id',$mykelas);

            if($jadual->exists()){
                $jadual = $jadual->first();
            }

        }

        return view('pengajar',compact('jadual'));
    }

    public function pengajar_detail(Request $request){

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

        return view('pengajar_detail',compact('oper','ispast','kelas_detail','kelas','jadual','date'));
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

        $weekday = [];
        $loopdate = Carbon::parse($request->start);
        $until = Carbon::parse($request->end);

        $jadual = DB::table('jadual')
                ->where('type','date')
                ->whereDate('date','>=',$request->start)
                ->whereDate('date','<=',$request->end);

        $return = $jadual->get();

        foreach ($return as $key => $value) {
            $value->url = './pengajar_detail?kelas_id='.$value->kelas_id.'&jadual_id='.$value->idno;
        }

        echo $return;

    }

    public function fcgetkelas_weekly(Request $request){
        $weekday = [];
        $loopdate = Carbon::parse($request->start);
        $until = Carbon::parse($request->end);

        $jadual = DB::table('jadual')
                ->where('type','weekly')
                ->first();

        while ($loopdate->lte($until)) {


            $loopdate = $loopdate->next($jadual->hari);

            $responce = new stdClass();
            $responce->date = $loopdate->format('Y-m-d');
            $responce->time = $jadual->time;
            $responce->title = $jadual->title;
            $responce->url = './pengajar_detail?kelas_id='.$jadual->kelas_id.'&jadual_id='.$jadual->idno;

            array_push($weekday, $responce);
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