<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// ShowMessage($arParams["~AUTH_RESULT"]);
$APPLICATION->AddChainItem($APPLICATION->GetTitle());

$arFormFields = array(
	'LOGIN' => array(
		'REQUIRED' => true,
	),
	'CHECKWORD' => array(
		'REQUIRED' => true,
	),
	'PASSWORD' => array(
		'REQUIRED' => true,
	),	
	'CONFIRM_PASSWORD' => array(
		'REQUIRED' => true,
	),	
);
$arResult['USER_LOGIN'] = $arResult['LAST_LOGIN'];
?>
<main class="container new-password-page">
	<h1><?$APPLICATION->ShowTitle()?></h1>

<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform" class="form_forgot-pass">
	<?if (strlen($arResult["BACKURL"]) > 0): ?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">
	
	<?foreach($arFormFields as $code => $arField):?>
		<?switch($code):
			case 'CONFIRM_PASSWORD':
			case 'PASSWORD':?>
				<label>
					<span class="text"><?=GetMessage("AUTH_".$code)?><?if($arField['REQUIRED']):?><span class="required-asterisk">*</span><?endif?></span>
					<input type="password" name="USER_<?=$code?>" maxlength="50" value="<?=$arResult["USER_".$code]?>" class="textinput" />
				</label>
			<?break;
			default:?>
				<label>
					<span class="text"><?=GetMessage("AUTH_".$code)?><?if($arField['REQUIRED']):?><span class="required-asterisk">*</span><?endif?></span>
					<input type="text" name="USER_<?=$code?>" maxlength="50" value="<?=$arResult["USER_".$code]?>" class="textinput" />
				</label>
		<?endswitch?>
	<?endforeach?>
	
	<div>
		<button type="submit" class="btn-main" name="change_pwd" value="Y"><span class="text"><?=GetMessage("AUTH_CHANGE")?></span></button>
	</div>
	
	<div>
		<p></p>
		<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		<p><span class="required-asterisk">*</span> - <?=GetMessage("AUTH_REQ")?></p>
		
		<p>
			<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
		</p>
	</div>
</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</main>