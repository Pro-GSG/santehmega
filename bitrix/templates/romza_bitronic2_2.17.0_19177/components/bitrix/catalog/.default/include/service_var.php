<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitronic2\Catalog\CookiesUtils;
use Bitronic2\Mobile;

CookiesUtils::setPrefix(SITE_ID.'_');

// view
$view = CookiesUtils::getView($rz_b2_options['catalog_view_default']);
$arSupViews = array();
if ($rz_b2_options['block_list-view-block'] == 'Y') {
	$arSupViews[] = 'blocks';
}
if ($rz_b2_options['block_list-view-list'] == 'Y') {
	$arSupViews[] = 'list';
}
if ($rz_b2_options['block_list-view-table'] == 'Y') {
	$arSupViews[] = 'table';
}
if (!in_array($view, $arSupViews, $strict = true)) {
	$view = empty($arSupViews)
	      ? (mobile::isMobile() ? 'list' : 'blocks')
	      : $arSupViews[0];
}

// Page count
$page_count = CookiesUtils::getPageCount();
$arPageCount = CookiesUtils::$_arPageCount;
// ---

// sort
$sort = CookiesUtils::getSort($arParams, NULL, $rz_b2_options['catalog_sort_default_field']);
$arSort = CookiesUtils::$_arSort;
// by
$by = CookiesUtils::getSortBy($rz_b2_options['catalog_sort_default_by']);

$arSupSort = array();
if ($rz_b2_options['block_list-sort-name'] == 'Y') {
	$arSupSort[] = 'name';
}
if ($rz_b2_options['block_list-sort-new'] == 'Y') {
	$arSupSort[] = 'created';
}
if ($rz_b2_options['block_list-sort-views'] == 'Y') {
	$arSupSort[] = 'shows';
}
if ($rz_b2_options['block_list-sort-rating'] == 'Y') {
	$arSupSort[] = 'property_rating';
}
if ($rz_b2_options['block_list-sort-price'] == 'Y') {
	$arSupSort[] = 'price';
}
foreach ($arSort as $key => $sSort) {
	if(!in_array($sSort, $arSupSort)) {
		unset($arSort[$key]);
	}
}

//========= SORT BY IBLOCK PROPERTIES =========//
if (is_array($arParams['LIST_SORT_PROPS']) && !empty($arParams['LIST_SORT_PROPS'])) {
	$cacheId = serialize($arParams['LIST_SORT_PROPS']) . $arParams['IBLOCK_ID'];
	$cachePath = '/bitronic2/catalog/sort-props';
	$obCache = new CPHPCache;
	if ($obCache->InitCache($arParams['CACHE_TIME'], $cacheId, $cachePath)) {
		$arPropNames = $obCache->GetVars();
	} else {
		$arPropNames = array();
		$obRes = CIBlockProperty::GetList(array('sort'=>'asc'), array('IBLOCK_ID' => $arParams['IBLOCK_ID']));
		while ($arProp = $obRes->Fetch()) {
			if (!in_array($arProp['CODE'], $arParams['LIST_SORT_PROPS'])) continue;
			$propCode = 'property_' . strtolower($arProp['CODE']);
			$arPropNames[$propCode] = $arProp['NAME'];
		}
		if ($obCache->StartDataCache()) {
			$obCache->EndDataCache($arPropNames);
		}
	}
	global $MESS;
	foreach ($arPropNames as $propCode => $propName) {
		$MESS['BITRONIC2_CATALOG_SORT_BY_'.$propCode] = $propName;
		unset($arPropNames[$propCode]);
		if (in_array($propCode, $arSort)) continue;
		$arSupSort[] = $propCode;
		$arSort[] = $propCode;
	}
}
//========= SORT BY IBLOCK PROPERTIES =========//

if (!in_array($sort['ACTIVE'], $arSupSort)) {
	$sort['ACTIVE'] = $arSupSort[array_rand($arSupSort)];
}
if (empty($sort)) {
	$sort['ACTIVE'] = 'name';
}
// pages
foreach ($_REQUEST as $k => $v)
{
	if (strpos($k, 'PAGEN_') === 0)
	{
		if ($_REQUEST[$k] > 0)
		{
			$pagen_key = $k;

			if (strpos($_REQUEST[$k], '?') !== false)
			{
				$tmp = explode('?', $_REQUEST[$k]);
				$pagen = htmlspecialchars($tmp[0]);
			}
			else
			{
				$pagen = htmlspecialchars($_REQUEST[$k]);
			}
			
			break;
		}
	}
}

// for right work of composite
\CHTMLPagesCache::setUserPrivateKey(CacheProvider::getCachePrefix(), 0);


$arAjaxParams = array(
	"view" => $view,
	"page_count" => $page_count,
	"sort" => $sort['ACTIVE'],
	"by" => $by,
);
if(isset($pagen_key, $pagen))
{
	$arAjaxParams[$pagen_key] = $pagen;
}
if (array_key_exists('rz_all_elements', $_REQUEST)) {
	$arAjaxParams['rz_all_elements'] = $_REQUEST['rz_all_elements'];
}
if($_REQUEST["rz_ajax"] !== "y")
{	//FOR AJAX
	?><script type="text/javascript">$.extend(RZB2.ajax.params, <?=CUtil::PhpToJSObject($arAjaxParams, false, true)?>);</script><?
}
?>