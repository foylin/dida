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
    const ShareAddText = '推广商品分成';

    protected $_itemModelName = '\appfront\local\local_models\mysqldb\order\Share';

    protected $_itemModel;
    
    public function init()
    {
        parent::init();
        list($this->_itemModelName, $this->_itemModel) = \Yii::mapGet($this->_itemModelName);
    }

    /**
     * 保存分享数据
     *
     * @param [type] $items
     * @param [type] $order_id
     * @return void
     */
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

    /**
     * 收货确认 - 派发分享所得金额，并记录
     *
     * @param [type] $order_id
     * @return void
     */
    protected function actionConfim($incrementId, $customerId){
        // echo $customerId;

        $items = $this->_itemModel->find()->asArray()->where([
            'increment_id' => $incrementId,
            'customer_id' => $customerId
        ])->all();

        if($items){
            foreach ($items as $item) {
                # code...
                $updateComules = $this->_itemModel->updateAll(
                    [
                        'status' => 1,
                    ],
                    [
                        'increment_id'  => $incrementId,
                        'order_id' => $item['order_id'],
                        'order_item_id' => $item['order_item_id'],
                        'status' => 0,
                        'customer_id' => $customerId,
                    ]
                );
                
                $recordsItem['customer_id'] = $item['share_uid'];
                $recordsItem['account_type'] = 1;
                $recordsItem['sign'] = 1;
                $recordsItem['number'] = $item['commission'];
                $recordsItem['from_type'] = 1;
                $recordsItem['data_id'] = $item['order_id'];
                $recordsItem['text'] = self::ShareAddText;
                Yii::$service->customer->accountrecords->addRecords($recordsItem);
            
            }
            
        }
        
        print_r($item);exit;
        

        

        return $updateComules;
        
    }

    
}
