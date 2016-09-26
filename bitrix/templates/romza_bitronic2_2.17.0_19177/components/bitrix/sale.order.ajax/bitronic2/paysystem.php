<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<? /* шаблон edost - НАЧАЛО */ ?>



<style>
    input:checked + label {
	border-color: #6495ed;
    box-shadow: 0px 1px 4px rgba(0,0,0,0.5);
	cursor: pointer;
}
     .edost_format_radio:hover {
	cursor: pointer;
	border-color: #6495ed;
    box-shadow: 0px 1px 4px rgba(0,0,0,0.5);
}

     .edost_format_radio {
    border-style: solid; 
	border-width: 3px;
    border-color: transparent;	
	color: #000;
    background: -webkit-linear-gradient(#fff, #f3f5f4);
    background: linear-gradient(#fff, #f3f5f4);
    box-shadow: 0px 1px 3px rgba(0,0,0,0.66),inset 0px 0px 0px rgba(0,0,0,0.17);
	
   
}

    label.edost_format_radio {
    vertical-align: middle;
    margin-right: 30px!important;
    margin-bottom: 10px!important;
	width: 160px;
    height: 80px;
    text-align: center;
}

    img.edost_ico {
    padding: 19px 20px!important;
}

img.edost_ico_normal {
    width: auto;
    height: 37px!important;
}

span.edost_format_tariff {
    font-size: 16px!important;
    font-weight: bold!important;
    font-family: "Open Sans", sans-serif;
}

.edost_format_description.edost_description {
    font-size: 12px;
    padding-top: 2px;
	font-family: "Open Sans", sans-serif;
	width: 70%;
	margin-top: 5px;
    margin-bottom: 30px;
}

div.edost span.edost_format_address_head {
    font-size: 12px;
    padding-top: 2px;
	font-family: "Open Sans", sans-serif;
	text-transform: capitalize;
    color: #000!important;
}

div.edost span.edost_format_address {
    font-size: 12px;
    padding-top: 2px;
	font-family: "Open Sans", sans-serif;
}


div#edost_general_div {
    width: 100%!important;
}

div.edost span.edost_format_link {
    cursor: pointer;
    color: #F00!important;
    font-size: 14px;
    font-weight: normal!important;
    border-bottom: 1px solid;
	font-family: "Open Sans", sans-serif;
	text-transform: uppercase;
}

div.edost_office_window_close{cursor: pointer;}

div#edost_tariff_div {
    display: inline-table;
	width: 100%;
}

div#edost_door_div {
    width: 100%!important;
}

div#edost_house_div {
    width: 100%!important;
}

div.edost span.edost_format_link_big {
    cursor: pointer;
    color: #F00;
    font-size: 14px;
    font-weight: normal!important;
    border-bottom: 1px solid;
	font-family: "Open Sans", sans-serif;
}

div.edost span.edost_format_link_big:hover {
    border-bottom: 1px solid #fff;
}

span.edost_price_free {
    color: #080;
    font-weight: normal!important;
    font-size: 16px!important;
	font-family: "Open Sans", sans-serif;
}

div.edost div.edost_format_head {
    background: none!important;
    padding: 0!important;
    color: #000!important;
    font-size: 18px;
    font-weight: normal!important;
    font-family: "Open Sans", sans-serif;
}

div.edost div.edost_delimiter {
    border: none!important;
}

span.edost_format_price.edost_day {
    font-size: 12px!important;
	font-family: "Open Sans", sans-serif;
}

span.edost_format_price.edost_price {
    font-family: "Open Sans", sans-serif;
    font-size: 16px!important;
}

td.edost_format_price {
    width: 10%;
}

span.edost_name {
    font-family: "Open Sans", sans-serif;
}

span.edost_price {
    font-family: "Open Sans", sans-serif;
}

span.edost_day {
    font-family: "Open Sans", sans-serif;
    font-size: 11px;
}	

div.edost_balloon {
    font-family: "Open Sans", sans-serif;
}	

a.edost_link {
    color: red!important;
    border-bottom: 1px solid;
	text-transform: capitalize;
}

table.edost_office_head td {
    cursor: pointer!important;
}

table.edost_office_head td.edost_office_head_all div {
    cursor: pointer;
    font-weight: normal;
    color: #F00;
    font-family: "Open Sans", sans-serif;
    text-transform: uppercase;
    margin: 20px;
    text-align: center;
    border-bottom: 1px dashed;
	width: 85%;
}

