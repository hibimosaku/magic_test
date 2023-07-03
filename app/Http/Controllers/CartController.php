<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Item;
use App\Models\Image;
use App\Models\ImagePrint;
use App\Models\Color;
use App\Models\Size;
use App\Models\SizeDetail;
use Carbon\Carbon;
use App\Util\Util;


define('ITEMNUM', 10);

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        // 最新情報に更新
        $updateCart = Util::updateSessionCart($cart);

        Session::put('cart', $updateCart);
        $cart = Session::get('cart', []);

        $cartSum = Util::calcCartSum($cart);
        $shippingFee = Util::calcShippingFee($cartSum);
        $allSum = $cartSum + $shippingFee;
        return view('cart', compact('cart', 'allSum', 'cartSum', 'shippingFee'))->with('ITEMNUM', ITEMNUM);
    }
    public function add(Request $request)
    {
        $request->validate([
            'name_print1' => $request->name_print_num > 0 ? 'required|max:15' : '',
            'name_print2' => $request->name_print_num > 1 ? 'required|max:15' : '',
            'name_print3' => $request->name_print_num > 2 ? 'required|max:15' : '',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name_print1.required' => '名入れ1は必須項目です。',
            'name_print1.max' => '名入れ1は25文字以内で入力してください。',
            'name_print2.required' => '名入れ2は必須項目です。',
            'name_print2.max' => '名入れ1は25文字以内で入力してください。',
            'name_print3.required' => '名入れ3は必須項目です。',
            'name_print3.max' => '名入れ1は25文字以内で入力してください。',
            'image.required' => '画像は必須項目です。',
            'image.image' => '有効な画像ファイルを選択してください。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式のファイルである必要があります。',
            'image.max' => '画像サイズは2MB以内でアップロードしてください。',
        ]);

        $item = Item::where('id', $request->input('item_id'))->first();
        $image1 = Image::where('id', $item->image1)->first();
        $image2 = Image::where('id', $item->image2)->first();
        $image3 = Image::where('id', $item->image3)->first();
        $image4 = Image::where('id', $item->image4)->first();

        $image = $request->file('image');
        $imagePath = null;
        if ($image) {
            $originalFilename = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $uniqueFilename = uniqid() . '_' . pathinfo($originalFilename, PATHINFO_FILENAME);
            $imagePath = $image->storeAs('images', $uniqueFilename . '.' . $extension, 'public');
        }
        $item = Item::where('id', $request->input('item_id'))->first();
        $cart_info = [
            'product_id' => Product::where('item_id', $request->input('item_id'))->where('color_id', $request->input('color'))->first()->id,
            'itemId' => $request->input('item_id'),
            'name' => $item->name,
            'image1' => $image1 ? $image1->filename : null,
            'image2' => $image2 ? $image2->filename : null,
            'image3' => $image3 ? $image3->filename : null,
            'image4' => $image4 ? $image4->filename : null,
            'color' => $request->input('color'),
            'colorName' => Color::where('id', $request->input('color'))->first()->name,
            'size' => $request->input('size'),
            'sizeName' => SizeDetail::where('id', $request->input('size'))->first()->name,
            'num' => $request->input('num'),
            'price' => $item['price'],
            'price_tax' => $item['price_tax'],
            'name_print_num' => $item->name_print_num,
            'name_print1' => $request->name_print_num > 0 ? $request->input('name_print1') : null,
            'name_print2' => $request->name_print_num > 1 ? $request->input('name_print2') : null,
            'name_print3' => $request->name_print_num > 2 ? $request->input('name_print3') : null,
            'image_path' => $imagePath ?? null
        ];
        $cart = Session::get('cart', []);
        $exists = false;
        foreach ($cart as &$item) {
            if ($item['itemId'] === $cart_info['itemId'] && $item['color'] === $cart_info['color'] && $item['size'] === $cart_info['size'] && $item['name_print_num'] === 0) {
                $item['num'] += $cart_info['num'];
                $exists = true;
                break;
            }
        };
        unset($item);

        if (!$exists) {
            $cart[] = $cart_info;
        }
        Session::put('cart', $cart);

        if ($imagePath) {
            ImagePrint::create([
                'filepath' => $imagePath,
                'expired_date' => Carbon::now()->addMinutes(env('SESSION_LIFETIME')),
                'item_id' => $request->input('item_id')
            ]);
        }


        return back();
    }

    public function updateNum(Request $request, $id, $color, $size)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as $index => &$item) {
            if ($item['itemId'] === $id && $item['color'] === $color && $item['size'] === $size) {
                $item['num'] = $request->num;
                break;
            }
        }
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function updateName(Request $request, $id, $color, $size)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as $index => &$item) {
            if ($item['itemId'] === $id && $item['color'] === $color && $item['size'] === $size) {
                $item['name_print1'] = $request->name_print1;
                break;
            }
        }
        Session::put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function delete($id, $color, $size)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as $index => &$item) {
            if ($item['itemId'] === $id && $item['color'] === $color && $item['size'] === $size) {
                $imagePathToDelete = $item['image_path'];
                if (!empty($imagePathToDelete)) {
                    $fullImagePath = storage_path('app/public/' . $imagePathToDelete);
                    if (file_exists($fullImagePath)) {
                        unlink($fullImagePath);
                        // TB削除
                        ImagePrint::where('filepath', $imagePathToDelete)->delete();
                    }
                }
                unset($cart[$index]);
                break;
            }
        };
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function sessionStripe(request $request)
    {
        $hasSession = Session::has('cart');
        if ($hasSession) {
            return response()->json(['hasSession' => $hasSession]);
        } else {
            $paymentId = $request->query('pay');
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentId);
            $paymentIntent->cancel();
            session()->flush();

            return response()->json(['hasSession' => $hasSession]);
        }
    }
}
