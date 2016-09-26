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
<div class="row">
	<div class="col-xs-12">
		<h1><?=$APPLICATION->GetTitle("title")?></h1>
	</div><!-- /.col-xs-12 -->
</div>
	
<div class="row news-n-articles">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="item col-xs-12 col-sm-6 col-md-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div class="news-item-img">
				<img src="<?=CResizer2Resize::ResizeGD2($arItem["PREVIEW_PICTURE"]["SRC"], $arParams["RESIZER_NEWS_LIST"])?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>">
			</div>
		<?endif?>
		<div class="date-wrap">
			<i class="flaticon-annual2"></i>
			<div class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
		</div>
		<div class="content">
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="link"><span class="text"><?echo $arItem["NAME"]?></span></a>
				<div class="desc"><?echo $arItem["PREVIEW_TEXT"];?></div>
		</div><!-- /.content -->
	</div><!-- /.item.col-xs-12.col-sm-6.col-md-4 -->
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<div class="row">
		<?=$arResult["NAV_STRING"]?>
	</div>
<?endif;?>
