<?php

namespace App\Http\Controllers;
use App\Helpers\DatabaseConnection;
use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Session;

class SelectionContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dbselection');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $params['driver'] = $request['driver'];
        $params['host'] = $request['dbhost'];
        if($request['driver'] == 'sqlite'){
            $params['dbname'] = $request['dbname']; 
        }else{ 
            $params['dbname'] = $request['dbname']; 
            $params['username'] = $request['username'];
            $params['password'] = $request['password'];
        }
       
        if($request['dbport']){ $params['port'] = $request['dbport']; } 
        try{
            $connection = DatabaseConnection::setConnection($params);
            //dd($connection);
            $table_name = $request['dbtable'];
            $users =  $connection->table($table_name)->get();        
            try {
                $users =  $connection->table($table_name)->get();
                try{
                    $store_views =  $connection->table('store_views')->get();
                    session(['dbdetails' => $params]);
                    return redirect('/');
                }catch(Exception $e){                
                    return redirect()->back()->with('msg' , 'store_views table is missing! Please add table with name "store_views" and columns are (id, name, view_table_name, created_at, updated_at)');
                }
            } catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
            } catch (QueryException $e) {
            return redirect()->back()->with('msg', $e->getMessage());
            }
        }catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
        } 
    }
    public function expire()
    {
       session()->forget('dbdetails');
       return redirect('/selection');
    }  
}
