<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Regression\LeastSquares;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('tgl', 'desc')->paginate(10);
        return view('backend.product.index', compact('product'));
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

    public function import_product(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx|file'
            ]);

            $data = $request->all();

            $file = $data['file'];
            $new_file = $file->getClientOriginalName();
            $path = $file->storeAs('public/assets/import', $new_file);

            Excel::import(new ProductImport, storage_path('app/public/assets/import/'.$new_file));

            Storage::delete($path);

            return back();


        }
    }

    public function prediksi()
    {
        // $product = Product::get()->toArray();

        // $samples = [];
        // $targets = [];

        // foreach ($product as $key) {
        //     $name = $key['name'];
        //     $tgl = $key['tgl'];
        //     $data = [];

        //     array_push($data, $name, $tgl);
        //     array_push($samples, $data);

        //     $qty = $key['qty'];
        //     array_push($targets, $qty);

        // }

        // dd($targets);

        $samples = [['oke', '2020-16-01'], ['oke', '2020-15-01'], ['kamhe', '2020-16-01'], ['teja', '2020-14-01'], ['oke', '2020-15-02'], ['teka', '2020-15-03']];
        $labels = ['1', '5', '5', '2', '2', '3'];

        $classifier = new LeastSquares();
        $classifier->train($samples, $labels);
        echo $classifier->predict(["oke", "2020-07-14"]);


    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return back();
    }
}
