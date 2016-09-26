<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arParams['RESIZER_SET'] = intval($arParams['RESIZER_SET']) ? $arParams['RESIZER_SET'] : 3;

$arResult['CURRENCY'] = CModule::IncludeModule("currency");
$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']) && $arResult['CURRENCY'];
if (!$boolConvert)
	$strBaseCurrency = $arResult['CURRENCY'] ? CCurrency::GetBaseCurrency() : 'RUB';

if (CModule::IncludeModule('yenisite.market')) {
	$arResult['CHECK_QUANTITY'] = (CMarketCatalog::UsesQuantity($arParams['IBLOCK_ID']) == 1);
}

foreach($arResult['ITEMS'] as $index => $arItem)
{
	$arItem = CRZBitronic2CatalogUtils::processItemCommon($arItem);
	$arItem['bFirst'] = ($index === 0);
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

	//Prices for MARKET
	if (CModule::IncludeModule('yenisite.bitronic2lite') && CModule::IncludeModule('yenisite.market')) {
		$prices = CMarketPrice::GetItemPriceValues($arItem['ID'], $arItem['PRICES']);
		if (count($prices) > 0) {
			unset($arItem['PRICES']);
		}
		$minPrice = false;
		foreach ($prices as $k => $pr) {
			$pr = floatval($pr);
			$arItem['PRICES'][$k]['VALUE'] = $pr;
			$arItem['PRICES'][$k]['PRINT_VALUE'] = $pr;
			if ((empty($minPrice) || $minPrice > $pr) && $pr > 0) {
				$minPrice = $pr;
			}
		}
		if ($minPrice !== false) {
			$arItem['MIN_PRICE']['VALUE'] = $minPrice;
			$arItem['MIN_PRICE']['PRINT_VALUE'] = $minPrice;
			$arItem['MIN_PRICE']['DISCOUNT_VALUE'] = $minPrice;
			$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $minPrice;
			$arItem['CATALOG_MEASURE_RATIO'] = 1;
			$arItem['CAN_BUY'] = true;
		}
		$arItem['CHECK_QUANTITY'] = $arResult['CHECK_QUANTITY'];
		$arItem['CATALOG_QUANTITY'] = CMarketCatalogProduct::GetQuantity($arItem['ID'], $arItem['IBLOCK_ID']);
		
		if ($arItem['CHECK_QUANTITY'] && $arItem['CATALOG_QUANTITY'] <= 0) {
			$arItem['CAN_BUY'] = false;
		}
		$arItem['CATALOG_TYPE'] = 1; //simple product
	}
	//end Prices for MARKET
	
	$arItem['ON_REQUEST'] = (empty($arItem['MIN_PRICE']) || $arItem['MIN_PRICE']['VALUE'] <= 0);
	
	if(isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
	{
		$minNotAvailPrice = false;
		$can_buy_find = false;
		$arItem['bOffers'] = true;
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
			$arItem['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromOffers(
				$arItem['OFFERS'],
				$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency,
				false
			);
			$arItem['ON_REQUEST'] = false;
		}
		else
		{
			$arItem['MIN_PRICE'] = $minNotAvailPrice;
		}
	}
	
	$arResult['ITEMS'][$index] = $arItem;
}