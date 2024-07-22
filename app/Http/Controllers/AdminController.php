<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Freelance;
use App\Models\SuspendRequest;
use App\Models\SuspendUser;
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

    public function view_kelola_freelance()
    {
        return view('back.admin.freelance.kelola_freelance');
    }

    public function get_kelola_freelance(Request $request)
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

    public function view_suspend()
    {
        return view('back.admin.suspend.suspend');
    }

    public function get_suspend(Request $request)
    {
        if ($request->ajax()) {
            $data = SuspendUser::with('user')->get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('username', function($row) {
                    return $row->user->username;
                })
                ->addColumn('email', function($row) {
                    return $row->user->email;
                })
                ->addColumn('admin', function($row) {
                    return $row->user->username;
                })
                ->addColumn('aksi', function($row){
                    return '<button class="btn btn-danger btn-sm unblock" data-id="'.$row->user_id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Unblock"><i class="ti ti-lock-open"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function block_user(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:suspend_request,id',
            'status' => 'required|in:ACCEPTED,REJECTED',
            'note' => 'required_if:status,ACCEPTED|string',
        ], [
            'id.required' => 'ID permintaan suspend harus diisi.',
            'id.exists' => 'Permintaan suspend tidak ditemukan.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status tidak valid.',
            'note.required_if' => 'Alasan blokir harus diisi jika status diterima.',
            'note.string' => 'Alasan blokir harus berupa teks.',
        ]);

        try {
            $suspendRequest = SuspendRequest::find($request->id);

            if ($suspendRequest->status != 'PENDING') {
                return response()->json([
                    'status' => false,
                    'message' => 'Permintaan suspend sudah diproses sebelumnya.',
                ], 400);
            }

            $reportedId = $suspendRequest->reported_id;

            if ($request->status == 'ACCEPTED') {
                $suspendUser = SuspendUser::where('user_id', $reportedId)->first();

                if (!$suspendUser) {
                    SuspendUser::create([
                        'user_id' => $reportedId,
                        'email' => User::find($reportedId)->email,
                        'note' => $request->note,
                        'admin_id' => auth()->user()->id,
                    ]);
                }

                SuspendRequest::where('reported_id', $reportedId)
                    ->where('status', 'PENDING')
                    ->update(['status' => 'ACCEPTED']);
            } else {
                SuspendRequest::where('reported_id', $reportedId)
                    ->where('status', 'PENDING')
                    ->update(['status' => 'REJECTED']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Status permintaan suspend berhasil diperbarui.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses permintaan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function unblock_user(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => 'ID pengguna harus diisi.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
        ]);

        try {
            $suspendUser = SuspendUser::where('user_id', $request->user_id)->first();

            if ($suspendUser) {
                $suspendUser->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Pengguna berhasil di-unblock.',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Pengguna tidak ditemukan atau tidak sedang ditangguhkan.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses permintaan unblock.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function view_suspend_request()
    {
        return view('back.admin.suspend.suspend_request');
    }

    public function get_suspend_request(Request $request)
    {
        if ($request->ajax()) {
            $data = SuspendRequest::with('reporter', 'reported')->get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('reporter', function($row) {
                    return $row->reporter->username;
                })
                ->addColumn('reported', function($row) {
                    return $row->reported->username;
                })
                ->addColumn('proff', function($row) {
                    return '<img class="img-fluid w-25" src="'.$row->proff.'" alt="Proff">';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at;
                })
                ->addColumn('aksi', function($row){
                    if ($row->status == 'PENDING') {
                        $btn = '<button class="btn btn-success btn-sm accept" data-id="'.$row->id.'">Terima</button>';
                        $btn .= ' <button class="btn btn-danger btn-sm reject" data-id="'.$row->id.'">Tolak</button>';
                    } else {
                        $btn = '<button class="btn btn-secondary btn-sm" disabled>'.$row->status.'</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['aksi','proff'])
                ->make(true);
        }

    }
}
