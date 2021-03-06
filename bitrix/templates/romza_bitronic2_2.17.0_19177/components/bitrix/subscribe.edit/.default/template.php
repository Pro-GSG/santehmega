<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe-edit row">
	<div class="col-sm-12">
		<?if(count($arResult["MESSAGE"]) > 0):?>
			<div class="message message-success">
				<?= implode('<br/>',$arResult["MESSAGE"])?>
			</div>
		<?endif;?>
		<?if(count($arResult["ERROR"]) > 0):?>
			<div class="message message-error">
				<?= implode('<br/>',$arResult["ERROR"])?>
			</div>
		<?endif;?>
	</div>
<?//whether to show the forms
if($arResult["ID"] == 0 && empty($_REQUEST["action"]) || CSubscription::IsAuthorized($arResult["ID"]))
{
	//show current authorization section
	if($USER->IsAuthorized() && ($arResult["ID"] == 0 || $arResult["SUBSCRIPTION"]["USER_ID"] == 0))
	{
		include("authorization.php");
	}
	//show authorization section for new subscription
	if(false && $arResult["ID"]==0 && !$USER->IsAuthorized())
	{
		if($arResult["ALLOW_ANONYMOUS"]=="N" || ($arResult["ALLOW_ANONYMOUS"]=="Y" && $arResult["SHOW_AUTH_LINKS"]=="Y"))
		{
			include("authorization_new.php");
		}
	}
	//setting section
	include("setting.php");
	//status and unsubscription/activation section
	if($arResult["ID"]>0)
	{
		include("status.php");
	}
	//show confirmation form
	if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y")
	{
		include("confirmation.php");
	}
	?>
	<div class="col-md-12">
		<div class="form-group required">
			<p class="help-block">
				<span class="required-asterisk">*</span> &mdash; <?= GetMessage("subscr_req")?>
			</p>
		</div>
	</div>
	<?
}
else
{
	//subscription authorization form
	include("authorization_full.php");
}
?>
</div>