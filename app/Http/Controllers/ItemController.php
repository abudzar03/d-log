<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Item;
use App\Propinsi;
use App\Kabupaten;
use DB;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('item.index');
    }

    public function load()
    {
    	$items = \Auth::user()->items;
    	return Datatables::of($items)->make(true);
    }

    public function new()
    {
    	return view('item.form', ['status' => 0]);
    }

    public function save(Request $request)
    {
    	$userPerusahaan = \Auth::user();
		$item = new Item;
    	$this->validate($request, [
    		'name' => 'required',
    		'price' => 'required',
    		'amount' => 'required'
    	]);
    	$item->name = $request->input('name');
    	$item->price = $request->input('price');
    	$item->amount = $request->input('amount');
    	$userPerusahaan->items()->save($item);
    	return redirect()->route('item.index');
    }

    public function addForm($id)
    {
    	return view('item.form', ['id' => $id, 'status' => 1]);
    }

    public function add(Request $request, $id)
    {
    	$item = Item::find($id);
    	$item->amount = $item->amount + $request->input('amount');
    	$item->save();
    	return redirect()->route('item.index');
    }

    public function changepriceForm($id)
    {
    	return view('item.form', ['id' => $id, 'status' => 2]);
    }

    public function changeprice(Request $request, $id)
    {
    	$item = Item::find($id);
    	$item->price = $request->input('price');
    	$item->save();
    	return redirect()->route('item.index');
    }

    public function distributeForm($id)
    {
    	$propinsis = Propinsi::all();
    	return view('item.form', ['id' => $id, 'status' => 3, 'propinsis' => $propinsis]);
    }
    
    public function getKabupaten($id)
    {
        $kabupatens = Propinsi::find($id)->kabupatens()->get();
        return $kabupatens;
    }

    public function takeForm($id)
    {
        $propinsis = Propinsi::all();
        return view('item.form', ['id' => $id, 'status' => 4, 'propinsis' => $propinsis]);
    }
}
