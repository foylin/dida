<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

// namespace fecshop\app\appfront\modules\Customer\block\order;
namespace appfront\local\local_modules\Customer\block\order;


use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Completed
{
    public function getLastData()
    {
        $order_id = Yii::$app->request->get('order_id');
        $order_info = $this->getCustomerOrderInfo($order_id);
        // $this->breadcrumbs(Yii::$service->page->translate->__('Customer Order Info'));
        // print_r($order_info);
        if(!empty($order_info)){
            // print_r(123);
            $result = $this->getDelivery($order_info['increment_id'], $order_info['customer_id']);
            // print_r($result);
            return $result;
        }
        
        return false;
    }
    
    // 面包屑导航
    protected function breadcrumbs($name)
    {
        if (Yii::$app->controller->module->params['customer_order_info_breadcrumbs']) {
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
        }
    }
    
    /**
     * 客户订单详情
     */
    public function getCustomerOrderInfo($order_id)
    {
        if ($order_id) {
            $order_info = Yii::$service->order->getOrderInfoById($order_id);
            if (isset($order_info['customer_id']) && !empty($order_info['customer_id'])) {
                $identity = Yii::$app->user->identity;
                $customer_id = $identity->id;
                if ($order_info['customer_id'] == $customer_id) {
                    return $order_info;
                }
            }
        }

        return [];
    }
    
    /**
     * 确认收货
     */
    public function getDelivery($incrementId, $customerId){
        if (!empty($incrementId) && !empty($customerId)) {
            
            $identity = Yii::$app->user->identity;
            $customer_id = $identity->id;
            if ($customerId == $customer_id) {
                $innerTransaction = Yii::$app->db->beginTransaction();
                try{
                    $result = Yii::$service->order->delivery($incrementId, $customerId);
                    
                    if(!$result){
                        
                        $innerTransaction->rollBack();
                    }else{
                        // 推广订单 分派金额及记录
                        Yii::$service->order->share->Confim($incrementId, $customerId);

                        $innerTransaction->commit();

                        return $result;
                    }

                    
                }catch (\Exception $e) {
                    $innerTransaction->rollBack();
                    return false;
                }
                
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
