<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
use fec\helpers\CRequest;
?>
<div class="main container two-columns-left">
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div style="margin:4px 0 0">
				<div class="page-title">
					<h2>
						<?= Yii::$service->page->translate->__('My Wallet');?> 
						$<?= isset($account['balance']) ? $account['balance'] : 0.00 ?>
					</h2>
				</div>
				<table class="addressbook" width="100%" cellspacing="0" cellpadding="0" border="0">
					<thead>
						<tr class="ress_tit">
							<th width="76" valign="middle" align="center" height="31">
								<?= Yii::$service->page->translate->__('ID #');?>
							</th>  
							<th width="72" valign="middle" align="center" height="31">
								<?= Yii::$service->page->translate->__('Date');?>
							</th>                                                                                       
							<th width="167" valign="middle" align="center">
								<?= Yii::$service->page->translate->__('Money');?>
							</th>
							<th width="67" valign="middle" align="center">
								<?= Yii::$service->page->translate->__('Detail');?>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php   if(is_array($coll) && !empty($coll)):   ?>
					<?php 		foreach($coll as $one): ?>
						<tr class="">
							<td valign="top" align="center"><?= $one['id'] ?></td>
							<td valign="top" align="center"><?= date('Y-m-d H:i:s',$one['created_at']) ?></td>
							<td valign="top" align="center"><?= $one['number'] ?></td>
							<td valign="top" align="center"><?= $one['text'] ?></td>
						</tr>	
					<?php 		endforeach; ?>
					<?php 	endif; ?>
					</tbody>
				</table>

				<?php if($pageToolBar): ?>
					<div class="pageToolbar">
						<label class="title"><?= Yii::$service->page->translate->__('Page:');?></label><?= $pageToolBar ?>
					</div>
				<?php endif; ?>

				<div class="product-Reviews">
					<input onclick="javascript:window.location.href='<?= Yii::$service->url->getUrl('customer/wallet/drawmoney') ?>'" class="submitbutton addnew cpointer" value="<?= Yii::$service->page->translate->__('Balance Withdraw');?>" name="" type="button">
					
				</div>
			</div>
		</div>

		<script>
            function deleteAddress(address_id){
				var r=confirm("<?= Yii::$service->page->translate->__('do you readly want delete this address?') ?>");
                if (r==true){ 
                    url = "<?= Yii::$service->url->getUrl('customer/address') ?>";
                    doPost(url, {"method": "remove", "address_id": address_id, "<?= CRequest::getCsrfName() ?>": "<?= CRequest::getCsrfValue() ?>" });
                }
            }
		</script>
	</div>
	
	<div class="col-left ">
		<?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	</div>
	<div class="clear"></div>
</div>
	