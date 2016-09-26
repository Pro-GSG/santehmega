<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$id = 'bxdinamic_banner_'/*.$arResult['BANNER_PROPERTIES']['ID'].'_'*/.$arResult['BANNER_PROPERTIES']['CONTRACT_ID'].'_'.$arResult['BANNER_PROPERTIES']['TYPE_SID'].$this->randString();
?>
<div id="<?=$id?>" class="promo">
<?$frame = $this->createFrame($id, false)->begin(CRZBitronic2Composite::insertCompositLoader());?>
	<?include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info.php';?>
	<?if(!empty($arResult['BANNER_PROPERTIES']) && intval($arResult['BANNER_PROPERTIES']["IMAGE_ID"]) > 0):?>
	<a href="<?=CAdvBanner::GetRedirectURL($arResult['BANNER_PROPERTIES']['URL'], $arResult['BANNER_PROPERTIES'])?>" target="<?=$arResult['BANNER_PROPERTIES']['URL_TARGET']?>">
		<img src="<?=CFile::GetPath($arResult['BANNER_PROPERTIES']["IMAGE_ID"])?>" alt="<?=$arResult['BANNER_PROPERTIES']["NAME"]?>">
	</a>
	<?endif?>
<?$frame->end();?>
</div>
