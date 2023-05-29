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

    }

    public function setup_user(Request $request){

        return view('setup_user');
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

        try {




            if($request->oper == 'add'){
                DB::table('users')
                    ->insert([
                        'username' => $request->year_id,
                        'password' => strtoupper($request->hari),
                        'kelas' => strtoupper($request->subjek),
                        'type' => strtoupper($request->kelas),
                        'ajar' => $request->masa_dari,
                        'setup' => $request->masa_hingga
                        // 'lastuser' => $request->masa_hingga,
                        // 'lastdate' => $request->masa_hingga
                    ]);
            }else if($request->oper == 'edit'){
                DB::table('users')
                    ->where('idno',$request->idno)
                    ->update([
                        'subjek' => strtoupper($request->subjek),
                        'kelas' => strtoupper($request->kelas),
                        'masa_dari' => $request->masa_dari,
                        'masa_hingga' => $request->masa_hingga
                    ]);
            }else if($request->oper == 'del'){
                DB::table('jadual')
                    ->where('idno',$request->idno)
                    ->delete();
            }

            DB::commit();
            
            $responce = new stdClass();
            $responce->operation = 'SUCCESS';
            return json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }

    }


}