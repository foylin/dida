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
    protected $_AccountModelName = '\appfront\local\local_models\mysqldb\customer\Account';

    protected $_AccountModel;
    
    public function init()
    {
        parent::init();
        list($this->_AccountModelName, $this->_AccountModel) = \Yii::mapGet($this->_AccountModelName);
    }

    /**
     * 获取账户余额 积分
     *
     * @param [type] $customer_id
     * @return void
     */
    public function getAccount($customer_id){
        if ($customer_id) {
            $one = $this->_AccountModel->findOne(['customer_id' => $customer_id]);
            if ($one['customer_id']) {
                return $one;
            }
        }
    }

    /**
     * 最大可提现金额
     *
     * @param [type] $customer_id
     * @return void
     */
    public function getMaxWithdraw($customer_id){
        if($customer_id){
            $myaccount = $this->getAccount($customer_id);
            $myaccount_money = $myaccount['balance'];

            $myaccount_records_wait = Yii::$service->customer->balancewithdraw->getRecordsBywait($customer_id);
            $myaccount_records_wait_money = 0;
            foreach ($myaccount_records_wait as $item) {
                $myaccount_records_wait_money += $item['cash'];
            }

            return $myaccount_money - $myaccount_records_wait_money;
            
        }else{
            return 0.00;
        }
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

        $item = $this->_AccountModel->find()->asArray()->where([
            'customer_id' => $customer_id
        ])->one();
        
        $update_type = $type == 1 ? 'balance' : 'point';

        if($item){
            if($sign == 1){
                $update_number = $item[$update_type] + $number;
            }elseif($sing == 0){
                $update_number = $item[$update_type] - $number;
            }

            $updateComules = $this->_AccountModel->updateAll(
                [
                    $update_type => $update_number,
                ],
                [
                    'customer_id' => $customer_id,
                ]
            );

            return $updateComules;

        }else{
            $update_number = $number;
            $accountItem = new $this->_AccountModelName();
            $accountItem['customer_id'] = $customer_id;
            $accountItem[$update_type] = $number;
            return $accountItem->save();
        }

        return false;
    }
}