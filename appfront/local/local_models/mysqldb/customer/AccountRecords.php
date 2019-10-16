<?php
/*
 * @Author: lin
 * @GitHub: https://github.com/foylin/dida
 * @Date: 2019-10-16 00:41:45
 * @Description: message
 */


namespace appfront\local\local_models\mysqldb\customer;

use yii\db\ActiveRecord;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class AccountRecords extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%customer_account_records}}';
    }
    
    // public function rules()
    // {
    //     $rules = [
            
    //         ['store', 'filter', 'filter' => 'trim'],
    //         ['store', 'string', 'length' => [1, 100]],
            
    //         ['product_id', 'filter', 'filter' => 'trim'],
    //         ['product_id', 'required'],
    //         ['product_id', 'string', 'length' => [1, 100]],
            
    //         ['sku', 'filter', 'filter' => 'trim'],
    //         ['sku', 'required'],
    //         ['sku', 'string', 'length' => [1, 100]],
            
    //         ['name', 'filter', 'filter' => 'trim'],
    //         ['name', 'string', 'length' => [1, 255]],
            
    //         ['custom_option_sku', 'filter', 'filter' => 'trim'],
    //         ['custom_option_sku', 'string', 'length' => [1, 50]],
            
    //         ['image', 'filter', 'filter' => 'trim'],
    //         ['image', 'string', 'length' => [1, 255]],
            
    //     ];

    //     return $rules;
    // }
    
    
}