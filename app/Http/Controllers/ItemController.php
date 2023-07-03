<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product;
use App\Models\SizeDetail;
use App\Models\SecondaryCategory;
use App\Models\PrimaryCategory;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Session;



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
        } elseif ($request->order === 'priceLow') {
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

        $itemId = $item->id;
        $color = $item->color;
        $size = $item->size;


        return view('items.item', compact(['products', 'item', 'sizes']));
    }

    public function showByPrimaryCategory(Request $request, $primarycategoryid)
    {
        $query = Item::whereHas('secondaryCategory', function ($query) use ($primarycategoryid) {
            $query->where('primary_category_id', $primarycategoryid);
        });
        if ($request->category !== null && $request->category != 0) {
            $query->where('secondary_category_id', $request->category);
        }

        if ($request->order === 'priceHigh') {
            $query->orderBy('price_tax', 'desc');
        } elseif ($request->order === 'priceLow') {
            $query->orderBy('price_tax', 'asc');
        } elseif ($request->order === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $items = $query->paginate(10);

        $primarycategory = PrimaryCategory::where('id', $primarycategoryid)->first();
        $secondarycategory = SecondaryCategory::where('primary_category_id', $primarycategoryid)->get();

        return view('items.primaryCategory', compact('primarycategory', 'secondarycategory', 'items', 'request'));
    }

    public function showBySecondaryCategory(Request $request, $primarycategoryid, $secondarycategoryid)
    {
        $query = Item::where('is_selling', true)->where('secondary_category_id', $secondarycategoryid);

        if ($request->order === 'priceHigh') {
            $query->orderBy('price_tax', 'desc');
        } elseif ($request->order === 'priceLow') {
            $query->orderBy('price_tax', 'asc');
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
        $category = SecondaryCategory::where('id', $secondarycategoryid)->first();
        return view('items.secondaryCategory', compact('items', 'category', 'request'));
    }
}
