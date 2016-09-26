<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $rz_b2_options;
//update parameters to set needed currency (only after CPHPCache check, changes through cookies)
if ($rz_b2_options['convert_currency']) {
	$arParams['CONVERT_CURRENCY'] = 'Y';
	$arParams['CURRENCY_ID'] = $rz_b2_options['active-currency'];
}
	
// resizer
$arSets = array();
$arSets['RESIZER_DETAIL_SMALL'] = $arParams['RESIZER_DETAIL_SMALL'];
$arSets['RESIZER_DETAIL_BIG'] = $arParams['RESIZER_DETAIL_BIG'];
$arSets['RESIZER_DETAIL_ICON'] = $arParams['RESIZER_DETAIL_ICON'];
$arSets['RESIZER_DETAIL_PROP'] = $arParams['RESIZER_DETAIL_PROP'];
$arSets['RESIZER_DETAIL_FLY_BLOCK'] = $arParams['RESIZER_DETAIL_FLY_BLOCK'];
$arSets['RESIZER_SET_CONTRUCTOR'] = $arParams['RESIZER_SET_CONTRUCTOR'];
$arSets['RESIZER_SECTION'] = $arParams['RESIZER_SECTION'];
$arSets['RESIZER_COMMENT_AVATAR'] = $arParams['RESIZER_COMMENT_AVATAR'];
$arSets['RESIZER_RECOMENDED'] = $arParams['RESIZER_RECOMENDED'];
$arSets['RESIZER_QUICK_VIEW'] = $arParams['RESIZER_QUICK_VIEW'];

if (CRZBitronic2Settings::isPro($withGeoip = true)) {
	if(!isset($rz_b2_options['GEOIP'])) {
		$arRes = $APPLICATION->IncludeComponent('yenisite:geoip.store', 'empty');
		$rz_b2_options['GEOIP'] = $arRes;
	}
	if (!empty($rz_b2_options['GEOIP']['PRICES'])) {
		$arParams["PRICE_CODE"] = $rz_b2_options['GEOIP']['PRICES'];
	}
	$arParams['STORES'] = NULL;
	if (!empty($rz_b2_options['GEOIP']['STORES'])) {
		$arParams['STORES'] = $rz_b2_options['GEOIP']['STORES'];
	}
}

if (isset($rz_b2_options['DEMO_CONTENT']['CATALOG']) && isset($arParams['IBLOCK_ID'])) {
	$arParams['IBLOCK_ID'] = $rz_b2_options['DEMO_CONTENT']['CATALOG'];
}

