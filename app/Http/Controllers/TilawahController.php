<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Auth;
use DateTimeZone;

class TilawahController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tilawah(Request $request){
        return view('tilawah');
    }

    public function tilawah_detail(Request $request){

        $effdate = DB::table('tilawah')
                    ->whereNotNull('effectivedate');

        if($effdate->exists()){
            $effdate = Carbon::parse($effdate->first()->effectivedate);
            $currdate = $request->date;

            $effdate = $effdate->is('Sunday') ? $effdate : $effdate->next('Sunday');
            $diffinweeks = $effdate->diffInWeeks($currdate);

            if($effdate->gt($currdate)){
                $tilawah_dtl=[];
                $ispast = 'true';
                $my_dtl = new stdClass();
                $my_dtl->got = 'false';

                $tilawah_detail = DB::table('tilawah_detail as td')
                                        ->select('td.idno','td.giliran','td.user_id','td.ms1','td.ms2','td.date','u.username','u.name','u.kelas','k.name as kelas_name')
                                        ->leftJoin('users as u', function($join) use ($request){
                                            $join = $join->on('u.id', '=', 'td.user_id');
                                        })
                                        ->leftJoin('kelas as k', function($join) use ($request){
                                            $join = $join->on('k.idno', '=', 'u.kelas');
                                        })
                                        ->where('td.date',$currdate)
                                        ->orderBy('td.giliran','asc')
                                        ->get();

                foreach ($tilawah as $key => $value) {
                    $obj = new stdClass();
                    $obj->giliran = $key;
                    $obj->user_id = $value->user_id;
                    $obj->username = $value->username;
                    $obj->name = $value->name;
                    $obj->kelas = $value->kelas;
                    $obj->kelas_name = $value->kelas_name;
                    $obj->ms1 = $value->ms1;
                    $obj->ms2 = $value->ms2;
                    $obj->date = $value->date;
                }

            }else{
                $tilawah_dtl=[];
                $ispast = 'false';
                $my_dtl = new stdClass();
                $my_dtl->got = 'false';

                $tilawah_c = DB::table('tilawah')
                            ->count();

                $tilawah = DB::table('tilawah')
                            ->orderBy('giliran','asc')
                            ->get();

                foreach ($tilawah as $key => $value) {
                    $obj = new stdClass();
                    $obj->giliran = $key;

                    array_push($tilawah_dtl, $obj);
                }

                foreach ($tilawah as $key => $value) {
                    $my_giliran = intval($key + $diffinweeks)%intval($tilawah_c);

                    $tilawah_detail = DB::table('tilawah_detail')
                                        ->where('giliran',$my_giliran)
                                        ->where('user_id',$value->user_id)
                                        ->where('date',$currdate)
                                        ->where('ms1',$value->ms1)
                                        ->where('ms2',$value->ms2);

                    $user =  DB::table('users as u')
                                    ->select('u.username','u.name','u.kelas','k.name as kelas_name')
                                    ->leftJoin('kelas as k', function($join) use ($request){
                                        $join = $join->on('k.idno', '=', 'u.kelas');
                                    })
                                    ->where('id',$value->user_id)
                                    ->first();

                    if($value->user_id == Auth::user()->id){
                        $my_dtl->giliran = $my_giliran;
                        $my_dtl->user_id = $value->user_id;
                        $my_dtl->ms1 = $value->ms1;
                        $my_dtl->ms2 = $value->ms2;
                        $my_dtl->date = $currdate;
                        $my_dtl->got = 'true';
                    }

                    $tilawah_dtl[$my_giliran]->user_id = $value->user_id;
                    $tilawah_dtl[$my_giliran]->username = $user->username;
                    $tilawah_dtl[$my_giliran]->name = $user->name;
                    $tilawah_dtl[$my_giliran]->kelas = $user->kelas;
                    $tilawah_dtl[$my_giliran]->kelas_name = $user->kelas_name;
                    $tilawah_dtl[$my_giliran]->ms1 = $value->ms1;
                    $tilawah_dtl[$my_giliran]->ms2 = $value->ms2;
                    $tilawah_dtl[$my_giliran]->date = $currdate;

                    if($tilawah_detail->exists()){

                        $tilawah_dtl[$my_giliran]->done = 'true';
                    }else{
                        $tilawah_dtl[$my_giliran]->done = 'false';
                    }                    
                }
            }
        }else{
            dd('Error: no effective date..');
        }

        return view('tilawah_detail',compact('tilawah_dtl','ispast','my_dtl'));
    }

    public function table(Request $request){
        switch($request->action){
            case 'fcgettilawah':
                $this->fcgettilawah($request);
                break;
            default:
                return 'error happen..';
        }
    }


    public function form(Request $request){
        switch($request->action){
            case 'tilawah_dtl_save':
                $this->tilawah_dtl_save($request);
                break;
            default:
                return 'error happen..';
        }
    }

    public function fcgettilawah(Request $request){
        $weekday = [];
        $loopdate = Carbon::parse($request->start);
        $until = Carbon::parse($request->end);

        if(!empty(Auth::user()->kelas)){
            // $mykelas = Auth::user()->kelas;

            // $jadual = DB::table('jadual')
            //         ->where('type','weekly')
            //         ->where('kelas_id',$mykelas)
            //         ->first();

            while ($loopdate->lte($until)) {


                $loopdate = $loopdate->next('SUNDAY');

                $responce = new stdClass();
                $responce->date = $loopdate->format('Y-m-d');
                $responce->title = 'Tilawah no ';
                $responce->url = './tilawah_detail';

                // $kelas_detail = DB::table('kelas_detail')
                //         ->where('kelas_id',$mykelas)
                //         ->where('user_id', '=', Auth::user()->id)
                //         ->where('jadual_id',$jadual->idno)
                //         ->where('type','weekly')
                //         ->whereDate('date','=',$loopdate->format('Y-m-d'));

                // if($kelas_detail->exists()){
                //     $kelas_detail_first = $kelas_detail->first();
                //     $responce->status = $kelas_detail_first->status;
                // }

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

    public function tilawah_dtl_save(Request $request){
        DB::beginTransaction();
        try {
            if($request->oper == 'add'){
                DB::table('tilawah_detail')
                    ->insert([
                        'giliran' => $request->giliran,
                        'user_id' => $request->user_id,
                        'ms1' => $request->ms1,
                        'ms2' => $request->ms2,
                        'date' => $request->date,
                        'adduser' => session('username'),
                        'adddate' => Carbon::now("Asia/Kuala_Lumpur")
                    ]);
            }else if($request->oper == 'del'){
                DB::table('tilawah_detail')
                    ->where('giliran',$request->giliran)
                    ->where('user_id',$request->user_id)
                    ->where('date',$request->date)
                    ->where('ms1',$request->ms1)
                    ->where('ms2',$request->ms2)
                    ->delete();
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


}