table.edost_office_head td.edost_office_head_all div:hover {
    border-bottom: 1px dashed #fff;
}

img.edost_ico_small {
    width: auto!important;
}

div.edost_warning {
    display: none;
}

div#edost_office_div {
    width: 100%!important;
}


.edost_main {
    float: left;
    width: 100%;
    margin-bottom: 50px;
}


.edost_button {
	cursor: pointer;
    pointer-events: auto;
}


td.edost_button_right {
    display: table-cell;
}

.pay_table{
	width: 25%!important;
	float: left;
}







@media (max-width: 480px) { 
    span.edost_format_tariff {
    font-size: 12px!important;
    }
	
	span.edost_format_price.edost_price {
    font-size: 12px!important;
    }
	
	img.edost_ico {
    padding: 4px 11px!important;
    }

    img.edost_ico_normal {
    width: auto!important;
    height: 32px!important;
    }
	
	label.edost_format_radio {
    vertical-align: middle;
    margin-right: 30px!important;
    margin-bottom: 10px!important;
	width: 80px;
    height: 40px;
    text-align: center;
    }
	
	.edost_format_description.edost_description {
        display: none;
    }
	
    span.edost_format_price.edost_day{
        display: none;
    }
	
	td.edost_format_price {
    width: 0%!important;
    }	
	
	div.edost span.edost_format_address_head {
    display: none;
    }
	
	div.edost span.edost_format_address {
    font-size: 10px;
    }
	
	div.edost span.edost_format_link {
    font-size: 10px;
    }
	
	.pay_table{
	height: 130px;
}
	
	
}


@media (min-width: 533px) and (max-width: 966px) { 

    span.edost_format_tariff {
    font-size: 14px!important;
    }
	
	.table-item .photo {
    height: auto;
    }

}


	
</style>



