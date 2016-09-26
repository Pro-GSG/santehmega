<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;


if (!Loader::includeModule('iblock'))
	return;
$boolCatalog = Loader::includeModule('catalog');

// SKU:
$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

//PROPERTIES:
$arProperties_ALL	= array('-' => GetMessage('CP_BC_TPL_PROP_EMPTY')) ;
$arProperties_LNS	= array('-' => GetMessage('CP_BC_TPL_PROP_EMPTY')) ; // list, number, string
$arProperties_LNS_S = array('-' => GetMessage('CP_BC_TPL_PROP_EMPTY')) ; // same but not multiple
$arProperties_E		= array('-' => GetMessage('CP_BC_TPL_PROP_EMPTY')) ; // link element
if (IntVal($arCurrentValues["IBLOCK_ID"]))
{
	$dbProperties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>IntVal($arCurrentValues["IBLOCK_ID"])));
	while ($arProp = $dbProperties->GetNext())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		
		$arProperties_ALL[$arProp["CODE"]] = "[{$arProp['CODE']}] {$arProp['NAME']}" ;
		if(in_array($arProp["PROPERTY_TYPE"], array("L", "N", "S"))) {
			$arProperties_LNS[$arProp["CODE"]] = &$arProperties_ALL[$arProp["CODE"]] ;
			if ($arProp["MULTIPLE"] != "Y") {
				$arProperties_LNS_S[$arProp["CODE"]] = &$arProperties_ALL[$arProp["CODE"]] ;
			}
		}
		if($arProp['PROPERTY_TYPE'] == 'E')
			$arProperties_E[$arProp["CODE"]] = &$arProperties_ALL[$arProp["CODE"]] ;
		if ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
	}
}

$siteId = $_REQUEST['src_site'];
$siteTemplate = $_REQUEST['siteTemplateId'];
if (empty($siteTemplate)) $siteTemplate = $_REQUEST['site_template'];
if (empty($siteTemplate)) $siteTemplate = $_REQUEST['template_id'];
// @var $moduleId
include $_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/templates/' . $siteTemplate . '/include/module_code.php';
if(Loader::includeModule($moduleId) && class_exists('CRZBitronic2CatalogUtils'))
{
	$arDefPropsHide = CRZBitronic2CatalogUtils::$_systemProps;
}
else
{
	$arDefPropsHide = array('SERVICE', 'MANUAL', 'ID_3D_MODEL', 'MAILRU_ID', 'VIDEO', 'ARTICLE', 'HOLIDAY', 'SHOW_MAIN','HIT','SALE','PHOTO','DESCRIPTION','MORE_PHOTO','NEW','KEYWORDS','TITLE','FORUM_TOPIC_ID','FORUM_MESSAGE_CNT','PRICE_BASE','H1','YML','FOR_ORDER','WEEK_COUNTER','WEEK', 'BESTSELLER', 'SALE_INT', 'SALE_EXT', 'COMPLETE_SETS', 'vote_count', 'vote_sum', 'rating');
}

$resizer_sets_list = array () ;
if(Loader::IncludeModule("yenisite.resizer2")){
	$arSets = CResizer2Set::GetList();
	while($arr = $arSets->Fetch())
	{
		$resizer_sets_list[$arr["id"]] = "[".$arr["id"]."] ".$arr["NAME"];
	}
}

$arPrice = array();
if(Loader::IncludeModule("catalog"))
{
	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
	while($arr=$rsPrice->Fetch()) 
	{
		$arPrice["CATALOG_PRICE_{$arr['ID']}"] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
	}
	$defPrice = 'CATALOG_PRICE_1';
}

global $arComponentParameters;

// GROUPS:
$arComponentParameters["GROUPS"]["RESIZER_SETS"]= array(
	"NAME" => GetMessage("RESIZER_SETS"),
	"SORT" => "100"
);
$arComponentParameters["GROUPS"]["STICKERS"]= array(
	"NAME" => GetMessage("STICKER_GROUP"),
	"SORT" => "4900",
);

