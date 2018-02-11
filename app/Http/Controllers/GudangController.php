<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Gudang;
use App\User;
use App\Item;
use DB;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('gudang.index', ['gudang' => \Auth::user()->gudang]);
    }

    public function load()
    {
    	$items = \Auth::user()->gudang->items;
    	return Datatables::of($items)->editColumn('amount', function($item) {
            return $item->pivot->amount;
        })->make(true);
    }

    public function distributeFind(Request $request)
    {
        $query = new User;
        $query = $query->join('gudangs', 'users.id','=','gudangs.user_gudang_id');
        $query = $query->select('gudangs.rating as rating','users.*');
        $query = $query->where('propinsi_id', '=', $request->propinsi_id);
        $query = $query->where('kabupaten_id', '=', $request->kabupaten_id);
        $query = $query->orderBy('rating','desc');
        $gudang = $query->first();
        return $gudang;
    }

    public function takeFind(Request $request, $id)
    {
        $query = new User;
        $query = $query->join('gudangs', 'users.id','=','gudangs.user_gudang_id');
        $query = $query->select('gudangs.rating as rating','users.*');
        $query = $query->where('propinsi_id', '=', $request->propinsi_id);
        $query = $query->where('kabupaten_id', '=', $request->kabupaten_id);
        $query = $query->orderBy('rating','desc');
        $gudangs = $query->get();
        for ($i = 0;$i < sizeof($gudangs);$i++) {
            $gudang = $gudangs[$i];
            $item = Item::where('id', '=', $id)->first();
            $userGudang = User::where('id', '=', $gudang->id)->first()->gudang;
            if ($userGudang->items->contains($item)) {
                return $gudang;
            }
        }
    }
}