$arPrepareParams = array(
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
	"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
	"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
	"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
	"BASKET_URL" => $arParams["BASKET_URL"],
	"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
	"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
	"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
	"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
	"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"SET_TITLE" => $arParams["SET_TITLE"],
	"SET_STATUS_404" => $arParams["SET_STATUS_404"],
	"PRICE_CODE" => $arParams["PRICE_CODE"],
	"USE_PRICE_COUNT" => "N",
	"USE_PRICE_COUNT_" => $rz_b2_options["extended-prices-enabled"],
	"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
	"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
	"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
	"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
	"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
	"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
	"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
	"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
	"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
	"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
	"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
	"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
	"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
	'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
	'CURRENCY_ID' => $arParams['CURRENCY_ID'],
	'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
	'SLIDERS_HIDE_NOT_AVAILABLE' => $arParams['SLIDERS_HIDE_NOT_AVAILABLE'] === 'Y' ? 'Y' : 'N',
	'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
	'EDOST_PREVIEW' => ($rz_b2_options['block_detail-delivery'] === 'Y' && version_compare(\Yenisite\Core\Tools::getModuleVersion('edost.catalogdelivery'), '2.0.0') >= 0),
	'SHOW_VIEW3D' => ($rz_b2_options['block_detail-view3d'] === 'Y' && IsModuleInstalled('yenisite.bitronic3dmodel')),

	//compare:
	'COMPARE_PATH' => $arParams['COMPARE_PATH'],

	'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
	'LABEL_PROP' => $arParams['LABEL_PROP'],
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'SHOW_DISCOUNT_PERCENT' => $rz_b2_options['show_discount_percent'] === 'N' ? 'N' : 'Y',
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'SHOW_MAX_QUANTITY' => $arParams['DETAIL_SHOW_MAX_QUANTITY'],
	'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
	'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
	'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
	'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
	'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
	//'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
	"BRAND_PROP_CODE" => $arParams['LIST_BRAND_PROP_CODE'],
	"BRAND_DETAIL" => $arParams['BRAND_DETAIL'] ?: SITE_DIR.'brands/#ID#/',
	"BRAND_EXT" => $rz_b2_options['brands_extended'],
	// 'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
	'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
	'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
	"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
	"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
	"DISPLAY_PREVIEW_TEXT_MODE" => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
	"DETAIL_PICTURE_MODE" => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : ''),
	'MANUAL_PROP' => $arParams['MANUAL_PROP'],
	
	//sku:
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
	'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
	"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
	"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
	"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
	"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
	"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
	"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
	"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
	"OFFER_VAR_NAME" => $arParams["OFFER_VAR_NAME"],
	"ADD_PARENT_PHOTO" => $arParams["ADD_PARENT_PHOTO"],
	
	//store:
	'USE_STORE' => $arParams['USE_STORE'],
	'USE_STORE_PHONE' => $arParams['USE_STORE_PHONE'],
	'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
	'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
	
	//SEF:
	"SEF_MODE" => $arParams["SEF_MODE"],
	"SEF_FILTER_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
	"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
	'SEF_FOLDER' => $arParams['SEF_FOLDER'],
	"FILTER_NAME" => $arParams["FILTER_NAME"],
	
	//resizer :
	"RESIZER_SETS" => $arSets,
	
	//stickers :
	"STICKER_NEW" => $arParams['STICKER_NEW'],
	"STICKER_HIT" => $arParams['STICKER_HIT'],
	"STICKER_BESTSELLER" => $arParams['STICKER_BESTSELLER'],
	"TAB_PROPERTY_NEW" => $arParams['TAB_PROPERTY_NEW'],
	"TAB_PROPERTY_HIT" => $arParams['TAB_PROPERTY_HIT'],
	"TAB_PROPERTY_SALE" => $arParams['TAB_PROPERTY_SALE'],
	"TAB_PROPERTY_BESTSELLER" => $arParams['TAB_PROPERTY_BESTSELLER'],
	"MAIN_SP_ON_AUTO_NEW" => $arParams['MAIN_SP_ON_AUTO_NEW'],

	"SHOW_CATCHBUY" => $rz_b2_options['detail_catchbuy_slider'] !== 'N',
	
	//articul:
	"ARTICUL_PROP" => $arParams['ARTICUL_PROP'],

	//bigdata titles
	
	//tabs:
	"DETAIL_INFO_MODE" => $arResult['DETAIL_INFO_MODE'],
	
	//reviews
	'USE_REVIEW' => ($arParams['USE_REVIEW'] === 'Y' && $rz_b2_options['block_detail_review'] !== 'N') ? 'Y' : 'N',
	'USE_OWN_REVIEW' => $arParams['USE_OWN_REVIEW'],
	'REVIEWS_MODE' => $arParams['REVIEWS_MODE'],
	"FORUM_ID" => $arParams['FORUM_ID'],
	"MESSAGES_PER_PAGE" => $arParams['MESSAGES_PER_PAGE'],
	'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
	'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
	'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
	'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
	'FEEDBACK_USE' => (isset($arParams['DETAIL_FEEDBACK_USE']) ? $arParams['DETAIL_FEEDBACK_USE'] : 'Y'),
	"FEEDBACK_IBLOCK_TYPE" => $arParams["FEEDBACK_IBLOCK_TYPE"],
	"FEEDBACK_IBLOCK_ID" => $arParams["FEEDBACK_IBLOCK_ID"],
	'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
	'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
	'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
	'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),		
	'DETAIL_YM_API_USE' => $arParams['DETAIL_YM_API_USE'],

	//quick view:
	'QUICK_VIEW' => (isset($_REQUEST['rz_quick_view']) ? 'Y' : 'N'),
	'QUICK_SHOW_CHARS' => (isset($_REQUEST['rz_quick_view']) ? $rz_b2_options['quick-view-chars'] : 'N'),
	//big data:
	'HIDE_ACCESSORIES'   => ($rz_b2_options['block_detail-addtoorder']    === 'Y') ? 'N' : 'Y',
	'HIDE_SIMILAR'       => ($rz_b2_options['block_detail-similar']       === 'Y') ? 'N' : 'Y',
	'HIDE_SIMILAR_VIEW'  => ($rz_b2_options['block_detail-similar-view']  === 'Y') ? 'N' : 'Y',
	'HIDE_SIMILAR_PRICE' => ($rz_b2_options['block_detail-similar-price'] === 'Y') ? 'N' : 'Y',
	'HIDE_RECOMMENDED'   => ($rz_b2_options['block_detail-recommended']   === 'Y') ? 'N' : 'Y',
	'HIDE_VIEWED'        => ($rz_b2_options['block_detail-viewed']        === 'Y') ? 'N' : 'Y',
	'SIMILAR_PRICE_PERCENT'          => $arParams['DETAIL_SIMILAR_PRICE_PERCENT'],
	'SIMILAR_PRICE_SMART_FILTER'     => $arParams['DETAIL_SIMILAR_PRICE_SMART_FILTER'],
	'SIMILAR_PRICE_WITH_EMPTY_PROPS' => $arParams['DETAIL_SIMILAR_PRICE_WITH_EMPTY_PROPS'],
	'SIMILAR_PRICE_PROPERTIES'       => $arParams['DETAIL_SIMILAR_PRICE_PROPERTIES'],
	'ACCESSORIES_TITLE'   => $arParams['DETAIL_ACCESSORIES_TITLE'],
	'SIMILAR_TITLE'       => $arParams['DETAIL_SIMILAR_TITLE'],
	'SIMILAR_VIEW_TITLE'  => $arParams['DETAIL_SIMILAR_VIEW_TITLE'],
	'SIMILAR_PRICE_TITLE' => $arParams['DETAIL_SIMILAR_PRICE_TITLE'],
	'RECOMMENDED_TITLE'   => $arParams['DETAIL_RECOMMENDED_TITLE'],
	'VIEWED_TITLE'        => $arParams['DETAIL_VIEWED_TITLE'],
	'STORE_DISPLAY_TYPE' => $rz_b2_options['store_amount_type'],
	'STORES' => $arParams['STORES'],
	'DETAIL_GALLERY_DESCRIPTION' => $rz_b2_options['detail_gallery_description'],
	'DETAIL_GALLERY_TYPE' => $rz_b2_options['detail_gallery_type'],
	'DETAIL_TEXT_DEFAULT' => $rz_b2_options['detail_text_default'],
	'DETAIL_INFO_FULL_EXPANDED' => $rz_b2_options['detail_info_full_expanded'],
	//feedback
	'FOUND_CHEAP'          => ($arParams['DETAIL_FOUND_CHEAP'] !== 'N' && $rz_b2_options['block_detail_feedback'] !== 'N') ? 'Y' : 'N',
	'FOUND_CHEAP_TYPE'     => $arParams['DETAIL_FOUND_CHEAP_TYPE'],
	'FOUND_CHEAP_IBLOCK'   => $arParams['DETAIL_FOUND_CHEAP_IBLOCK'],
	'PRICE_LOWER'          => ($arParams['DETAIL_PRICE_LOWER'] !== 'N' && $rz_b2_options['block_detail_feedback'] !== 'N') ? 'Y' : 'N',
	'PRICE_LOWER_TYPE'     => $arParams['DETAIL_PRICE_LOWER_TYPE'],
	'PRICE_LOWER_IBLOCK'   => $arParams['DETAIL_PRICE_LOWER_IBLOCK'],
	'ELEMENT_EXIST'        => ($arParams['DETAIL_ELEMENT_EXIST'] !== 'N' && $rz_b2_options['block_detail_feedback'] !== 'N') ? 'Y' : 'N',
	'ELEMENT_EXIST_TYPE'   => $arParams['DETAIL_ELEMENT_EXIST_TYPE'],
	'ELEMENT_EXIST_IBLOCK' => $arParams['DETAIL_ELEMENT_EXIST_IBLOCK'],

	// GIFTS
	"USE_GIFTS_DETAIL" => ($rz_b2_options['block_detail-gift-products'] === 'Y' ? 'Y' : 'N'),
	"USE_GIFTS_MAIN_PR_SECTION_LIST" => ($rz_b2_options['block_detail-gift-main-products'] === 'Y' ? 'Y' : 'N'),
	"GIFTS_SHOW_DISCOUNT_PERCENT" => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
	"GIFTS_SHOW_OLD_PRICE" => $arParams['GIFTS_SHOW_OLD_PRICE'],
	"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'] ?: 10,
	"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
	"GIFTS_DETAIL_TEXT_LABEL_GIFT" => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
	"GIFTS_DETAIL_BLOCK_TITLE" => $arParams["GIFTS_DETAIL_BLOCK_TITLE"],
	"GIFTS_SHOW_NAME" => $arParams['GIFTS_SHOW_NAME'],
	"GIFTS_SHOW_IMAGE" => $arParams['GIFTS_SHOW_IMAGE'],
	"GIFTS_MESS_BTN_BUY" => $arParams['GIFTS_MESS_BTN_BUY'],

	"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'] ?: 10,
	"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

	// other
	'DISPLAY_COMPARE' => $rz_b2_options['block_show_compare'] == 'Y',
	'DISPLAY_FAVORITE' => $rz_b2_options['block_show_favorite'] == 'Y',
	"DISPLAY_ONECLICK" => $rz_b2_options['block_show_oneclick'] == 'Y',
	'SHOW_STARS' => $rz_b2_options['block_show_stars'],
	'SHOW_ARTICLE' => $rz_b2_options['block_show_article'],
	"SHOW_PRINT" => ($rz_b2_options['block_detail_print'] !== 'N'),
	"SHOW_PRICE_UPDATED" => ($rz_b2_options['block_detail_price_updated'] !== 'N'),
	"SHOW_SHORT_INFO_UNDER_IMAGE" => ($rz_b2_options['block_detail_short_info_under_image'] !== 'N'),
	"SHOW_SOCIAL_BUTTONS" => ($rz_b2_options['block_detail_socials'] !== 'N'),
	"SHOW_GAMIFICATION" => ($rz_b2_options['block_detail_gamification'] !== 'N'),
	"HOVER-MODE" => $rz_b2_options['product-hover-effect'],
);

if (Bitrix\Main\ModuleManager::isModuleInstalled("catalog")) {
	// you need it to support live preview of stores popups and have different cache
	$arPrepareParams['SHOW_STORE'] = $rz_b2_options['stores'];
	if ($rz_b2_options['stores'] === 'disabled') {
		$arPrepareParams['SHOW_QUANTITY'] = $rz_b2_options['show-stock'];
	}
}
