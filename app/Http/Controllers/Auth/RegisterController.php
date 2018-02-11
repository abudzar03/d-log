<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Propinsi;
use App\Kabupaten;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationFormPerusahaan()
    {
        \Session::flash('akun', 1);
        $propinsis = Propinsi::all();
        return view('auth.register', [
            'propinsis' => $propinsis
        ]);
    }
    public function showRegistrationFormPemilikGudang()
    {
        \Session::flash('akun', 2);
        $propinsis = Propinsi::all();
        return view('auth.register', [
            'propinsis' => $propinsis
        ]);
    }
    public function getKabupaten($id)
    {
        \Session::reflash();
        $kabupatens = Propinsi::find($id)->kabupatens()->get();
        return $kabupatens;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string',
            'propinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'nomor_telepon' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        \Session::reflash();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'alamat' => $data['alamat'],
            'propinsi_id' => $data['propinsi_id'],
            'kabupaten_id' => $data['kabupaten_id'],
            'nomor_telepon' => "+62" . $data['nomor_telepon']
        ]);
    }
}
