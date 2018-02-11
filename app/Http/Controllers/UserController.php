<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class UserController extends Controller
{

	protected $xsightApiToken = "";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verificationAgreement()
    {
    	// phpinfo();
    	return view('phone.verify');
    }

    public function callSMSOTP()
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
    	$response = $client->request('PUT', 'https://api.mainapi.net/smsotp/1.0.1/otp/1', [
    		'headers' => [
    			'Authorization' => 'Bearer ' . $xsightApiToken,
    			'Accept' => 'application/json',
		        'Content-Type' => 'application/x-www-form-urlencoded',
		    ],
		    'form_params' => [
		    	'phoneNum' => \Auth::user()->nomor_telepon,
  				'digit' => '6'
		    ]
    	]);
    	$body = (string) $response->getBody(true);
    	return $xsightApiToken;
    }

    public function verify(Request $request)
    {
    	$client = new Client();
    	$response = $client->request('POST', 'https://api.mainapi.net/smsotp/1.0.1/otp/1/verifications', [
    		'headers' => [
		        'Authorization' => 'Bearer ' . $request->input('token'),
    			'Accept' => 'application/json',
		        'Content-Type' => 'application/x-www-form-urlencoded',
		    ],
		    'form_params' => [
		    	'otpstr' => $request->input('kode'),
  				'digit' => '6'
		    ]
    	]);
    	$body = (string) $response->getBody(true);
    	$user = User::where('id', '=', \Auth::user()->id)->first();
    	$user->nomor_telepon_verified = 1;
    	$user->save();
    	return view('phone.verified');
    }
}
