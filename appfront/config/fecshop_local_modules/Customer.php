<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    /**
     * Customer 模块的配置，您可以在@appfront/config/fecshop_local_modules/Customer.php 
     * 中进行配置，二开，或者重写该模块（在上面路径中如果文件不存在，自行新建配置文件。）
     */
    'customer' => [
        // 'class' => '\appfront\local\local_modules\Customer\Module',
        'controllerMap' => [
            'ajax' => 'appfront\local\local_modules\Customer\controllers\AjaxController',
            'order' => 'appfront\local\local_modules\Customer\controllers\OrderController',             
         ],

        
        
    ],
];
