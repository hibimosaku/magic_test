<?php

namespace App\Http\Controllers;

use Stripe\Exception\CardException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\OrderReceived;
use App\Mail\OrderSuccess;



class OrderController extends Controller
{
    public function index(request $request)
    {
        //カートがなければ、カートにリダイレクト
        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        };
        //リクエスト情報なし（urlを直接たたいたことを想定）
        if ($request->all() === []) {
            $cart = Session::get('cart');
            // error表示書く
            // とりあえず、リダイレクトしとく
            // return redirect()->route('top');
            // abort(500);//エラー画面にいく
        } else {
            $cart = json_decode($request->input('cart'), true);
            // dd($cart);
            foreach ($cart as $item) {
                if (is_array($item)) {
                    $rules = [
                        'name_print1' => isset($item['name_print_num']) && $item['name_print_num'] > 0 ? 'required|max:15' : '',
                        // 'name_print2' => isset($item['name_print_num']) && $item['name_print_num'] > 1 ? 'required|max:15' : '',
                        // 'name_print3' => isset($item['name_print_num']) && $item['name_print_num'] > 2 ? 'required|max:15' : '',
                    ];

                    $messages = [
                        'name_print1.required' => '名入れ1は必須項目です。',
                        // 'name_print2.required' => '名入れ2は必須項目です。',
                        // 'name_print3.required' => '名入れ3は必須項目です。',
                    ];

                    $validator = Validator::make($item, $rules, $messages);

                    if ($validator->fails()) {
                        $errors = $validator->errors()->all();
                        // エラーメッセージの処理
                        session()->flash('errors', $errors);
                        return redirect()->back()->withInput();
                    }
                }
            }
        }
        $allSum = 0;
        foreach ($cart as $key => $item) {
            if (isSelling($item) === 0) {
                unset($cart[$key]);
            } else {
                $allSum += $item['price'] * $item['num'];
            }
        };
        return view('order', compact(['cart', 'allSum']));
    }


    //購入確認ページ
    public function indexConfirm(Request $request)
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        };

        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|digits_between:10,11',
            'postal_code' => 'required|digits:7',
            'prefecture' => 'required',
            'city' => 'required',
            'address1' => 'required|max:255',
            'pay' => 'required'
        ], [
            'name.required' => '名前は必須項目です。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールは必須項目です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'tel.required' => '電話番号は必須項目です。',
            'tel.digits_between' => '有効な電話番号を入力してください。',
            'postal_code.required' => '郵便番号は必須項目です。',
            'postal_code.digits' => '有効な郵便番号を入力してください。',
            'prefecture.required' => '都道府県は必須項目です。',
            'city.required' => '市区町村は必須項目です。',
            'address1.required' => '番地は必須項目です。',
            'address1.max' => '番地は255文字以内で入力してください。',
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
            'tel' => $request->tel,
            'pay' => $request->pay,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'city' => $request->city,
            'address1' => $request->address1,
            'address2' => $request->address2,
        ];

        Session::put('user_info', $user_info);
        return view('orderConfirm', compact(['cart', 'allSum', 'user_info']));
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
        if (!Session::has('cart') || !Session::has('user_info')) {
            return redirect()->route('order.fail');
        }

        $user_info = Session::get('user_info');
        $pay = $user_info['pay'];
        $email = $user_info['email'];
        $cart = Session::get('cart');

        if ($pay == 'cash' || $pay == 'bank') {
            if (!Session::has('cart') || !Session::has('user_info')) {
                return redirect()->route('order.fail');
            }
        }

        if ($pay == 'cash') {
            createDb('cash', '');
            // メール送信
            Mail::to($email)->cc($email)->send(new OrderReceived($user_info, $cart));
        } elseif ($pay == 'bank') {
            createDb('bank', '');
            // メール送信
            Mail::to($email)->send(new OrderReceived($user_info, $cart));
            Mail::to($email)->send(new OrderSuccess($user_info, $cart));
        } else {
            createDb('credit', '');
            // メール送信
            Mail::to($email)->cc($email)->send(new OrderReceived($user_info, $cart));
        };

        // カート情報取得

        // 画像削除
        $cart = Session::get('cart', []);
        foreach ($cart as $index => &$item) {
            $imagePathToDelete = $item['image_path'];
            unset($cart[$index]);
            $imagePathToDelete = $item['image_path'];
            if (!empty($imagePathToDelete)) {
                $fullImagePath = storage_path('app/public/' . $imagePathToDelete);
                if (file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                }
            }
        }
        // cart情報削除
        session()->flush();

        return view('success', compact('pay'));
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
    $purchase->tel = $user_info['tel'];
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
        $purchaseDetail->name_print1 = $item['name_print1'] ?? null;
        $purchaseDetail->name_print2 = $item['name_print2'] ?? null;
        $purchaseDetail->name_print3 = $item['name_print3'] ?? null;

        $purchaseDetail->save();
    }
}

function isSelling($item)
{
    return Item::where('id', $item['itemId'])->first()->is_selling;
};
