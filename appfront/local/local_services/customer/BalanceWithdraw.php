<?php
/*
 * @Author: lin
 * @GitHub: https://github.com/foylin/dida
 * @Date: 2019-10-16 00:38:49
 * @Description: 客户 提现记录子服务
 */


namespace appfront\local\local_services\customer;

//use fecshop\models\mysqldb\order\Item as MyOrderItem;
use fecshop\services\Service;
use Yii;

class BalanceWithdraw extends Service
{
    protected $_itemModelName = '\appfront\local\local_models\mysqldb\customer\BalanceWithdraw';

    protected $_itemModel;
    
    public function init()
    {
        parent::init();
        list($this->_itemModelName, $this->_itemModel) = \Yii::mapGet($this->_itemModelName);
    }

    /**
     * 获取处理中的提现记录
     *
     * @return void
     */
    public function getRecordsBywait($customer_id){
        return $data = $this->_itemModel->find()->asArray()->where([
            'customer_id' => $customer_id,
            'status' => 0,
        ])->all();
    }
    
}