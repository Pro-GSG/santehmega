<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

// ShowMessage($arParams["~AUTH_RESULT"]);
$APPLICATION->AddChainItem($APPLICATION->GetTitle());
$arFormFields = array(/*
	'LOGIN' => array(
		'REQUIRED' => true,
	),*/
	'EMAIL' => array(
		'REQUIRED' => true,
	),
);
$arResult['USER_LOGIN'] = $arResult['LAST_LOGIN'];
?>
<main class="container new-password-page">
	<h1><?$APPLICATION->ShowTitle()?></h1>
<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form_forgot-pass">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">
	<p>
	<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
	</p>
	
	<p><b><?=GetMessage("AUTH_GET_CHECK_STRING")?></b></p>

	<?
	$i = 0;
	foreach($arFormFields as $code => $arField):?>
		<?if($i > 0):?>
			<p><?=GetMessage("AUTH_OR")?></p>
		<?endif?>
		<?switch($code):
			case 'CONFIRM_PASSWORD':
			case 'PASSWORD':?>
				<label class="textinput-wrapper">
					<span class="text"><?=GetMessage("AUTH_".$code)?><?if($arField['REQUIRED']):?><span class="required-asterisk">*</span><?endif?>:</span>
					<input type="password" name="USER_<?=$code?>" maxlength="50" value="<?=$arResult["USER_".$code]?>" class="textinput" <?=($arField['REQUIRED']?'required':'')?> />
				</label>
			<?break;
			default:?>
				<label class="textinput-wrapper">
					<span class="text"><?=GetMessage("AUTH_".$code)?><?if($arField['REQUIRED']):?><span class="required-asterisk">*</span><?endif?>:</span>
					<input type="<?=($code=='EMAIL'?'email':'text')?>" name="USER_<?=$code?>" maxlength="50" value="<?=$arResult["USER_".$code]?>" class="textinput" <?=($arField['REQUIRED']?'required':'')?> />
				</label>
		<?endswitch?>
		
	<?$i++;
	endforeach?>
	
	<div>
		<button type="submit" class="btn-main" name="send_account_info" value="Y"><span class="text"><?=GetMessage("AUTH_SEND")?></span></button>
	</div>
	
	<div>
		<p></p>
		
		<p>
			<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
		</p>
	</div>
</form>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</main>