<? if (isset($arResult['edost']['format'])) { ?>

<script type="text/javascript">
	function changePaySystem(param) {
		if (BX("account_only") && BX("PAY_CURRENT_ACCOUNT"))
			if (BX("account_only").value == 'Y') {
				if (param == 'account') {
					if (BX("PAY_CURRENT_ACCOUNT").checked) BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
					else BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");

					var el = document.getElementsByName("PAY_SYSTEM_ID");
					for(var i = 0; i < el.length; i++) el[i].checked = false;
				}
				else {
					BX("PAY_CURRENT_ACCOUNT").checked = false;
					BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
				}
			}
			else if (BX("account_only").value == 'N') {
				if (param == 'account') {
					if (BX("PAY_CURRENT_ACCOUNT").checked) BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
					else BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
				}
			}

		submitForm();
	}
</script>

<? if ((!empty($arResult['PAY_SYSTEM']) || $arResult['PAY_FROM_ACCOUNT'] == 'Y') && !empty($arResult['edost']['format']['active']['id'])) { ?>
<div class="edost_main"<?=(!empty($arResult['edost']['format']['active']['cod_tariff']) ? ' style="display: none;"' : '')?>>
<?
	if (!isset($table_width)) $table_width = 645;
	$hide_radio = (count($arResult['PAY_SYSTEM']) == 1 && $arResult['PAY_FROM_ACCOUNT'] != 'Y' ? true : false);
	$ico_default = $templateFolder.'/images/logo-default-ps.gif';
?>
	<h3>Платежная система</h3>
    <div>
<!--	<div style="width: <?=$table_width?>px;"> -->
<?
	$i2 = 0;
	if ($arResult['PAY_FROM_ACCOUNT'] == 'Y') {
		$i2++;
		$id = 'PAY_CURRENT_ACCOUNT';
		$accountOnly = ($arParams['ONLY_FULL_PAY_FROM_ACCOUNT'] == 'Y') ? 'Y' : 'N';
?>
		<input type="hidden" id="account_only" value="<?=$accountOnly?>">
		<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="edost_format_ico" width="95">
					<input class="edost_format_radio" type="checkbox" name="<?=$id?>" id="<?=$id?>" value="Y" <?=($arResult['USER_VALS']['PAY_CURRENT_ACCOUNT'] == 'Y' ? 'checked="checked"' : '')?> onclick="changePaySystem('account');">

<?					if (!empty($ico_default)) { ?>
					<label class="edost_format_radio" for="<?=$id?>"><img class="edost_ico edost_ico_normal" src="<?=$ico_default?>" border="0"></label>
<?					} else { ?>
					<div class="edost_ico"></div>
<?					} ?>
				</td>
				<td class="edost_format_tariff">
					<label for="<?=$id?>">
					<span class="edost_format_tariff"><?=GetMessage('SOA_TEMPL_PAY_ACCOUNT')?></span>

					<div class="edost_format_description edost_description"><?=GetMessage('SOA_TEMPL_PAY_ACCOUNT1').' <b>'.$arResult['CURRENT_BUDGET_FORMATED']?></b></div>
					<div class="edost_format_description edost_description">
						<?=($arParams['ONLY_FULL_PAY_FROM_ACCOUNT'] == 'Y' ? GetMessage('SOA_TEMPL_PAY_ACCOUNT3') : GetMessage('SOA_TEMPL_PAY_ACCOUNT2'))?>
					</div>
					</label>
				</td>
			</tr>
		</table>
<?	}

	foreach($arResult['PAY_SYSTEM'] as $v) {
		if ($i2 != 0) echo '<div class="edost_delimiter edost_delimiter_ms"></div>';
		$i2++;

		$id = 'ID_PAY_SYSTEM_ID_'.$v['ID'];
		$value = $v['ID'];
		$checked = ($v['CHECKED'] == 'Y' && !($arParams['ONLY_FULL_PAY_FROM_ACCOUNT'] == 'Y' && $arResult['USER_VALS']['PAY_CURRENT_ACCOUNT'] == 'Y') ? true : false);

		if (!empty($v['PSA_LOGOTIP']['SRC'])) $ico = $v['PSA_LOGOTIP']['SRC'];
		else if (!empty($ico_default)) $ico = $ico_default;
		else $ico = false;
?>
		<table class="pay_table" width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="edost_format_ico" width="<?=($hide_radio ? '70' : '95')?>">
					<input class="edost_format_radio" <?=($hide_radio ? 'style="display: none;"' : '')?> type="radio" id="<?=$id?>" name="PAY_SYSTEM_ID" value="<?=$value?>" <?=($checked ? 'checked="checked"' : '')?> onclick="changePaySystem();">

<?					if ($ico !== false) { ?>
					<label class="edost_format_radio" for="<?=$id?>"><img class="edost_ico edost_ico_normal" src="<?=$ico?>" border="0"></label>
<?					} else { ?>
					<div class="edost_ico"></div>
<?					} ?>
				</td>
              </tr>
             <tr>
			    <td style="height: 15px;"></td>
			 </tr>
               <tr>
				<td class="edost_format_tariff">
					<label for="<?=$id?>">
					<span class="edost_format_tariff"><?=$v['PSA_NAME']?></span>

<?					if (!empty($v['DESCRIPTION'])) { ?>
					<div class="edost_format_description edost_description"><?=nl2br($v['DESCRIPTION'])?></div>
<?					} ?>

<?					if (!empty($v['PRICE'])) { ?>
					<div class="edost_format_description edost_warning">
						<?=str_replace('#PAYSYSTEM_PRICE#', SaleFormatCurrency(roundEx($v['PRICE'], SALE_VALUE_PRECISION), $arResult['BASE_LANG_CURRENCY']), GetMessage('SOA_TEMPL_PAYSYSTEM_PRICE'))?>
					</div>
<?					} ?>

<?					if (!empty($v['codplus'])) { ?>
					<div class="edost_format_description edost_description"><?=$v['codplus']?></div>
<?					} ?>

<?					if (!empty($v['transfer'])) { ?>
					<div class="edost_format_description edost_warning"><?=$v['transfer']?></div>
<?					} ?>

<?					if (!empty($v['codtotal'])) { ?>
					<div class="edost_format_description edost_description"><?=$v['codtotal']?></div>
<?					} ?>
					</label>
				</td>
			</tr>
			<tr>
			    <td style="height: 25px;"></td>
			</tr>
		</table>
<?	} ?>

	</div>

</div>
<? } ?>

<? } ?>
<? /* шаблон edost - КОНЕЦ */ ?>




