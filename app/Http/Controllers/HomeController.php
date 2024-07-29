<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $catalogs = Catalog::with('user.freelance','category', 'feedback', 'packages', 'portofolios','transactions')->where('status','on')->get();
        $categorys = Category::withCount('catalogs')->get();
        return view('front.home.main', compact('catalogs','categorys'));
    }

    public function search(Request $request, $search)
    {
        if (!$search) {
            toastr()->error('Kata kunci pencarian tidak boleh kosong.');
            return redirect()->route('home');
        }

        $catalogs = Catalog::with('user.freelance', 'category', 'feedback', 'packages', 'portofolios', 'transactions')
            ->where('title_name', 'like', '%' . $search . '%')
            ->where('status','on')
            ->orWhereHas('category', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $categorys = Category::withCount('catalogs')->get();

        return view('front.home.catalog.search-catalog', compact('catalogs', 'search', 'categorys'));
    }

    public function get_catalog(Request $request, $search)
    {
        $catalogs = Catalog::with('user.freelance', 'category', 'feedback', 'packages', 'portofolios')
            ->where('title_name', 'like', '%' . $search . '%')
            ->where('status','on')
            ->orWhereHas('category', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        return view('front.home.catalog.get-catalog', compact('catalogs'))->render();
    }

    public function view_catalog(Request $request,$username,$slug)
    {
        $catalog = Catalog::with('user.freelance', 'feedback.user' ,'category', 'packages', 'portofolios', 'transactions')->where('status','on')->whereHas('user', function($query) use ($username) {
            $query->where('username', $username);
        })->where('slug', $slug)->first();

        if (!$catalog) {
            toastr()->error('Katalog tidak ditemukan.');
            return redirect()->route('home');
        }

        $session_view = $request->session()->get('viewed_catalogs', []);

        if (!in_array($catalog->id, $session_view)) {
            $catalog->increment('count_views');

            $request->session()->push('viewed_catalogs', $catalog->id);
        }

        return view('front.home.catalog.view-catalog', compact('catalog'));
    }

    public function view_wishlist()
    {
        $user = auth()->user();
        $catalogs = $user->wishlist()->with('catalog', 'catalog.category', 'catalog.user', 'catalog.portofolios', 'catalog.feedback', 'catalog.packages', 'catalog.transactions')->get();
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
