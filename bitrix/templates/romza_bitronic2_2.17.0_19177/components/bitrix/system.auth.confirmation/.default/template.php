<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arFormFields = array(
	'LOGIN' => array(
		'REQUIRED' => true,
	),
	'CONFIRM_CODE' => array(
		'REQUIRED' => true,
	),	
);
?>
<?//here you can place your own messages
	switch($arResult["MESSAGE_CODE"])
	{
	case "E01":
		?><? //When user not found
		break;
	case "E02":
		?><? //User was successfully authorized after confirmation
		break;
	case "E03":
		?><? //User already confirm his registration
		break;
	case "E04":
		?><? //Missed confirmation code
		break;
	case "E05":
		?><? //Confirmation code provided does not match stored one
		break;
	case "E06":
		?><? //Confirmation was successfull
		break;
	case "E07":
		?><? //Some error occured during confirmation
		break;
	}
?>
<?if($arResult["SHOW_FORM"]):?>
<main class="container new-password-page">
	<h1><?$APPLICATION->ShowTitle()?></h1>
	<p><?echo $arResult["MESSAGE_TEXT"]?></p>
	<form method="post" action="<?echo $arResult["FORM_ACTION"]?>" class="form_forgot-pass">
		<input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
		
		<?foreach($arFormFields as $code => $arField):?>
			<label>
				<span class="text"><?=GetMessage("CT_BSAC_".$code)?><?if($arField['REQUIRED']):?><span class="required-asterisk">*</span><?endif?></span>
				<input type="text" name="<?echo $arParams[$code]?>" size="17" maxlength="50" value="<?echo ((strlen($arResult[$code]) > 0 || $code != 'LOGIN')? $arResult[$code]: $arResult["USER"][$code])?>" class="textinput" />
			</label>
		<?endforeach?>
	
		<div>
			<button type="submit" class="btn-main" value="Y"><span class="text"><?=GetMessage("CT_BSAC_CONFIRM")?></span></button>
		</div>
	</form>
</main>
<?elseif(!$USER->IsAuthorized()):?>
	<div class="container">
		<p><?echo $arResult["MESSAGE_TEXT"]?></p>
	</div>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array());?>
<?endif?>
