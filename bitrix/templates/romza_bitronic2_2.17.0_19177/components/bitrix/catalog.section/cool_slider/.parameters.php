<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

$resizer_sets_list = array ();
if(Loader::IncludeModule("yenisite.resizer2")){
	$arSets = CResizer2Set::GetList();
	while($arr = $arSets->Fetch())
	{
		$resizer_sets_list[$arr["id"]] = "[".$arr["id"]."] ".$arr["NAME"];
	}
}

global $arComponentParameters;

// RESIZER:
$arComponentParameters["GROUPS"]["RESIZER_SETS"]= array(
	"NAME" => GetMessage("RESIZER_SETS"),
	"SORT" => 1
);

$arTemplateParameters = array(
	"RESIZER_SET_BIG" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SET_BIG"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "2",
	),
	"RESIZER_SET_SMALL" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SET_SMALL"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "6",
	),
);


// HIDE exist params
$arTemplateParameters['LINE_ELEMENT_COUNT']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_TEMPLATE']['HIDDEN'] = 'Y';
$arTemplateParameters['DISPLAY_TOP_PAGER']['HIDDEN'] = 'Y';
$arTemplateParameters['DISPLAY_BOTTOM_PAGER']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_TITLE']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_SHOW_ALWAYS']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_DESC_NUMBERING']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_DESC_NUMBERING_CACHE_TIME']['HIDDEN'] = 'Y';
$arTemplateParameters['PAGER_SHOW_ALL']['HIDDEN'] = 'Y';
$arTemplateParameters['AJAX_OPTION_ADDITIONAL']['HIDDEN'] = 'Y';
$arTemplateParameters['DISPLAY_COMPARE']['HIDDEN'] = 'Y';

// EDIT exist params
$arTemplateParameters['PAGE_ELEMENT_COUNT']['NAME'] = GetMessage('PAGE_ELEMENT_COUNT');
?>