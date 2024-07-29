<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Withdraw;
use Barryvdh\DomPDF\PDF;
use App\Models\Freelance;
use App\Models\SuspendUser;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SuspendRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function dashboard()
    {
        return view('back.admin.dashboard');
    }

    public function catalog_chart(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subYears(100)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $catalogData = Catalog::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
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
            $total = 0;
            foreach ($catalogData as $data) {
                if ($data['date'] == $dateStr) {
                    $total = $data['total'];
                    break;
                }
            }
            $processedData[] = [
                'x' => $dateStr,
                'y' => $total
            ];
            $currentDate->addDay();
        }

        return response()->json($processedData);
    }

    public function transaction_chart(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subYears(100)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $transactionData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
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
            $total = 0;
            foreach ($transactionData as $data) {
                if ($data['date'] == $dateStr) {
                    $total = $data['total'];
                    break;
                }
            }
            $processedData[] = [
                'x' => $dateStr,
                'y' => $total
            ];
            $currentDate->addDay();
        }

        return response()->json($processedData);
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
        $freelance->status_register = "APPROVED";

        $user = $freelance->user;
        $user->role = "Freelance";

        if($freelance->save() && $user->save()){
            return response()->json([
            'status' => true,
            'message' => 'Freelance berhasil divalidasi.',
        ]);
        }
    }

    public function reject_freelance(Request $request, $id)
    {
        $freelance = Freelance::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'note_register' => 'required|string|max:255',
        ], [
            'note_register.required' => 'Kolom alasan penolakan harus diisi.',
            'note_register.max' => 'Kolom alasan penolakan tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $freelance->status_register = 'REJECTED';
        $freelance->note_register = $request->note_register;
        $freelance->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Freelance berhasil ditolak.',
        ]);
    }


    public function data_catalog()
    {
        $catalog = Catalog::get();
        return view('back.admin.data.catalog', compact('catalog'));
    }

    public function get_data_catalog(Request $request)
    {
        if ($request->ajax()) {
            $query = Catalog::with('user', 'packages')->get();

            return DataTables::of($query)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('freelance', function ($row) {
                    return $row->user->username;
                })
                ->addColumn('package', function ($row) {
                    return $row->packages->count();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('aksi', function ($row) {
                    $buttonText = $row->status == 'on' ? 'Hidden' : 'Visible';
                    $buttonClass = $row->status == 'on' ? 'btn-danger' : 'btn-success';
                    return '<button class="btn '.$buttonClass.' btn-sm btn-toggle-status" data-id="'.$row->id.'" data-status="'.$row->status.'">'.$buttonText.'</button>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        abort(404);
    }

    public function toggle_status(Request $request)
    {
        $catalog = Catalog::findOrFail($request->id);
        $catalog->status = $catalog->status == 'on' ? 'off' : 'on';
        $catalog->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }


    public function pdf_data_catalog(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(29)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $catalogData = Catalog::with('user')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('MIN(title_name) as title_name'),
                DB::raw('MIN(user_id) as user_id'),
                DB::raw('SUM(count_views) as count_views'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->get();
    
        $freelancerLeaderboard = Catalog::with('user')
            ->select('user_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->get();
    
        $catalogViewsLeaderboard = Catalog::with('user')
            ->select('title_name', 'count_views')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('count_views', 'DESC')
            ->take(5)
            ->get();

        $pdf = $this->pdf->loadView('back.admin.data.pdf_catalog', compact('catalogData', 'startDate', 'endDate', 'freelancerLeaderboard', 'catalogViewsLeaderboard'));

        return $pdf->download('catalog_report.pdf');
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
                    return '<img class="img-fluid" src="'.url('storage/'.$row->proff).'" alt="Proff">';
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

    public function view_category()
    {
        return view('back.admin.category.category');
    }

    public function get_category(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('icon', function($row) {
                    return $row->icon;
                })
                ->addColumn('image', function($row) {
                    return '<img class="img-fluid w-25" src="'.url($row->image).'" alt="Image">';
                })
                ->addColumn('aksi', function($row){
                    return '<button class="btn btn-primary me-2 update" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#update-modal"><i class="ti ti-edit"></i></button><button class="btn btn-danger delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['aksi','image','icon'])
                ->make(true);
        }

        abort(404);
    }

    public function get_category_id(Request $request,$id)
    {
        if ($request->ajax()) {
            return response()->json(Category::find($id));
        }

        abort(404);
    }

    public function create_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable',
            'image' => 'nullable|image',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs('category_images', Str::uuid() . '.' . $request->file('image')->extension(), 'public');
            }

            $category = Category::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'image' => $imagePath ? Storage::url($imagePath) : null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil dibuat.',
                'data' => $category,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat membuat kategori.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable',
            'image' => 'nullable|image',
        ]);

        try {
            $category = Category::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
                }
                $imagePath = $request->file('image')->storeAs('category_images', Str::uuid() . '.' . $request->file('image')->extension(), 'public');
                $category->image = Storage::url($imagePath);
            }

            $category->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'image' => $category->image,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil diperbarui.',
                'data' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kategori.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete_category(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function view_withdraw()
    {
        return view('back.admin.withdraw.withdraw');
    }

    public function get_withdraw(Request $request)
    {
        if ($request->ajax()) {
            $query = Withdraw::with('user');

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->user) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('username', 'like', '%'.$request->user.'%');
                });
            }

            if ($request->rekening) {
                $query->where('rekening', 'like', '%'.$request->rekening.'%');
            }

            $data = $query->orderByRaw("CASE WHEN status = 'PENDING' THEN 1 ELSE 2 END, created_at DESC")->get();

            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('username', function($row){
                    return $row->user->username;
                })
                ->addColumn('transfer', function($row){
                    return 'Rp. '.number_format($row->transfer,0,',','.');
                })
                ->addColumn('fee', function($row){
                    return 'Rp. '.number_format($row->fee,0,',','.');
                })
                ->addColumn('status', function($row){
                    $badgeClass = '';
                    switch ($row->status) {
                        case 'COMPLETED':
                            $badgeClass = 'bg-success';
                            break;
                        case 'CANCLED':
                            $badgeClass = 'bg-danger';
                            break;
                        case 'PENDING':
                            $badgeClass = 'bg-warning';
                            break;
                    }
                    return '<span class="badge ' . $badgeClass . ' rounded-pill">' . $row->status . '</span>';
                })
                ->addColumn('action', function($row){
                    if($row->status != "P"){
                        return null;
                    }
                    $btn = '<button class="btn btn-success btn-sm approve me-1" data-id="'.$row->id.'">Approve</button>';
                    $btn .= '<button class="btn btn-danger btn-sm reject" data-id="'.$row->id.'">Reject</button>';
                    return $btn;
                })
                ->addColumn('created_at',function($row){
                    return $row->created_at;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        
        abort(404);
    }



    public function withdraw_approve($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        if ($withdraw->status == 'PENDING') {
            $withdraw->status = 'COMPLETED';
            $withdraw->save();
            return response()->json([
                'success' => true,
                'message' => 'Penarikan telah disetujui.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Penarikan tidak dapat disetujui.',
            ]);
        }

    }

    public function withdraw_reject($id)
    {
        $withdraw = Withdraw::findOrFail($id);

        if ($withdraw->status == 'PENDING') {
            // Kembalikan saldo pengguna
            $user = User::findOrFail($withdraw->user_id);
            $user->balance += $withdraw->transfer + $withdraw->fee;
            $user->save();

            $withdraw->status = 'CANCLED';
            $withdraw->save();

            return response()->json([
                'success' => true,
                'message' => 'Penarikan telah ditolak dan saldo dikembalikan.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Penarikan tidak dapat ditolak.',
            ]);
        }
    }

    public function view_user()
    {
        return view('back.admin.user.user');
    }

    public function get_user(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'User')->get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'"><i class="ti ti-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        abort(404);
    }

    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'no_telp' => 'required|string|max:15|unique:users,no_telp,' . $id,
            'gender' => 'required|string|in:Laki - Laki,Perempuan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diupdate',
        ]);
    }


    public function delete_user($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->catalogs()->exists() || $user->freelance()->exists() || $user->wishlist()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak bisa menghapus pengguna karena masih ada data terkait di tabel lain.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus',
        ]);
    }

    public function view_freelance()
    {
        return view('back.admin.freelance.freelance');
    }

    public function get_freelance(Request $request)
    {
        if ($request->ajax()) {
            $data = Freelance::with('user')->get();
            return DataTables::of($data)
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
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        abort(404);
    }

    public function edit_freelance($id)
    {
        $freelance = Freelance::findOrFail($id);
        return response()->json($freelance);
    }

    public function update_freelance(Request $request, $id)
    {
        $freelance = Freelance::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:255',
            'about' => 'required|string',
            'alamat' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'no_rekening' => 'required|string|max:255',
            'jenis_rekening' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $freelance->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Freelance berhasil diupdate',
        ]);
    }

    public function delete_freelance($id)
    {
        $freelance = Freelance::findOrFail($id);
        $user = $freelance->user;

        if ($user->catalogs()->exists() || $user->wishlist()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak bisa menghapus data freelance karena masih ada data terkait di tabel lain.',
            ], 422);
        }

        $user = $freelance->user;

        $freelance->delete();

        $user->role = 'user';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Freelance berhasil dihapus dan role pengguna telah diubah menjadi user',
        ]);
    }


}
