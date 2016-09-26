<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);?>
<?if($arParams['SHOW_CONTAINER'] !== 'N'):?>
<div class="stickers clearfix">
<?endif?>
	<div class="stickers-wrap">
	<?if($arResult["NEW"]):?>
		<div class="sticker new flaticon-new92"><?=GetMessage('STICKER_SECT_NEW')?></div>
	<?endif?>

	<?if($arResult["HIT"]):?>
		<div class="sticker hit flaticon-first43"><?=GetMessage('STICKER_SECT_HIT')?></div>
	<?endif?>

	<?if($arResult["SALE"]):?>
		<div class="sticker discount flaticon-sale" <?if(!empty($arParams['CONT_ID_DSC_PERC'])):?> id="<?=$arParams['CONT_ID_DSC_PERC']?>" <?endif?>>
			<?=GetMessage('STICKER_SECT_SALE')?>
		</div>
	<?endif;?>

	<?if($arResult["BESTSELLER"]):?>
		<div class="sticker best-choice flaticon-like"><?=GetMessage('STICKER_SECT_BESTSELLER')?></div>
	<?endif?>

	<?foreach ($arResult['CUSTOM'] as $arCustom):?>
		<div class="sticker <?=$arCustom['CLASS']?>"><?=$arCustom['TEXT']?></div>
	<?endforeach?>

	<?if('N' != $arParams['STICKER_CATCHBUY'] && $arResult["CATCHBUY"] || $arParams['SKU_EXT'] === true):?>
		<div class="sticker circle hurry-buy flaticon-stopwatch6"<?=($arResult["CATCHBUY"]?'':' style="display:none"')?>><?=GetMessage('STICKER_SECT_CATCHBUY')?></div>
	<?endif?>
	</div>
	<?if($arResult["SALE"] && $arResult["SALE_DISC"]>0 && $arParams['SHOW_DISCOUNT_PERCENT'] !== 'N'):?>
	<div class="sticker discount-w-number">
		<span class="text">
			<?if(false):?><span class="small"><?=GetMessage('STICKER_SECT_SALE')?></span><?endif;//for those who really wanna text here?>

			-<?=Round($arResult["SALE_DISC"])?>%
		</span>
	</div>
	<?endif?>
<?if($arParams['SHOW_CONTAINER'] !== 'N'):?>
</div><!-- /.stickers -->
<?endif?>
