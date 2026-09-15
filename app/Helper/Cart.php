<?php

namespace App\Helper;

use App\Models\Voucher;

class Cart
{
    private $items = [];

    private $voucher = null;

    private $discount = 0;

    public function __construct()
    {
        $this->items = session('cart') ?? [];

        $this->voucher = session('voucher');

        $this->recalculateVoucher();
    }



    public function add($tour, $quantity, $transport, $tour_type)
    {
        $item = [

            'tour_id' => $tour->id,

            'tour_name' => $tour->name,

            'transport' => $transport,

            'tour_type' => $tour_type,

            'image' => $tour->image,

            'price' => $tour->sale_price > 0
                ? $tour->sale_price
                : $tour->price,

            'quantity' => max(1, $quantity),

            'start_date' => $tour->start_date,

        ];

        $key = $tour->id.$transport.$tour_type;

        if (isset($this->items[$key])) {

            $this->items[$key]['quantity'] += $quantity;

        } else {

            $this->items[$key] = $item;

        }

        session(['cart' => $this->items]);

        $this->recalculateVoucher();
    }



    public function getItems()
    {
        return $this->items;
    }

    public function getTotalQuantity()
    {
        $total = 0;

        foreach ($this->items as $item) {

            $total += $item['quantity'];

        }

        return $total;
    }

    public function getTotalPrice()
    {
        $total = 0;

        foreach ($this->items as $item) {

            $total +=
                $item['quantity']
                * $item['price'];

        }

        return $total;
    }



    public function applyVoucher($code)
    {
        $voucher = Voucher::where('code', $code)
            ->where('status', 1)
            ->first();

        if (! $voucher) {
            return false;
        }

        session(['voucher' => $voucher]);

        $this->voucher = $voucher;

        $this->recalculateVoucher();

        return true;
    }



    private function recalculateVoucher()
    {
        $this->discount = 0;

        if (! $this->voucher) {

            session()->forget('discount');

            return;
        }

        // FIX: voucher là array
        $voucher = Voucher::find($this->voucher['id'] ?? null);

        if (! $voucher) {

            $this->removeVoucher();

            return;
        }

        // hết hạn
        if ($voucher->end_date && now()->gt($voucher->end_date)) {

            $this->removeVoucher();

            return;
        }

        $total = $this->getTotalPrice();

        // min order
        if ($voucher->min_order_value && $total < $voucher->min_order_value) {

            $this->removeVoucher();

            return;
        }

        // tính discount
        if ($voucher->discount_type == 'percent') {

            $this->discount = $total * $voucher->discount_value / 100;

            if ($voucher->max_discount) {
                $this->discount = min($this->discount, $voucher->max_discount);
            }

        } else {

            $this->discount = $voucher->discount_value;
        }

        session([
            'discount' => $this->discount,
        ]);
    }


    public function getDiscount()
    {
        return $this->discount;
    }

    public function getFinalPrice()
    {
        $final =
            $this->getTotalPrice()
            - $this->discount;

        return max(0, $final);
    }

    public function removeVoucher()
    {
        session()->forget([
            'voucher',
            'discount',
        ]);

        $this->voucher = null;

        $this->discount = 0;
    }

    public function update($id, $quantity)
    {
        if ($quantity < 1) {
            $quantity = 1;
        }

        if (isset($this->items[$id])) {

            $this->items[$id]['quantity'] = $quantity;

        }

        session(['cart' => $this->items]);

        $this->recalculateVoucher();
    }


    public function delete($id)
    {
        if (isset($this->items[$id])) {

            unset($this->items[$id]);

        }

        session(['cart' => $this->items]);

        $this->recalculateVoucher();
    }


    public function clear()
    {
        session()->forget([
            'cart',
            'voucher',
            'discount',
        ]);
    }

    public function setVoucher($voucher)
    {
        if (! $voucher) {
            session()->forget('voucher');

            return;
        }

        session([
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount_type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'max_discount' => $voucher->max_discount,
            ],
        ]);
    }

    public function canUseVoucher($voucher)
    {
        $total = $this->getTotalPrice();
        // hết hạn
        if ($voucher->end_date && now()->gt($voucher->end_date)) {
            return false;
        }

        // đơn tối thiểu
        if ($voucher->min_order_value && $total < $voucher->min_order_value) {
            return false;
        }

        return true;
    }
}
