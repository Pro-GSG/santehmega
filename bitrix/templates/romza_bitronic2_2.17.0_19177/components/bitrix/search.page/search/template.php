<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info.php';
?>
<main class="container search-results-page" data-page="search-results-page">
	<h1><?$APPLICATION->ShowTitle()?></h1>
	
	<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):?>
		<p>
			<?echo GetMessage("BITRONIC2_CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<strong><a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a></strong>'))?>
		</p>
	<?elseif(isset($arResult["REQUEST"]["QUERY"]) && !empty($arResult["REQUEST"]["QUERY"])):?>
		<p><?=GetMessage('BITRONIC2_SEARCH_BY_QUERY')?><strong><?=$arResult["REQUEST"]["QUERY"]?></strong></p>
	<?endif;?>
	
	<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
	<?elseif($arResult["ERROR_CODE"]!=0):?>
		<p><?=GetMessage("BITRONIC2_SEARCH_ERROR")?></p>
		<?ShowError($arResult["ERROR_TEXT"]);?>
		<p><?=GetMessage("BITRONIC2_SEARCH_CORRECT_AND_CONTINUE")?></p>
		<br /><br />
		<p><?=GetMessage("BITRONIC2_SEARCH_SINTAX")?><br /><b><?=GetMessage("BITRONIC2_SEARCH_LOGIC")?></b></p>
		<table border="0" cellpadding="5">
			<tr>
				<td align="center" valign="top"><?=GetMessage("BITRONIC2_SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("BITRONIC2_SEARCH_SYNONIM")?></td>
				<td><?=GetMessage("BITRONIC2_SEARCH_DESCRIPTION")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("BITRONIC2_SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
				<td><?=GetMessage("BITRONIC2_SEARCH_AND_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("BITRONIC2_SEARCH_OR")?></td><td valign="top">or, |</td>
				<td><?=GetMessage("BITRONIC2_SEARCH_OR_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("BITRONIC2_SEARCH_NOT")?></td><td valign="top">not, ~</td>
				<td><?=GetMessage("BITRONIC2_SEARCH_NOT_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top">( )</td>
				<td valign="top">&nbsp;</td>
				<td><?=GetMessage("BITRONIC2_SEARCH_BRACKETS_ALT")?></td>
			</tr>
		</table>
	<?else:?> 
		<div class="sort-n-view no-justify">
			<span class="text"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY')?></span>
			<select name="sort-by" id="sort-by" class="sort-by-select">
				<option value="relevance-up"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_RANK')?> &uarr;</option>
				<option value="relevance-down"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_RANK')?> &darr;</option>
				<option value="date-up"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_DATE')?> &uarr;</option>
				<option value="date-down"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_DATE')?> &darr;</option>
			</select>
			<ul class="sort-list">
				<li class="sort-list-item<?=$arResult['RZ_SORT_RANK']?>">
					<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["WHERE"]? '&amp;where='.$arResult["REQUEST"]["WHERE"]: ''?>">
						<span class="text"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_RANK')?></span>
					</a>
				</li><!--
				--><li class="sort-list-item<?=$arResult['RZ_SORT_DATE']?>">
					<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["WHERE"]? '&amp;where='.$arResult["REQUEST"]["WHERE"]: ''?>">
						<span class="text"><?=GetMessage('BITRONIC2_SEARCH_SORT_BY_DATE')?></span>
					</a>
				</li><!--
			--></ul>
		</div>
		<? if($arParams["SHOW_WHERE"]): ?> 
		<div class="sort-n-view no-sort no-justify">
			<span class="text"><?=GetMessage('BITRONIC2_SEARCH_BY_CATEGORY')?></span>
			<ul class="sort-list w-links" id="search-in-category">
				<?

				foreach ($arResult['DROPDOWN'] as $key => $value):
				?><li class="sort-list-item<?=($arResult["REQUEST"]["WHERE"]===$key?' active':'')?>">
					<a href="<?=$APPLICATION->GetCurPageParam('where='.$key, array('where'), false)?>">
						<span class="text"><?=($key=='iblock_catalog'?GetMessage('BITRONIC2_SEARCH_PRODUCTS'):$value)?></span>
					</a>
				</li><!--
				--><?
				endforeach;

				?><li class="sort-list-item<?=(!array_key_exists($arResult["REQUEST"]["WHERE"], $arResult['DROPDOWN'])?' active':'')?>">
					<a href="<?=$APPLICATION->GetCurPageParam((CSite::InDir(SITE_DIR.'catalog/')?'where=ALL':''), array('where'), false)?>">
						<span class="text"><?=GetMessage("BITRONIC2_SEARCH_ALL")?></span>
					</a>
				</li><!--
			--></ul>
		</div>
		<? endif ?> 
		<?if(count($arResult["SEARCH"])>0):?> 
			<div class="search-robot-wrap">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/bg/search-robot.png" alt="<?=GetMessage('BITRONIC2_SEARCH_SATISFIED_ROBOT')?>">
			</div>
			
			<?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
			<?if(CSite::InDir(SITE_DIR.'catalog/')):?> 
				<?if($arResult["REQUEST"]["WHERE"] == 'iblock_'.$arParams['IBLOCK_TYPE']):?> 
			<div class="search-results-other" id="search-results-other">
				<?foreach($arResult["SEARCH"] as $arItem):?>
					<?if ($arItem['MODULE_ID'] != 'iblock' || strpos($arItem['ITEM_ID'], 'S') !== 0) continue?>
					<div class="search-results-item">
						<div class="link-wrap">
							<a href="<?echo $arItem["URL"]?>" class="link"><span class="text"><?echo $arItem["TITLE_FORMATED"]?></span></a>
						</div>
						<div class="desc">
							<?echo $arItem["BODY_FORMATED"]?>
						</div>
						<div class="date"><?=GetMessage("BITRONIC2_SEARCH_MODIFIED")?> <?=$arItem["DATE_CHANGE"]?></div>
						<?if($arItem["CHAIN_PATH"]):?>
							<div class="path">
								<span class="text"><?=GetMessage("BITRONIC2_SEARCH_PATH")?></span>
								<?=$arItem["CHAIN_PATH"]?>
							</div>
						<?endif;?>
					</div>
				<?endforeach;?>
			</div><!-- /#search-results-other -->
				<? endif ?> 
			<div class="search-results-catalog" id="search-results-catalog">
				<?$APPLICATION->ShowViewContent('catalog_search')?>
			</div>
			<div class="clearfix"></div>
			<?endif?> 
			<?if(!CSite::InDir(SITE_DIR.'catalog/') || $arResult["REQUEST"]["WHERE"] != 'iblock_'.$arParams['IBLOCK_TYPE']):?> 
			<div class="search-results-other" id="search-results-other">
				<?foreach($arResult["SEARCH"] as $arItem):?>
					<div class="search-results-item">
						<div class="link-wrap">
							<a href="<?echo $arItem["URL"]?>" class="link"><span class="text"><?echo $arItem["TITLE_FORMATED"]?></span></a>
						</div>
						<div class="desc">
							<?echo $arItem["BODY_FORMATED"]?>
						</div>
						<div class="date"><?=GetMessage("BITRONIC2_SEARCH_MODIFIED")?> <?=$arItem["DATE_CHANGE"]?></div>
						<?if($arItem["CHAIN_PATH"]):?>
							<div class="path">
								<span class="text"><?=GetMessage("BITRONIC2_SEARCH_PATH")?></span>
								<?=$arItem["CHAIN_PATH"]?>
							</div>
						<?endif;?>
					</div>
				<?endforeach;?>
			</div><!-- /#search-results-other -->
			<? endif ?> 
			<?
			/* TODO
			<div id="search-results-all">
			 ..................
			</div>
			*/
			?>
			
			<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<?else:?> 
			<?ShowNote(GetMessage("BITRONIC2_SEARCH_NOTHING_TO_FOUND"));?>
		<?endif;?> 
	<?endif;?> 
	<?$APPLICATION->ShowViewContent('search_sliders')?>
</main>

<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";
