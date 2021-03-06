<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<script type="text/javascript">
	function fShowStore(id, showImages, formWidth, siteId, del_id)
	{
		del_id = del_id || 0;
		var strUrl = '<?=$templateFolder?>' + '/map.php';
		var strUrlPost = 'delivery=' + id + '&showImages=' + showImages + '&siteId=' + siteId;

		var storeForm = new BX.CDialog({
					'title': '<?=GetMessage('BITRONIC2_SOA_ORDER_GIVE')?>',
					head: '',
					'content_url': strUrl,
					'content_post': strUrlPost,
					'width': formWidth,
					'height':450,
					'resizable':false,
					'draggable':false
				});

		var button = [
				{
					title: '<?=GetMessage('BITRONIC2_SOA_POPUP_SAVE')?>',
					id: 'crmOk',
					'action': function ()
					{
						GetBuyerStore(del_id);
						BX.WindowManager.Get().Close();
					}
				},
				BX.CDialog.btnCancel
			];
		storeForm.ClearButtons();
		storeForm.SetButtons(button);
		storeForm.Show();
	}

	function GetBuyerStore(del_id)
	{
		BX('BUYER_STORE').value = BX('POPUP_STORE_ID').value;
		BX('ORDER_DESCRIPTION').value = '<?=GetMessage("BITRONIC2_SOA_ORDER_GIVE_TITLE")?>: '+BX('POPUP_STORE_NAME').value;
		BX('store_desc_' + del_id).innerHTML = BX('POPUP_STORE_NAME').value;
		BX.show(BX('select_store_' + del_id));
	}

	function showExtraParamsDialog(deliveryId)
	{
		var strUrl = '<?=$templateFolder?>' + '/delivery_extra_params.php';
		var formName = 'extra_params_form';
		var strUrlPost = 'deliveryId=' + deliveryId + '&formName=' + formName;

		if(window.BX.SaleDeliveryExtraParams)
		{
			for(var i in window.BX.SaleDeliveryExtraParams)
			{
				strUrlPost += '&'+encodeURI(i)+'='+encodeURI(window.BX.SaleDeliveryExtraParams[i]);
			}
		}

		var paramsDialog = new BX.CDialog({
			'title': '<?=GetMessage('BITRONIC2_SOA_ORDER_DELIVERY_EXTRA_PARAMS')?>',
			head: '',
			'content_url': strUrl,
			'content_post': strUrlPost,
			'width': 500,
			'height':200,
			'resizable':true,
			'draggable':false
		});

		var button = [
			{
				title: '<?=GetMessage('BITRONIC2_SOA_POPUP_SAVE')?>',
				id: 'saleDeliveryExtraParamsOk',
				'action': function ()
				{
					insertParamsToForm(deliveryId, formName);
					BX.WindowManager.Get().Close();
				}
			},
			BX.CDialog.btnCancel
		];

		paramsDialog.ClearButtons();
		paramsDialog.SetButtons(button);
		//paramsDialog.adjustSizeEx();
		paramsDialog.Show();
	}

	function insertParamsToForm(deliveryId, paramsFormName)
	{
		var orderForm = BX("ORDER_FORM"),
			paramsForm = BX(paramsFormName);
			wrapDivId = deliveryId + "_extra_params";

		var wrapDiv = BX(wrapDivId);
		window.BX.SaleDeliveryExtraParams = {};

		if(wrapDiv)
			wrapDiv.parentNode.removeChild(wrapDiv);

		wrapDiv = BX.create('div', {props: { id: wrapDivId}});

		for(var i = paramsForm.elements.length-1; i >= 0; i--)
		{
			var input = BX.create('input', {
				props: {
					type: 'hidden',
					name: 'DELIVERY_EXTRA['+deliveryId+']['+paramsForm.elements[i].name+']',
					value: paramsForm.elements[i].value
					}
				}
			);

			window.BX.SaleDeliveryExtraParams[paramsForm.elements[i].name] = paramsForm.elements[i].value;

			wrapDiv.appendChild(input);
		}

		orderForm.appendChild(wrapDiv);

		BX.onCustomEvent('onSaleDeliveryGetExtraParams',[window.BX.SaleDeliveryExtraParams]);
	}
</script>

