<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Package;
use App\Models\Category;
use App\Models\Portofolio;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FreelanceController extends Controller
{
    public function dashboard()
    {
        return view('front.freelance.dashboard.dashboard');
    }

    public function katalog()
    {
        return view('front.freelance.katalog.katalog');
    }

    public function view_katalog()
    {
        $categorys = Category::get();
        // dd($categorys);
        return view('front.freelance.katalog.tambah', compact('categorys'));
    }

    public function create_katalog(Request $request){
        // dd($request->all());

        $catalog = Catalog::create([
            'title_name' => $request->title_name,
            'description' => $request->description,
            'category_id' => $request->category
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
        }

    }
}
