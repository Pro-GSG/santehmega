<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(method_exists($this, 'setFrameMode')) $this->setFrameMode(false);
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';
?>
<aside class="account-menu col-sm-3 col-xl-2 hidden-xs" id="account-menu">
	<div class="profile clearfix">
		<div class="avatar">
			<img src="<?=$arResult['USER']['PERSONAL_PHOTO']?>" alt="<?=GetMessage('BITRONIC2_AVATAR')?>" title="<?=GetMessage('BITRONIC2_AVATAR')?>">
		</div>
		<span class="name"><?=$arResult['USER']['PRINT_NAME']?></span>
		<?if(!empty($arResult['USER']['EMAIL'])):?>
			<div>
				<span class="login">[<?=$arResult['USER']['EMAIL']?>]</span>
			</div>
		<?endif?>
		<div>
			<a href="<?=SITE_DIR.'?logout=yes'?>" class="btn-logout">
				<i class="flaticon-logout13"></i>
				<span class="text"><?=GetMessage('BITRONIC2_LOGOUT')?></span>
			</a>
		</div>
	</div><!-- /profile -->
	<ul>
	<?foreach($arResult as $key=>$arItem):?>
		<?$class = '';
		if($arItem['SELECTED']) $class .= ' active';
		?>
		<li>
			<a class="link <?=$class?>" href="<?=$arItem['LINK']?>"><span class="text"><?=$arItem['TEXT']?></span></a>
		</li>
	<?endforeach?>
	</ul>
</aside><!-- /account-menu -->