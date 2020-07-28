<?php

declare(strict_types=1);

namespace Calculator;

use Entity\Product;
use Entity\Coupon;

class ProductDiscountCalculator
{
    const MAX_DISCOUNT = 50;

    private Coupon $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function calculate(Product $product): Product
    {
        $this->setAvailableDiscount($product);

        return $product;
    }

    protected function setAvailableDiscount(Product &$product) {
        if ($this->coupon->getDiscount() <= 0) {
            return;
        }

        if ($this->coupon->getDiscount() > self::MAX_DISCOUNT) {
            $product->setDiscount(0);

            return;
        }

        $discountInCents = $product->getPrice() * $this->coupon->getDiscount();
        $product->setDiscount($discountInCents/100);

        $priceWithDiscount = $product->getPrice() - $product->getDiscount();
        $product->setPrice($priceWithDiscount);
    }
}
