<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

global ${$arParams['FILTER_NAME']} ;
${$arParams['FILTER_NAME']} = array('!PROPERTY_SHOW_MAIN' => false);


global $rz_b2_options;
if ($rz_b2_options['convert_currency']) {
	$arParams['CONVERT_CURRENCY'] = 'Y';
	$arParams['CURRENCY_ID'] = $rz_b2_options['active-currency'];
}
$arParams['SHOW_DISCOUNT_PERCENT'] = ($rz_b2_options['show_discount_percent'] === 'N') ? 'N' : 'Y';
$arParams['VREGIONS_REGION'] = $_SESSION["VREGIONS_REGION"];

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"cool_slider",
	$arParams,
	$component,
	array('HIDE_ICONS' => 'N')
);
?>
