<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule('yenisite.core');
$isAjax = Yenisite\Core\Tools::isAjax();
if(!$isAjax) {
	$this->setFrameMode(true);
}
?>
<? if ($isAjax && $arResult['SUCCESS'] === true) {
	CRZBitronic2CatalogUtils::ShowMessage(array('MESSAGE' => $arResult['SUCCESS_TEXT'], 'TYPE' => 'OK')); ?>
	<script type="text/javascript">
		(typeof(jQuery) != 'undefined')
		&& (function ($) {
			$('#modal_subscribe_product').modal('hide');
		})(jQuery);
	</script>
<? } else if ($isAjax && !empty($arResult['ERROR'])) {
	CRZBitronic2CatalogUtils::ShowMessage(array('MESSAGE' => $arResult['ERROR'], 'TYPE' => 'ERROR'));
} ?>
<? if (!$isAjax): ?>
	<? \Yenisite\Core\Ajax::saveParams($this, $arParams, $templateName); ?>
	<div class="modal fade modal-form" id="modal_subscribe_product" tabindex="-1">
		<div class="modal-dialog">
			<button class="btn-close" data-toggle="modal" data-target="#modal_subscribe_product">
				<span class="btn-text"><?= GetMessage("RZ_ZAKRIT") ?></span>
				<i class="flaticon-close47"></i>
			</button>
			<form method="post" action="#" id="modal_subscribe_product_form"
						class="form_subscribe_product modal-form-w-icons"<? \Yenisite\Core\Ajax::printAjaxDataAttr($this) ?>>
				<? endif ?>
				<? if ($isAjax): ?>
					<input type="hidden" name="<?= $arResult['CODE'] ?>[PRODUCT]" value="<?= htmlspecialcharsbx($_REQUEST['PRODUCT']) ?>"/>
					<input type="hidden" name="FORM_CODE" value="<?= $arResult['CODE'] ?>"/>
					<h2><span class="header-text"><?= GetMessage('RZ_SUBSCRIBE_TITLE') ?></span></h2>
					<div class="help-block"><?= GetMessage('RZ_SUBSCRIBE_TEXT') ?></div>
					<div>
						<div class="text-w-icon"><?= GetMessage("RZ_VASH") ?> e-mail<span class="required-asterisk">*</span>:</div>
						<label class="textinput-wrapper email">
							<i class="flaticon-mail9 icon-before-input"></i>
							<input type="email" name="<?= $arResult['CODE'] ?>[EMAIL]"
								   id="modal_cry-for-price_email"
								   class="textinput" required
								   value="<?= (!empty($arResult['DATA']['EMAIL'])) ? $arResult['DATA']['EMAIL'] : $USER->GetEmail() ?>">
					<span class="textinput-icons">
						<i class="icon-valid flaticon-check33"></i>
						<i class="icon-not-valid flaticon-x5"></i>
					</span>
						</label>
					</div>
					<div class="submit-wrap">
						<button type="submit" class="btn-submit btn-main">
							<span class="text"><?= GetMessage("RZ_OTPRAVIT") ?></span>
						</button>
					</div>
					<div class="required-info"><span
							class="required-asterisk">*</span> &mdash; <?= GetMessage("RZ_POLYA__OTMECHENNIE_ZVEZDOCHKOJ__OBYAZATELNI_DLYA_ZAPOLNENIYA") ?>
					</div>
				<? endif ?>
				<? if (!$isAjax): ?>
			</form>
		</div>
	</div>
<? endif ?>