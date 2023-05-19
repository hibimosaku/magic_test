<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
   public function index(request $request){
      if($request->all()===[]){
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
      foreach($cart as $item){
         $allSum += $item['price'] * $item['num'];
      };
      return view('order',compact(['cart','allSum']));
   }
   
   

   public function indexConfirm(Request $request)
{

    $validator = $request->validate([
        'postal_code' => 'required|max:8',
        'prefecture' => 'required',
        'city' => 'required',
        'address1' => 'required',
        'pay' => 'required'
    ], [
        'postal_code.required' => '郵便番号は必須項目です。',
        'postal_code.max' => '郵便番号は8文字以内で入力してください。',
        'prefecture.required' => '都道府県は必須項目です。',
        'city.required' => '市区町村は必須項目です。',
        'address1.required' => '番地は必須項目です。',
        'pay.required' => '支払いは必須項目です。',
    ]);

    $cart = json_decode($request->input('cart'), true);
    $allSum = 0;
    foreach($cart as $item){
      $allSum += $item['price'] * $item['num'];
   };

    $pay = $request->pay;
    $postal_code = $request->postal_code;
    $prefecture = $request->prefecture;
    $city = $request->city;
    $address1 = $request->address1;
    $address2 = $request->address2;
    return view('orderConfirm',compact(['pay','cart','allSum','postal_code','prefecture','city','address1','address2']));
}

   public function success()
    {
        return view('orderConfirm');
    }
}
