<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

// namespace fecshop\app\appfront\modules\Customer\block\wallet;
namespace appfront\local\local_modules\Customer\block\wallet;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Index
{
    protected $numPerPage = 5;
    protected $pageNum;
    protected $orderBy;
    protected $_page = 'p';

    public function getLastData()
    {
        $method = Yii::$app->request->post('method');
        $address_id = Yii::$app->request->post('address_id');
        if ($method == 'remove' && $address_id) {
            $this->removeAddressById($address_id);
        }
        $this->pageNum = (int) Yii::$app->request->get($this->_page);
        $this->pageNum = ($this->pageNum >= 1) ? $this->pageNum : 1;
        $this->orderBy = ['created_at' => SORT_DESC];
        $data = $this->coll();
        $this->breadcrumbs(Yii::$service->page->translate->__('Customer Address'));

        $account = $this->getCustomerAccount();
        // print_r($data);
        return [
            'coll' => $data['coll'],
            'account' => $account,
            'pageToolBar' => $data['pageToolBar'],

        ];
    }
    // 面包屑导航
    protected function breadcrumbs($name)
    {
        if (Yii::$app->controller->module->params['customer_address_breadcrumbs']) {
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
        }
    }
    
    public function coll()
    {
        $identity = Yii::$app->user->identity;
        $customer_id = $identity['id'];
        $filter = [
            'numPerPage'    => $this->numPerPage,
            'pageNum'        => $this->pageNum,
            'orderBy'        => $this->orderBy,
            'where'            => [
                ['customer_id' => $customer_id],
            ],
            'asArray' => true,
        ];

        $coll = Yii::$service->customer->accountrecords->coll($filter);
        if (isset($coll['coll']) && !empty($coll['coll'])) {
            $count = $coll['count'];
            $pageToolBar = $this->getAddressPage($count);
            $coll['pageToolBar'] = $pageToolBar;
            return $coll;
        }
    }

    protected function getAddressPage($countTotal)
    {
        if ($countTotal <= $this->numPerPage) {
            return '';
        }
        $config = [
            'class'        => 'fecshop\app\appfront\widgets\Page',
            'view'        => 'widgets/page.php',
            'pageNum'        => $this->pageNum,
            'numPerPage'    => $this->numPerPage,
            'countTotal'    => $countTotal,
            'page'            => $this->_page,
        ];

        return Yii::$service->page->widget->renderContent('category_product_page', $config);
    }

    public function removeAddressById($address_id)
    {
        $identity = Yii::$app->user->identity;
        $customer_id = $identity['id'];
        Yii::$service->customer->address->remove($address_id, $customer_id);
    }

    /**
     * 获取当前用户余额
     *
     * @return void
     */
    public function getCustomerAccount(){
        $identity = Yii::$app->user->identity;
        $customer_id = $identity['id'];
        return Yii::$service->customer->account->getAccount($customer_id);
    }

    public function getCustomerRecords(){
        $identity = Yii::$app->user->identity;
        $customer_id = $identity['id'];
        return Yii::$service->customer->accountrecords->getRecords($customer_id);
    }
}
