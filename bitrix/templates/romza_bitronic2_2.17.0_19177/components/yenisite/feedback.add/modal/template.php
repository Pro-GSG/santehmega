<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if($arParams['EMPTY'])
{ 
	echo $arParams['TITLE'];
	return;
}
if($arResult['SUCCESS'])
{
	CRZBitronic2CatalogUtils::ShowMessage(Array("MESSAGE" => $arResult['SUCCESS_TEXT'], "TYPE" => "OK"));
	return;
}
if($arResult['ERROR'])
{
	CRZBitronic2CatalogUtils::ShowMessage(Array("MESSAGE" => $arResult['ERROR'], "TYPE" => "ERROR"));
	return;
}
?>
<form method="post" action="#" class="<?=$arParams['FORM']?>">
	<?include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';?>
	<h2><span class="header-text"><?=$arParams['TITLE']?></span></h2>
	
	<?foreach($arResult['FIELDS'] as $arItem):?>
		<label class="textinput-wrapper">
			<span class="label-text"><span class="inner-wrap"><span class="inner"><?=$arItem['NAME'];?><?=($arItem['IS_REQUIRED'] == 'Y')?'<span class="required-asterisk">*</span>':'';?>:</span></span></span>
			<?=$arItem['HTML'];?>
			<span class="textinput-icons">
				<i class="icon-valid flaticon-check33"></i>
				<i class="icon-not-valid flaticon-x5"></i>
			</span>
		</label>
  <?endforeach;?>
	<? if (!empty($arResult["CAPTCHA_CODE"])): ?>
		<label class="textinput-wrapper">
			<span class="label-text"><span class="inner-wrap"><span class="inner"><?//=GetMessage("BITRONIC2_FEED_MODAL_CAPTCHA_ALT")?></span></span></span>
			<img src="/bitrix/tools/captcha.php?captcha_code=<?= $arResult["CAPTCHA_CODE"] ?>" alt="<?=GetMessage("BITRONIC2_FEED_MODAL_CAPTCHA_ALT")?>">
			<input type="hidden" name="captcha_code" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
		</label>
		<label class="textinput-wrapper">
			<span class="label-text"><span class="inner-wrap"><span class="inner"><?=GetMessage('BITRONIC2_FEED_MODAL_CAPTCHA_TITLE')?><span class="required-asterisk">*</span>:</span></span></span>
			<input type="text" name="captcha_word" class="textinput" required="">
			<span class="textinput-icons">
				<i class="icon-valid flaticon-check33"></i>
				<i class="icon-not-valid flaticon-x5"></i>
			</span>
		</label>
	<? endif; ?>
	<div class="textinput-wrapper submit-wrap">
		<button type="submit" class="btn-submit btn-main"><span class="btn-text"><?=GetMessage('BITRONIC2_FEED_MODAL_SEND')?></span></button>
	</div>				
	
	<div class="required-info"><span class="required-asterisk">*</span> &mdash; <?=GetMessage('BITRONIC2_FEED_MODAL_REQUIRED')?></div>
</form>