<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";

$arParams['RESIZER_SET'] = intval($arParams['RESIZER_SET']);

if (0 >= $arParams['RESIZER_SET']) $arParams['RESIZER_SET'] = 5;

if ($arParams['VIEW_MODE'] != 'TEXT') {
	foreach ($arResult['SECTIONS'] as &$arSection) {
		if ($arParams['VIEW_MODE'] == 'BOTH' && empty($arSection['PICTURE'])) continue;
		$arSection['PICTURE'] = CRZBitronic2CatalogUtils::getSectionPictureById($arSection['ID'], $arParams['RESIZER_SET']);
	}
}
unset($arSection);
