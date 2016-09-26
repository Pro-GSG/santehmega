<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';
?>


<div class="news-n-articles">
	<h3><?=GetMessage('BITRONIC2_NEWS_TITLE')?></h3>
	<?
	$prefix = 'news_';
	foreach($arResult["ITEMS"] as $arItem):
		$this->AddEditAction($prefix.$arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($prefix.$arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$itemTitle = (
			isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
			? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
			: $arItem['NAME']
		);
	?>
		<div class="item" id="<?=$this->GetEditAreaId($prefix.$arItem['ID']);?>">
			<div class="date-wrap">
				<i class="flaticon-annual2"></i>
				<div class="date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>
			</div>
			<div class="content">
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="link"><span class="text"><?=$itemTitle?></span></a>
				<div class="desc"><?=$arItem['PREVIEW_TEXT']?></div>
			</div>
		</div><!-- /.item -->
	<?endforeach?>
					
	<a href="<?=SITE_DIR?>news/" class="link more-content">
		<div class="bullets">
			<span class="bullet">&bullet;</span><!-- 
			--><span class="bullet">&bullet;</span><!--
			--><span class="bullet">&bullet;</span>
		</div>
		<span class="text"><?=GetMessage('BITRONIC2_NEWS_ALL')?></span>
	</a>
</div><!-- /.news-n-articles -->

<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";