<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

if (!Loader::includeModule('iblock'))
	return;

// RESIZER
$resizer_sets_list = array () ;
if(Loader::IncludeModule("yenisite.resizer2")){
	$arSets = CResizer2Set::GetList();
	while($arr = $arSets->Fetch())
	{
		$resizer_sets_list[$arr["id"]] = "[".$arr["id"]."] ".$arr["NAME"];
	}
}



$arTemplateParameters["RESIZER_SET"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("RESIZER_SET"),
	"TYPE" => "LIST",
	"VALUES" => $resizer_sets_list,
	"DEFAULT" => "5",
);

$arTemplateParameters["SHOW_AMOUNT_STORE"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("SHOW_AMOUNT_STORE"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

$arTemplateParameters["SHOW_VOTING"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("SHOW_VOTING"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

$arTemplateParameters["DISPLAY_TOP_PAGER"]['HIDDEN'] = 'Y';
$arTemplateParameters["DISPLAY_BOTTOM_PAGER"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_TEMPLATE"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_TITLE"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_SHOW_ALWAYS"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_DESC_NUMBERING"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_DESC_NUMBERING_CACHE_TIME"]['HIDDEN'] = 'Y';
$arTemplateParameters["PAGER_SHOW_ALL"]['HIDDEN'] = 'Y';
$arTemplateParameters["DISPLAY_COMPARE"]['HIDDEN'] = 'Y';

if (\Bitrix\Main\Loader::includeModule('yenisite.geoipstore')) {
	$arComponentParameters = array();
	/** @noinspection PhpDynamicAsStaticMethodCallInspection */
	\CComponentUtil::__IncludeLang($componentPath, ".parameters.php");
	include($_SERVER["DOCUMENT_ROOT"].$componentPath."/.parameters.php");
	$arTemplateParameters['PRICE_CODE'] = array(
		'TYPE' => 'STRING',
		'NAME' => $arComponentParameters['PARAMETERS']['PRICE_CODE']['NAME'],
		'MULTIPLE' => 'N'
	);
	unset($arComponentParameters);
}