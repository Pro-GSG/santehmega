<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
CJSCore::Init(array('rz_b2_bx_catalog_item'));
global $rz_b2_options;
$arParams = array_merge($arParams, array(
	"SHOW_STARS" => $rz_b2_options["block_show_stars"],
	"DISPLAY_FAVORITE" => $rz_b2_options["block_show_favorite"] == "Y",
	"DISPLAY_ONECLICK" => $rz_b2_options["block_show_oneclick"] == "Y",
	"DISPLAY_COMPARE" => $rz_b2_options["block_show_compare"] == "Y",
	"SHOW_ARTICLE" => $rz_b2_options["block_show_article"],
	"SHOW_COMMENT_COUNT" => $rz_b2_options["block_show_comment_count"],
	"SHOW_GALLERY_THUMB" => $rz_b2_options["block_show_gallery_thumb"],
	"HOVER-MODE" => $rz_b2_options["product-hover-effect"],
	"COLOR_HEADING" => $rz_b2_options["catchbuy_color_heading"],
	"SHOW_DISCOUNT_PERCENT" => $rz_b2_options["show_discount_percent"] === "N" ? "N" : "Y",
));
$APPLICATION->IncludeComponent('bitrix:catalog.section', $arParams['CATALOG_TEMPLATE'], $arParams, $component);
