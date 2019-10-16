<?php

/*
 * @Author: lin
 * @GitHub: https://github.com/foylin/dida
 * @Date: 2019-10-16 00:20:41
 * @Description: 客户扩展配置
 */

return [
    'customer' => [
        'class' => 'appfront\local\local_services\Customer',
        // 子服务
        'childService' => [
            'accountrecords' => [
                'class' => 'appfront\local\local_services\customer\AccountRecords',
            ],
            'account' => [
                'class' => 'appfront\local\local_services\customer\Account',
            ],
            
        ],
        /*
        //'increment_id' => '',
        'requiredAddressAttr' => [ # 必填的订单字段。
            'first_name',
            'last_name',
            'email',
            'telephone',
            'street1',
            'country',
            'city',
            'state',
            'zip'
        ],
        #处理多少分钟后，支付状态为pending的订单，归还库存。
        'minuteBeforeThatReturnPendingStock' 	=>  60,
        # 脚本一次性处理多少个pending订单。
        'orderCountThatReturnPendingStock' 		=>  30,
        # 子服务
        'childService' => [
            'item' => [
                'class' => 'fecshop\services\order\Item',
            ],
        ],
        */
    ],
];
