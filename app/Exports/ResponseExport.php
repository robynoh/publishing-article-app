<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use DB;

class ResponseExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return  $records= DB::table('form_'.auth()->user()->id.'_store')->get(); 
    }

    public function headings(): array
    {
        return [
            'Category',
            'Title',
            'Department'
        // etc


        ];
    }

}
