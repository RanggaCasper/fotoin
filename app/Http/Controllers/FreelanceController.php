<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Package;
use App\Models\Calendar;
use App\Models\Category;
use App\Models\Portofolio;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FreelanceController extends Controller
{
    public function dashboard()
    {
        return view('front.freelance.dashboard.dashboard');
    }

    public function catalog()
    {
        $catalogs = Catalog::with('user.freelance', 'feedback','category', 'packages', 'portofolios')->where('user_id', auth()->user()->id)->get();
        // dd($catalogs);
        return view('front.freelance.catalog.catalog', compact('catalogs'));
    }

    public function view_catalog()
    {
        $categorys = Category::get();
        return view('front.freelance.catalog.create', compact('categorys'));
    }

    public function create_catalog(Request $request){
        $request->validate([
            'title_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categorys,id',
            'path_image.*.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi|max:20480', // max 20MB
            'packages.*.package_name' => 'required|string|max:255',
            'packages.*.price' => 'required|numeric',
            'packages.*.package_description' => 'required|string',
        ], [
            'title_name.required' => 'Judul Katalog harus diisi.',
            'title_name.string' => 'Judul Katalog harus berupa teks.',
            'title_name.max' => 'Judul Katalog tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'category.required' => 'Kategori harus dipilih.',
            'category.exists' => 'Kategori yang dipilih tidak valid.',
            'path_image.*.*.required' => 'Setiap file gambar/video harus diunggah.',
            'path_image.*.*.file' => 'Setiap unggahan harus berupa file.',
            'path_image.*.*.mimes' => 'File harus berupa gambar atau video dengan format: jpeg, png, jpg, gif, svg, mp4, mov, avi.',
            'path_image.*.*.max' => 'File tidak boleh lebih dari 20MB.',
            'packages.*.package_name.required' => 'Nama Paket harus diisi.',
            'packages.*.package_name.string' => 'Nama Paket harus berupa teks.',
            'packages.*.package_name.max' => 'Nama Paket tidak boleh lebih dari 255 karakter.',
            'packages.*.price.required' => 'Harga Paket harus diisi.',
            'packages.*.price.numeric' => 'Harga Paket harus berupa angka.',
            'packages.*.package_description.required' => 'Deskripsi Paket harus diisi.',
            'packages.*.package_description.string' => 'Deskripsi Paket harus berupa teks.',
        ]);
    
        $catalog = Catalog::create([
            'title_name' => $request->title_name,
            'description' => $request->description,
            'slug' => Str::slug($request->title_name),
            'category_id' => $request->category,
            'user_id' => auth()->user()->id
        ]);
    
        if($catalog){
            foreach ($request->path_image as $key => $files) {
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('portofolio', $filename, 'public');
                        Portofolio::create([
                            'path_image' => $path,
                            'catalog_id' => $catalog->id,
                        ]);
                    }
                }
            }
    
            foreach ($request->packages as $item) {
                Package::create([
                    'package_name' => $item['package_name'],
                    'price' => $item['price'],
                    'description' => $item['package_description'],
                    'catalog_id' => $catalog->id
                ]);
            }

            toastr()->success('Katalog berhasil ditambahkan.');
        }
    
        return redirect()->route('catalog-freelance')->with('success', 'Katalog berhasil dibuat.');
    }  
    
    public function edit_catalog($id)
    {
        $catalog = Catalog::with('portofolios', 'packages')->findOrFail($id);
        $categorys = Category::all();
        return view('front.freelance.catalog.update', compact('catalog', 'categorys'));
    }

    public function calendar()
    {
        return view('front.freelance.calendar.calendar');
    }

    public function get_calendar(Request $request)
    {
        if ($request->ajax()) {
            $query = Calendar::where('user_id', auth()->user()->id);

            return DataTables::of($query)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('aksi', function ($row) {
                    return '<button class="btn btn-primary update" data-id="'.$row->id.'"><i class="ti ti-pencil"></i></button> <button class="btn btn-danger delete" data-id="'.$row->id.'"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        abort(404);
    }

    public function get_calendar_id(Request $request,$id)
    {
        if ($request->ajax()) {
            return response()->json(Calendar::where('user_id', auth()->user()->id)->where('id',$id)->first());
        }

        abort(404);
    }

    public function create_calendar(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'start.required' => 'Tanggal mulai harus diisi.',
            'start.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'end.required' => 'Tanggal akhir harus diisi.',
            'end.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        $data = Calendar::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'user_id' => auth()->user()->id
        ]);

        if($data){
            toastr()->success('Aktivitas berhasil ditambahkan.');
        } else { 
            toastr()->error('Aktivitas gagal ditambahkan.');
        }

        return redirect()->back();
    }

    public function update_calendar(Request $request, $id)
    {
    
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'start.required' => 'Tanggal mulai harus diisi.',
            'start.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'end.required' => 'Tanggal akhir harus diisi.',
            'end.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        $event = Calendar::where('user_id', auth()->user()->id)->where('id', $id)->first();

        if (!$event) {
            toastr()->error('Aktivitas gagal diperbarui.');
            return redirect()->back();
        }

        $data = $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'allDay' => $request->boolean('allDay'),
        ]);

        if($data){
            toastr()->success('Aktivitas berhasil diperbarui.');
        } else { 
            toastr()->error('Aktivitas gagal diperbarui.');
        }

        return redirect()->back();
    }

    public function delete_calendar(Request $request, $id)
    {
        $data = Calendar::where('user_id', auth()->user()->id)->where('id', $id)->first();

        if (!$data) {
            toastr()->error('Aktivitas gagal dihapus.');
            return redirect()->back();
        }

        if($data->delete()){
            toastr()->success('Aktivitas berhasil dihapus.');
        };

        return redirect()->back();
    }

    public function view_transaction()
    {
        return view('front.freelance.transaction.transaction');
    }

    public function get_transaction(Request $request)
    {
        // if ($request->ajax()) {
            $query = Transaction::select(['id', 'invoice', 'user_id', 'catalog_name', 'package_name', 'package_price', 'status', 'approved', 'created_at'])->with('user')->where('freelance_id', auth()->user()->id);

            return DataTables::of($query)
                    ->addColumn('no', function ($row) {
                        static $counter = 0;
                        return ++$counter;
                    })
                    ->addColumn('invoice', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view_transaction', ['invoice' => $row->invoice]).'" data-toggle="tooltip" data-placement="right" title="Cek detail invoice #'.$row->invoice.'">#'.$row->invoice.'</a>';
                    })
                    ->addColumn('catalog_name', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view-catalog', ['username' => auth()->user()->username,'slug' => Str::slug($row->catalog_name)]).'" data-toggle="tooltip" data-placement="right" title="Cek Katalog '.$row->catalog_name.'">'.$row->catalog_name.'</a>';
                    })
                    ->addColumn('customer', function ($row) {
                        return '<a class="fw-bolder" href="'.route('view_message').'?id='.$row->user_id.'&text=Hallo kak '.$row->user->username.', " data-toggle="tooltip" data-placement="right" title="Chat Customer '.$row->user->username.'">'.$row->user->username.'</a>';
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
                            case 'CANCELLED':
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
                        }
                        return '<h6 class="text-' . $color . '">' . $row->approved . '</h6>';
                    })
                    ->addColumn('aksi', function ($row) {
                        if($row->approved != "APPROVED"){
                            return '<button class="btn btn-primary check" data-id="'.$row->id.'" data-toggle="tooltip" data-placement="right" title="Approve invoice #'.$row->invoice.'"><i class="ti ti-check"></i></button>';
                        }
                    })
                    ->addColumn('created_at', function ($row) {
                        return $row->created_at; 
                    })
                    ->rawColumns(['invoice','catalog_name','customer','status', 'approved', 'aksi'])
                    ->toJson();

        // }

        // abort(404);
    }

    public function approved_transaction(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id'
        ]);
        
        $transaction = Transaction::where('id',$request->transaction_id)->where('freelance_id', auth()->user()->id)->first();

        if ($transaction->approved === "APPROVED") {
            return response()->json(['success' => true, 'message' => 'Status data sudah Approved.']);
        }

        if ($transaction) {
            $transaction->approved = "APPROVED";
            $transaction->save();
    
            return response()->json(['success' => true, 'message' => 'Data berhasil di update.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
    }
}
