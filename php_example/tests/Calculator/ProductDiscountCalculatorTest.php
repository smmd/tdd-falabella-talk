<?php

declare(strict_types=1);

use Entity\Coupon;
use Entity\Product;
use Calculator\ProductDiscountCalculator;
use PHPUnit\Framework\TestCase;

class ProductDiscountCalculatorTest extends TestCase
{
    public function testIsApplyingDiscount(): void
    {
        $coupon = new Coupon();
        $coupon->setDiscount(30);

        $product = new Product();
        $product->setPrice(100);

        $calculator = new ProductDiscountCalculator($coupon);
        $result = $calculator->calculate($product);

        $this->assertEquals(30, $result->getDiscount());
    }

    public function testIsNotApplyingMoreThatMaxDiscount(): void
    {
        $coupon = new Coupon();
        $coupon->setDiscount(51);

        $product = new Product();
        $product->setPrice(100);

        $calculator = new ProductDiscountCalculator($coupon);
        $result = $calculator->calculate($product);

        $this->assertEquals(0, $result->getDiscount());
    }

    public function testIsUpdatingPriceWithDiscount(): void
    {
        $coupon = new Coupon();
        $coupon->setDiscount(40);

        $product = new Product();
        $product->setPrice(100);

        $calculator = new ProductDiscountCalculator($coupon);
        $result = $calculator->calculate($product);

        $this->assertEquals(40, $result->getDiscount());
        $this->assertEquals(60, $result->getPrice());
    }

    public function testIsNotApplyingInvalidDiscounts(): void
    {
        $coupon = new Coupon();
        $coupon->setDiscount(-40);

        $product = new Product();
        $product->setPrice(100);

        $calculator = new ProductDiscountCalculator($coupon);
        $result = $calculator->calculate($product);

        $this->assertEquals(0, $result->getDiscount());
        $this->assertEquals(100, $result->getPrice());
    }
}
