<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

global $rz_b2_options;
if ($rz_b2_options['convert_currency']) {
	$arParams['CONVERT_CURRENCY'] = 'Y';
	$arParams['CURRENCY_ID'] = $rz_b2_options['active-currency'];
}
$arParams['SHOW_VOTING'] = $rz_b2_options['block_show_stars'];
$arParams['SHOW_ARTICLE'] = $rz_b2_options['block_show_article'];
$APPLICATION->IncludeComponent('bitrix:catalog.section', $arParams['CATALOG_TEMPLATE'], $arParams, $component);
