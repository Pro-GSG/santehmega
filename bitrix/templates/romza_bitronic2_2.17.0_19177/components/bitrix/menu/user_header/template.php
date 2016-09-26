<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);
// echo "<pre style='text-align:left;'>"; print_r($arResult); echo "</pre>";

$curPage = $APPLICATION->GetCurPage();
?>

<div id="popup_account-menu" class="top-line-popup popup_account-menu" data-darken >
	<ul>
		<?foreach($arResult as $key=>$arItem):?>
		<?
		$class = $iconClass = '';
		if($arItem['SELECTED']) $class .= ' active';
		$iconClass = ($arItem['PARAMS']['ICON_CLASS']) ? $arItem['PARAMS']['ICON_CLASS'] : 'icon-user flaticon-user12';
		?>
		<li>
			<a href="<?=$arItem['LINK']?>" class="with-icon">
				<i class="<?=$iconClass?>"></i>
				<span class="link-text"><?=$arItem['TEXT']?></span>
			</a>
		</li>
	<?endforeach?>
	</ul>	
</div>

