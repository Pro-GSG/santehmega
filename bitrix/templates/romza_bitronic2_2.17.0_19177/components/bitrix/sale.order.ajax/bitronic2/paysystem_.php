<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
		function changePaySystem(param)
		{
			if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = true;
						BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
						BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

						// deselect all other
						var el = document.getElementsByName("PAY_SYSTEM_ID");
						for(var i=0; i<el.length; i++)
							el[i].checked = false;
					}
				}
				else
				{
					BX("PAY_CURRENT_ACCOUNT").checked = false;
					BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
					BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
				}
			}
			else if (BX("account_only") && BX("account_only").value == 'N')
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

						if (BX("PAY_CURRENT_ACCOUNT").checked)
						{
							BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
							BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
						else
						{
							BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
							BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
					}
				}
			}

			submitForm();
		}
</script>
			
<h3><?=GetMessage("BITRONIC2_SOA_TEMPL_PAY_SYSTEM")?></h3>
<div class="payment-system-type row">
<?
	if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
	{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" />
			<div class="col-xs-12 pay-from-inner-wrap">
				<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
				<label class="checkbox-styled" onclick="changePaySystem('account');">
					<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
					<span class="checkbox-content">
						<i class="flaticon-check14"></i>
						<?=GetMessage("BITRONIC2_SOA_TEMPL_PAY_ACCOUNT")?>
						<div> - <?=GetMessage("BITRONIC2_SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
						<div>
							<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
								<?=GetMessage("BITRONIC2_SOA_TEMPL_PAY_ACCOUNT3")?>
							<? else:?>
								<?=GetMessage("BITRONIC2_SOA_TEMPL_PAY_ACCOUNT2")?>
							<? endif;?>
						</div>
					</span>
				</label>
			</div>
			<?
		}

		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value

		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
						$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
					else:
						$imgUrl = $templateFolder."/images/logo-default-ps.gif";
					endif;
					?>
					<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
					<label class="col-md-2 col-sm-4 col-xs-6" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<input type="radio"
							id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
							name="PAY_SYSTEM_ID"
							value="<?=$arPaySystem["ID"]?>"
							<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
							onclick="changePaySystem();"
							/>
						<span class="radio-item">
							<span class="radio-img">
								<img src="<?=$imgUrl?>" alt="<?=$arPaySystem["PSA_NAME"];?>">
							</span>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<span class="radio-item-header"><?=$arPaySystem["PSA_NAME"];?></span>
							<?endif;?>
							<p>
								<?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("BITRONIC2_SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</p>
						</span>
					</label>
					<?
				}
				else // more than one
				{
					if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
						$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
					else:
						$imgUrl = $templateFolder."/images/logo-default-ps.gif";
					endif;
				?>
					<label class="col-md-2 col-sm-4 col-xs-6" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<input type="radio"
							id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
							name="PAY_SYSTEM_ID"
							value="<?=$arPaySystem["ID"]?>"
							<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
							onclick="changePaySystem();" />
						<span class="radio-item">
							<span class="radio-img">
								<img src="<?=$imgUrl?>" alt="<?=$arPaySystem["PSA_NAME"];?>">
							</span>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<span class="radio-item-header"><?=$arPaySystem["PSA_NAME"];?></span>
							<?endif;?>
							<p>
								<?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("BITRONIC2_SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</p>
						</span>
					</label>
				<?
				}
			}

			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
						$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
					else:
						$imgUrl = $templateFolder."/images/logo-default-ps.gif";
					endif;
					?>
					<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
					<label class="col-md-2 col-sm-4 col-xs-6" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<input type="radio"
							id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
							name="PAY_SYSTEM_ID"
							value="<?=$arPaySystem["ID"]?>"
							<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
							onclick="changePaySystem();"
							/>
						<span class="radio-item">
							<span class="radio-img">
								<img src="<?=$imgUrl?>" alt="<?=$arPaySystem["PSA_NAME"];?>">
							</span>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<span class="radio-item-header"><?=$arPaySystem["PSA_NAME"];?></span>
							<?endif;?>
						</span>
					</label>
				<?
				}
				else // more than one
				{
					if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
						$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
					else:
						$imgUrl = $templateFolder."/images/logo-default-ps.gif";
					endif;
				?>
					<label class="col-md-2 col-sm-4 col-xs-6" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<input type="radio"
							id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
							name="PAY_SYSTEM_ID"
							value="<?=$arPaySystem["ID"]?>"
							<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
							onclick="changePaySystem();" />
						<span class="radio-item">
							<span class="radio-img">
								<img src="<?=$imgUrl?>" alt="<?=$arPaySystem["PSA_NAME"];?>">
							</span>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<span class="radio-item-header"><?=$arPaySystem["PSA_NAME"];?></span>
							<?endif;?>
						</span>
					</label>
				<?
				}
			}
	}?>
</div><!-- /payment-system-type.row -->