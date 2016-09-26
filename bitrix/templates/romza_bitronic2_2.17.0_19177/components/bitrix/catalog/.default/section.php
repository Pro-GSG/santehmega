<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;
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
define("IS_CATALOG_LIST",true);

$this->setFrameMode(true);
if(defined("ERROR_404")) return;
global $rz_b2_options, $rz_current_sectionID;
// $view, $sort, $by, $pagen, $pagen_key, $page_count
include 'include/service_var.php';

global $rz_b2_options, $rz_current_sectionID;
include 'include/get_cur_section.php'; // @var $arCurSection
$rz_current_sectionID = $arCurSection['ID'];

// THIS EXPRESSION NEEDS TO BE CHANGED IF REVIEWS OR RELATED-CATEGORIES SHOULD BE ADDED
$noAside = ($arResult['MENU_CATALOG'] !== 'side' && ($arParams['USE_FILTER'] !== 'Y' || $arResult['FILTER_PLACE'] !== 'side'))
         ? ' no-aside'
         : '';

$asset = Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.countdown.2.0.2/jquery.plugin.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.countdown.2.0.2/jquery.countdown.min.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initTimers.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/libs/UmTabs.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/sliders/initPhotoThumbs.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/toggles/initGenInfoToggle.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initCatalogHover.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/nouislider.min.js");
CJSCore::Init(array('rz_b2_um_countdown', 'rz_b2_bx_catalog_item'));
if ('Y' === $rz_b2_options['quick-view']) {
	$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/jquery.mobile.just-touch.min.js");
	$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/initMainGallery.js");
}
if ('Y' === $rz_b2_options['wow-effect']) {
	$asset->addJs(SITE_TEMPLATE_PATH."/js/3rd-party-libs/wow.min.js");
}
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/pages/initCatalogPage.js");
$asset->addString('<script>RZB2.ajax.CatalogSection.ID = '. (int)$arResult['VARIABLES']['SECTION_ID'] .';</script>', false, AssetLocation::AFTER_JS);
?>
<main class="container catalog-page<?=$noAside?>" id="catalog-page" data-page="catalog-page">
	<div class="row">
		<aside class="catalog-aside col-sm-12 col-md-3 col-xxl-2" id="catalog-aside">
			<div id="catalog-at-side" class="catalog-at-side minified">
				<?if($arResult['MENU_CATALOG'] == 'side' && $_REQUEST['rz_ajax'] !== 'y'):?>
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "EDIT_TEMPLATE" => "include_areas_template.php", "PATH" => SITE_DIR."include_areas/header/menu_catalog.php"), false, array("HIDE_ICONS"=>"Y"));?>
				<?endif?>
			</div>
			<div id="filter-at-side">
				<?if($arParams['USE_FILTER'] == 'Y')
				{
					if($arResult['FILTER_PLACE'] == 'side'
					|| ($_GET['ajax'] == 'y' && isset($_SERVER['HTTP_BX_AJAX'])) // second condition for ajax filter
					) {
						include 'include/filter.php';
					}
				}?>
			</div>
			<?
			/* TODO
			<div class="reviews hidden-xs hidden-sm">
				..............................
			</div><!-- /.reviews -->
			*/?>
			<?
			/* TODO
			<div class="related-categories hidden-xs hidden-sm">
				..............................
			</div>
			*/?>
		</aside>
		<div class="catalog-main-content col-sm-12 col-md-9 col-xxl-10">
			<?
			/* TODO
			<nav class="breadcrumbs">
			<!-- same breadcrumbs as always, but without dummy for
			#catalog-at-side -->
				..............................
			</nav>
			*/?>
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
			<?
			$showDescription = $rz_b2_options['block_list-section-desc'];
			if ($arParams['SHOW_DESCRIPTION_TOP'] == 'N') {
				$showDescription = 'N';
			}
			if ($rz_b2_options['block_list-sub-sections'] == "Y"
				|| ($rz_b2_options['block_list-section-desc'] == "Y" && $arParams['SHOW_DESCRIPTION_TOP'] != 'N')
			)
			{
				include 'include/section_list.php';
			}
			if($arParams['LIST_BRAND_USE'] != 'N'):
			$brandsId = 'bx_dynamic_'.$this->randString(20);
			?>

			<div class="brands-catalog hidden-xs wow fadeIn" id="<?=$brandsId?>"><?

				$dynamicArea = new \Bitrix\Main\Page\FrameStatic("catalog_brands_dynamic");
				$dynamicArea->setAnimation(true);
				$dynamicArea->setContainerID($brandsId);
				$dynamicArea->startDynamicArea();
				$APPLICATION->ShowViewContent('catalog_brands');
				$dynamicArea->finishDynamicArea();
				?>

			</div><!-- /.brands-catalog -->
			<div class="brands-catalog-toggle-wrap">
				<a href="#<?=$brandsId?>"
				   class="pseudolink-bd collapsed" data-toggle="height-collapse"
				   data-when-expanded="<?=GetMessage('RZ_COLLAPSE_CATALOG_BRANDS')?>"
				   data-when-collapsed="<?=GetMessage('RZ_EXPAND_CATALOG_BRANDS')?>"></a>
			</div>
			<?endif?>
			<div id="filter-at-top">
				<?
					if($arParams['USE_FILTER'] == 'Y' && $arResult['FILTER_PLACE'] == 'top')
					{
						include 'include/filter.php';
					}
				?>
			</div>
			
			<?
			$dynamicArea = new \Bitrix\Main\Page\FrameStatic("catalog_hits_dynamic");
			$dynamicArea->setAnimation(true);
			$dynamicArea->startDynamicArea();
			if($rz_b2_options['block_list-hits'] == 'Y' && $_REQUEST['rz_ajax'] !== 'y' && Bitrix\Main\Loader::includeModule('catalog')) {
				include 'include/catalog_hits.php';
				Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/back-end/visual/hits.js");
			}
			$dynamicArea->finishDynamicArea();
			?>
			<div class="sort-n-view for-catalog">
				<?include 'include/sort.php';?>
				<?include 'include/view.php';?>
			</div>

