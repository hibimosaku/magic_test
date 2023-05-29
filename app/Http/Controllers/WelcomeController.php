<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Item;
use App\Models\SizeDetail;
use App\Models\SecondaryCategory;
use Illuminate\Support\Facades\Session;


class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // カテゴリー選択時
        if ($request->category === null || $request->category == 0) {
            $items = Item::orderBy('created_at', 'desc')->paginate(3);
        } else {
            $items = Item::where('secondary_category_id', $request->category)->paginate(3);
        }


        //　検索ワード機能

        //  並び替え機能


        $categories = SecondaryCategory::all();

        // dd($items, $categories);
        return view('welcome', compact(['items', 'categories']));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        $products = Product::where('item_id', $id)->get();
        $sizeId = $item->size_id;
        $sizes = SizeDetail::where('size_id', $sizeId)->get();
        return view('show', compact(['products', 'item', 'sizes']));
    }
};
