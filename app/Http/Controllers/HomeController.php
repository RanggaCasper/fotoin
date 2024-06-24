<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Portofolio;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $catalogs = Catalog::with('category', 'portofolios')->get();
        $categorys = Category::withCount('catalogs')->get();
        return view('front.home.main', compact('catalogs','categorys'));
    }

    public function search_catalog($search)
    {
        if (!$search) {
            toastr()->error('Kata kunci pencarian tidak boleh kosong.');
            return redirect()->route('home');
        }

        $catalogs = Catalog::with('user.freelance','category', 'feedback', 'packages', 'portofolios')->where('title_name', 'like', '%' . $search . '%')->get();
        $categorys = Category::withCount('catalogs')->get();
        return view('front.home.catalog.search-catalog', compact('catalogs','search','categorys'));
    }

    public function search_category($search)
    {
        $data = Category::where('name', $search)->first();
        if($data){
            $catalogs = Catalog::with('user.freelance', 'feedback','category', 'packages', 'portofolios')->where('category_id', $data->id)->get();
            // dd($catalogs);
            $categorys = Category::withCount('catalogs')->get();
            return view('front.home.catalog.search-catalog', compact('catalogs','search','categorys'));
        }

        toastr()->error('Maaf kategori yang anda cari tidak ditemukan.');
        return redirect()->route('home');
    }

    public function view_catalog(Request $request,$username,$slug)
    {
        $catalog = Catalog::with('user.freelance', 'feedback.user' ,'category', 'packages', 'portofolios')->whereHas('user', function($query) use ($username) {
            $query->where('username', $username);
        })->where('slug', $slug)->first();
        // dd($catalog);

        if (!$catalog) {
            toastr()->error('Katalog tidak ditemukan.');
            return redirect()->route('home');
        }

        $session_view = $request->session()->get('viewed_catalogs', []);
        // $request->session()->forget('viewed_catalogs');

        if (!in_array($catalog->id, $session_view)) {
            $catalog->increment('count_views');

            $request->session()->push('viewed_catalogs', $catalog->id);
        }

        return view('front.home.catalog.view-catalog', compact('catalog'));
    }

    public function view_wishlist()
    {
        $user = auth()->user();
        $catalogs = $user->wishlist()->with('catalog', 'catalog.category', 'catalog.user', 'catalog.portofolios', 'catalog.feedback', 'catalog.packages')->get();
        return view('front.home.wishlist.wishlist', compact('catalogs'));
    }

    public function add_wishlist(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Harus login terlebih dahulu!'], 401);
        }

        $userId = auth()->user()->id;
        $catalogId = $request->id;

        $existingWishlist = Wishlist::where('catalog_id', $catalogId)
                                    ->where('user_id', $userId)
                                    ->first();

        if ($existingWishlist) {
            return response()->json(['success' => false, 'message' => 'Katalog sudah ada dalam wishlist Anda!']);
        }

        $wishlist = Wishlist::create([
            'catalog_id' => $catalogId,
            'user_id' => $userId
        ]);

        return response()->json(['success' => true, 'message' => 'Berhasil menambahkan wishlist!']);
    }



    public function remove_wishlist(Request $request)
    {
        $wishlist = Wishlist::where('catalog_id', $request->id)
                            ->where('user_id', auth()->user()->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'message' => 'Berhasil menghapus dari wishlist!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Wishlist tidak ditemukan.']);
        }
    }
}
