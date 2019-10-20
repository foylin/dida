<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

// namespace fecshop\app\appfront\modules\Customer\block\address;
namespace appfront\local\local_modules\Customer\block\wallet;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Drawmoney
{
    public $_address_id;
    public $_country;
    public $_state;
    public $_data;

    public function initWithdraw()
    {
        $withdraw = Yii::$app->request->post('withdraw');
        $isSave = 0;

        // 数据提交 保存paypal账号、记录提现log
        if (is_array($withdraw) && !empty($withdraw)) {
            $withdraw = \Yii::$service->helper->htmlEncode($withdraw);
            $this->save($withdraw);
            $isSave = 1;
        }

        // 页面访问  获取paypal默认账号、可提现最大金额
        if (!$isSave) {
            // $this->_address_id = Yii::$app->request->get('address_id');
            // if ($this->_address_id) {
            //     $addressModel = Yii::$service->customer->address->getByPrimaryKey($this->_address_id);
            //     $identity = Yii::$app->user->identity;
            //     $customer_id = $identity['id'];
            //     if ($addressModel['address_id']) {
            //         // 该id必须是当前用户的
            //         if ($customer_id == $addressModel['customer_id']) {
            //             foreach ($addressModel as $k=>$v) {
            //                 $this->_address[$k] = $v;
            //             }
            //         }
            //     }
            // }
            
            $identity = Yii::$app->user->identity;
            $customer_id = $identity['id'];
            $max_withdrawmoney = Yii::$service->customer->account->getMaxWithdraw($customer_id);

            $this->_data['max_withdrawmoney'] = $max_withdrawmoney;

        } else {
            $this->_address = $address;
        }
        // $country = isset($this->_address['country']) ? $this->_address['country'] : '';
        // if (!$country) {
        //     $country = Yii::$service->helper->country->getDefaultCountry();
        // }
        // $this->_country = $country;
        // $this->getCountrySelect();
        // $this->getState();
        // if (!isset($this->_address['email']) || empty($this->_address['email'])) {
        //     $identity = Yii::$app->user->identity;
        //     $email = $identity['email'];
        //     $this->_address['email'] = $email;
        // }
        // if (!isset($this->_address['first_name']) || empty($this->_address['first_name'])) {
        //     $identity = Yii::$app->user->identity;
        //     $first_name = $identity['firstname'];
        //     $this->_address['first_name'] = $first_name;
        // }
        // if (!isset($this->_address['last_name']) || empty($this->_address['last_name'])) {
        //     $identity = Yii::$app->user->identity;
        //     $last_name = $identity['lastname'];
        //     $this->_address['last_name'] = $last_name;
        // }
    }

    public function getLastData()
    {
        $this->initWithdraw();
        if (empty($this->_data)) {
            $this->_data = [];
        }
        // $this->getIsDefault();
        $this->breadcrumbs(Yii::$service->page->translate->__('Balance Withdraw'));
        return $this->_data;
        // $data['account_number'] = 
    }
    
    // 面包屑导航
    protected function breadcrumbs($name)
    {
        if (Yii::$app->controller->module->params['customer_address_edit_breadcrumbs']) {
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
        }
    }

    public function getIsDefault()
    {
        $is_default_str = '';
        $is_default = $this->_address['is_default'];
        if (!$is_default) {
            $address_id = $this->_address['address_id'];
            if (!$address_id) {
                $is_default_str = 'checked="checked"';
            }
        } else {
            if ($is_default == 1) {
                $is_default_str = 'checked="checked"';
            }
        }
        $this->_address['is_default_str'] = $is_default_str;
    }

    public function getCountrySelect()
    {
        $countrySelect = Yii::$service->helper->country->getAllCountryOptions('', '', $this->_country);
        $this->_address['countrySelect'] = $countrySelect;
    }

    public function getState($country = '')
    {
        $state = isset($this->_address['state']) ? $this->_address['state'] : '';
        if (!$country) {
            $country = $this->_country;
        }
        $stateHtml = Yii::$service->helper->country->getStateOptionsByContryCode($country, $state);
        if (!$stateHtml) {
            $stateHtml = '<input id="state" name="address[state]" value="'.$state.'" title="State" class="input-text" style="" type="text">';
        } else {
            $stateHtml = '<select id="address:state" class="address_state validate-select" title="State" name="address[state]">
							<option value="">Please select region, state or province</option>'
                        .$stateHtml.'</select>';
        }
        $this->_address['stateHtml'] = $stateHtml;

        return $stateHtml;
    }

    public function getAjaxState()
    {
        $country = Yii::$app->request->get('country');
        $state = $this->getState($country);
        echo json_encode([
            'state' => $state,
        ]);
        exit;
    }

    public function save($addressInfo)
    {
        $identity = Yii::$app->user->identity;
        $addressInfo['customer_id'] = $identity['id'];
        $saveStatus = Yii::$service->customer->address->save($addressInfo);
        if (!$saveStatus) {
            Yii::$service->page->message->addByHelperErrors();
            return false;
        }
        Yii::$service->url->redirectByUrlKey('customer/address');
        return true;
    }
}
