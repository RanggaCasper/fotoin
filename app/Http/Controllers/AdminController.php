<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('back.admin.dashboard');
    }

    public function view_validasi_freelance()
    {
        return view('back.admin.freelance.validasi_freelance');
    }

    public function get_validasi_freelance(Request $request)
    {
        if ($request->ajax()) {
            $query = Freelance::whereHas('user', function ($query) {
                $query->where('role', 'User');
            });

            return DataTables::of($query)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('username', function ($row) {
                    return $row->user->username;
                })
                ->addColumn('fullname', function ($row) {
                    return $row->user->fullname;
                })
                ->addColumn('aksi', function ($row) {
                    return '<button class="btn btn-primary btn-sm detail" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#detail-modal"><i class="ti ti-eye"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        abort(404);
    }

    public function get_freelance_id(Request $request,$id)
    {
        if ($request->ajax()) {
            return response()->json(Freelance::with('user')->find($id));
        }

        abort(404);
    }

    public function update_validasi_freelance(Request $request, $id)
    {
        $freelance = Freelance::find($id);
        $freelance->status = "on";

        $user = $freelance->user;
        $user->role = "Freelance";

        if($freelance->save() && $user->save()){
            toastr()->success('Data berhasil diupdate.');
            return redirect()->back();
        }

    }
}