// RESIZER:
$arTemplateParameters_resizer = array(
	"RESIZER_SECTION_LVL0" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SECTION_LVL0"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "6",
	),
	"RESIZER_SECTION" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SECTION"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "4",
	),
	"RESIZER_SECTION_ICON" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SECTION_ICON"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "5",
	),
	"RESIZER_SUBSECTION" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SUBSECTION"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "5",
	),
	"RESIZER_DETAIL_SMALL" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_DETAIL_SMALL"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "2"
	),
	"RESIZER_DETAIL_BIG" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_DETAIL_BIG"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "1"
	),
	"RESIZER_QUICK_VIEW" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_QUICK_VIEW"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "2"
	),
	"RESIZER_DETAIL_ICON" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_DETAIL_ICON"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "6"
	),
	"RESIZER_DETAIL_PROP" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_DETAIL_PROP"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "5"
	),
	"RESIZER_DETAIL_FLY_BLOCK" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_DETAIL_FLY_BLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "3"
	),
	"RESIZER_COMMENT_AVATAR" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_COMMENT_AVATAR"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "6"
	),
	"RESIZER_SET_CONTRUCTOR" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_SET_CONTRUCTOR"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "3"
	),
	"RESIZER_RECOMENDED" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_RECOMENDED"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "3"
	),
	"RESIZER_FILTER" => array(
		"PARENT" => "RESIZER_SETS",
		"NAME" => GetMessage("RESIZER_FILTER"),
		"TYPE" => "LIST",
		"VALUES" => $resizer_sets_list,
		"DEFAULT" => "5"
	),
);


// COMMON
$arTemplateParameters_common = array(
	'SLIDERS_HIDE_NOT_AVAILABLE' => array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('CP_BC_HIDE_NOT_AVAILABLE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'HIDDEN' => CRZBitronic2Settings::isPro($bWithGeoip = true, $siteId) ? 'Y' : 'N'
	),
	// ARTICUL
	'ARTICUL_PROP' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('ARTICUL_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'DEFAULT' => 'ARTICUL',
		'VALUES' => $arProperties_ALL,
	),
	'BIGDATA_BESTSELL_TITLE' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('BIGDATA_BESTSELL_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('BIGDATA_BESTSELL_TITLE_DEFAULT')
	),
	'BIGDATA_PERSONAL_TITLE' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('BIGDATA_PERSONAL_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('BIGDATA_PERSONAL_TITLE_DEFAULT')
	),
);
if(Loader::includeModule('yenisite.favorite'))
{
	$arTemplateParameters_common['DISPLAY_FAVORITE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('DISPLAY_FAVORITE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	);
}
if(Loader::includeModule('yenisite.oneclick'))
{
	$arTemplateParameters_common['DISPLAY_ONECLICK'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('DISPLAY_ONECLICK'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
}

// SECTION SORT
$arTemplateParameters_section_sort = array(
	"LIST_PRICE_SORT" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME"   => GetMessage("BITRONIC2_PRICE_SORT"),
		"TYPE"   => "LIST",
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "N",
		"VALUES" => $arPrice,
		"DEFAULT" => $defPrice
	),		
	"DEFAULT_ELEMENT_SORT_BY" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('BITRONIC2_DEFAULT_ELEMENT_SORT_BY'),
		"TYPE"	 => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => Array(
				'PRICE' => GetMessage('BITRONIC2_ELEMENT_SORT_PRICE'),
				'NAME'  => GetMessage('BITRONIC2_ELEMENT_SORT_NAME'),
				'SHOWS' => GetMessage('BITRONIC2_ELEMENT_SORT_HIT') ,
				// 'PROPERTY_SALE_INT' => GetMessage('BITRONIC2_ELEMENT_SORT_SALE_INT'),
				// 'PROPERTY_SALE_EXT' => GetMessage('BITRONIC2_ELEMENT_SORT_SALE_EXT'),
				'RATING' => GetMessage('BITRONIC2_ELEMENT_SORT_RATING'),				
			),
		"DEFAULT" => 'NAME',
	),
	"DEFAULT_ELEMENT_SORT_ORDER" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('BITRONIC2_DEFAULT_ELEMENT_SORT_ORDER'),
		"TYPE"	 => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => Array(
				'ASC' => GetMessage('BITRONIC2_ELEMENT_SORT_ASC'),
				'DESC' => GetMessage('BITRONIC2_ELEMENT_SORT_DESC'),
			),
		"DEFAULT" => 'ASC',
	),
	"LIST_SORT_PROPS" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage('BITRONIC2_LIST_SORT_PROPS'),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"SIZE" => "6",
		"VALUES" => $arProperties_LNS_S
	)
);

