<?php 
namespace App\Helpers;
use Config;
use DB;
use Session;

class DatabaseConnection
{
    public static function setConnection($params)
    {       
        //DB::disconnect(env("DB_CONNECTION"));
        DB::purge($params['driver']);
        if($params['driver'] == 'mysql'){            
            DB::purge($params['driver']);
            config(['database.connections.mysql' => [
                'driver' => $params['driver'],
                'host' => $params['host'],
                'database' => $params['dbname'],
                'username' => $params['username'],
                'password' => $params['password']
            ]]);
            return DB::reconnect('mysql');
        }else if($params['driver'] == 'sqlite'){
            DB::purge($params['driver']);
            config(['database.connections.sqlite' => [
                'driver' => $params['driver'],
                'database' => $params['dbname'],
            ]]);
            return DB::reconnect('sqlite');
        }else if($params['driver'] == 'pgsql'){       
            DB::purge($params['driver']);
            config(['database.connections.pgsql' => [
                'driver' => $params['driver'],
                'host' => $params['host'],
                'database' => $params['dbname'],
                'username' => $params['username'],
                'password' => $params['password']
            ]]);
            return DB::reconnect('pgsql');
        }
    }
}
?>