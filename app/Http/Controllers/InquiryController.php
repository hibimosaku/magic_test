<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryForm;

class InquiryController extends Controller
{
    public function index()
    {
        return view('emails.inquiry');
    }
    public function send(request $request)
    {
        $validator = $request->validate([
            // 'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            // 'tel' => 'required|digits_between:10,11',
            // 'postal_code' => 'required|digits:7',
            // 'prefecture' => 'required',
            // 'city' => 'required',
            // 'address1' => 'required|max:255',
            // 'pay' => 'required'
        ], [
            // 'name.required' => '名前は必須項目です。',
            // 'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールは必須項目です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            // 'tel.required' => '電話番号は必須項目です。',
            // 'tel.digits_between' => '有効な電話番号を入力してください。',
            // 'postal_code.required' => '郵便番号は必須項目です。',
            // 'postal_code.digits' => '有効な郵便番号を入力してください。',
            // 'prefecture.required' => '都道府県は必須項目です。',
            // 'city.required' => '市区町村は必須項目です。',
            // 'address1.required' => '番地は必須項目です。',
            // 'address1.max' => '番地は255文字以内で入力してください。',
            // 'pay.required' => '支払いは必須項目です。',
        ]);

        Mail::to($request->email)->send(new InquiryForm());
        // return redirect()->route('top');
    }
}
