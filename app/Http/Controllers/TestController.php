<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Schema;
use App\Exports\AllExport;
use App\Models\store_views;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\DatabaseConnection;
use Session;
use DB;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $session_value = session('dbdetails');
        $connection = DatabaseConnection::setConnection($session_value);
        if ($request->ajax()) {           
            $data = $connection->table('store_views')->get();            
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
   
    public function displayTables($name)
    {
        if ($name) {
            $tblGetHeads = Schema::getColumnListing($name);
            $data = DB::table($name)->get();
            $datatable =  Datatables::of($data);
            foreach($tblGetHeads as $tblGetHead){
                $datatable->addColumn($tblGetHead, function($jsonObject){
                    return $jsonObject;
                });
            }
            return $datatable->make(true);
        }
    }
    public function export($name) 
    {
        $session_value = session('dbdetails');
        $connection = DatabaseConnection::setConnection($session_value);
        $ex_details = $connection->table($name)->get();
        //dd( $ex_details);
        if($ex_details->isEmpty()){
            return redirect('/')->with('msg', 'Table is empty');
        }else{
            return Excel::download(new AllExport($name), $name.'.xlsx');
        }
        
    }    
    // for check view name
    public function checkViewName(Request $request){
        $view_name = $request['title'];
        $session_value = session('dbdetails');
        $connection = DatabaseConnection::setConnection($session_value);
        $viewTbl = $connection->table('store_views')->where('name', $view_name)->exists();
        if($viewTbl){
            return true;
        }else{
            return false;
        }exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $session_value = session('dbdetails');
       $connection = DatabaseConnection::setConnection($session_value);
       $qry = $request['qgroup'];
       $table_name = $request['title'];
       //if (Schema::$connection->hasTable($table_name)) {        
        $connection->statement('DROP VIEW if exists '.$table_name);
       //}       
       $view_created = $connection->statement('CREATE VIEW '.$table_name.' AS '.$qry);       
       $val['name'] = $table_name;
       $val['view_table_name'] = $qry;
       $view_insert = $connection->table('store_views')->insert($val);
       $details = $connection->table($table_name)->get();
       echo json_encode($details); exit;
    }
    public function getViewTables($name)
    {
        $tblGetHead = Schema::getColumnListing($name);
        $details = DB::table($name)->get();
        $viewRender = view('viewTable', ['header' => $tblGetHead, 'details' => $details, 'name' => $name])->render();
        return response()->json(array('success' => true, 'header' => $tblGetHead, 'html'=>$viewRender));
    }   
}
