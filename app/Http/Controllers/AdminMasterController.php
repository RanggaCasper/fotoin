<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profit;
use App\Models\WebsiteConf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentChannel;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Services\TokopayService;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'no_telp' => 'required|unique:users',
            'email' => 'required|email|unique:users',
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Pastikan semua kolom sudah diisi dan valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $request['role'] = "Admin";
        $request['password'] = bcrypt($request->password);

        try {
            $user = User::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data baru.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
                    return '<button class="btn btn-primary btn-sm me-2 update" data-id="'.$row->id.'"><i class="ti ti-edit"></i></button><button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        abort(404);
    }

    public function update_admin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'fullname' => 'required',
            'no_telp' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'fullname.required' => 'Kolom nama lengkap harus diisi.',
            'username.unique' => 'Username sudah terdaftar, silahkan gunakan username lainnya.',
            'no_telp.required' => 'Kolom nomor handphone harus diisi.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar, silahkan gunakan nomor telepon lainnya.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lainnya.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Pastikan semua kolom sudah diisi dan valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = User::findOrFail($id);

            $data->username = $request->username;
            $data->fullname = $request->fullname;
            $data->no_telp = $request->no_telp;
            $data->email = $request->email;
            
            if ($request->has('password') && !empty($request->password)) {
                $data->password = bcrypt($request->password);
            }

            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diperbarui.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function delete_admin($id)
    {
        try {
            $data = User::findOrFail($id);

            if ($data->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus.',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus.',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_admin_id($id)
    {
        $user = User::select('id','username','fullname','email','no_telp')
                    ->where('role', 'Admin')
                    ->find($id);

        if ($user) {
            return response()->json($user, 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
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
            'web_footer' => $request->web_footer,
        ];

        if ($request->hasFile('web_logo')) {
            $logoPath = $request->file('web_logo')->storeAs('public/logo', Str::uuid() . '.' . $request->file('web_logo')->extension());
            $data['web_logo'] = url('storage/logo/' . basename($logoPath));
        }

        if ($request->hasFile('web_icon')) {
            $iconPath = $request->file('web_icon')->storeAs('public/icon', Str::uuid() . '.' . $request->file('web_icon')->extension());
            $data['web_icon'] = url('storage/icon/' . basename($iconPath));
        }

        foreach ($data as $confKey => $confValue) {
            WebsiteConf::updateOrCreate(['conf_key' => $confKey], ['conf_value' => $confValue]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Konfigurasi Website berhasil diupdate.',
        ]);
    }

    public function update_payment_gateway(Request $request)
    {
        $data = [
            'tokopay_api' => $request->tokopay_api,
            'tokopay_secret' => $request->tokopay_secret,
        ];
        
        foreach ($data as $confKey => $confValue) {
            WebsiteConf::updateOrCreate(['conf_key' => $confKey], ['conf_value' => $confValue]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Konfigurasi Payment Gateway berhasil diupdate.',
        ]);
    }

    public function update_kontak(Request $request)
    {
        $data = [
            'web_location' => $request->web_location,
            'cs_phone' => $request->cs_phone,
            'cs_email' => $request->cs_email,
        ];
        
        foreach ($data as $confKey => $confValue) {
            WebsiteConf::updateOrCreate(['conf_key' => $confKey], ['conf_value' => $confValue]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Konfigurasi Kontak berhasil diupdate.',
        ]);
    }

    public function update_web_profit(Request $request)
    {
        $request->validate([
            'take_fee' => 'required|numeric|between:0,100',
            'take_fee_withdraw' => 'required|numeric',
        ]);

        $data = [
            'take_fee' => $request->take_fee,
            'take_fee_withdraw' => $request->take_fee_withdraw
        ];
        
        foreach ($data as $confKey => $confValue) {
            WebsiteConf::updateOrCreate(['conf_key' => $confKey], ['conf_value' => $confValue]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Konfigurasi Profit berhasil diupdate.',
        ]);
    }

    public function get_tokopay()
    {
        $tokopay = new TokopayService();
        return $tokopay->getProfile();
    }

    public function view_payment_channel()
    {
        return view('back.master.payment_channel.payment_channel');
    }

    public function get_payment_channel(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentChannel::all();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('image', function($row) {
                    return '<img class="img-fluid w-25" src="'.url($row->image).'" alt="Image">';
                })
                ->addColumn('aksi', function($row){
                    return '<button class="btn btn-primary me-2 update" data-id="'.$row->id.'"><i class="ti ti-edit"></i></button><button class="btn btn-danger delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['aksi', 'image'])
                ->make(true);
        }
    }

    public function get_payment_channel_id(Request $request, $id)
    {
        if ($request->ajax()) {
            return response()->json(PaymentChannel::find($id));
        }

        abort(404);
    }

    public function create_payment_channel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_channel,code',
            'image' => 'required|image',
            'desc' => 'required|string',
            'flat_fee' => 'required|numeric',
            'percent_fee' => 'required|numeric',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs('payment_channel_images', Str::uuid() . '.' . $request->file('image')->extension(), 'public');
            }

            $isQris = $request->has('is_qris') ? "on" : "off";

            $paymentChannel = PaymentChannel::create([
                'name' => $request->name,
                'code' => $request->code,
                'image' => $imagePath ? Storage::url($imagePath) : null,
                'desc' => $request->desc,
                'is_qris' => $isQris,
                'flat_fee' => $request->flat_fee,
                'percent_fee' => $request->percent_fee,
                'min_amount' => $request->min_amount,
                'max_amount' => $request->max_amount,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Payment Channel successfully created.',
                'data' => $paymentChannel,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the payment channel.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_payment_channel(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_channel,code,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'desc' => 'required|string',
            'flat_fee' => 'required|numeric',
            'percent_fee' => 'required|numeric',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric',
        ]);

        try {
            $paymentChannel = PaymentChannel::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($paymentChannel->image) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $paymentChannel->image));
                }
                $imagePath = $request->file('image')->storeAs('payment_channel_images', Str::uuid() . '.' . $request->file('image')->extension(), 'public');
                $paymentChannel->image = Storage::url($imagePath);
            }

            $isQris = $request->has('is_qris') ? "on" : "off";

            $paymentChannel->update([
                'name' => $request->name,
                'code' => $request->code,
                'image' => $paymentChannel->image,
                'desc' => $request->desc,
                'is_qris' => $isQris,
                'flat_fee' => $request->flat_fee,
                'percent_fee' => $request->percent_fee,
                'min_amount' => $request->min_amount,
                'max_amount' => $request->max_amount,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Payment Channel successfully updated.',
                'data' => $paymentChannel,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the payment channel.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete_payment_channel(Request $request, $id)
    {
        try {
            $paymentChannel = PaymentChannel::findOrFail($id);

            if ($paymentChannel->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $paymentChannel->image));
            }

            $paymentChannel->delete();

            return response()->json([
                'status' => true,
                'message' => 'Payment Channel successfully deleted.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the payment channel.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function view_profit()
    {
        return view('back.master.profit.profit');
    }

    public function get_profit(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $data = Profit::with('transaction', 'transaction.freelance', 'transaction.user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return DataTables::of($data)
            ->addColumn('no', function ($row) {
                static $counter = 0;
                return ++$counter;
            })
            ->addColumn('profit', function ($row) {
                return number_format($row->profit, 0, ',', '.');
            })
            ->addColumn('transaction', function ($row) {
                return $row->transaction->invoice;
            })
            ->addColumn('freelance', function ($row) {
                return $row->transaction->freelance->username;
            })
            ->addColumn('client', function ($row) {
                return $row->transaction->user->username;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->make(true);
    }


    public function profit_chart(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $profitData = Profit::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(profit) as total_profit'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();

        $processedData = [];
        $currentDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate);

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $totalProfit = 0;
            foreach ($profitData as $data) {
                if ($data['date'] == $dateStr) {
                    $totalProfit = $data['total_profit'];
                    break;
                }
            }
            $processedData[] = [
                'x' => $dateStr,
                'y' => $totalProfit
            ];
            $currentDate->addDay();
        }

        return response()->json($processedData);
    }


}
