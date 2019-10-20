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
     * @param $filter|array
     * @return Array;
     *  通过过滤条件，得到coupon的集合。
     *  example filter:
     *  [
     *  'numPerPage' 	=> 20,
     *  'pageNum'		=> 1,
     *  'orderBy'	=> ['_id' => SORT_DESC, 'sku' => SORT_ASC ],
     *  'where'			=> [
     *      ['>','price',1],
     *      ['<=','price',10]
     * 		['sku' => 'uk10001'],
     * 	],
     * 	'asArray' => true,
     *  ]
     */
    protected function actionColl($filter = '')
    {
        $query = $this->_itemModel->find();
        $query = Yii::$service->helper->ar->getCollByFilter($query, $filter);
        $coll = $query->all();
        
        return [
            'coll' => $coll,
            'count'=> $query->limit(null)->offset(null)->count(),
        ];
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
            $result = Yii::$service->customer->account->UpdateAccount($item['customer_id'], 1, $item['number'], $item['sign']);
            return $result;
        }else{
            return false;
        }
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