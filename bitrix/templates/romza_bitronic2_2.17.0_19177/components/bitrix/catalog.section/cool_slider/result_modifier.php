<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
// AJAX PATH
$ajaxPath = SITE_DIR."ajax/cool-slider.php";
$arResult['ADD_URL_TEMPLATE'] = $ajaxPath."?".$arParams["ACTION_VARIABLE"]."=ADD2BASKET&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";
$arResult['BUY_URL_TEMPLATE'] = $ajaxPath."?".$arParams["ACTION_VARIABLE"]."=BUY&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#&ajax_basket=Y";

$arResult['CURRENCY'] = CModule::IncludeModule("currency");
$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']) && $arResult['CURRENCY'];
if (!$boolConvert)
	$strBaseCurrency = $arResult['CURRENCY'] ? CCurrency::GetBaseCurrency() : 'RUB';

if (CModule::IncludeModule('yenisite.market')) {
	$arResult['CHECK_QUANTITY'] = (CMarketCatalog::UsesQuantity($arParams['IBLOCK_ID']) == 1);
}
foreach($arResult['ITEMS'] as $index => $arItem)
{
	$arResult['ITEMS'][$index] = CRZBitronic2CatalogUtils::processItemCommon($arItem);
	$arResult['ITEMS'][$index]['bFirst'] = $index == 0;
	if(!empty($arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT']))
	{
		$imgAlt = $arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT'];
	}
	else
	{
		$imgAlt = $arItem['NAME'];
	}
	$arResult['ITEMS'][$index]['PICTURE_PRINT_BIG']['ALT'] = $arResult['ITEMS'][$index]['PICTURE_PRINT_SMALL']['ALT'] = $imgAlt;
	$arResult['ITEMS'][$index]['PICTURE_PRINT_BIG']['SRC'] = CRZBitronic2CatalogUtils::getElementPictureById($arItem['ID'], $arParams['RESIZER_SET_BIG']);
	$arResult['ITEMS'][$index]['PICTURE_PRINT_SMALL']['SRC'] = CRZBitronic2CatalogUtils::getElementPictureById($arItem['ID'], $arParams['RESIZER_SET_SMALL']);

	//Prices for MARKET
	if (CModule::IncludeModule('yenisite.bitronic2lite') && CModule::IncludeModule('yenisite.market')) {
		$prices = CMarketPrice::GetItemPriceValues($arItem['ID'], $arItem['PRICES']);
		if (count($prices) > 0) {
			unset($arResult['ITEMS'][$index]['PRICES']);
		}
		$minPrice = false;
		foreach ($prices as $k => $pr) {
			$pr = floatval($pr);
			$arResult['ITEMS'][$index]['PRICES'][$k]['VALUE'] = $pr;
			$arResult['ITEMS'][$index]['PRICES'][$k]['PRINT_VALUE'] = $pr;
			if ((empty($minPrice) || $minPrice > $pr) && $pr > 0) {
				$minPrice = $pr;
			}
		}
		if ($minPrice !== false) {
			$arResult['ITEMS'][$index]['MIN_PRICE']['VALUE'] = $arItem['MIN_PRICE']['VALUE'] = $minPrice;
			$arResult['ITEMS'][$index]['MIN_PRICE']['PRINT_VALUE'] = $minPrice;
			$arResult['ITEMS'][$index]['MIN_PRICE']['DISCOUNT_VALUE'] = $minPrice;
			$arResult['ITEMS'][$index]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $minPrice;
			$arResult['ITEMS'][$index]['CATALOG_MEASURE_RATIO'] = 1;
			$arResult['ITEMS'][$index]['CAN_BUY'] = $arItem['CAN_BUY'] = true;
		}
		$arResult['ITEMS'][$index]['CHECK_QUANTITY'] = $arResult['CHECK_QUANTITY'];
		// $arResult['ITEMS'][$index]['CATALOG_QUANTITY'] = CMarketCatalogProduct::GetQuantity($arItem['ID'], $arItem['IBLOCK_ID']);
		// количество товара на определённом складе
		$rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $arItem["ID"], 'STORE_ID' => $_SESSION["VREGIONS_REGION"]["ID_SKLADA"]), false, false, array('AMOUNT'));
		if ($arStore = $rsStore->Fetch()){
			// echo $arStore['AMOUNT'];
			$arResult['ITEMS'][$index]['CATALOG_QUANTITY'] = $arStore['AMOUNT'];
		}
		
		if ($arResult['ITEMS'][$index]['CHECK_QUANTITY'] && $arResult['ITEMS'][$index]['CATALOG_QUANTITY'] <= 0) {
			$arResult['ITEMS'][$index]['CAN_BUY'] = $arItem['CAN_BUY'] = false;
		}
		$arResult['ITEMS'][$index]['CATALOG_TYPE'] = 1; //simple product
	}
	//end Prices for MARKET
	
	$arResult['ITEMS'][$index]['ON_REQUEST'] = $arItem['ON_REQUEST'] = (empty($arItem['MIN_PRICE']) || $arItem['MIN_PRICE']['VALUE'] <= 0);
	
	if(isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
	{
		$minNotAvailPrice = false;
		$can_buy_find = false;
		$arResult['ITEMS'][$index]['bOffers'] = true;
		$arItem['CAN_BUY'] = false;
		$arItem['ON_REQUEST'] = false;
		foreach($arItem['OFFERS'] as &$arOffer)
		{
			$minNotAvailPrice = (
				$arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $minNotAvailPrice['DISCOUNT_VALUE'] || !$minNotAvailPrice
				? $arOffer['MIN_PRICE']
				: $minNotAvailPrice
			);
			$arOffer['ON_REQUEST'] = (empty($arOffer['MIN_PRICE']) || $arOffer['MIN_PRICE']['VALUE'] <= 0);
			if ($arOffer['ON_REQUEST']) {
				$arOffer['CAN_BUY'] = false;
				if(!$arItem['CAN_BUY']) {
					$arItem['ON_REQUEST'] = $arOffer['ON_REQUEST'];
				}
			}
			if(!$can_buy_find && $arOffer['CAN_BUY'])
			{
				$arItem['CAN_BUY'] = $arOffer['CAN_BUY'];
				$can_buy_find = true;
			}
		}
		unset($arOffer);
		if($arItem['CAN_BUY'])
		{
			$arResult['ITEMS'][$index]['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromOffers(
				$arItem['OFFERS'],
				$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency,
				false
			);
			$arItem['ON_REQUEST'] = false;
		}
		else
		{
			$arResult['ITEMS'][$index]['MIN_PRICE'] = $minNotAvailPrice;
		}
		$arResult['ITEMS'][$index]['CAN_BUY'] = $arItem['CAN_BUY'];
		$arResult['ITEMS'][$index]['ON_REQUEST'] = $arItem['ON_REQUEST'];
	}

	if ($arItem['ON_REQUEST']) {
		$arResult['ITEMS'][$index]['CAN_BUY'] = false;
	}
}

