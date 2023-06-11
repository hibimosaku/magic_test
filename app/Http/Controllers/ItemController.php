<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product;
use App\Models\SizeDetail;
use App\Models\SecondaryCategory;


class ItemController extends Controller
{
    public function showAll(Request $request)
    {
        $query = Item::where('is_selling', true);

        if ($request->category !== null && $request->category != 0) {
            $query->where('secondary_category_id', $request->category);
        }

        if ($request->order === 'priceHigh') {
            $query->orderBy('price', 'desc');
        } elseif ($request->order === 'low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->order === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->keyword) {
            $keyword = strtolower($request->keyword);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $keyword . '%']);
        }

        $items = $query->paginate(10);

        $categories = SecondaryCategory::all();

        return view('items/all', compact(['items', 'categories']));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        $products = Product::where('item_id', $id)->get();
        $sizeId = $item->size_id;
        $sizes = SizeDetail::where('size_id', $sizeId)->get();
        return view('items.item', compact(['products', 'item', 'sizes']));
    }

    public function showBySecondaryCategory($secondarycategory)
    {

        return view('items.secondaryCategory');
    }

    public function showByPrimaryCategory($secondarycategory, $primarycategory)
    {

        return view('items.primaryCategory');
    }
}
