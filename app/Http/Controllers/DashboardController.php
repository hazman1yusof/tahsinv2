<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{   

    public function __construct()
    {

    }

    public function dashboard(Request $request){

        return view('dashboard');
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