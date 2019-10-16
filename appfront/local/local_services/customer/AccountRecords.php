<?php
/*
 * @Author: lin
 * @GitHub: https://github.com/foylin/dida
 * @Date: 2019-10-16 00:38:49
 * @Description: 客户 流水账 子服务
 */


namespace appfront\local\local_services\customer;

//use fecshop\models\mysqldb\order\Item as MyOrderItem;
use fecshop\services\Service;
use Yii;

class AccountRecords extends Service
{
    protected $_itemModelName = '\appfront\local\local_models\mysqldb\customer\AccountRecords';

    protected $_itemModel;
    
    public function init()
    {
        parent::init();
        list($this->_itemModelName, $this->_itemModel) = \Yii::mapGet($this->_itemModelName);
    }

    /**
     * 新增 流水帐
     *
     * @param [type] $customer_id
     * @param [type] $account_type
     * @param [type] $sign
     * @param [type] $number
     * @param [type] $from_type
     * @param [type] $data_id
     * @param [type] $text
     * @return void
     */
    protected function actionAddRecords($item){
        print_r($item);

        $recordsItem = new $this->_itemModelName();
        $recordsItem['customer_id'] = $item['customer_id'];
        $recordsItem['account_type'] = $item['account_type'];
        $recordsItem['sign'] = $item['sign'];
        $recordsItem['number'] = $item['number'];
        $recordsItem['from_type'] = $item['from_type'];
        $recordsItem['data_id'] = $item['data_id'];
        $recordsItem['text'] = $item['text'];
        $recordsItem['created_at'] = time();

        $saveStatus = $recordsItem->save();
        
        // 新增成功 更新账户金额 
        if($saveStatus){
            Yii::$service->customer->account->UpdateAccount($item['customer_id'], 1, $item['number'], $item['sign']);
        }
    }

    

    
}