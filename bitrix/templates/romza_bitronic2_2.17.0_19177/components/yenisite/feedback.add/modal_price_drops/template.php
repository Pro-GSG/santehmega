<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
\Bitrix\Main\Loader::includeModule('yenisite.core');
$isAjax = Yenisite\Core\Tools::isAjax();
?>
<? if($isAjax && $arResult['SUCCESS'] === true) {
	CRZBitronic2CatalogUtils::ShowMessage(array('MESSAGE' => $arResult['SUCCESS_TEXT'], 'TYPE' => 'OK'));?>
	<script type="text/javascript">
		(typeof(jQuery) != 'undefined')
		&& (function ($) {
			$('#modal_inform-when-price-drops').modal('hide');
		})(jQuery);
	</script>
<? } ?>
<? if (!$isAjax): ?>
<? \Yenisite\Core\Ajax::saveParams($this, $arParams, $templateName); ?>
<div class="modal fade modal-form modal_inform-when-price-drops" id="modal_inform-when-price-drops" tabindex="-1">
	<div class="modal-dialog">
		<button class="btn-close" data-toggle="modal" data-target="#modal_inform-when-price-drops">
			<span class="btn-text"><?= GetMessage("RZ_ZAKRIT") ?></span>
			<i class="flaticon-close47"></i>
		</button>
		<form method="post" action="#" class="form_inform-when-price-drops modal-form-w-icons"<? \Yenisite\Core\Ajax::printAjaxDataAttr($this) ?>>
			<? endif ?>
			<? if ($isAjax): ?>
				<input type="hidden" id="modal_price_drop_product" name="<?= $arResult['CODE'] ?>[PRODUCT]" value="<?= htmlspecialcharsbx($_REQUEST['PRODUCT'])?>"/>
				<input type="hidden" id="modal_price_drop_cur" name="<?= $arResult['CODE'] ?>[CURRENCY]" value="<?= htmlspecialcharsbx($_REQUEST['CURRENCY'])?>"/>
				<input type="hidden" id="modal_price_drop_price_type" name="<?= $arResult['CODE'] ?>[PRICE_TYPE_ID]"
					   value="<?= htmlspecialcharsbx($_REQUEST['PRICE_TYPE']) ?>"/>
				<input type="hidden" name="FORM_CODE" value="<?= $arResult['CODE'] ?>"/>
				<input type="hidden" name="CONVERT_CURRENCY" value="Y"/>
				<h2><span class="header-text"><?= GetMessage("RZ_SOOBSHIT_O_SNIZHENII_TCENI") ?></span></h2>
				<div>
					<div class="text-w-icon"><?= GetMessage("RZ_VASH") ?> e-mail<span class="required-asterisk">*</span>:</div>
					<label class="textinput-wrapper email">
						<i class="flaticon-mail9 icon-before-input"></i>
						<input type="email" name="<?= $arResult['CODE'] ?>[EMAIL]"
							   id="modal_inform-when-price-drops_email"
							   class="textinput" required value="<?= $USER->GetEmail() ?>">
					<span class="textinput-icons">
						<i class="icon-valid flaticon-check33"></i>
						<i class="icon-not-valid flaticon-x5"></i>
					</span>
					</label>
				</div>
				<div>
					<div class="text-w-icon price"><?= GetMessage("RZ_ZHELAEMAYA_TCENA") ?>
						(<?= GetMessage("RZ_VVEDITE_ILI_ISPOLZUJTE_BEGUNOK") ?>)<span class="required-asterisk">*</span>:
					</div>
					<label class="textinput-wrapper price">
						<i class="flaticon-dollar67 icon-before-input"></i>
						<input type="text" name="<?= $arResult['CODE'] ?>[PRICE]"
							   id="modal_inform-when-price-drops_price" class="textinput" required>
						<span class="currency">
							<?= CRZBitronic2CatalogUtils::getCurrencyLang($_REQUEST['CURRENCY']) ?>
						</span>
					</label>
				</div>
				<div class="prices">
					<div class="simple-slider desired-price-slider"></div>
					<div class="info">
						<div class="price-block desired" style="display: none;">
							<span class="text"><?= GetMessage("RZ_ZHELAEMAYA") ?>:</span>
						<span class="price" id="desired-price">
							<?= CRZBitronic2CatalogUtils::getElementPriceFormat($_REQUEST['CURRENCY'], $_REQUEST['PRICE']) ?>
						</span>
						</div>
						<div class="price-block current">
							<span class="text"><?= GetMessage("RZ_TEKUSHAYA") ?>:</span>
						<span class="price" id="price-current">
							<?= CRZBitronic2CatalogUtils::getElementPriceFormat($_REQUEST['CURRENCY'], $_REQUEST['PRICE']) ?>
						</span>
						</div>
						<div class="price-block difference">
							<span class="text"><?= GetMessage("RZ_RAZNITCA") ?>:</span>
						<span class="price" id="price-difference">
							<?= CRZBitronic2CatalogUtils::getElementPriceFormat($_REQUEST['CURRENCY'], 0) ?>
							<span class="percent-value"></span>
						</span>
						</div>
					</div>
				</div>
				<div class="submit-wrap">
					<button type="submit" class="btn-submit btn-main">
						<span class="text"><?= GetMessage("RZ_OTPRAVIT") ?></span>
					</button>
				</div>
				<div class="required-info">
				<span
					class="required-asterisk">*</span> &mdash; <?= GetMessage("RZ_POLYA__OTMECHENNIE_ZVEZDOCHKOJ__OBYAZATELNI_DLYA_ZAPOLNENIYA") ?>
				</div>
			<? endif ?>
			<? if (!$isAjax): ?>
		</form>
	</div>
</div>
<? endif ?>
