<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);
?>
<h3><?=(!empty($arParams['TITLE'])) ? $arParams['TITLE'] : GetMessage('BITRONIC2_CAT_BOT_MENU_TITLE')?></h3>
<div class="catalog-menu-footer">
	<?
	//The template is never cached
	//include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';
	foreach($arResult as $key=>$arItem):
		if($arItem['DEPTH_LEVEL'] > 1) continue;
		if($arItem['SELECTED']) $class .= ' active';?>
		<div class="footer-menu-item">
			<a href="<?=$arItem['LINK']?>" class="link <?=$class?>">
				<span class="text"><?=$arItem['TEXT']?></span>
			</a>
		</div>
	<?endforeach?>
	<a href="<?=SITE_DIR.'catalog/?rz_all_elements=y'?>" class="link more-content">
		<div class="bullets">
			<span class="bullet">&bullet;</span><!-- 
			--><span class="bullet">&bullet;</span><!--
			--><span class="bullet">&bullet;</span>
		</div>
		<span class="text">
			<?=GetMessage('BITRONIC2_ALL_ELEMENTS')?>
		</span>
	</a>
</div>