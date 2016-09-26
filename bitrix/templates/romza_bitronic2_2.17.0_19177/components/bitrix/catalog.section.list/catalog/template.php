<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
if (method_exists($this, 'setFrameMode')) $this->setFrameMode(true);

// if(empty($arResult['SECTIONS']))
// {
// return false;
// }
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';
?>
<?if ($arParams['SHOW_DESCRIPTION'] == 'Y'): ?>
	<div class="category-description general-info">
		<div class="desc">
			<?= $arResult['SECTION']['DESCRIPTION'] ?>
		</div>
		<div class="link">
			<span class="text when-closed"><?= GetMessage('BITRONIC2_DESC_SHOW_FULL') ?></span>
			<span class="text when-opened"><?= GetMessage('BITRONIC2_DESC_HIDE_FULL') ?></span>
		</div>
	</div>
<? endif ?>
<?if ($arParams['SHOW_SUBSECTIONS'] == 'Y'): ?>
	<div class="sub-categories">
		<? foreach ($arResult['SECTIONS'] as $arSection): ?>
			<a href="<?= $arSection['SECTION_PAGE_URL'] ?>" class="link">
<? if($arParams['VIEW_MODE'] != 'TEXT' && !empty($arSection['PICTURE'])): ?>
				<img src="<?=$arSection['PICTURE']?>" alt="<?=$arSection['NAME']?>" title="<?=$arSection['NAME']?>" class="subcategory-img">
<? endif ?>
<? if($arParams['VIEW_MODE'] != 'PICTURE'): ?>
				<span class="text"><?= $arSection['NAME'] ?></span>
<? endif ?>
				<sup><?= $arSection['ELEMENT_CNT'] ?></sup>
			</a>
		<? endforeach ?>
	</div>
<? endif ?>
<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";