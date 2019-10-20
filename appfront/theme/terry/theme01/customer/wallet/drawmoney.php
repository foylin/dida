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
<?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div>
				<form class="addressedit" action="<?= Yii::$service->url->getUrl('customer/wallet/drawmoney'); ?>" id="form-validate" method="post">
					<?php echo CRequest::getCsrfInputHtml();  ?>
                    <input name="address[address_id]" value="<?= $address_id; ?>" type="hidden">
					<div class="">
						<ul class="">
							<li>
								<label class="required" for="email"><?= Yii::$service->page->translate->__('Paypal Account');?></label>
								<div class="input-box">
									<input class="input-text required-entry" maxlength="255" title="Email" value="<?= $email ?>" name="withdraw[account]" id="customer_email"   type="text">
									
								</div>
							</li>
							<li class="">
								<div class="field name-firstname">
									<label class="required" for="firstname"><?= Yii::$service->page->translate->__('Money');?></label>
									<div class="input-box">
										<input class="input-text required-entry" maxlength="255" title="First Name" value="<?= $max_withdrawmoney ?>" name="withdraw[money]" id="firstname" type="text">
									</div>
									<span><?= Yii::$service->page->translate->__('Maximum withdrawable amount is ('.$max_withdrawmoney.')')?></span>
								</div>
							</li>

						</ul>
						
					</div>
					
					<a href="javascript:void(0)" onclick="submit_address()" class="submitbutton"><span><span><?= Yii::$service->page->translate->__('Save');?></span></span> </a>
					
				</form>
			</div>
		</div>

	</div>
	
	<div class="col-left ">
		<?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	</div>
	<div class="clear"></div>
</div>
	
	
<script>
<?php $this->beginBlock('editCustomerAddress') ?>
	$(document).ready(function(){
		$(".address_country").change(function(){
			//alert(111);
			ajaxurl = "<?= Yii::$service->url->getUrl('customer/address/changecountry') ?>";
			country = $(this).val();
			$.ajax({
				async:false,
				timeout: 8000,
				dataType: 'json', 
				type:'get',
				data: {
						'country':country,
				},
				url:ajaxurl,
				success:function(data, textStatus){ 
					$(".state_html").html(data.state);
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){
						
				}
			});
			
		});

	});	
	function submit_address(){
		i = 1;
		jQuery(".addressedit input").each(function(){
			type = jQuery(this).attr("type");
			if(type != "hidden"){
				value = jQuery(this).val();
				if(!value){
					//alert($(this).hasClass('optional'));
					if(!$(this).hasClass('optional')){
						i = 0;
					}
				}
			}
		});
		
		jQuery(".addressedit select").each(function(){
			value = jQuery(this).val();
			if(!value){
				i = 0;
			}
		});
		if(i){
			jQuery(".addressedit").submit();
		}else{
			alert("You Must Fill All Field");
		}
	}
	
<?php $this->endBlock(); ?> 
<?php $this->registerJs($this->blocks['editCustomerAddress'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

</script>