<? /* шаблон bitrix (на базе 16) - НАЧАЛО */ ?>
<? if (!isset($arResult['edost']['format'])) { ?>

<div class="section">
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
	<div class="bx_section">
		<?
		if (!empty($arResult["PAY_SYSTEM"]) && is_array($arResult["PAY_SYSTEM"]) || $arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			?><h4><?=GetMessage("SOA_TEMPL_PAY_SYSTEM")?></h4><?
		}
		if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" />
			<div class="bx_block w100 vertical">
				<div class="bx_element">
					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
					<label for="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT_LABEL" onclick="changePaySystem('account');" class="<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "selected"?>">
						<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
						<div class="bx_logotype">
							<span style="background-image:url(<?=$templateFolder?>/images/logo-default-ps.gif);"></span>
						</div>
						<div class="bx_description">
							<strong><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?></strong>
							<p>
								<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
								<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
								<? else:?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
								<? endif;?>
							</p>
						</div>
					</label>
					<div class="clear"></div>
				</div>
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
					?>
					<div class="bx_block w100 vertical">
						<div class="bx_element">
							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$arFileTmp = CFile::ResizeImageGet(
											$arPaySystem["PSA_LOGOTIP"]['ID'],
											array("width" => "95", "height" =>"55"),
											BX_RESIZE_IMAGE_PROPORTIONAL,
											true
									);
									$imgUrl = $arFileTmp["src"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>
								<div class="bx_logotype">
									<span style="background-image:url(<?=$imgUrl?>);"></span>
								</div>
								<div class="bx_description">
									<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
										<strong class="bitrix_title"><?=$arPaySystem["PSA_NAME"];?></strong>
									<?endif;?>
									<div class="bitrix_description">
									<p>
										<?
										if (intval($arPaySystem["PRICE"]) > 0)
											echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
										else
											echo $arPaySystem["DESCRIPTION"];
										?>
									</p>
									</div>
								</div>
							</label>
							<div class="clear"></div>
						</div>
					</div>
					<?
				}
				else // more than one
				{
				?>
					<div class="bx_block w100 vertical">
						<div class="bx_element">
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();" />
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$arFileTmp = CFile::ResizeImageGet(
											$arPaySystem["PSA_LOGOTIP"]['ID'],
											array("width" => "95", "height" =>"55"),
											BX_RESIZE_IMAGE_PROPORTIONAL,
											true
									);
									$imgUrl = $arFileTmp["src"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>
								<div class="bx_logotype">
									<span style='background-image:url(<?=$imgUrl?>);'></span>
								</div>
								<div class="bx_description">
									<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
										<strong class="bitrix_title"><?=$arPaySystem["PSA_NAME"];?></strong>
									<?endif;?>
									<div class="bitrix_description">
									<p>
										<?
										if (intval($arPaySystem["PRICE"]) > 0)
											echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
										else
											echo $arPaySystem["DESCRIPTION"];
										?>
									</p>
									</div>
								</div>
							</label>
							<div class="clear"></div>
						</div>
					</div>
				<?
				}
			}

			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
					<div class="bx_block horizontal">
						<div class="bx_element">
							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
							<?
							if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
								$arFileTmp = CFile::ResizeImageGet(
										$arPaySystem["PSA_LOGOTIP"]['ID'],
										array("width" => "95", "height" =>"55"),
										BX_RESIZE_IMAGE_PROPORTIONAL,
										true
								);
								$imgUrl = $arFileTmp["src"];
							else:
								$imgUrl = $templateFolder."/images/logo-default-ps.gif";
							endif;
							?>
							<div class="bx_logotype">
								<span style='background-image:url(<?=$imgUrl?>);'></span>
							</div>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<div class="bx_description">
									<div class="clear"></div>
									<strong class="bitrix_title"><?=$arPaySystem["PSA_NAME"];?></strong>
								</div>
							<?endif;?>
							</label>
						</div>
					</div>
				<?
				}
				else // more than one
				{
				?>
					<div class="bx_block horizontal">
						<div class="bx_element">

							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();" />

							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
								<?
								if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
									$arFileTmp = CFile::ResizeImageGet(
											$arPaySystem["PSA_LOGOTIP"]['ID'],
											array("width" => "95", "height" =>"55"),
											BX_RESIZE_IMAGE_PROPORTIONAL,
											true
									);
									$imgUrl = $arFileTmp["src"];
								else:
									$imgUrl = $templateFolder."/images/logo-default-ps.gif";
								endif;
								?>
								<div class="bx_logotype">
									<span style='background-image:url(<?=$imgUrl?>);'></span>
								</div>
								<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
									<div class="bx_description">
										<div class="clear"></div>
										<strong class="bitrix_title">
											<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
												<?=$arPaySystem["PSA_NAME"];?>
											<?else:?>
												<?="&nbsp;"?>
											<?endif;?>
										</strong>
									</div>
								<?endif;?>
							</label>
						</div>
					</div>
				<?
				}
			}
		}
		?>
		<div style="clear: both;"></div>
	</div>
</div>

<? } ?>
<? /* шаблон bitrix - КОНЕЦ */ ?>
