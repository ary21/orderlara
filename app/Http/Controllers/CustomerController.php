<?php

namespace OrderLara\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

use OrderLara\Customer;
use OrderLara\City;

class CustomerController extends Controller
{
    protected $rules = [
        'nama' => 'required',
        'telp' => 'required',
        'umur' => 'required',
        'id_city' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = DB::table('customers')
        ->leftjoin('citys', 'citys.id', '=', 'customers.id_city')
        ->orderBy('customers.id', 'desc')
        ->select('customers.*', 'citys.city')
        ->paginate(5);

        return view('customer.data', ['customers' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = City::all();

        return view('customer.form', ['citys' => $city]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $store = new Customer();
        $store->nama = $request->nama;
        $store->telp = $request->telp;
        $store->alamat = $request->alamat;
        $store->umur = $request->umur;
        $store->id_city = $request->id_city;
        $store->save();

        return response()->json($store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::find($id);
        $city = City::all();

        return view('customer.form', ['data' => $data, 'citys' => $city]);
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
        $this->validate($request, $this->rules);

        $update = new Customer();
        $update = $update->find($id);

        $update->nama = $request->nama;
        $update->telp = $request->telp;
        $update->alamat = $request->alamat;
        $update->umur = $request->umur;
        $update->id_city = $request->id_city;
        $update->save();

        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::find($id);
        $data->delete();

        return redirect(url('customers'));
    }
}
