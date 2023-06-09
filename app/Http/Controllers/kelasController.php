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

        return view('kelas',compact('jadual'));
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
                    ->where('time',$request->time);

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
            $oper='view';
        }

        return view('kelas_detail',compact('oper','kelas_detail','kelas','jadual','date'));
    }

    public function table(Request $request){
        switch($request->action){
            case 'fcgetkelas':
                $this->fcgetkelas($request);
                break;
            default:
                return 'error happen..';
        }
    }


    public function form(Request $request){
        switch($request->action){
            case 'save_userxx':
                $this->save_user($request);
                break;
            default:
                return 'error happen..';
        }
    }

    public function fcgetkelas(Request $request){

        $return = [];
        if(!empty(Auth::user()->kelas)){
            $mykelas = Auth::user()->kelas;
            $jadual = DB::table('jadual')
                        ->whereDate('date','>=',$request->start)
                        ->whereDate('date','<=',$request->end)
                        ->where('type','date')
                        ->where('kelas_id',$mykelas);

            $return = $jadual->get();

            foreach ($return as $key => $value) {
                $url = './kelas_detail?kelas_id='.$value->kelas_id.'&user_id='.Auth::user()->id.'&jadual_id='.$value->idno.'&type='.$value->type.'&time='.$value->time;
                $value->url = $url;
            }

        }

        echo $return;

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