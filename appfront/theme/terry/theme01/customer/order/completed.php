<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div class="main container two-columns-left">
    

<div class="empty_cart">
		<?php
			$param = ['urlB' => '<a rel="nofollow" href="'.Yii::$service->url->getUrl('customer/account/login').'">','urlE' =>'</a>'];
		?>	
		
		<div id="empty_cart_info">
			<?= Yii::$service->page->translate->__('Your Shopping Cart is empty');?>
			<a href="<?= Yii::$service->url->homeUrl(); ?>"><?= Yii::$service->page->translate->__('Start shopping now!');?></a>
			<br>
			<?= Yii::$service->page->translate->__('Please {urlB}log in{urlE} to view the products you have previously added to your Shopping Cart.',$param);?>
		</div>
  
  
		</div>

		
</div>
	