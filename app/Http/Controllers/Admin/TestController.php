<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TestExport;
use App\Http\Controllers\Controller;
use App\Imports\TestImport;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test = Test::orderBy('id', 'desc')->paginate(10);
        return view('backend.test.index', compact('test'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function import(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'file' => 'required|mimes:xlsx|file'
            ]);

            $data = $request->all();

            $file = $data['file'];
            $new_file = $file->getClientOriginalName();
            $path = $file->storeAs('public/assets/import', $new_file);



            Excel::import(new TestImport, storage_path('app/public/assets/import/'.$new_file));

            Storage::delete($path);
            Alert::success('Notification', 'Data Berhasil Di Import');

            return back();


        }
    }

    public function test_predict(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'x' => 'integer'
            ]);
            $data = $request->all();

            $test = Test::get()->toArray();
            $n = Test::get()->count();
            $xy = [];
            $x2 = [];
            $y2 =[];
            $sumX = 0;
            $sumY = 0;

            foreach ($test as $k) {
            array_push($xy, $k['X'] * $k['Y']);
            array_push($x2, pow($k['X'], 2));
            array_push($y2, pow($k['Y'], 2));

            $sumX+=$k['X'];
            $sumY+=$k['Y'];



            }
            $sumxy = array_sum($xy);
            $sumx2 = array_sum($x2);
            $sumy2 = array_sum($y2);

            // rumus  => y = a +bx

            $a = (($sumY*$sumx2) - ($sumX*$sumxy)) / (($n*$sumx2) - (pow($sumX, 2)));
            $b = (($n*$sumxy) - ($sumX*$sumY)) / (($n*$sumx2) - (pow($sumX, 2)));

            //Uji Anova
            $JKT = $sumy2 - ((pow($sumY, 2)) / $n);
            $JKR = $b*($sumxy - (($sumX*$sumY) / $n));
            $JKG = $JKT - $JKR;
            $dbT = $n - 1;

            //$dbR = jumlah variable preditor (Field X saja dalam database)
            $dbR = 1;

            $dbG = $dbT - $dbR;

            // dd($x2);
            $y = $a + ($b*$data['x']);
            Session::flash('hasil', $y);
            return back();

        }
    }

    public function export_test()
    {
        return Excel::download(new TestExport, 'test.xlsx');
    }
}
