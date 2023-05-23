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

    public function show(Request $request){
        $year = date_create('today')->format('Y');

        $UTAMA = DB::table('rph.subjek_detail')
                        ->where('subjek','MATEMATIK')
                        ->where('type','UTAMA')
                        ->get();

        $SUBTOPIK = DB::table('rph.subjek_detail')
                        ->where('subjek','MATEMATIK')
                        ->where('type','SUBTOPIK')
                        ->get();

        $OBJEKTIF = DB::table('rph.subjek_detail')
                        ->where('subjek','MATEMATIK')
                        ->where('type','OBJEKTIF')
                        ->get();

        return view('rph',compact('year','UTAMA','SUBTOPIK','OBJEKTIF'));
    }


}