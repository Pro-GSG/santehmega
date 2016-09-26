<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$frame = new \Bitrix\Main\Page\FrameBuffered("{$this->__name}_{$templateName}_epilog_JCCatalogItem");
$frame->setAssetMode(\Bitrix\Main\Page\AssetMode::STANDARD);
$frame->begin('');?>
<?if (!empty($templateData['jsFile']) && file_exists($templateData['jsFullPath']) && $arParams['CACHE_TYPE'] != 'N'):?>
	<?if(!\Yenisite\Core\Tools::isAjax()):?>
		<?\Bitrix\Main\Page\Asset::getInstance()->addJs($templateData['jsFile'])?>
	<?else:?>
		<script type="text/javascript">
			<?=file_get_contents($templateData['jsFullPath'])?>
		</script>
	<?endif;
endif;
$frame->end();