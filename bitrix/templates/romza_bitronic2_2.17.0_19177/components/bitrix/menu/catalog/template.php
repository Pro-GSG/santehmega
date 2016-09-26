<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
use Bitronic2\Mobile;

if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);

$curPage = $APPLICATION->GetCurPage();

$bViewHits = ($arParams['VIEW_HIT'] == 'Y' && !mobile::isMobile());

if ($_REQUEST['RZ_B2_AJAX_MENU_HITS'] === 'Y') {
	$APPLICATION->RestartBuffer();
	if ($bViewHits) {
		foreach($arResult["ALL_ITEMS_ID"] as $idItem_1=>$arItem_1) {
			if (!is_array($arItem_1) || count($arItem_1) < 1) continue;
			include 'items_hits.php';
		}
	}
	die();
}

if ($bViewHits):
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/custom-scripts/inits/sliders/initHorizontalCarousels.js");

	if ($arParams['HITS_COMPONENT'] != 'BIGDATA'):?>

	<script>
		serverSettings.loadMenuHits = true;
	</script>
	<?endif?>
<?endif?>

<nav class="catalog-menu mainmenu" id="mainmenu"<?if($arParams['HITS_POSITION'] === 'BOTTOM'):?> data-menu-hits-pos="bottom"<?endif?>
	 data-menu-hits-enabled=<?=var_export($bViewHits,1)?>>