<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
	<?
	if(!empty($arResult["DELIVERY"]))
	{
		$width = ($arParams["SHOW_STORES_IMAGES"] == "Y") ? 850 : 700;
		?>
		<h3><?=GetMessage("BITRONIC2_SOA_TEMPL_DELIVERY")?></h3>
		<div class="delivery-type row">
		<?

		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
			if ($delivery_id !== 0 && intval($delivery_id) <= 0)
			{
				foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
				{
					if (count($arDelivery["LOGOTIP"]) > 0):
						$arFileTmp = CFile::ResizeImageGet(
							$arDelivery["LOGOTIP"]["ID"],
							array("width" => "160", "height" =>"106"),
							BX_RESIZE_IMAGE_PROPORTIONAL,
							true
						);

						$deliveryImgURL = $arFileTmp["src"];
					else:
						$deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
					endif;

					if($arDelivery["ISNEEDEXTRAINFO"] == "Y")
						$extraParams = "showExtraParamsDialog('".$delivery_id.":".$profile_id."');";
					else
						$extraParams = "";
						
					$onclick="BX('ID_DELIVERY_{$delivery_id}_{$profile_id}').checked=true;{$extraParams}submitForm();";
					?>
					<label class="col-md-2 col-sm-3 col-xs-6" for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">
						<input
							type="radio"
							id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>"
							name="<?=htmlspecialcharsbx($arProfile["FIELD_NAME"])?>"
							value="<?=$delivery_id.":".$profile_id;?>"
							<?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?>
							onclick="submitForm();"
							/>
						<span class="radio-item">
							<span class="radio-img" onclick="<?=$onclick?>">
								<img src="<?=$deliveryImgURL?>" alt="<?=$arDelivery["TITLE"].'('.$arProfile["TITLE"].')'?>">
							</span>
							<span class="radio-item-header" onclick="<?=$onclick?>"><?=htmlspecialcharsbx($arDelivery["TITLE"])." (".htmlspecialcharsbx($arProfile["TITLE"]).")";?></span>
							<span class="bx_result_price"><!-- click on this should not cause form submit -->
								<?
								if($arProfile["CHECKED"] == "Y" && doubleval($arResult["DELIVERY_PRICE"]) > 0):
								?>
									<div><?=GetMessage("BITRONIC2_SALE_DELIV_PRICE")?>:&nbsp;<b><?=$arResult["DELIVERY_PRICE_FORMATED"]?></b></div>
								<?
									if ((isset($arResult["PACKS_COUNT"]) && $arResult["PACKS_COUNT"]) > 1):
										echo GetMessage('SALE_PACKS_COUNT').': <b>'.$arResult["PACKS_COUNT"].'</b>';
									endif;
								else:
									$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
										"NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
										"DELIVERY" => $delivery_id,
										"PROFILE" => $profile_id,
										"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
										"ORDER_PRICE" => $arResult["ORDER_PRICE"],
										"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
										"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
										"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
										"ITEMS" => $arResult["BASKET_ITEMS"],
										"EXTRA_PARAMS_CALLBACK" => $extraParams
									), null, array('HIDE_ICONS' => 'Y'));
								endif;
								?>
							</span>
							<span class="radio-item-description">
								<p onclick="<?=$onclick?>">
								<?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
									<?=nl2br($arProfile["DESCRIPTION"])?>
								<?else:?>
									<?=nl2br($arDelivery["DESCRIPTION"])?>
								<?endif;?>
								</p>
							</span>
						</span>
					</label>
					<?
				} // endforeach
			}
			else // stores and courier
			{
				if (count($arDelivery["STORE"]) > 0)
					$clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."'," . $arDelivery["ID"] . ")\";";
				else
					$clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;submitForm();\"";
					
				if (count($arDelivery["LOGOTIP"]) > 0):

					$arFileTmp = CFile::ResizeImageGet(
						$arDelivery["LOGOTIP"]["ID"],
						array("width" => "161", "height" =>"107"),
						BX_RESIZE_IMAGE_PROPORTIONAL,
						true
					);

					$deliveryImgURL = $arFileTmp["src"];
				else:
					$deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
				endif;
				?>
					<label class="col-md-2 col-sm-3 col-xs-6" for="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>">
						<input type="radio"
							id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
							name="<?=htmlspecialcharsbx($arDelivery["FIELD_NAME"])?>"
							value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
							onclick="submitForm();"
							/>
						<span class="radio-item">
							<span class="radio-img">
								<img src="<?=$deliveryImgURL?>" alt="<?=$arDelivery["NAME"]?>">
							</span>
							<span class="radio-item-header"><?= htmlspecialcharsbx($arDelivery["NAME"])?></span>
							<span class="bx_result_price">
								<?
								if (strlen($arDelivery["PERIOD_TEXT"])>0)
								{
									echo $arDelivery["PERIOD_TEXT"];
									?><br /><?
								}
								?>
								<?=GetMessage("BITRONIC2_SALE_DELIV_PRICE");?>: <b><?=$arDelivery["PRICE_FORMATED"]?></b><br />
							</span>
							<span class="radio-item-description">	
								<?
								if (strlen($arDelivery["DESCRIPTION"])>0)
									echo $arDelivery["DESCRIPTION"]."<br />";

								if (count($arDelivery["STORE"]) > 0):
								?>
									<span id="select_store_<?=$arDelivery["ID"]?>"<?if(strlen($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"]) <= 0) echo " style=\"display:none;\"";?>>
										<span class="select_store"><?=GetMessage('BITRONIC2_SOA_ORDER_GIVE_TITLE');?>: </span>
										<span class="ora-store" id="store_desc_<?=$arDelivery["ID"]?>"><?=htmlspecialcharsbx($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"])?></span>
									</span>
								<?
							endif;
							?>
							</span>
							<?if(count($arDelivery['STORE']) > 0):?>
								<a class="pseudolink select-store" href="javascript:;" id="select_store_link_<?=$arDelivery["ID"]?>" <?=$clickHandler?>><span class="link-text"><?=GetMessage("RZ_VIBRAT_SKLAD")?> </span></a>
							<?endif?>
						</span>
					</label>
				<?
			}
		}
		?>
		</div><!-- /delivery-type row -->
		<?
	}
?>