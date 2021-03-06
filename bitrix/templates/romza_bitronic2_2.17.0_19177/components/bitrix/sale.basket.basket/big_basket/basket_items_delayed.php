<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="waitlist-big" class="basket-big-waitlist tab-target">
	<table id="delayed_items" class="items-table">
		<thead>
			<tr>
				<th colspan="2"><?=GetMessage('BITRONIC2_SALE_NAME')?></th>
				<th class="availability"><?=GetMessage('BITRONIC2_SALE_QUANTITY')?></th>
				<th class="price"><?=GetMessage('BITRONIC2_SALE_PRICE')?></th>
				<th class="sum"><?=GetMessage('BITRONIC2_SALE_SUM')?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?
			foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
				if ($arItem["DELAY"] == "Y"):// && $arItem["CAN_BUY"] == "Y"):
			?>
				<tr class="table-item<?if($arItem['CAN_BUY']!='Y'):?> out-of-stock<?elseif($arItem['FOR_ORDER']):?> available-for-order<?endif?>" id="<?=$arItem["ID"]?>">
					<td class="photo">
						<?if(!empty($arItem['DETAIL_PAGE_URL'])):?>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?endif?>
							<img src="<?=$arItem['PICTURE_PRINT']['SRC']?>" alt="<?=$arItem['NAME']?>">
						<?if(!empty($arItem['DETAIL_PAGE_URL'])):?>
						</a>
						<?endif?>
					</td>
					<td class="name">
						<?if(!empty($arItem['DETAIL_PAGE_URL'])):?>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="link">
						<?endif?>
							<span class="text"><?=$arItem['NAME']?></span>
						<?if(!empty($arItem['DETAIL_PAGE_URL'])):?>
						</a>
						<?endif?>
						<?
						foreach ($arItem["PROPS"] as $val):
							if (is_array($arItem["SKU_DATA"]))
							{
								$bSkip = false;
								foreach ($arItem["SKU_DATA"] as $propId => $arProp)
								{
									if ($arProp["CODE"] == $val["CODE"])
									{
										$bSkip = true;
										break;
									}
								}
								if ($bSkip)
									continue;
							}
							?>
							<div><?=$val["NAME"]?>: <strong><?=$val["VALUE"]?></strong></div>
						<?endforeach;?>

						<div>
							<? if ($arParams['SHOW_ARTICLE'] && !empty($arItem['PROPERTY_'.$catalogParams['ARTICUL_PROP'].'_VALUE'])): ?>
							<span class="art">
								<?=GetMessage('BITRONIC2_SALE_ARTICUL')?>:
								<strong><?=htmlspecialcharsbx($arItem['PROPERTY_'.$catalogParams['ARTICUL_PROP'].'_VALUE'])?></strong>
							</span>
							<? endif ?>
							<?
							if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
							?>
							<div class="sku">
								<?
								foreach ($arItem["SKU_DATA"] as $propId => $arProp):
								?>
									<span class="sku-wrap">
										<span class="text"><?=$arProp["NAME"]?>: </span>
										<select id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" class="select-styled disabled" data-property="<?=$arProp["CODE"]?>" disabled>
										<?
										foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

											$selected = "";
											foreach ($arItem["PROPS"] as $arItemProp):
												if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
												{
													if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
														$selected = ' selected="selected"';
												}
											endforeach;
										?>
											<option value="<?=($arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory' ? $arSkuValue['XML_ID'] : $arSkuValue['NAME']); ?>"<?=$selected?>><?=$arSkuValue["NAME"]?></option>
										<?
										endforeach;
										?>
										</select>
									</span>
								<?
								endforeach;
								?>
							</div>
							<?
							endif;
							?>
						</div>
					</td>
					<td class="availability ">
						<div class="quantity-counter"><?=$arItem["QUANTITY"]?> <?=$arItem['MEASURE_TEXT']?></div>
						<?
						$availableID = false;
						$availableClass = '';
						$availableFrame = false;
						$availableForOrderText = &$arItem['PROPERTY_RZ_FOR_ORDER_TEXT_VALUE'];
						$availableItemID = &$arItem['PRODUCT_ID'];
						$availableMeasure = &$arItem['MEASURE_TEXT'];
						$availableQuantity = &$arItem['AVAILABLE_QUANTITY'];
						$availableStoresPostfix = 'basket_items_delayed';
						$availableSubscribe = $arItem['SUBSCRIBE'];
						$bShowEveryStatus = true;
						include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/availability_info.php';
						?>
						
						<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
						<input type="hidden" name="DELAY_<?=$arItem["ID"]?>" id="DELAY_<?=$arItem["ID"]?>" value="N"/>
						<input type="hidden" name="DELETE_<?=$arItem["ID"]?>" id="DELETE_<?=$arItem["ID"]?>" value="N"/>
					</td>
					<td class="price">
						<?$bDiscountShow = ($arItem['DISCOUNT_PRICE'] > 0)?>
						<span class="price-new"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arItem['CURRENCY'], $arItem["PRICE"], $arResult["PRICE_FORMATED"], array('ID'=> 'current_price_'.$arItem["ID"]))?></span>
						<div>
							<span class="price-old <?=(!$bDiscountShow) ? 'hide' : ''?>"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arItem['CURRENCY'], $arItem["FULL_PRICE"], $arResult["FULL_PRICE_FORMATED"], array('ID'=> 'old_price_'.$arItem["ID"]))?></span>
						</div>
					</td>
					<td class="sum"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arItem['CURRENCY'], $arItem["SUM_NOT_FORMATED"], $arResult["SUM"], array('ID'=> 'sum_'.$arItem["ID"]))?></td>
					<td class="actions">
						<a href="<?=htmlspecialcharsbx(str_replace("#ID#", $arItem["ID"], $arUrls["add"]))?>" class="btn-to-waitlist pseudolink with-icon" data-action="add" data-id="<?=$arItem['ID']?>" data-tooltip title="<?=GetMessage('BITRONIC2_SALE_RETURN_TO_BASKET')?>" data-placement="bottom">
							<i class="flaticon-back15"></i>
							<span class="btn-text"><?=GetMessage('BITRONIC2_SALE_ADD_TO_BASKET')?></span>
						</a>
						<a href="<?=htmlspecialcharsbx(str_replace("#ID#", $arItem["ID"], $arUrls["delete"]))?>" class="btn-delete pseudolink with-icon" data-action="delete" data-id="<?=$arItem['ID']?>" data-tooltip title="<?=GetMessage('BITRONIC2_SALE_DELETE')?>" data-placement="bottom">
							<i class="flaticon-trash29"></i>
							<span class="btn-text"><?=GetMessage('BITRONIC2_SALE_DELETE')?></span>
						</a>
					</td>
				</tr>
				<?
				endif;
			endforeach;
			?>
		</tbody>

	</table>
</div>
<?
