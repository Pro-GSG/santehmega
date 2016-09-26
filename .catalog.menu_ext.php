<?
global $APPLICATION, $rz_b2_options;
global $rz_b2_options;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"yenisite:menu.ext", 
	".default", 
	array(
		"IBLOCK_TYPE" => array(
			0 => "catalog",
			1 => "",
		),
		"IBLOCK_TYPE_MASK" => array(
		),
		"IBLOCK_ID" => array(
			0 => "9",
		),
		"DEPTH_LEVEL_START" => "3",
		"DEPTH_LEVEL_FINISH" => "3",
		"DEPTH_LEVEL_SECTIONS" => "3",
		"IBLOCK_TYPE_URL" => "/#IBLOCK_TYPE#/",
		"IBLOCK_TYPE_URL_REPLACE" => "",
		"HIDE_ELEMENT" => "N",
		"ELEMENT_CNT" => ($rz_b2_options["block_menu_count"]!=="N"?"Y":"N"),
		"ELEMENT_CNT_AVAILABLE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"IBLOCK_TYPE_SORT_FIELD" => "sort",
		"IBLOCK_TYPE_SORT_ORDER" => "asc",
		"IBLOCK_SORT_FIELD" => "sort",
		"IBLOCK_SORT_ORDER" => "asc",
		"SECTION_SORT_FIELD" => "sort",
		"SECTION_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"GET_SECTION_UF" => "Y",
		"ID" => $_REQUEST["ID"],
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
    $aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>