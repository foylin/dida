<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Catalog\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class ProductController extends \fecshop\app\appfront\modules\Catalog\controllers\ProductController
{
    // 产品详细页面
    public function actionIndex()
    {
        
        $data = $this->getBlock()->getLastData();
        
        $share_uid = Yii::$app->request->get('share_uid', 0);
        // print_r($share_uid);
        if(is_array($data)){
            $data['share_uid'] = $share_uid;
            return $this->render($this->action->id, $data);
        }
    }

    public function actionTest(){
        echo 123;
    }
}