<?
include 'include/pagination.php';
?>
<?
$catalogClass  = 'catalog ';
$catalogClass .= ($view == 'table' ? 'catalog-table' : $view);
$catalogClass .= ' active';
$catalogClass .= ($arParams['HIDE_ICON_SLIDER'] === 'Y' ? ' thumbs-disabled' : '');

global ${$arParams["FILTER_NAME"]};
if(!empty(${$arParams["FILTER_NAME"]}))
{
	$arSkipFilters = array('FACET_OPTIONS');
	
	$arDiff = array_diff(array_keys(${$arParams["FILTER_NAME"]}) , $arSkipFilters);
	
	$arParams["CACHE_FILTER"] = count($arDiff) > 0 ? 'N' : 'Y';
	
	unset($arSkipFilters, $arDiff);
}

/**
 * @var array $arSectionParams
 */
include 'include/prepare_params_section.php';

?>
			
			<div class="<?=$catalogClass?>" id="catalog_section" data-hover-effect="<?= $arResult['HOVER-MODE'] ?>"  data-quick-view-enabled="false"><!--
				--><?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						$view,
						$arSectionParams, //prepare_params_section.php
						$component
				);?><!--
			--></div>

			<?
			include 'include/pagination.php';
			?>
					
			<?
			/* TODO
			<div class="show-not-in-stock-wrap">
				..............................
			</div>
			*/
			$showDescription = $rz_b2_options['block_list-section-desc'];
			if ($arParams['SHOW_DESCRIPTION_BOTTOM'] == 'N') {
				$showDescription = 'N';
			}
			if ($rz_b2_options['block_list-section-desc'] == "Y" && $arParams['SHOW_DESCRIPTION_BOTTOM'] == 'Y')
			{
				$bDescBottom = true;
				include 'include/section_list.php';
			}
			?>
			<? if ($rz_b2_options['block_show_ad_banners'] == 'Y'): ?>
				<div class="banners">
					<?if(\Bitrix\Main\Loader::includeModule("advertising")):?>
						<?
						$arParams['ADV_BANNER_TYPE'] = $arParams['ADV_BANNER_TYPE'] ?: 'b2_catalog_bottom';
						?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:advertising.banner",
							"catalog_bottom",
							Array(
								"TYPE" => $arParams['ADV_BANNER_TYPE'],
								"NOINDEX" => "Y",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "1000"
							),
							$component,
							array("HIDE_ICONS"=>"Y")
						);?>
					<?endif?>
				</div>
			<? endif ?>
		</div><!-- /.catalog-main-content.col-sm-12.col-md-9 -->
	</div><!-- /.row -->
	
</main>