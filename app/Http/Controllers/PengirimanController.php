<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Item;
use App\Propinsi;
use App\Kabupaten;
use App\User;
use DB;
use DNS2D;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class PengirimanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('pengiriman.index');
    }

    public function loadPerusahaan()
    {
    	$pengirimans = DB::table('pengiriman')->join('users as perusahaan', 'pengiriman.user_perusahaan_id', '=', 'perusahaan.id')
    	->join('users as gudang', 'pengiriman.user_gudang_id', '=', 'gudang.id')
    	->join('items', 'pengiriman.item_id', '=', 'items.id')
    	->select('pengiriman.id as id', 'gudang.propinsi_id as gudang_propinsi_id', 'gudang.kabupaten_id as gudang_kabupaten_id', 'gudang.name as gudang_name', 'pengiriman.item_id as item_id', 'pengiriman.amount as amount', 'pengiriman.status as status')
    	->where('pengiriman.user_perusahaan_id', '=', \Auth::user()->id)
    	->get();
    	return Datatables::of($pengirimans)->editColumn('propinsi', function($pengiriman) {
    		$propinsi = Propinsi::where('id', '=', $pengiriman->gudang_propinsi_id)->first();
    		return $propinsi->name;
    	})->editColumn('kabupaten', function($pengiriman) {
    		$kabupaten = Kabupaten::where('id', '=', $pengiriman->gudang_kabupaten_id)->first();
    		return $kabupaten->name;
    	})->editColumn('item', function($pengiriman) {
    		$item = Item::where('id', '=',$pengiriman->item_id)->first();
    		return $item->name;
    	})->editColumn('status', function($pengiriman) {
    		if ($pengiriman->status == 0) {
    			return "Menunggu persetujuan";
    		}
    		else if ($pengiriman->status == 1) {
    			return "Disetujui";
    		}
    		else if ($pengiriman->status == 2) {
    			return "Dikirim ke gudang";
    		}
            else if ($pengiriman->status == 3) {
                return "Sampai di gudang";
            }
            else if ($pengiriman->status == 4) {
                return "Pengambilan";
            }
            else if ($pengiriman->status == 5) {
                return "Dikirim ke pelanggan";
            }
            else if ($pengiriman->status == 6) {
                return "Sampai ke pelanggan";
            }
    		else if ($pengiriman->status == 10) {
    			return "Ditolak";
    		}
    	})->addColumn('action', function($pengiriman) {
    		if ($pengiriman->status == 1) {
    			return "<button id='kirim-qrcode'>QR Code</button><button id='kirim'>Kirim</button>";
    		}
    	})->make(true);
    }

    public function loadGudang()
    {
    	$pengirimans = DB::table('pengiriman')->join('users as perusahaan', 'pengiriman.user_perusahaan_id', '=', 'perusahaan.id')
    	->join('users as gudang', 'pengiriman.user_gudang_id', '=', 'gudang.id')
    	->join('items', 'pengiriman.item_id', '=', 'items.id')
    	->select('pengiriman.id as id', 'perusahaan.propinsi_id as perusahaan_propinsi_id', 'perusahaan.kabupaten_id as perusahaan_kabupaten_id', 'perusahaan.name as perusahaan_name', 'pengiriman.item_id as item_id', 'pengiriman.amount as amount', 'pengiriman.status as status')
    	->where('pengiriman.user_gudang_id', '=', \Auth::user()->id)
    	->get();
    	return Datatables::of($pengirimans)->editColumn('propinsi', function($pengiriman) {
    		$propinsi = Propinsi::where('id', '=', $pengiriman->perusahaan_propinsi_id)->first();
    		return $propinsi->name;
    	})->editColumn('kabupaten', function($pengiriman) {
    		$kabupaten = Kabupaten::where('id', '=', $pengiriman->perusahaan_kabupaten_id)->first();
    		return $kabupaten->name;
    	})->editColumn('item', function($pengiriman) {
    		$item = Item::where('id', '=',$pengiriman->item_id)->first();
    		return $item->name;
    	})->editColumn('status', function($pengiriman) {
    		if ($pengiriman->status == 0) {
    			return "Menunggu persetujuan";
    		}
    		else if ($pengiriman->status == 1) {
    			return "Disetujui";
    		}
    		else if ($pengiriman->status == 2) {
    			return "Dikirim ke gudang";
    		}
            else if ($pengiriman->status == 3) {
                return "Sampai di gudang";
            }
            else if ($pengiriman->status == 4) {
                return "Pengambilan";
            }
            else if ($pengiriman->status == 5) {
                return "Dikirim ke pelanggan";
            }
            else if ($pengiriman->status == 6) {
                return "Sampai ke pelanggan";
            }
    		else if ($pengiriman->status == 10) {
    			return "Ditolak";
    		}
    	})->addColumn('action', function($pengiriman) {
    		if ($pengiriman->status == 0) {
    			return "<button id='terima'>Terima</button><button id='tolak'>Tolak</button>";
    		}
            else if ($pengiriman->status == 2) {
    			return "<button id='terima-barang'>Terima Barang</button>";
    		}
            else if ($pengiriman->status == 4) {
                return "<button id='ambil-qrcode'>QR Code</button><button id='kirim'>Kirim</button>";
            }
            else if ($pengiriman->status == 5) {
                return "<button id='sampai'>Sampai</button>";
            }
    	})->make(true);
    }

    public function request(Request $request)
    {
        $getId = DB::table('pengiriman')->insertGetId([
        	'user_perusahaan_id' => \Auth::user()->id,
            'user_gudang_id' => $request->user_gudang_id,
            'item_id' => $request->item_id,
            'amount' => $request->amount,
            'status' => 0
        ]);
        $gudang = User::where('id', '=', $request->user_gudang_id)->first();
        $xsightApiToken = "";
        $client = new Client();
        $response = $client->request('POST', 'https://api.mainapi.net/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization'     => 'Basic c05POUUxeXZKUk9GMDJFcEJWODJIYV9faTZrYTpmbkNaZzVKM1Zic09tOU1ZSjZuWW5TWnpEcE1h'
            ],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);
        $body = (string) $response->getBody(true);
        for ($i = 96;$i < (96+32);$i++) {
            $xsightApiToken = $xsightApiToken . $body[$i];
        }
        $client = new Client();
        $response = $client->request('POST', 'http://api.mainapi.net/smsnotification/1.0.0/messages', [
            'headers' => [
                'Authorization' => 'Bearer ' . $xsightApiToken
            ],
            'form_params' => [
                'msisdn' => $gudang->nomor_telepon,
                'content' => \Auth::user()->name . ' sedang meminta persetujuan Anda untuk menggunakan gudang Anda sebagai tempat penyimpanan. Mohon untuk segera menindaklanjuti permintaan ini dengan login ke akun Anda di d-log.dev.'
            ]
        ]);
        $body = (string) $response->getBody(true);
        return $xsightApiToken;
    }

    public function accept(Request $requst, $id) 
    {
    	DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 1]);
    }

    public function reject(Request $requst, $id) 
    {
    	DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 10]);
    }

    public function qrCode($id)
    {
    	$pengiriman = DB::table('pengiriman')->where('id', '=', $id)->first();
    	return view('pengiriman.qrcode', ['pengiriman' => $pengiriman, 'barcode' => DNS2D::getBarcodePNG($pengiriman->id, "QRCODE", 8, 8)]);
    }

    public function scanner($id)
    {
    	$pengiriman = DB::table('pengiriman')->where('id', '=', $id)->first();
    	return view('pengiriman.scanner')->with('pengiriman', $pengiriman);
    }

    public function send(Request $request, $id)
    {
        if (\Auth::user()->hasRole('perusahaan')) {
    	   DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 2]);
            $gudang = User::where('id', '=', $request->user_gudang_id)->first();
            $xsightApiToken = "";
            $client = new Client();
            $response = $client->request('POST', 'https://api.mainapi.net/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization'     => 'Basic c05POUUxeXZKUk9GMDJFcEJWODJIYV9faTZrYTpmbkNaZzVKM1Zic09tOU1ZSjZuWW5TWnpEcE1h'
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]
            ]);
            $body = (string) $response->getBody(true);
            for ($i = 96;$i < (96+32);$i++) {
                $xsightApiToken = $xsightApiToken . $body[$i];
            }
            $client = new Client();
            $response = $client->request('POST', 'http://api.mainapi.net/smsnotification/1.0.0/messages', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $xsightApiToken
                ],
                'form_params' => [
                    'msisdn' => $gudang->nomor_telepon,
                    'content' => \Auth::user()->name . ' telah mengirim barang menuju gudang Anda. Mohon untuk segera menindaklanjuti pengiriman ini dengan login ke akun Anda di d-log.dev.'
                ]
            ]);
            $body = (string) $response->getBody(true);
        } else if (\Auth::user()->hasRole('pemilik_gudang')) {
            DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 5]);
        }
    }

    public function receive(Request $request, $id)
    {
        //HACKATHON : TAMBAHKAN SMS NOTIF KE STATUS LAINNYA
        DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 3]);
        $pengiriman = DB::table('pengiriman')->where('id', '=', $id)->first();
        $items = \Auth::user()->gudang->items;
        $done = false;
        for ($i = 0;$i < sizeof($items);$i++){
            $item = $items[$i];
            if ($item->id == $pengiriman->item_id) {
                \Auth::user()->gudang->items()->updateExistingPivot($pengiriman->item_id, ['amount' => $item->pivot->amount + $pengiriman->amount]);
                $done = true;
            }
        }
        if (!$done) {
            \Auth::user()->gudang->items()->attach([$pengiriman->item_id => ['amount' => $pengiriman->amount]]);
        }
    }

    public function take(Request $request)
    {
        $getId = DB::table('pengiriman')->insertGetId([
            'user_perusahaan_id' => \Auth::user()->id,
            'user_gudang_id' => $request->user_gudang_id,
            'item_id' => $request->item_id,
            'amount' => $request->amount,
            'status' => 4
        ]);
        return $getId;
    }

    public function arrive(Request $request, $id)
    {
        DB::table('pengiriman')->where('id', '=', $id)->update(['status' => 6]);
        $pengiriman = DB::table('pengiriman')->where('id', '=', $id)->first();
        $items = \Auth::user()->gudang->items;
        for ($i = 0;$i < sizeof($items);$i++) {
            $item = $items[$i];
            if ($item->id == $pengiriman->item_id) {
                break;
            }
        }
        \Auth::user()->gudang->items()->updateExistingPivot($pengiriman->item_id, ['amount' => $item->pivot->amount - $pengiriman->amount]);
        $perusahaan = User::where('id', '=', $pengiriman->user_perusahaan_id)->first();
        $item = $perusahaan->items()->where('id', '=', $pengiriman->item_id)->first();
        $item->amount = $item->amount - $pengiriman->amount;
        $perusahaan->items()->save($item);
    }

    public function vesselSchedule()
    {
        $xsightApiToken = "";
        $client = new Client();
        $response = $client->request('POST', 'https://api.mainapi.net/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization'     => 'Basic c05POUUxeXZKUk9GMDJFcEJWODJIYV9faTZrYTpmbkNaZzVKM1Zic09tOU1ZSjZuWW5TWnpEcE1h'
            ],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);
        $body = (string) $response->getBody(true);
        for ($i = 96;$i < (96+32);$i++) {
            $xsightApiToken = $xsightApiToken . $body[$i];
        }
        $client = new Client();
        $response = $client->request('GET', 'http://api.mainapi.net/tracklogistic/v1.0/vessel/schedule', [
            'headers' => [
                'Authorization' => 'Bearer ' . $xsightApiToken
            ],
            'form_params' => [
                'start' => '2016-10-10',
                'end' => '2016-10-17'
            ]
        ]);
        $body = (string) $response->getBody(true);
        var_dump($body);
    }
}
