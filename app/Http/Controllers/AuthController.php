<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\TokenEmail;
use App\Models\Freelance;
use App\Models\EmailToken;
use App\Models\SuspendUser;
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

        $suspendUser = SuspendUser::where('email', $request->email)->first();
        if ($suspendUser) {
            $note = $suspendUser->note;
            toastr()->error("Akun Anda telah ditangguhkan. Catatan: $note. Silakan hubungi admin untuk informasi lebih lanjut.", 'Oops!');
            return redirect()->back()->with('error', "Akun Anda telah ditangguhkan. Catatan: $note. Silakan hubungi admin untuk informasi lebih lanjut.");
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        
        toastr()->error('Email atau password salah. Silakan coba lagi.','Oops!');
        return redirect()->back()->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function register()
    {
        return view('front.auth.register');
    }

    public function send_verify_token(Request $request)
    {
        $request->validate([
            'email' => 'email|unique:users,email',
        ], [
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lainnya.',
        ]);

        try {
            $data = EmailToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => (new EmailToken())->generateToken(),
                    'type' => 'verify',
                    'expired_at' => now()->addMinutes(180),
                ]
            );

            Mail::to($request->email)->send(new TokenEmail($data));

            return response()->json([
                'message' => 'Token verifikasi telah dikirim ke email Anda.',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengirim token reset password. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'no_telp' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'gender' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'fullname.required' => 'Kolom nama lengkap harus diisi.',
            'no_telp.required' => 'Nomor handphone harus diisi.',
            'no_telp.unique' => 'Nomor handphone sudah terdaftar.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'gender.required' => 'Opsi Jenis kelamin harus diisi.',
            'confirm_password.required' => 'Kolom konfirmasi password harus diisi.',
            'confirm_password.same' => 'Konfirmasi password harus cocok dengan password.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = EmailToken::where('email', $request->email)
                ->where('type', 'verify')
                ->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak valid.'
                ], 400);
            }

            if ($data->token !== $request->token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak valid.'
                ], 400);
            }

            if ($data->expired_at < Carbon::now()) {
                $data->delete();
                return response()->json([
                    'status' => false,
                    'message' => 'Token telah kadaluarsa.'
                ], 400);
            }

            $data->delete();

            $user = User::create([
                'username' => $request->username,
                'fullname' => $request->fullname,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'User',
                'email_verified_at' => now()
            ]);

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Pendaftaran berhasil.',
                    'redirect' => route('login')
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => 'Pendaftaran gagal, silahkan kontak admin.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function forgot()
    {
        return view('front.auth.forgot');
    }

    public function send_reset_token(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        try {
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email tidak terdaftar.',
                ], 404);
            }

            $data = EmailToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => (new EmailToken())->generateToken(),
                    'type' => 'reset',
                    'expired_at' => now()->addMinutes(180),
                ]
            );

            Mail::to($request->email)->send(new TokenEmail($data));

            return response()->json([
                'message' => 'Token reset password telah dikirim ke email Anda.',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengirim token reset password. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8',
        ], [
            'token.required' => 'Kolom token harus diisi.',
            'password.required' => 'Kolom Password harus diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        try {
            $emailToken = EmailToken::where('token', $request->token)
                                    ->where('type', 'reset')
                                    ->where('expired_at', '>', now())
                                    ->first();

            if (!$emailToken) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak valid atau telah kedaluwarsa.',
                ], 400);
            }

            $user = User::where('email', $emailToken->email)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pengguna tidak ditemukan.',
                ], 404);
            }

            $user->password = bcrypt($request->password);
            $user->save();

            $emailToken->delete();

            return response()->json([
                'status' => true,
                'message' => 'Password berhasil diubah. Silakan login.',
                'redirect' => route('login'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengubah Password. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function register_freelance()
    {
        $provinsi = Provinsi::get();
        $freelance = Freelance::where('user_id', auth()->user()->id)->first();
        return view('front.auth.freelance.register', compact('provinsi', 'freelance'));
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
            'jenis_rekening' => 'required',
            'no_rekening' => 'required',
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
            'jenis_rekening.required' => 'Kolom jenis rekening harus diisi.',
            'no_rekening.required' => 'Kolom no rekening harus diisi.',
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
            'jenis_rekening' => $request->jenis_rekening,
            'no_rekening' => $request->no_rekening,
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

    public function register_update_freelance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:freelance,nik,' . auth()->user()->freelance->id,
            'about' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
            'kota' => 'required',
            'jenis_rekening' => 'required',
            'no_rekening' => 'required',
            'foto_ktp' => 'image|nullable',
            'selfie_ktp' => 'image|nullable',
            'portofolio' => 'image|nullable',
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
            'jenis_rekening.required' => 'Kolom jenis rekening harus diisi.',
            'no_rekening.required' => 'Kolom no rekening harus diisi.',
            'foto_ktp.image' => 'Kolom foto ktp harus berisi gambar.',
            'selfie_ktp.image' => 'Kolom foto selfie harus berisi gambar.',
            'portofolio.image' => 'Kolom portofolio harus berisi gambar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $freelance = Freelance::where('user_id', auth()->user()->id)->first();

        if (!$freelance) {
            toastr()->error('Entri freelance tidak ditemukan.');
            return redirect()->back();
        }

        if ($request->hasFile('foto_ktp')) {
            $fotoKTP = $request->file('foto_ktp')->store('foto_ktp', 'public');
            $freelance->foto_ktp = $fotoKTP;
        }

        if ($request->hasFile('selfie_ktp')) {
            $selfieKTP = $request->file('selfie_ktp')->store('selfie_ktp', 'public');
            $freelance->selfie_ktp = $selfieKTP;
        }

        if ($request->hasFile('portofolio')) {
            $portofolio = $request->file('portofolio')->store('portofolio_pendaftaran', 'public');
            $freelance->portofolio = $portofolio;
        }

        $freelance->nik = $request->nik;
        $freelance->about = $request->about;
        $freelance->alamat = $request->alamat;
        $freelance->kode_pos = $request->kode_pos;
        
        function _wilayah($model, $field, $code) {
            $data = $model::where('code', $code)->first();
            if ($data) {
                return $data->name;
            }
            return null;
        }

        $freelance->provinsi = _wilayah(Province::class, 'provinsi', $request->provinsi);
        $freelance->kota = _wilayah(City::class, 'kota', $request->kota);
        $freelance->kecamatan = _wilayah(District::class, 'kecamatan', $request->kecamatan);
        $freelance->desa = _wilayah(Village::class, 'desa', $request->desa);

        $freelance->status_register = "PENDING";

        $freelance->save();

        if($freelance){
            toastr()->success('Data freelance berhasil diperbarui.');
            return redirect()->back();
        }

        toastr()->error('Proses pembaruan data freelance gagal.');
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
            $data = EmailToken::where('email',auth()->user()->email)->where('type', 'verify')->first();
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
