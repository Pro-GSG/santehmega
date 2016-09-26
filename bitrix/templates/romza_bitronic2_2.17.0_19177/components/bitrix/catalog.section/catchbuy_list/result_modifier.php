<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main\Loader;

// AJAX PATH
$ajaxPath = SITE_DIR."ajax/catchbuy.php";
$ajaxPathCompare = SITE_DIR."ajax/compare.php";
$ajaxPathFavorite = SITE_DIR."ajax/favorites.php";
$arResult['ADD_URL_TEMPLATE'] = $ajaxPath."?".$arParams["ACTION_VARIABLE"]."=ADD2BASKET&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";
$arResult['BUY_URL_TEMPLATE'] = $ajaxPath."?".$arParams["ACTION_VARIABLE"]."=BUY&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";
$arResult['COMPARE_URL_TEMPLATE'] = $ajaxPathCompare."?".$arParams["ACTION_VARIABLE"]."=ADD_TO_COMPARE_LIST&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";
$arResult['COMPARE_URL_TEMPLATE_DEL'] = $ajaxPathCompare."?".$arParams["ACTION_VARIABLE"]."=DELETE_FROM_COMPARE_LIST&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";

$arResult['FAVORITE_URL_TEMPLATE'] = $ajaxPathFavorite."?ACTION=ADD&ID=#ID#";
$arResult['FAVORITE_URL_TEMPLATE_DEL'] = $ajaxPathFavorite."?ACTION=DELETE&ID=#ID#";

$arParams['RESIZER_SET'] = intval($arParams['RESIZER_SET']) > 0 ? $arParams['RESIZER_SET'] : 3;

foreach($arResult['ITEMS'] as $index => $arItem)
{
	$arItem = CRZBitronic2CatalogUtils::processItemCommon($arItem);
	if(!$arItem['CAN_BUY'])
	{
		unset($arResult['ITEMS'][$index]);
		continue;
	}
	if(!empty($arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT']))
	{
		$imgAlt = $arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT'];
	}
	else
	{
		$imgAlt = $arItem['NAME'];
	}
	$arItem['PICTURE_PRINT']['ALT'] = $imgAlt;
	$arItem['PICTURE_PRINT']['SRC'] = CRZBitronic2CatalogUtils::getElementPictureById($arItem['ID'], $arParams['RESIZER_SET']);

	$arResult['ITEMS'][$index] = $arItem;
}

$arParams['DISPLAY_FAVORITE'] = $arParams['DISPLAY_FAVORITE'] && Loader::includeModule('yenisite.favorite');