<?include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';?>
	<div class="container">
		<div class="btn-catalog-wrap" id="btn-catalog-wrap">
			<button type="button" class="btn-catalog catalog-show" id="catalog-show">
				<span class="content">
					<span class="text"><?=GetMessage('BITRONIC2_MENU_CATALOG_MORE')?></span>
					<span class="bullets">
						<span class="bullet">&bullet;</span>
						<span class="bullet">&bullet;</span>
						<span class="bullet">&bullet;</span>
					</span>	
				</span>
			</button>
			<button type="button" class="btn-catalog catalog-hide" id="catalog-hide">
				<span class="text content"><?=GetMessage('BITRONIC2_MENU_CATALOG_HIDE')?></span>
			</button>
		
			<button type="button" class="btn-catalog catalog-switch" id="catalog-switch">
				<i class="flaticon-menu6"></i>
				<span class="text"><?=GetMessage('BITRONIC2_MENU_CATALOG_CATALOG')?></span>
			</button>
		</div>
		
		<div class="catalog-menu-lvl0 main">
			<?foreach($arResult["ALL_ITEMS_ID"] as $idItem_1=>$arItem_1):?>
				<?
				$bCnt = is_numeric($arResult["ALL_ITEMS"][$idItem_1]['PARAMS']['ELEMENT_CNT']);
				?>
				<div class="catalog-menu-lvl0-item<?= $bCnt ? '' : ' no-numbers' ?>"><?
					$img = &$arResult['ALL_ITEMS'][$idItem_1]['PARAMS']['PICTURE'];
					$bImg = !empty($img) && $arParams['SHOW_ICONS'];
					if($bSpan = ($curPage == $arResult["ALL_ITEMS"][$idItem_1]['LINK'])):?>

					<span class="menu-lvl0-link active<?if($bImg):?> has-img<?endif?>"><?
					else:?>

					<a href="<?=$arResult["ALL_ITEMS"][$idItem_1]['LINK']?>" class="menu-lvl0-link<?=($arResult["ALL_ITEMS"][$idItem_1]['SELECTED'] ? ' active' : '')?><?if($bImg):?> has-img<?endif?>"><?
					endif;
					if($bImg):?>

						<i class="img-wrap">
							<img src="<?=$img?>" alt="<?=$arResult["ALL_ITEMS"][$idItem_1]['TEXT']?>" class="subcategory-img">
						</i><?
					endif;
					unset($img);
					if($bCnt):?>
						<span class="category-items-number"><?=$arResult["ALL_ITEMS"][$idItem_1]['PARAMS']['ELEMENT_CNT']?></span><?
					endif?>

						<span class="category-name"><?=$arResult["ALL_ITEMS"][$idItem_1]['TEXT']?></span><?
					if(!$bSpan):?>

					</a><?
					else:?>

					</span><?
					endif?>
					<?if(is_array($arItem_1) && count($arItem_1) > 0):?>
					<div class="submenu-wrap">
						<?
						if($bViewHits && $arParams['HITS_POSITION'] !== 'BOTTOM') {
							include 'items_hits.php';
						}
						?>
						<div class="catalog-menu-lvl1-content">
							<?foreach($arItem_1 as $idItem_2=>$arItem_2):?>
							<div class="catalog-menu-lvl1">
								<div class="menu-lvl1-header">
									<a href="<?=$arResult["ALL_ITEMS"][$idItem_2]['LINK']?>" class="menu-lvl1-additional-link">
										<i class="flaticon-right10"></i>
									</a><?
								$img = &$arResult['ALL_ITEMS'][$idItem_2]['PARAMS']['PICTURE'];
								$bImg = !empty($img) && $arParams['SHOW_ICONS'];
								if ($curPage == $arResult["ALL_ITEMS"][$idItem_2]['LINK']):?>

									<span class="menu-lvl1-link active"><?if($bImg):?><img src="<?=$img?>" alt="<?=$arResult["ALL_ITEMS"][$idItem_2]['TEXT']?>" class="subcategory-img"/><?endif?><span class="text"><?=$arResult["ALL_ITEMS"][$idItem_2]['TEXT']?></span><?if(is_numeric($arResult["ALL_ITEMS"][$idItem_2]['PARAMS']['ELEMENT_CNT'])):?><sup class="i-number"><?=$arResult["ALL_ITEMS"][$idItem_2]['PARAMS']['ELEMENT_CNT']?></sup><?endif?></span>
								<?else:?>

									<a href="<?=$arResult["ALL_ITEMS"][$idItem_2]['LINK']?>" class="menu-lvl1-link <?=($arResult["ALL_ITEMS"][$idItem_2]['SELECTED'] ? 'active' : '')?>"><?if($bImg):?><img src="<?=$img?>" alt="<?=$arResult["ALL_ITEMS"][$idItem_2]['TEXT']?>" class="subcategory-img"/><?endif?><span class="text"><?=$arResult["ALL_ITEMS"][$idItem_2]['TEXT']?></span><?if(is_numeric($arResult["ALL_ITEMS"][$idItem_2]['PARAMS']['ELEMENT_CNT'])):?><sup class="i-number"><?=$arResult["ALL_ITEMS"][$idItem_2]['PARAMS']['ELEMENT_CNT']?></sup><?endif?></a><?
								endif;
								unset($img)?>

								</div>
								<?if(is_array($arItem_2) && count($arItem_2) > 0):?>
								<ul>
									<?foreach($arItem_2 as $idItem_3):?>
									<li><?
									$img = &$arResult['ALL_ITEMS'][$idItem_3]['PARAMS']['PICTURE'];
									$bImg = !empty($img) && $arParams['SHOW_ICONS'];
									if ($curPage == $arResult["ALL_ITEMS"][$idItem_3]['LINK']):?>

										<span class="link active"><?if($bImg):?><img src="<?=$img?>" alt="<?=$arResult["ALL_ITEMS"][$idItem_3]['TEXT']?>" class="subcategory-img"/><?endif?><span class="text"><?=$arResult["ALL_ITEMS"][$idItem_3]['TEXT']?></span><?if(is_numeric($arResult["ALL_ITEMS"][$idItem_3]['PARAMS']['ELEMENT_CNT'])):?><sup class="i-number"><?=$arResult["ALL_ITEMS"][$idItem_3]['PARAMS']['ELEMENT_CNT']?></sup><?endif?></span><?
									else:?>

										<a href="<?=$arResult["ALL_ITEMS"][$idItem_3]['LINK']?>" class="link <?=($arResult["ALL_ITEMS"][$idItem_3]['SELECTED'] ? 'active' : '')?>"><?if($bImg):?><img src="<?=$img?>" alt="<?=$arResult["ALL_ITEMS"][$idItem_3]['TEXT']?>" class="subcategory-img"/><?endif?><span class="text"><?=$arResult["ALL_ITEMS"][$idItem_3]['TEXT']?></span><?if(is_numeric($arResult["ALL_ITEMS"][$idItem_3]['PARAMS']['ELEMENT_CNT'])):?><sup class="i-number"><?=$arResult["ALL_ITEMS"][$idItem_3]['PARAMS']['ELEMENT_CNT']?></sup><?endif?></a><?
									endif;
									unset($img)?>

									</li>
									<?endforeach?>
								</ul>
								<?endif?>
							</div><?
							endforeach?>
						</div>
						<?
						if($bViewHits && $arParams['HITS_POSITION'] === 'BOTTOM') {
							include 'items_hits.php';
						}
						?>
					</div>
					<?endif?>
				</div>
			<?endforeach?>
		</div><!-- .catalog-menu-lvl0.main -->
	</div><!-- /container -->
</nav><!-- #mainmenu.catalog-menu.mainmenu -->

<?
// echo "<pre style='text-align:left;'>"; print_r($arResult); echo "</pre>";