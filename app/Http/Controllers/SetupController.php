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
            case 'get_weeks':
                break;
            default:
                return 'error happen..';
        }
    }


    public function form(Request $request){
        switch($request->action){
            case 'save_jadual':
                break;
            default:
                return 'error happen..';
        }
    }


}