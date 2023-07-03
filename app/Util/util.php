<?php

namespace App\Util;

use App\Models\Item;

class Util
{
  public static function calcShippingFee($allSum)
  {
    $FREEPRICE = 3980;
    $SHIPPINGFEE = 990;

    return $allSum >= $FREEPRICE ? 0 : $SHIPPINGFEE;
  }
  public static function calcCartSum($cart)
  {
    $cartSum = 0;
    foreach ($cart as $item) {
      $cartSum += $item['price_tax'] * $item['num'];
    };
    return $cartSum;
  }

  public static function updateSessionCart($cart)
  {
    $itemsTb = Item::all();
    foreach ($cart as $index => &$item) {
      $itemTb = $itemsTb->where('id', $item['itemId'])->first();
      // 価格更新
      if ($itemTb && $item['price_tax'] !== $itemTb['price_tax']) {
        $item['price_tax'] = $itemTb['price_tax'];
      }
      // 商品販売停止
      if ($itemTb && $itemTb['is_selling'] === 0) {
        unset($cart[$index]);
      }
    }

    return $cart;
  }
}
