<?php
/**
 * FecShop file.
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'cart' => [
        'class' => 'appfront\local\local_services\Cart',

        // 子服务
        'childService' => [
            'quote' => [
                'class' => 'appfront\local\local_services\cart\Quote',
            ],
            'quoteItem' => [
                'class' => 'appfront\local\local_services\cart\QuoteItem',
            ],

            // 'info' => [
                // 'class' => 'fecshop\services\cart\Info',
                /*
                 * 单个sku加入购物车的最大个数。
                 */
                //'maxCountAddToCart' => 100,
                // 上架状态产品加入购物车时，
                // 如果addToCartCheckSkuQty设置为true，则需要检查产品qty是否>购买qty，
                // 如果设置为false，则不需要，也就是说产品库存qty小于购买qty，也是可以加入购物车的。
                //'addToCartCheckSkuQty' => false,
            // ],
            // 'coupon' => [
            //     'class' => 'fecshop\services\cart\Coupon',
            // ],
        ],
    ],
];
