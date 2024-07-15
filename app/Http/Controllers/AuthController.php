<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\TokenEmail;
use App\Models\Freelance;
use App\Models\EmailToken;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Provinsi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Notifications\VerifyEmail;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.auth.login');
    }

    public function proses_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kolom password harus diisi.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->back()->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function register()
    {
        return view('front.auth.register');
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'gender' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'fullname.required' => 'Kolom nama lengkap harus diisi.',
            'no_telp.required' => 'Nomor handphone harus diisi',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kolom password harus diisi.',
            'gender.required' => 'Opsi Jenis kelamin harus diisi.',
            'confirm_password.required' => 'Kolom konfirmasi password harus diisi.',
            'confirm_password.same' => 'Konfirmasi password harus cocok dengan password.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'User',
        ]);

        if($user){
            $email = EmailToken::create([
                'email' => $request->email,
                'token' => (new EmailToken())->generateToken(),
                'expired_at' => now()->addHours(1),
            ]);
            if($email){
                Mail::to($request->email)->send(new TokenEmail($email));
                toastr()->success('Pendaftaran berhasil silahkan login.');
                return redirect()->route('login');
            }
        }

        toastr()->error('Pendaftaran gagal silahkan kontak admin.');
        return redirect()->back();
    }

    public function register_freelance()
    {
        $provinsi = Provinsi::get();
        return view('front.auth.freelance.register', compact('provinsi'));
    }

    public function proses_register_freelance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:freelance',
            'about' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
            'kota' => 'required',
            'foto_ktp' => 'required|image',
            'selfie_ktp' => 'required|image',
            'portofolio' => 'required|image',
        ], [
            'nik.required' => 'Kolom nik harus diisi.',
            'nik.unique' => 'Nik sudah terdaftar.',
            'about.required' => 'Kolom tentang saya harus diisi.',
            'alamat.required' => 'Kolom alamat harus diisi.',
            'provinsi.required' => 'Kolom provinsi harus diisi.',
            'desa.required' => 'Kolom desa harus diisi.',
            'kecamatan.required' => 'Kolom kecamatan harus diisi.',
            'kode_pos.required' => 'Kolom kode pos harus diisi.',
            'kota.required' => 'Kolom kota harus diisi.',
            'foto_ktp.required' => 'Kolom foto ktp harus diisi.',
            'foto_ktp.image' => 'Kolom foto ktp harus berisi gambar.',
            'selfie_ktp.required' => 'Kolom foto selfie harus diisi.',
            'selfie_ktp.image' => 'Kolom foto selfie harus berisi gambar.',
            'portofolio.required' => 'Kolom portofolio harus diisi.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $check_freelance = Freelance::where('user_id', auth()->user()->id)->first();

        if ($check_freelance) {
            toastr()->error('Anda sudah memiliki entri freelance.');
            return redirect()->back();
        }

        $fotoKTP = $request->file('foto_ktp')->store('foto_ktp', 'public');

        $selfieKTP = $request->file('selfie_ktp')->store('selfie_ktp', 'public');

        $portofolio = $request->file('portofolio')->store('portofolio_pendaftaran', 'public');

        $freelance = new Freelance([
            'nik' => $request->nik,
            'about' => $request->about,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'foto_ktp' => $fotoKTP,
            'selfie_ktp' => $selfieKTP,
            'portofolio' => $portofolio,
            'user_id' => auth()->user()->id,
        ]);
        
        function wilayah($model, $field, $code) {
            $data = $model::where('code', $code)->first();
            if ($data) {
                return $data->name;
            }
            return null;
        }
        
        $freelance->provinsi = wilayah(Province::class, 'provinsi', $request->provinsi);
        $freelance->kota = wilayah(City::class, 'kota', $request->kota);
        $freelance->kecamatan = wilayah(District::class, 'kecamatan', $request->kecamatan);
        $freelance->desa = wilayah(Village::class, 'desa', $request->desa);
        
        $freelance->save();

        if($freelance){
            toastr()->success('Proses pengajuan pendaftaran freelance sedang di proses.');
            return redirect()->back();
        }

        toastr()->error('Proses pengajuan pendaftaran freelance gagal di proses.');
        return redirect()->back();
    }

    public function verify_email()
    {
        return view('front.auth.verify_email');
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ], [
            'token.required' => 'Kolom token harus diisi.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(auth()->check()){
            $data = EmailToken::where('email',auth()->user()->email)->first();
            $user = User::where('id',auth()->user()->id)->first();
            if($data->token === $request->token){
                if($data->expired_at > Carbon::now()->format('H:i:s')){
                    $user->email_verified_at = now();
                    $user->save();
                    $data->delete();
                    
                    toastr()->success('Email berhasil di verifikasi.');
                    return redirect()->route('login');
                }
                toastr()->error('Token telah kadaluarsa.');
                return redirect()->back();
            }
            toastr()->error('Token tidak valid.');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
