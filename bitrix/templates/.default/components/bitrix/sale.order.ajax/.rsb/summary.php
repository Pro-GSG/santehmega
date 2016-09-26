<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
<h3><?=GetMessage("BITRONIC2_SALE_PRODUCTS_SUMMARY");?></h3>
<table class="items-table">
	<thead>
		<tr>
			<th colspan="2"><?=GetMessage("BITRONIC2_SOA_GOOD");?></th>
			<th class="availability"><?=GetMessage("BITRONIC2_SOA_QUANTITY");?></th>
			<th class="price"><?=GetMessage("BITRONIC2_SOA_PRICE_BY_1");?></th>
			<th class="sum"><?=GetMessage("BITRONIC2_SOA_SUMMA");?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="5">
				<div class="totals">
					<table class="table_totals">
						<?
						$orderTotalSum = $arResult["ORDER_PRICE"] + $arResult["DELIVERY_PRICE"] + $arResult["TAX_PRICE"] - $arResult["DISCOUNT_PRICE"];
						
						if($arResult['USER_VALS']["PAY_CURRENT_ACCOUNT"] == "Y")
						{
							if ($arResult["USER_ACCOUNT"]["CURRENT_BUDGET"] > 0)
							{
								$arResult["PAYED_FROM_ACCOUNT"] = ($arResult["USER_ACCOUNT"]["CURRENT_BUDGET"] >= $orderTotalSum) ? $orderTotalSum : $arResult["USER_ACCOUNT"]["CURRENT_BUDGET"];
								
								$orderTotalSum -= $arResult["PAYED_FROM_ACCOUNT"];
							}
						}		
						?>
						<tr>
							<td class="text" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_WEIGHT_SUM")?></td>
							<td class="value" class="price"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></td>
						</tr>
						<tr>
							<td class="text" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_SUMMARY")?></td>
							<td class="value" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"], $arResult['ORDER_PRICE_FORMATED'])?></td>
						</tr>
						<?
						if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
						{
							?>
							<tr>
								<td class="text" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</td>
								<td class="value" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $arResult["DISCOUNT_PRICE"], $arResult['DISCOUNT_PRICE_FORMATED'])?></td>
							</tr>
							<?
						}
						if(!empty($arResult["TAX_LIST"]))
						{
							foreach($arResult["TAX_LIST"] as $val)
							{
								?>
								<tr>
									<td class="text" colspan="<?=$colspan?>" class="itog"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
									<td class="value" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $val["VALUE_MONEY"], $val['VALUE_MONEY_FORMATED'])?></td>
								</tr>
								<?
							}
						}
						if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
						{
							?>
							<tr>
								<td class="text" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_DELIVERY")?></td>
								<td class="value" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $arResult["DELIVERY_PRICE"], $arResult['DELIVERY_PRICE_FORMATED'])?></td>
							</tr>
							<?
						}
						if ($arResult["PAYED_FROM_ACCOUNT"] > 0)
						{
							?>
							<tr>
								<td class="text" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_PAYED")?></td>
								<td class="value" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $arResult["PAYED_FROM_ACCOUNT"], $arResult['PAYED_FROM_ACCOUNT_FORMATED'])?></td>
							</tr>
							<?
						}

										
						?>
						<tr>
							<td class="text fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("BITRONIC2_SOA_TEMPL_SUM_IT")?></td>
							<td class="value fwb" class="price"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arResult["BASE_LANG_CURRENCY"], $orderTotalSum, $arResult['ORDER_TOTAL_PRICE_FORMATED'])?></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):
			$arItem = $arData["data"];?>
				<tr class="table-item">
					<td class="photo">
						<?
							if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
								$url = $arData["data"]["PREVIEW_PICTURE_SRC"];
							elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
								$url = $arData["data"]["DETAIL_PICTURE_SRC"];
							else:
								$url = $templateFolder."/images/no_photo.png";
							endif;
						?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"] ?>">
							<img src="<?=$url?><?//=$arItem['PICTURE_PRINT']['SRC']?>" alt="<?=$arItem["NAME"]?>">
						</a>
					</td>
					<td class="name">
						<a href="<?=$arItem["DETAIL_PAGE_URL"] ?>" class="link"><span class="text"><?=$arItem["NAME"]?></span></a>
						<div>
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
						</div>
					</td>
					<td class="availability">
						x <?=$arItem["QUANTITY"] ?> <?=$arItem["MEASURE_TEXT"] ?>
					</td>
					<td class="price">
						<span class="price-new"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arItem['CURRENCY'], $arItem['PRICE'], $arItem['PRICE_FORMATED'])?></span>
					</td>
					<td class="sum"><?=CRZBitronic2CatalogUtils::getElementPriceFormat($arItem['CURRENCY'], $arItem['PRICE']*$arItem["QUANTITY"], $arItem['SUM'])?></td>
				</tr>
		<?endforeach;?>
	</tbody>
</table>

<h3><?=GetMessage('BITRONIC2_SOA_ADITIONAL_INFO')?>:</h3>
<textarea class="textinput" name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
