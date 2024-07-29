<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('front.user.dashboard.dashboard');   
    }

    public function view_transaction()
    {
        return view('front.user.transaction.transaction');   
    }

    public function get_transaction(Request $request)
    {
        if($request->ajax()){
            $query = Transaction::select(['id', 'invoice', 'freelance_id', 'catalog_name', 'package_name', 'package_price', 'status', 'approved', 'created_at'])
                    ->with('freelance')
                    ->where('user_id', auth()->user()->id)
                    ->orderByRaw("CASE WHEN status = 'PENDING' THEN 1 ELSE 2 END, created_at DESC");

            return DataTables::of($query)
                    ->addColumn('no', function ($row) {
                        static $counter = 0;
                        return ++$counter;
                    })
                    ->addColumn('invoice', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view_transaction', ['invoice' => $row->invoice]).'" data-toggle="tooltip" data-placement="right" title="Cek detail invoice #'.$row->invoice.'">#'.$row->invoice.'</a>';
                    })
                    ->addColumn('catalog_name', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view-catalog', ['username' => $row->freelance->username,'slug' => Str::slug($row->catalog_name)]).'" data-toggle="tooltip" data-placement="right" title="Cek Katalog '.$row->catalog_name.'">'.$row->catalog_name.'</a>';
                    })
                    ->addColumn('freelance', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view_message').'?id='.$row->freelance_id.'&text=Hallo kak '.$row->freelance->username.', " data-toggle="tooltip" data-placement="right" title="Chat freelance '.$row->freelance->username.'">'.$row->freelance->username.'</a>';
                    })
                    ->addColumn('package_price', function ($row) {
                        return 'Rp. '.number_format($row->package_price, 0, ',', '.');
                    })
                    ->addColumn('status', function ($row) {
                        $color = '';
                        switch ($row->status) {
                            case 'COMPLETED':
                                $color = 'success';
                                break;
                            case 'CANCLED':
                                $color = 'danger';
                                break;
                            case 'PENDING':
                                $color = 'warning';
                                break;
                            case 'PROCESSING':
                                $color = 'info';
                                break;
                        }
                        return '<h6 class="text-' . $color . '">' . $row->status . '</h6>';
                    })
                    ->addColumn('approved', function ($row) {
                        $color = '';
                        switch ($row->approved) {
                            case 'APPROVED':
                                $color = 'success';
                                break;
                            case 'WAITING':
                                $color = 'info';
                                break;
                            case 'REJECTED':
                                $color = 'danger';
                                break;
                        }
                        return '<h6 class="text-' . $color . '">' . $row->approved . '</h6>';
                    })
                    ->addColumn('created_at', function ($row) {
                        return $row->created_at; 
                    })
                    ->rawColumns(['invoice','catalog_name','freelance','status', 'approved'])
                    ->toJson();
        }

        abort(404);
    }

    public function view_profile()
    {
        return view('front.user.profile.profile');
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            toastr()->error('Password saat ini salah.');
            return redirect()->back();
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images/profile'), $imageName);
            $user->profile_image = '/images/profile/'.$imageName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if($user->save()){
            toastr()->success('Profile berhasil diupdate.');
        } else {
            toastr()->error('Terjadi kesalahan saat mengupdate profil.');
        }

        return redirect()->back();
    }

}
