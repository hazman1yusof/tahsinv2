<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;
use DateTimeZone;

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

        $date = Carbon::createFromFormat('Y-m-d', $request->date, new DateTimeZone('Asia/Kuala_Lumpur'));
        
        $jadual = DB::table('jadual as j')
                    ->select('j.idno','j.kelas_id','j.title','j.type','j.hari','j.date','j.time','k.name')
                    ->leftJoin('kelas as k', function($join) use ($request){
                            $join = $join->on('k.idno', '=', 'j.kelas_id');
                    })
                    ->where('j.idno',$request->jadual_id)
                    ->first();

        $user_kd = DB::table('kelas_detail as kd')
                        ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.surah2','kd.ms2','kd.marked','u.name')
                        ->leftJoin('users as u', function($join) use ($request){
                                $join = $join->on('u.id', '=', 'kd.user_id');
                        })
                        ->where('kd.kelas_id',$request->kelas_id)
                        ->where('kd.jadual_id',$request->jadual_id)
                        ->where('kd.type',$jadual->type)
                        ->where('kd.date',$request->date)
                        ->where('kd.time',$jadual->time)
                        ->orderBy('kd.pos', 'asc')
                        ->get();

        if($date->addDays(1)->isPast()){
            $ispast=true;
        }else{
            $ispast=false;
        }

        return view('pengajar_detail',compact('ispast','jadual','date','user_kd'));
    }

    public function mark(Request $request){

        $user_kd = DB::table('kelas_detail as kd')
                        ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.status','kd.pos','kd.adddate','kd.adduser','kd.upddate','kd.upduser','kd.surah','kd.ms','kd.remark','kd.rating','kd.surah2','kd.ms2','u.name')
                        ->leftJoin('users as u', function($join) use ($request){
                                $join = $join->on('u.id', '=', 'kd.user_id');
                        })
                        ->where('kd.idno',$request->id)
                        ->first();

        return view('mark',compact('user_kd'));
    }

    public function table(Request $request){
        switch($request->action){
            case 'fcgetkelas':
                $this->fcgetkelas($request);
                break;
            case 'fcgetkelas_weekly':
                $this->fcgetkelas_weekly($request);
                break;
            case 'getkelasdetail':
                $this->getkelasdetail($request);
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
            case 'save_kelas_detail':
                $this->save_kelas_detail($request);
                break;
            case 'mark_kd':
                $this->mark_kd($request);
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

    public function getkelasdetail(Request $request){
         $kelas_detail = DB::table('kelas_detail as kd')
                            ->select('kd.idno','kd.kelas_id','kd.user_id','kd.jadual_id','kd.type','kd.date','kd.time','kd.adddate','kd.adduser','kd.surah','kd.ms','kd.remark','kd.status','u.name')
                            ->leftJoin('users as u', function($join) use ($request){
                                $join = $join->on('u.id', '=', 'kd.user_id');
                            })
                            ->where('kd.kelas_id',$request->kelas_id)
                            ->where('kd.jadual_id',$request->jadual_id)
                            ->where('kd.type',$request->type)
                            ->where('kd.date',$request->date)
                            ->where('kd.time',$request->time)
                            ->where('kd.status','confirm')
                            ->get();

        $responce = new stdClass();
        $responce->data = $kelas_detail;

        echo json_encode($responce);

    }

    public function mark_kd(Request $request){
        DB::beginTransaction();
        try {
            
            $kelas_detail = DB::table('kelas_detail')
                                ->where('idno',$request->idno);

            if($kelas_detail->exists()){
                DB::table('kelas_detail')
                    ->where('idno',$request->idno)
                    ->update([
                        'remark' => $request->remark,
                        'rating' => $request->rating,
                        'ms2' => $request->ms2,
                        'surah2' => $request->surah2,
                        'marked' => 1,
                    ]);
            }else{
                dd('x ada');
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
                $responce->url = './pengajar_detail?kelas_id='.'2'.'&jadual_id='.$jadual->idno;

                array_push($weekday, $responce);
            }

        }
        echo json_encode($weekday);

    }


}