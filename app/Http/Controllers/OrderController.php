<?php

namespace App\Http\Controllers;

use Stripe\Exception\CardException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Purchase;
use App\Models\PurchaseDetail;


class OrderController extends Controller
{
    public function index(request $request)
    {

        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        };
        if ($request->all() === []) {
            // error表示書く
            // とりあえず、リダイレクトしとく
            // return redirect()->route('top');
        }
        // $cart = json_decode($request->input('cart'), true);
        // $errors = session()->get('errors');
        // if($errors){

        //    return view('order', ['errors' => $errors]);
        // };
        $cart = json_decode($request->input('cart'), true);
        $allSum = 0;
        foreach ($cart as $item) {
            $allSum += $item['price'] * $item['num'];
        };
        return view('order', compact(['cart', 'allSum']));
    }


    //最終購入確認ページ
    public function indexConfirm(Request $request)
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        };

        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'postal_code' => 'required|max:8',
            'prefecture' => 'required',
            'city' => 'required',
            'address1' => 'required',
            'pay' => 'required'
        ], [
            'name.required' => '名前は必須項目です。',
            'email.required' => 'メールは必須項目です。',
            'postal_code.required' => '郵便番号は必須項目です。',
            'postal_code.max' => '郵便番号は8文字以内で入力してください。',
            'prefecture.required' => '都道府県は必須項目です。',
            'city.required' => '市区町村は必須項目です。',
            'address1.required' => '番地は必須項目です。',
            'pay.required' => '支払いは必須項目です。',
        ]);

        $cart = json_decode($request->input('cart'), true);
        $allSum = 0;
        foreach ($cart as $item) {
            $allSum += $item['price'] * $item['num'];
        };
        $user_info = [
            'name' => $request->name,
            'email' => $request->email,
            'pay' => $request->pay,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'city' => $request->city,
            'address1' => $request->address1,
            'address2' => $request->address2,
        ];
        $name = $request->name;
        $email = $request->email;
        $pay = $request->pay;
        $postal_code = $request->postal_code;
        $prefecture = $request->prefecture;
        $city = $request->city;
        $address1 = $request->address1;
        $address2 = $request->address2;

        Session::put('user_info', $user_info);
        return view('orderConfirm', compact(['name', 'email', 'pay', 'cart', 'allSum', 'postal_code', 'prefecture', 'city', 'address1', 'address2']));
    }


    public function checkout(request $request)
    {
        if (!Session::has('cart') || !Session::has('user_info')) {
            return redirect()->route('order.fail');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {
            $items = $request->input('items');
            $metadataArray = [];

            foreach ($items as $index => $item) {
                $metadataArray['商品' . $index] = $item['id'] . ',' . $item['name'];
            }


            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $request->input('allSum'),
                'currency' => 'jpy',
                'automatic_payment_methods' => [
                    'enabled' => false,
                ],
                // 'customer' => '',これは使えない
                // 'description' => $request->json('items')[0]['id'],

                'metadata' => $metadataArray
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'paymentId' => $paymentIntent->id
            ];
            // Session::migrate(true); //sessionの期間を更新
            Session::put('paymentId', $paymentIntent->id);
            return response()->json($output);
        } catch (CardException $e) {
            http_response_code($e->getHttpStatus());
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        return redirect()->route('success');
    }

    public function success(request $request)
    {
        if ($request->pay == 'cash' || $request->pay == 'bank') {
            if (!Session::has('cart') || !Session::has('user_info')) {
                return redirect()->route('order.fail');
            }
        }


        if ($request->pay == 'cash') {
            createDb('cash', '');
            // メール送信

        } elseif ($request->pay == 'bank') {
            createDb('bank', '');
            // メール送信
        } else {
            createDb('credit', '');

            // メール送信
        };

        // カート情報取得


        // cart情報削除
        session()->flush();
        return view('success');
    }

    public function fail()
    {
        return view('fail');
    }

    public function cancel(request $request)
    {
        $paymentId = $request->pay;
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentId);
        $paymentIntent->cancel();
        session()->flush();

        return response()->json(['result' => true]);
    }
}


function createDb($pay, $user_id)
{
    $cart = Session::get('cart', []);
    $user_info = Session::get('user_info');
    $paymentId = Session::get('paymentId', "");

    $purchase = new Purchase;
    $purchase->user_id = $user_id;
    $purchase->name = $user_info['name'];
    $purchase->email = $user_info['email'];
    $purchase->pay = $pay;
    $purchase->payId = $paymentId;
    $purchase->postal_code = $user_info['postal_code'];
    $purchase->prefecture = $user_info['prefecture'];
    $purchase->city = $user_info['city'];
    $purchase->address1 = $user_info['address1'];
    $purchase->address2 = $user_info['address2'];
    $purchase->save();
    $newId = $purchase->id;

    foreach ($cart as $item) {
        $purchaseDetail = new PurchaseDetail;

        $purchaseDetail->purchase_id = $newId;
        $purchaseDetail->product_id = $item['product_id'];
        $purchaseDetail->size_detail_id = $item['size'];
        $purchaseDetail->num = $item['num'];
        $purchaseDetail->price = $item['price'];
        $purchaseDetail->save();
    }
}
