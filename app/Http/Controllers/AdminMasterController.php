<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebsiteConf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminMasterController extends Controller
{
    public function dashboard()
    {
        return view('back.master.dashboard.dashboard');
    }

    public function view_admin()
    {
        return view('back.master.admin.admin');
    }

    public function create_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar, silahkan gunakan username lainnya.',
            'fullname.required' => 'Kolom nama lengkap harus diisi.',
            'no_telp.required' => 'Kolom nomor handphone harus diisi.',
            'password.required' => 'Kolom password harus diisi.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lainnya.',
            'password.required' => 'Kolom password harus diisi.',
        ]);
        
        if ($validator->fails()) {
            toastr()->error('Pastikan semua kolom sudah di isi dan valid.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $request['role'] = "Admin";
        $request['password'] = bcrypt($request->password);

        if(User::create($request->all())){
            toastr()->success('Data berhasil di tambahkan.');
            return redirect()->back();
        }
        
        toastr()->error('Terjadi kesalahan saat menambahkan data baru.');
    }

    public function get_admin(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select('id','username','fullname','email','no_telp')->where('role','Admin');

            return DataTables::of($query)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('aksi', function ($row){
                    return '<button class="btn btn-primary btn-sm me-2 update" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#update-modal"><i class="ti ti-edit"></i></button><button onclick="hapus('.$row->id.')" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        abort(404);
    }

    public function update_admin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username_update' => 'required',
            'fullname_update' => 'required',
            'no_telp_update' => 'required',
            'email_update' => 'required|email:dns',
        ], [
            'username_update.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar, silahkan gunakan username lainnya.',
            'fullname_update.required' => 'Kolom nama lengkap harus diisi.',
            'no_telp_update.required' => 'Kolom nomor handphone harus diisi.',
            'password.required' => 'Kolom password harus diisi.',
            'email_update.required' => 'Kolom email harus diisi.',
            'email_update.email' => 'Format email tidak valid.',
            'email_update.unique' => 'Email sudah terdaftar, silahkan gunakan email lainnya.',
        ]);
        
        if ($validator->fails()) {
            toastr()->error('Pastikan semua kolom sudah di isi dan valid.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = User::find($id);
        
        $data->username = $request->username_update;
        $data->fullname = $request->fullname_update;
        $data->no_telp = $request->no_telp_update;
        $data->email = $request->email_update;
        $data->password = bcrypt($request->password_update);

        if($data->save()){
            toastr()->success('Data berhasil di perbarui.');
            return redirect()->back();
        }

        toastr()->error('Data gagal diperbarui.', 'Oops!');
        return redirect()->back();
    }

    public function delete_admin($id)
    {
        $data = User::find($id);

        if ($data->delete()) {
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }

        return response()->json(['message' => 'Data gagal dihapus.']);
    }

    public function get_admin_id($id)
    {
        return response()->json(User::select('id','username','fullname','email','no_telp')->where('role','Admin')->find($id));
    }

    public function view_website_conf()
    {
        return view('back.master.website.configuration');
    }

    public function update_website_conf(Request $request)
    {
        $data = [
            'web_title' => $request->web_title,
            'web_description' => $request->web_description,
            'web_author' => $request->web_author,
            'web_keywords' => $request->web_keywords,
            'web_icon' => $request->web_icon,
            'web_logo' => $request->web_logo,
            'web_footer' => $request->web_footer,
        ];
        
        foreach ($data as $confKey => $confValue) {
            WebsiteConf::where('conf_key', $confKey)->update(['conf_value' => $confValue]);
        }

        toastr()->success('Konfigurasi Website berhasil diupdate.', 'Success!');
        return redirect()->back();
    }
}
