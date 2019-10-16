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

class Account extends Service
{
    protected $_itemModelName = '\appfront\local\local_models\mysqldb\customer\Account';

    protected $_itemModel;
    
    public function init()
    {
        parent::init();
        list($this->_itemModelName, $this->_itemModel) = \Yii::mapGet($this->_itemModelName);
    }

    /**
     * 更新账户统计
     *
     * @param [type] $customer_id
     * @param [type] $type 类型 1-余额，2-积分
     * @param [type] $number 数量
     * @param [type] $sign 正负
     * @return void
     */
    protected function actionUpdateAccount($customer_id, $type, $number, $sign){
        print_r($item);

        $item = $this->_itemModel->find()->asArray()->where([
            'customer_id' => $customer_id
        ])->one();
        
        $update_type = $type == 1 ? 'balance' : 'point';

        if($item){
            if($sign == 1){
                $update_number = $item[$update_type] + $number;
            }elseif($sing == 0){
                $update_number = $item[$update_type] - $number;
            }

            $updateComules = $this->_itemModel->updateAll(
                [
                    $update_type => $update_number,
                ],
                [
                    'customer_id' => $customer_id,
                ]
            );

        }else{
            $update_number = $number;
            $accountItem = new $this->_itemModelName();
            $accountItem['customer_id'] = $customer_id;
            $accountItem[$update_type] = $number;
            $accountItem->save();
        }


        
        

        

    }

    

    
}