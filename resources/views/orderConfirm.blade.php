<?php
$url = env('APP_URL');
?>

@extends('layouts.layout-nonav')

@section('content')

<head>
      <link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
      <script src="https://js.stripe.com/v3/"></script>
</head>


<form method="GET" action="{{route('order.success')}}">
      @csrf
      <input type="hidden" name="cart" value="{{json_encode($cart)}}">
      @foreach($cart as $item)
      <img style="height:50px;" src="{{ asset('images/item/'. $item['image1'] ?? '') }}">
      <p>名前：{{$item['name']}}</p>
      <p>色：{{$item['colorName']}}</p>
      <p>サイズ：{{$item['sizeName']}}</p>
      <p>価格：{{number_format($item['price'])}}円</p>
      <p>数：{{$item['num']}}</p>
      @if($item['name_print_num'] > 0)
      <p>名入れ1：{{$item['name_print1']}}</p>
      @endif
      @if($item['name_print_num'] > 1)
      <p>名入れ2：{{$item['name_print2']}}</p>
      @endif
      @if($item['name_print_num'] > 2)
      <p>名入れ3：{{$item['name_print3']}}</p>
      @endif
      @if($item['image_path'])
      <img src="{{ asset('storage/' . $item['image_path']) }}" alt="画像">
      @endif

      <p>合計：{{number_format($item['price']*$item['num'])}}円</p>
      <hr>
      @endforeach
      <p>総額：{{number_format($allSum)}}円</p>
      <p>個人名：{{$user_info['name']}}</p>
      <p>アドレス名：{{$user_info['email']}}</p>
      <p>送り先</p>
      <p>〒{{$user_info['postal_code']}}</p>
      <p>{{$user_info['prefecture']}}{{$user_info['city']}}{{$user_info['address1']}}{{$user_info['address2']}}</p>
      <p>支払い方法：{{$user_info['pay']}}</p>
      @if($user_info['pay'] !== 'credit')
      <button class="button" type="submit">注文確定</button>
      @endif
</form>
@if($user_info['pay'] === 'credit')
<form id="payment-form">
      <table>
            <tr>
                  <th>シナリオ
                  <th>テスト用のクレジット番号
            </tr>
            <tr>
                  <td>カード支払いは成功し、認証は必要とされません。</td>
                  <td>4242 4242 4242 4242</td>
            </tr>
            <tr>
                  <td>カード支払いには認証が必要です。</td>
                  <td>4000 0025 0000 3155</td>
            </tr>
            <tr>
                  <td>カードは、insufficient_funds などの拒否コードで拒否されます。</td>
                  <td>4000 0000 0000 9995</td>
            </tr>
            <tr>
                  <td>13～19桁以外</td>
                  <td>6205 500 0000 0000 0004</td>
            </tr>
      </table>
      <hr>
      <!-- <div id="payment-form"> -->
      <!-- @csrf -->
      <div id="link-authentication-element">
            <!-- リンク認証要素を表示するための要素です。
            Stripe.jsがこの要素を注入してリンク認証を処理します。
            リンク認証は、一部の支払い方法（例：銀行振込）で使用されるセキュリティ手段です。 -->
            <!--Stripe.js injects the Link Authentication Element-->
      </div>
      <div id="payment-element">
            <!-- 支払い要素を表示するための要素です。
            Stripe.jsがこの要素を注入して支払い情報の入力フィールドを提供します。
            ユーザーはここでクレジットカード情報やその他の支払い情報を入力します。 -->
            <!--Stripe.js injects the Payment Element-->
      </div>
      <div id="payment-message" class="hidden"></div>
      <!-- <button id="submit" onClick="checkStatus()"> -->
      <button class="button" id="submit">
            <div class="spinner hidden" id="spinner"></div>
            <span id="button-text">注文確定</span>
      </button>
