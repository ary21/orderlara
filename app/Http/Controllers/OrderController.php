<?php

namespace OrderLara\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

use OrderLara\Order;
use OrderLara\Customer;
use OrderLara\City;

class OrderController extends Controller
{
    protected $rules = [
        'code' => 'required',
        'date' => 'required',
        'id_customer' => 'required',
        'id_city' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        $data = DB::table('orders')
        ->leftjoin('customers', 'customers.id', '=', 'orders.id_customer')
        ->leftjoin('citys', 'citys.id', '=', 'customers.id_city')
        ->orderBy('orders.id', 'desc')
        ->select('orders.*', 'customers.nama', 'citys.city')
        ->paginate(5);

        return view('order.data', ['orders' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Customer::all();
        $city = City::all();

        return view('order.form', ['customers' => $customer, 'citys' => $city]);
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
        
        $store = new Order();
        $store->code        = $request->code;
        $store->date        = $request->date;
        $store->id_customer = $request->id_customer;
        $store->id_city     = $request->id_city;
        $store->totalqty    = $request->totalqty;
        $store->totalgrand  = $request->totalgrand;
        $store->items       = json_encode($request->items);
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
        $data = Order::find($id);
        $customer = Customer::all();
        $city = City::all();

        return view('order.form', ['data' => $data, 'customers' => $customer, 'citys' => $city]);
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

        $update = new Order();
        $update = $update->find($id);

        $update->code        = $request->code;
        $update->date        = $request->date;
        $update->id_customer = $request->id_customer;
        $update->id_city     = $request->id_city;
        $update->totalqty    = $request->totalqty;
        $update->totalgrand  = $request->totalgrand;
        $update->items       = json_encode($request->items);
        $update->save();

        return response()->json($update);
    }

    public function getcustomer($id)
    {
        $customer = Customer::find($id);
        $data = DB::table('orders')
        ->leftjoin('citys', 'citys.id', '=', 'customers.id_city')
        ->where('id', $id);

        return response()->json($customer);
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data = DB::table('orders')
        ->leftjoin('customers', 'customers.id', '=', 'orders.id_customer')
        ->leftjoin('citys', 'citys.id', '=', 'customers.id_city')
        ->where('orders.id', $id)
        ->select('orders.*', 'customers.nama', 'citys.city')
        ->get();

        return view('order.detail', ['data' => $data[0]]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Order::find($id);
        $data->delete();

        return redirect(url('orders'));
    }
}
