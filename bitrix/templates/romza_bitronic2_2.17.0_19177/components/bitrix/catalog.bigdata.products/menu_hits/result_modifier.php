<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arParams['RESIZER_SET'] = intval($arParams['RESIZER_SET']) ? $arParams['RESIZER_SET'] : 3;

$arResult['CURRENCY'] = CModule::IncludeModule("currency");
$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']) && $arResult['CURRENCY'];
if (!$boolConvert)
	$strBaseCurrency = CCurrency::GetBaseCurrency();
if (is_array($arResult['ITEMS']))
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

	$arItem['ON_REQUEST'] = (empty($arItem['MIN_PRICE']) || $arItem['MIN_PRICE']['VALUE'] <= 0);
	if ($arItem['ON_REQUEST']) {
		$arItem['CAN_BUY'] = false;
	}
	
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
				$arItem['CAN_BUY'] = $arItem['CAN_BUY'] = $arOffer['CAN_BUY'];
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