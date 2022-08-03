<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Schema;
use App\Helpers\DatabaseConnection;
use Session;

class AllExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $name){
        $this->name = $name;
    }
    public function collection()
    {
        $session_value = session('dbdetails');
        $connection = DatabaseConnection::setConnection($session_value);
        $ex_details = $connection->table($this->name)->get();
        if(!empty($ex_details)){
            return $ex_details;
        }        
    }
    public function headings(): array
    {
        $session_value = session('dbdetails');
        $connection = DatabaseConnection::setConnection($session_value);
        $viewDb = $connection->table($this->name)->get()->first();
        if(!empty($viewDb)){
            $viewDb = json_decode(json_encode($viewDb),true);
            $headers = array_keys($viewDb);
            return $headers;
        }else{
            return [];
        }
    }
}