</form>
@endif
<script>
      // This is your test publishable API key.
      // async function btnstripe(){
      // const stripe = Stripe(env('STRIPE_PUBLIC_KEY'));
      const stripe = Stripe("pk_test_51N2o9WL7ySdWxWBC0GVLhnK80yv58Y4iZBox4reW9wNz8EYQZoNKNLS26ssSNXwlLYUGNIJ8YfxJwsPsdNZuP8JV00HVencmzu");
      const csrfToken = "{{ csrf_token() }}";
      // The items the customer wants to buy
      // const items = [{{$allSum}}];
      const pay = "{{$user_info['pay']}}";
      let elements;
      if (pay === 'credit') {
            initialize();
            checkStatus();
            document
                  .querySelector("#payment-form")
                  .addEventListener("submit", handleSubmit);
            let emailAddress = 'n.kubomitsu@gmail.com';
      }
      // Fetches a payment intent and captures the client secret
      let payid = {}
      async function initialize() {
            const data = {
                  items: [{
                              id: "{{$allSum}}",
                              name: 'name1'
                        },
                        {
                              id: "{{$allSum}}",
                              name: 'name2'
                        }
                  ],
                  allSum: "{{$allSum}}"
            };
            const {
                  clientSecret,
                  paymentId
            } = await fetch("{{$url}}/order/checkout", {
                  method: "POST",
                  headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                  },

                  body: JSON.stringify(data),
            }).then((r) => {
                  console.log('succc', r)
                  return r.json()
            }).catch((e) => {
                  console.log('er', e)
            })
            payid = paymentId;
            elements = stripe.elements({
                  clientSecret
            });

            const linkAuthenticationElement = elements.create("linkAuthentication");
            linkAuthenticationElement.mount("#link-authentication-element");

            const paymentElementOptions = {
                  layout: "tabs",
            };

            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");
      }

      async function handleSubmit(e) {
            const csrfToken = "{{ csrf_token() }}";

            e.preventDefault();
            setLoading(true);
            const hasSession = await fetch(`{{$url}}/cart/sessionStripe?pay=${payid}`, {
                  method: "POST",
                  headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                  },
            })
            const sessionData = await hasSession.json();
            if (sessionData.hasSession === false) {
                  alert('時間の経過により、失敗しました。')
                  window.location.href = "{{$url}}";

                  return
            } else {
                  console.log('aaf')
                  const {
                        error
                  } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                              // Make sure to change this to your payment completion page
                              return_url: '{{$url}}/order/success',
                              receipt_email: "n.kubomitsu@gmail.com",
                        },
                  });
                  console.log(error)
                  // This point will only be reached if there is an immediate error when
                  // confirming the payment. Otherwise, your customer will be redirected to
                  // your `return_url`. For some payment methods like iDEAL, your customer will
                  // be redirected to an intermediate site first to authorize the payment, then
                  // redirected to the `return_url`.
                  if (error.type === "card_error" || error.type === "validation_error") {
                        showMessage(error.message);
                  } else {
                        showMessage("An unexpected error occurred.");
                  }
            }

            setLoading(false);
      }

      // Fetches the payment intent status after payment submission
      async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                  "payment_intent_client_secret"
            );
            if (!clientSecret) {
                  console.log('fdaf');
                  return;
            }
            const {
                  paymentIntent
            } = await stripe.retrievePaymentIntent(clientSecret);
            switch (paymentIntent.status) {
                  case "succeeded":
                        showMessage("Payment succeeded!");
                        break;
                  case "processing":
                        showMessage("Your payment is processing.");
                        break;
                  case "requires_payment_method":
                        showMessage("Your payment was not successful, please try again.");
                        break;
                  default:
                        showMessage("Something went wrong.");
                        break;
            }
      }

      // ------- UI helpers -------

      function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");
            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function() {
                  messageContainer.classList.add("hidden");
                  messageText.textContent = "";
            }, 4000);
      }

      // Show a spinner on payment submission
      function setLoading(isLoading) {
            if (isLoading) {
                  // Disable the button and show a spinner
                  document.querySelector("#submit").disabled = true;
                  document.querySelector("#spinner").classList.remove("hidden");
                  document.querySelector("#button-text").classList.add("hidden");
            } else {
                  document.querySelector("#submit").disabled = false;
                  document.querySelector("#spinner").classList.add("hidden");
                  document.querySelector("#button-text").classList.remove("hidden");
            }
      }
</script>
@endsection