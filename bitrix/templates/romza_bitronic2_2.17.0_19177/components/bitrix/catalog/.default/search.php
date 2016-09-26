<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
$APPLICATION->SetTitle(GetMessage("BITRONIC2_SEARCH_RESULTS"));
$this->setFrameMode(true);

global $rz_b2_options;

$asset = Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.countdown.2.0.2/jquery.plugin.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.countdown.2.0.2/jquery.countdown.min.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initTimers.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/libs/UmTabs.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/pages/initSearchResultsPage.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/sliders/initPhotoThumbs.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initCatalogHover.js");
CJSCore::Init(array('rz_b2_um_countdown', 'rz_b2_bx_catalog_item'));
if ('Y' == $rz_b2_options['wow-effect']) {
	$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/wow.min.js");
}
if ($rz_b2_options['quick-view'] === 'Y') {
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.mobile.just-touch.min.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initMainGallery.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/toggles/initGenInfoToggle.js");
}
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/pages/initCatalogPage.js");

// hack search request
if (empty($_GET['where']) || empty($_REQUEST['where'])) {
	$_GET['where'] = $_REQUEST['where'] = 'iblock_' . $arParams['IBLOCK_TYPE'];
}

if ($_GET['where'] === 'ALL' || $_REQUEST['where'] === 'ALL') {
	$_GET['where'] = $_REQUEST['where'] = '';
}

// @var array $arSectionParams;
include 'include/prepare_params_section.php';

$arSearchParams = array(
		"FILTER_NAME" => "searchFilter",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(),
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"META_KEYWORDS" => "",
		"META_DESCRIPTION" => "",
		"BROWSER_TITLE" => "",
		"ADD_SECTIONS_CHAIN" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",

		"ELEMENT_SORT_FIELD" => "",
		"ELEMENT_SORT_ORDER" => "",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER2" => ""
	);

$arSearchParams = array_merge($arSectionParams, $arSearchParams);

?>
<?
$arElements = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"search",
	Array(
		"RESTART" => "N",
		"NO_WORD_LOGIC" => "Y",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "Y",
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"arrFILTER" => array(
			0 => "iblock_".$arParams["IBLOCK_TYPE"],
			1 => "iblock_news"
		),
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
		"arrFILTER_iblock_news" => array(
			0 => "all",
		),
		"SHOW_WHERE" => "Y",
		"arrWHERE" => array(
			0 => "iblock_catalog",
			1 => "iblock_news",
		),
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => 20,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => GetMessage("BITRONIC2_SEARCH_RESULTS"),
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",

		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE']
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);

if ($_REQUEST['where'] !== 'iblock_'.$arParams['IBLOCK_TYPE']) return;

if (!empty($arElements) && is_array($arElements))
{
	global $rz_b2_options;

	$catalogClass  = 'catalog blocks active ';
	$catalogClass .= $arResult['HOVER-MODE'];

		global $searchFilter;
		$searchFilter = array(
			"=ID" => $arElements,
		);
		$this->SetViewTarget('catalog_search');
		echo '<div class="'.$catalogClass.'" id="catalog_section" data-hover-effect="'.$arResult['HOVER-MODE'].'"  data-quick-view-enabled="false">';
		$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"blocks",
		$arSearchParams,
		$component,
		array('HIDE_ICONS' => 'Y')
	);
	echo '</div>';
	$this->EndViewTarget('catalog_search');
}
else
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}

$this->SetViewTarget('search_sliders');
if ('N' !== $rz_b2_options['block_search-viewed']
||  'N' !== $rz_b2_options['block_search-bestseller']
||  'N' !== $rz_b2_options['block_search-recommend']
) {
	$arPrepareParams = $arSectionParams;
	$asset->addJs(SITE_TEMPLATE_PATH . '/js/custom-scripts/inits/sliders/initHorizontalCarousels.js');
}
if ($rz_b2_options['block_search-viewed'] !== 'N') {
	include 'include/viewed_products.php';
}
if ($rz_b2_options['block_search-bestseller'] !== 'N') {
	$arPrepareParams['HEADER_TEXT'] = $arParams['BIGDATA_BESTSELL_TITLE'] ?: GetMessage('BIGDATA_BESTSELL_TITLE_DEFAULT');
	$arPrepareParams['RCM_TYPE'] = 'bestsell';
	include 'include/bigdata.php';
}
if ($rz_b2_options['block_search-recommend'] !== 'N') {
	$arPrepareParams['HEADER_TEXT'] = $arParams['BIGDATA_PERSONAL_TITLE'] ?: GetMessage('BIGDATA_PERSONAL_TITLE_DEFAULT');
	$arPrepareParams['RCM_TYPE'] = 'personal';
	include 'include/bigdata.php';
}
$this->EndViewTarget('search_sliders');
?>
