<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
if(is_array($arResult["GRID"]["ROWS"]))
{
	foreach($arResult["GRID"]["ROWS"] as &$arItem)
	{
		$arItem['data']['PICTURE_PRINT']['SRC'] = CRZBitronic2CatalogUtils::getElementPictureById($arItem['data']['PRODUCT_ID'], $arParams['RESIZER_BASKET_PHOTO']);
	}
	unset($arItem);
}

if (empty($arParams['PATH_TO_SETTINGS'])) {
	$arParams['PATH_TO_SETTINGS'] = SITE_DIR.'personal/profile/';
}