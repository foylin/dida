<?php

/*
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

// namespace fecshop\services\order;
namespace appfront\local\local_services\order;


//use fecshop\models\mysqldb\order\Item as MyOrderItem;
use fecshop\services\Service;
use Yii;

/**
 * Cart items services.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Share extends Service
{
    protected $_itemModelName = '\appfront\local\local_models\mysqldb\order\Share';

    protected $_itemModel;
    
    public function init()
    {
        parent::init();
        list($this->_itemModelName, $this->_itemModel) = \Yii::mapGet($this->_itemModelName);
    }

    protected function actionSaveOrderShare($items, $order_id){
        

        if(!is_array($items)){
            return false;
        }

        foreach ($items as $item) {
            $percent = 0.10;

            $commission = $item['product_row_price'] * $percent;

            $OrderShare = new $this->_itemModelName();
            $OrderShare['order_id'] = $order_id;
            $OrderShare['customer_id'] = Yii::$app->user->identity->id;
            $OrderShare['share_uid'] = $item['share_uid'];
            $OrderShare['percent'] = $percent;
            $OrderShare['commission'] = $commission;
            $OrderShare['status'] = 0;

            // var_dump($item);
            $saveStatus = $OrderShare->save();
            // 如果保存失败，直接返回。
            if (!$saveStatus) {
                return $saveStatus;
            }
        }
        
    }

    
}