// SECTION
$arTemplateParameters_section = array(
	"HIDE_SHOW_ALL_BUTTON" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('BITRONIC2_HIDE_SHOW_ALL_BUTTON'),
		"TYPE"	 => "CHECKBOX",
		"DEFAULT" => 'N',
	),
	"HIDE_ICON_SLIDER" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('BITRONIC2_HIDE_ICON_SLIDER'),
		"TYPE"	 => "CHECKBOX",
		"DEFAULT" => 'N',
	),
	"HIDE_STORE_LIST" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('BITRONIC2_HIDE_STORE_LIST'),
		"TYPE"	 => "CHECKBOX",
		"DEFAULT" => 'N',
	),
	
	"SHOW_DESCRIPTION_TOP" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('SHOW_DESCRIPTION_TOP'),
		"TYPE"	 => "CHECKBOX",
		"DEFAULT" => 'Y',
	),
	"SHOW_DESCRIPTION_BOTTOM" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" 	 => GetMessage('SHOW_DESCRIPTION_BOTTOM'),
		"TYPE"	 => "CHECKBOX",
		"DEFAULT" => 'N',
	),
);
$arTemplateParameters_filter = array();
// FILTER:
if($arCurrentValues["USE_FILTER"]=="Y")
{
	$arTemplateParameters_filter["FILTER_DISPLAY_ELEMENT_COUNT"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("FILTER_DISPLAY_ELEMENT_COUNT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arTemplateParameters_filter["FILTER_VISIBLE_PROPS_COUNT"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("FILTER_VISIBLE_PROPS_COUNT"),
		"TYPE" => "STRING",
		"DEFAULT" => "3",
	);
	$arTemplateParameters_filter["FILTER_HIDE_DISABLED_VALUES"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("FILTER_HIDE_DISABLED_VALUES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);
	$arTemplateParameters_filter["FILTER_SHOW_NAME_FIELD"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("FILTER_SHOW_NAME_FIELD"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
}

// STICKERS:
$arTemplateParameters_stickers = array();
if (CModule::IncludeModule('yenisite.mainspec')) {
	$arTemplateParameters_stickers = CYenisiteMainspec::CatalogParams($arProperties_LNS, $arCurrentValues);
	unset(
		$arTemplateParameters_stickers['STICKER_HIT'],
		$arTemplateParameters_stickers['STICKER_BESTSELLER']
	);
	foreach ($arTemplateParameters_stickers as &$arParam) {
		$arParam['PARENT'] = 'STICKERS';
	} unset($arParam);
}

$arTemplateParameters_sku = array();
// SKU:
if ($boolSKU)
{
	$arAllOfferPropList = array();
	$arFileOfferPropList = array(
		'-' => GetMessage('CP_BCS_TPL_PROP_EMPTY')
	);
	$arTreeOfferPropList = array(
		'-' => GetMessage('CP_BCS_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
			continue;
		$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllOfferPropList[$arProp['CODE']] = $strPropName;
		if ('F' == $arProp['PROPERTY_TYPE'])
			$arFileOfferPropList[$arProp['CODE']] = $strPropName;
		if ('N' != $arProp['MULTIPLE'])
			continue;
		if (
			'L' == $arProp['PROPERTY_TYPE']
			|| 'E' == $arProp['PROPERTY_TYPE']
			|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
		)
			$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
	}
	
	$arTemplateParameters_sku['OFFER_TREE_PROPS'] = array(
		'PARENT' => 'OFFERS_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_OFFER_TREE_PROPS'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'Y',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arTreeOfferPropList
	);
	
	$arTemplateParameters_detail['OFFER_VAR_NAME'] = array(
		'PARENT' => 'OFFERS_SETTINGS',
		'NAME' => GetMessage('OFFER_VAR_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'pid'
	);
	$arTemplateParameters_detail['MANUAL_PROP'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('MANUAL_PROP_NAME'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'VALUES' => $arProperties_ALL,
		'ADDITIONAL_VALUES' => 'Y',
		'DEFAULT' => 'MANUAL'
	);
	$arTemplateParameters_sku['ADD_PARENT_PHOTO'] = array(
		'PARENT' => 'OFFERS_SETTINGS',
		'NAME' => GetMessage('ADD_PARENT_PHOTO'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'N'
	);	
}

// DETAIL
$arTemplateParameters_detail['SETTINGS_HIDE'] = array(
	"PARENT" => "DETAIL_SETTINGS",
	"NAME" => GetMessage("SETTINGS_HIDE"),
	"TYPE" => "LIST",
	"MULTIPLE" => "Y",
	"VALUES" => $arProperties_ALL,
	"SIZE" => "8",
	"DEFAULT" => $arDefPropsHide,
);

if (isset($arCurrentValues['USE_REVIEW']) && $arCurrentValues['USE_REVIEW'] == 'Y')
{
	$arTemplateParameters_detail['USE_OWN_REVIEW'] = array(
		'PARENT' => 'REVIEW_SETTINGS',
		'NAME' => GetMessage('USE_OWN_REVIEW'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	$arCurrentValues['USE_OWN_REVIEW'] = isset($arCurrentValues['USE_OWN_REVIEW']) ? $arCurrentValues['USE_OWN_REVIEW'] : 'Y';
	if($arCurrentValues['USE_OWN_REVIEW'] == 'Y')
	{
		$arReviewModeValues = array();
		if ($bForum = ModuleManager::isModuleInstalled('forum')) $arReviewModeValues['forum'] = GetMessage('REVIEWS_FORUM');
		if ($bBlog  = ModuleManager::isModuleInstalled('blog'))  $arReviewModeValues['blog']  = GetMessage('REVIEWS_BLOG');
		if ($bFeedback = (CModule::IncludeModule('yenisite.feedback') && ModuleManager::isModuleInstalled('yenisite.bitronic2lite'))) {
			$arReviewModeValues['feedback'] = GetMessage('REVIEWS_FEEDBACK');
		}
		$arReviewDefault = current(array_keys($arReviewModeValues));
		if (!isset($arReviewModeValues[$arCurrentValues['REVIEWS_MODE']])) {
			$arCurrentValues['REVIEWS_MODE'] = $arReviewDefault;
		}

		$arTemplateParameters_detail['REVIEWS_MODE'] = array(
			"PARENT" => "REVIEW_SETTINGS",
			"NAME" => GetMessage("REVIEWS_MODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			'REFRESH' => 'Y',
			"VALUES" => $arReviewModeValues,
			"DEFAULT" => $arReviewDefault,
		);
		if (isset($arCurrentValues['REVIEWS_MODE']) && $arCurrentValues['REVIEWS_MODE'] == 'blog' && $bBlog)
		{
			$arTemplateParameters_detail['DETAIL_BLOG_URL'] = array(
				'PARENT' => 'REVIEW_SETTINGS',
				'NAME' => GetMessage('CP_BCE_TPL_BLOG_URL'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'b2_catalog_comments'
			);
			$arTemplateParameters_detail['BLOG_EMAIL_NOTIFY'] = array(
				'PARENT' => 'REVIEW_SETTINGS',
				'NAME' => GetMessage('CP_BCE_TPL_BLOG_EMAIL_NOTIFY'),
				'TYPE' => 'CHECKBOX',
				'DEFAULT' => 'N'
			);
		}
		if (isset($arCurrentValues['REVIEWS_MODE']) && !($arCurrentValues['REVIEWS_MODE'] == 'forum' && $bForum))
		{
			$arTemplateParameters_detail["FORUM_ID"]['HIDDEN'] = 'Y';
			$arTemplateParameters_detail["USE_CAPTCHA"]['HIDDEN'] = 'Y';
		}
		if (isset($arCurrentValues['REVIEWS_MODE']) && $arCurrentValues['REVIEWS_MODE'] == 'feedback' && $bFeedback) {
			$arIBlockType = CIBlockParameters::GetIBlockTypes();
			$arTemplateParameters_detail['FEEDBACK_IBLOCK_TYPE'] = array(
				'PARENT' => 'REVIEW_SETTINGS',
				'NAME' => GetMessage('CP_BCE_TPL_FEEDBACK_IBLOCK_TYPE'),
				'TYPE' => 'LIST',
				'VALUES' => $arIBlockType,
				'DEFAULT' => 'yenisite_feedback',
				'REFRESH' => 'Y'
			);

			$arIBlock = array();
			$iblockFilter = (
			!empty($arCurrentValues['FEEDBACK_IBLOCK_TYPE'])
				? array('TYPE' => $arCurrentValues['FEEDBACK_IBLOCK_TYPE'], 'ACTIVE' => 'Y')
				: array('TYPE' => 'yenisite_feedback', 'ACTIVE' => 'Y')
			);
			$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
			while ($arr = $rsIBlock->Fetch())
				$arIBlock[$arr['ID']] = '[' . $arr['ID'] . '] ' . $arr['NAME'];
			unset($arr, $rsIBlock, $iblockFilter);

			$arTemplateParameters_detail['FEEDBACK_IBLOCK_ID'] = array(
				'PARENT' => 'REVIEW_SETTINGS',
				'NAME' => GetMessage('CP_BCE_TPL_FEEDBACK_IBLOCK_ID'),
				'TYPE' => 'LIST',
				'VALUES' => $arIBlock,
				'DEFAULT' => ''
			);
		}
	}
	else
	{
		$arTemplateParameters_detail["FORUM_ID"]['HIDDEN'] = 'Y';
		$arTemplateParameters_detail["USE_CAPTCHA"]['HIDDEN'] = 'Y';
		$arTemplateParameters_detail["MESSAGES_PER_PAGE"]['HIDDEN'] = 'Y';
	}
	if (CModule::IncludeModule('yenisite.yandexreviewsmodel'))
	{
		$arTemplateParameters_detail['DETAIL_YM_API_USE'] = array(
			'PARENT' => 'REVIEW_SETTINGS',
			'NAME' => GetMessage('DETAIL_YM_API_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'N'
		);
	}
}

$arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_PERCENT'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_SIMILAR_PRICE_PERCENT'),
	'TYPE' => 'STRING',
	'DEFAULT' => '20',
);
$arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_SMART_FILTER'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_SIMILAR_PRICE_SMART_FILTER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
);
$arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_WITH_EMPTY_PROPS'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_SIMILAR_PRICE_WITH_EMPTY_PROPS'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
);
$arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_PROPERTIES'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_SIMILAR_PRICE_PROPERTIES'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => array_merge(
		array(
			'-'               => NULL, //fills from merge with $arProperties_LNS
			'---AVAILABLE---' => GetMessage('DETAIL_SIMILAR_PRICE_PROPERTIES_AVAILABLE'),
			'---SECTION---'   => GetMessage('DETAIL_SIMILAR_PRICE_PROPERTIES_SECTION'),
			'---PRICE---'     => GetMessage('DETAIL_SIMILAR_PRICE_PROPERTIES_PRICE'),
			),
		$arProperties_LNS
		),
	'DEFAULT' => array('---AVAILABLE---', '---SECTION---', '---PRICE---')
);
$arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_PROPERTIES']['SIZE'] = min(count($arTemplateParameters_detail['DETAIL_SIMILAR_PRICE_PROPERTIES']['VALUES']), 10);

global $MESS;
if ($boolCatalog) {
	$MESS['DETAIL_SIMILAR_PRICE_SMART_FILTER_TIP'] = GetMessage(
		'DETAIL_SIMILAR_PRICE_SMART_FILTER_TIP_CATALOG',
		array('#IBLOCK_ID#' => $arCurrentValues['IBLOCK_ID'])
	);
} else {
	$MESS['DETAIL_SIMILAR_PRICE_SMART_FILTER_TIP'] = GetMessage(
		'DETAIL_SIMILAR_PRICE_SMART_FILTER_TIP_MARKET',
		array(
			'#IBLOCK_ID#'   => $arCurrentValues['IBLOCK_ID'],
			'#IBLOCK_TYPE#' => $arCurrentValues['IBLOCK_TYPE']
		)
	);
}

foreach (array('ACCESSORIES', 'SIMILAR', 'SIMILAR_VIEW', 'SIMILAR_PRICE', 'RECOMMENDED', 'VIEWED') as $detailBlock) {
	$name = 'DETAIL_' . $detailBlock . '_TITLE';
	$arTemplateParameters_detail[$name] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'TYPE' => 'STRING',
		'NAME' => GetMessage($name),
		'DEFAULT' => GetMessage($name.'_DEFAULT')
	);
}

if (Loader::IncludeModule('yenisite.feedback')) {
	//FOUND_CHEAP
	//PRICE_LOWER
	$arTemplateParameters_detail['DETAIL_FOUND_CHEAP'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('BITRONIC2_FOUND_CHEAP_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);

	$arTemplateParameters_detail['DETAIL_PRICE_LOWER'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('BITRONIC2_PRICE_LOWER_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
}

if (ModuleManager::isModuleInstalled("highloadblock"))
{
	$arTemplateParameters_section['LIST_BRAND_USE'] = array(
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_LIST_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	);

	$arTemplateParameters_section['LIST_BRAND_PROP_CODE'] = array(
		'PARENT' => 'LIST_SETTINGS',
		"NAME" => GetMessage("CP_BC_TPL_LIST_PROP_CODE"),
		"TYPE" => "LIST",
		"VALUES" => $arHighloadPropList,
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "BRANDS_REF"
	);
	$arTemplateParameters_detail['BRAND_DETAIL'] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("CP_BC_TPL_BRAND_DETAIL"),
		"TYPE" => "STRING",
		"DEFAULT" => "={SITE_DIR.\"brands/#ID#/\"}"
	);
}

// BIG DATA
if($boolCatalog)
{
	$arTemplateParameters_detail['DETAIL_HIDE_ACCESSORIES'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('DETAIL_HIDE_ACCESSORIES'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'HIDDEN' => 'Y',
	);
		
	$arTemplateParameters_detail['DETAIL_HIDE_SIMILAR'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('DETAIL_HIDE_SIMILAR'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'HIDDEN' => 'Y',
	);
		
	$arTemplateParameters_detail['DETAIL_HIDE_SIMILAR_VIEW'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('DETAIL_HIDE_SIMILAR_VIEW'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'HIDDEN' => 'Y',
	);

	$arTemplateParameters_section['SECTION_SHOW_HITS'] = array(
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => GetMessage('SECTION_SHOW_HITS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);

	if ($arCurrentValues['SECTION_SHOW_HITS'] !== 'N') {
		$arTemplateParameters_section['SECTION_HITS_RCM_TYPE'] = array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_HITS_RCM_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'bestsell' => GetMessage('SECTION_HITS_RCM_TYPE_BESTSELL'),
				'personal' => GetMessage('SECTION_HITS_RCM_TYPE_PERSONAL')
				),
			'DEFAULT' => 'bestsell'
		);

		$arTemplateParameters_section['SECTION_HITS_HIDE_NOT_AVAILABLE'] = array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_HITS_HIDE_NOT_AVAILABLE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		);
	}

	$arTemplateParameters_common['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
}

// META COMPARE
$arTemplateParameters_meta_compare = array(
	
	"COMPARE_META_H1" => array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("BITRONIC2_META_H1"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BITRONIC2_META_COMPARE_THAT_BETTER"),
	),
	
	"COMPARE_META_TITLE" => array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("BITRONIC2_META_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BITRONIC2_META_COMPARE_THAT_BETTER_BUY"),
	),

	"COMPARE_META_KEYWORDS" => array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("BITRONIC2_META_KEYWORDS"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BITRONIC2_META_COMPARE_COMPARE"),
	),
		
	"COMPARE_META_DESCRIPTION" => array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("BITRONIC2_META_DESCRIPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BITRONIC2_META_COMPARE_COMPARE"),
	),
	
);

if (CModule::IncludeModule('sale') && CModule::IncludeModule('edost.catalogdelivery')) {
	$arTemplateParameters_edost = array(
		'EDOST_SHOW_QTY' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_SHOW_QTY'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'EDOST_SHOW_ADD_CART' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_SHOW_ADD_CART'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'EDOST_MINIMIZE' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_MINIMIZE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'EDOST_SORT' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_SORT'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'EDOST_ECONOMIZE' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_ECONOMIZE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'EDOST_ECONOMIZE_INLINE' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_ECONOMIZE_INLINE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'EDOST_MAX' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_MAX'),
			'TYPE' => 'STRING',
			'DEFAULT' => '5',
		),
		'EDOST_PRICE_VALUE' => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('EDOST_PRICE_VALUE'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'max' => GetMessage('EDOST_PRICE_VALUE_MAX'),
				'min' => GetMessage('EDOST_PRICE_VALUE_MIN'),
				'first' => GetMessage('EDOST_PRICE_VALUE_FIRST'),
				),
			'DEFAULT' => 'min'
		)
	);
	$arTemplateParameters_detail += $arTemplateParameters_edost;
}

$arTemplateParameters = array_merge(
	$arTemplateParameters_common,
	$arTemplateParameters_section_sort,
	$arTemplateParameters_section,
	$arTemplateParameters_filter,
	$arTemplateParameters_stickers,
	$arTemplateParameters_sku,
	$arTemplateParameters_detail,
	$arTemplateParameters_resizer,
	$arTemplateParameters_meta_compare
);


// #### EDIT exist params

// TODO
	$arTemplateParameters["HIDE_NOT_AVAILABLE"]['HIDDEN'] = 'Y'; 
	$arTemplateParameters["USE_ALSO_BUY"]['HIDDEN'] = 'Y'; 
	$arTemplateParameters["DETAIL_BRAND_USE"]['HIDDEN'] = 'Y';
	
if($boolSKU)
{
	$arTemplateParameters["LIST_PRICE_SORT"]['HIDDEN'] = 'Y'; 
}

// HIDDEN	
	$arTemplateParameters["DETAIL_PROPERTY_CODE"]['HIDDEN'] = 'Y'; 
	$arTemplateParameters["AJAX_MODE"]['HIDDEN'] = 'Y'; 
	$arTemplateParameters["ELEMENT_SORT_FIELD"]['HIDDEN'] = 'Y'; 
	$arTemplateParameters["ELEMENT_SORT_ORDER"]['HIDDEN'] = 'Y';
	$arTemplateParameters["ELEMENT_SORT_FIELD2"]['HIDDEN'] = 'Y';
	$arTemplateParameters["ELEMENT_SORT_ORDER2"]['HIDDEN'] = 'Y';
	$arTemplateParameters["FILTER_FIELD_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["FILTER_PROPERTY_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["FILTER_PRICE_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["FILTER_OFFERS_FIELD_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["FILTER_OFFERS_PROPERTY_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_ELEMENT_COUNT"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_LINE_ELEMENT_COUNT"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_ELEMENT_SORT_FIELD"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_ELEMENT_SORT_ORDER"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_ELEMENT_SORT_FIELD2"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_ELEMENT_SORT_ORDER2"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_PROPERTY_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_OFFERS_FIELD_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_OFFERS_PROPERTY_CODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_OFFERS_LIMIT"]['HIDDEN'] = 'Y';
	$arTemplateParameters["TOP_VIEW_MODE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["SHOW_TOP_ELEMENTS"]['HIDDEN'] = 'Y';
	$arTemplateParameters["PAGE_ELEMENT_COUNT"]['HIDDEN'] = 'Y';
	$arTemplateParameters["LINE_ELEMENT_COUNT"]['HIDDEN'] = 'Y';
	
	$arTemplateParameters["PATH_TO_SMILE"]['HIDDEN'] = 'Y';
	$arTemplateParameters["REVIEW_AJAX_POST"]['HIDDEN'] = 'Y';
	$arTemplateParameters["URL_TEMPLATES_READ"]['HIDDEN'] = 'Y';
	$arTemplateParameters["SHOW_LINK_TO_FORUM"]['HIDDEN'] = 'Y';

	$arTemplateParameters['GIFTS_SHOW_NAME']['HIDDEN'] = 'Y';
	$arTemplateParameters['GIFTS_SHOW_IMAGE']['HIDDEN'] = 'Y';
	$arTemplateParameters['GIFTS_MESS_BTN_BUY']['HIDDEN'] = 'Y';
	$arTemplateParameters['USE_GIFTS_SECTION']['HIDDEN'] = 'Y';

if ($arCurrentValues['USE_STORE'] === 'Y') {
	$arTemplateParameters['USE_STORE']['HIDDEN'] = 'Y';
} else {
	$arTemplateParameters['USE_STORE'] = array(
		"PARENT" => "STORE_SETTINGS",
		'TYPE' => 'CHECKBOX',
		'NAME' => GetMessage('BITRONIC2_USE_STORE'),
		'REFRESH' => 'Y',
	);
}
if ($arCurrentValues['USE_MIN_AMOUNT'] === 'Y' || $arCurrentValues['USE_STORE'] !== 'Y') {
	$arTemplateParameters['USE_MIN_AMOUNT']['HIDDEN'] = 'Y';
} else {
	$arTemplateParameters['USE_MIN_AMOUNT'] = array(
		"PARENT" => "STORE_SETTINGS",
		'TYPE' => 'CHECKBOX',
		'NAME' => GetMessage('BITRONIC2_USE_MIN_AMOUNT'),
		'REFRESH' => 'Y',
	);
}
if ($arCurrentValues['USE_REVIEW'] === 'Y') {
	$arTemplateParameters['USE_REVIEW']['HIDDEN'] = 'Y';
} else {
	$arTemplateParameters['USE_REVIEW'] = array(
		'PARENT' => 'REVIEW_SETTINGS',
		'TYPE' => 'CHECKBOX',
		'NAME' => GetMessage('BITRONIC2_USE_REVIEW'),
		'REFRESH' => 'Y'
	);
}

$arComponentParameters = array();
/** @noinspection PhpDynamicAsStaticMethodCallInspection */
\CComponentUtil::__IncludeLang($componentPath, ".parameters.php");
include($_SERVER["DOCUMENT_ROOT"].$componentPath."/.parameters.php");

if (\Bitrix\Main\Loader::includeModule('yenisite.geoipstore')) {
	$arTemplateParameters['PRICE_CODE'] = array(
		'TYPE' => 'STRING',
		'NAME' => $arComponentParameters['PARAMETERS']['PRICE_CODE']['NAME'],
		'MULTIPLE' => 'N'
	);
}

$arTemplateParameters['USE_PRICE_COUNT'] = $arComponentParameters['USE_PRICE_COUNT'];
$arTemplateParameters['USE_PRICE_COUNT']['HIDDEN'] = 'Y';
$arTemplateParameters['USE_PRICE_COUNT']['DEFAULT'] = 'N';

unset($arComponentParameters);

if (\Bitrix\Main\Loader::IncludeModule("advertising")) {
	$arTypeFields = Array("-" => GetMessage("ADV_SELECT_DEFAULT"));
	$res = CAdvType::GetList($by, $order, Array("ACTIVE" => "Y"), $is_filtered, "Y");
	while (is_object($res) && $ar = $res->GetNext()) {
		$arTypeFields[$ar["SID"]] = "[" . $ar["SID"] . "] " . $ar["NAME"];
	}
	$arTemplateParameters["ADV_BANNER_TYPE"] = Array(
		"NAME" => GetMessage("ADV_TYPE"),
		"PARENT" => "BASE",
		"TYPE" => "LIST",
		"DEFAULT" => "",
		"VALUES" => $arTypeFields,
		"ADDITIONAL_VALUES" => "N"
	);
}

?>