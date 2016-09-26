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
		<h1><?=$arResult["NAME"]?></h1>
		
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<div class="row images-row">
			<div class="img-container">
				<img src="<?=CResizer2Resize::ResizeGD2($arResult["DETAIL_PICTURE"]["SRC"], $arParams["RESIZER_NEWS_DETAIL"])?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>">
			</div>
		</div>
		<?endif;?>
		
		<p>
		<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
			<?echo $arResult["DETAIL_TEXT"];?>
		<?else:?>
			<?echo $arResult["PREVIEW_TEXT"];?>
		<?endif?>
		</p>
<?// echo '<pre>', htmlspecialcharsBx(var_export($arResult, 1)), '</pre>'; ?>
