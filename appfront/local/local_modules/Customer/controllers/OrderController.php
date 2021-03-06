<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

// namespace fecshop\app\appfront\modules\Customer\controllers;

namespace appfront\local\local_modules\Customer\controllers;


use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class OrderController extends AppfrontController
{
    //protected $_registerSuccessRedirectUrlKey = 'customer/account';


    public $blockNamespace = '';

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }

    public function actionView()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }

    public function actionReorder()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        return $this->getBlock()->getLastData();
        //return $this->render($this->action->id,$data);
    }

    /**
     * 确认收货
     */
    public function actionCompleted(){
        
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }

        $this->blockNamespace = 'appfront\\local\\local_modules\\Customer\\block';

        $result = $this->getBlock()->getLastData();
        // $result = true;
        // return $this->render($this->action->id, $data);
        // echo 123;
        // return $this->render($this->action->id, ['a'=>123]);
        if($result){
            echo json_encode([
                'status' => 'success',
                'msg' => '',
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'msg' => Yii::$service->page->translate->__('Data error'),
            ]);
        }
        
        exit;
    }
}
