<?php

namespace App\Imports;

use App\Models\Test;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;

class TestImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Test([
            'X' => $row[0],
            'Y' => $row[1]
        ]);
    }
}
