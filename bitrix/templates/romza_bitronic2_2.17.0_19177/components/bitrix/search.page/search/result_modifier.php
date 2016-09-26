<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

if($arResult["REQUEST"]["HOW"] == "d") {
	$arResult['RZ_SORT_DATE'] = ' active'; $arResult['RZ_SORT_RANK'] = '';
} else {
	$arResult['RZ_SORT_RANK'] = ' active'; $arResult['RZ_SORT_DATE'] = '';
}


?>