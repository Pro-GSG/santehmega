<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";
$id = 'bxdinamic_bitronic2_auth_authorized';

?>
<div class="top-line-item account-authorized" id="<?=$id?>"><?
$frame = $this->createFrame($id, false)->begin(CRZBitronic2Composite::insertCompositLoader());

if($USER->IsAuthorized()):?>
	<div id="account-menu-toggler">
		<?
		$userPhoto = CResizer2Resize::ResizeGD2(CFile::GetPath($USER->GetParam("PERSONAL_PHOTO")), $arParams['RESIZER_USER_AVA_ICON']);
		$userName = $arResult['USER_NAME'] ? $arResult['USER_NAME'] : $arResult['USER_LOGIN'];
		?>
		<a href="account-settings.php" class="account pseudolink" data-popup="#popup_account-menu" data-toggler="#account-menu-toggler">
			<span class="avatar">
				<i class="flaticon-user12"></i>
				<img src="<?=$userPhoto?>" alt="avatar">
			</span>
			<span class="link-text hidden-xs"><?=$userName?></span>
			<span class="link-text visible-xs-inline"><?=$userName?></span>
		</a>
		<a href="?logout=yes" id="btn-logout" class="btn-logout flaticon-logout13"></a>
	</div>
	<script> $('body').addClass('authorized'); </script>
	<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "EDIT_TEMPLATE" => "include_areas_template.php", "PATH" => SITE_DIR."include_areas/header/user_menu.php"), false, array("HIDE_ICONS"=>"Y"));?>
<?endif;
if(method_exists($this, 'createFrame')) $frame->end();?>
</div>
<?
$id = 'bxdinamic_bitronic2_auth_not_authorized';
?>
<div class="top-line-item account-not-authorized with-icon" id="<?=$id?>"><?
$frame = $this->createFrame($id, false)->begin(CRZBitronic2Composite::insertCompositLoader());

if(!$USER->IsAuthorized()):?>
	<span class="avatar" data-popup="^.account-not-authorized>.content"><i class="flaticon-user12"></i></span>
	<span class="content">
		<a href="<?=$arResult["AUTH_URL"]?>" class="pseudolink" data-toggle="modal" data-target="#modal_login"><span class="link-text"><?=GetMessage('BITRONIC2_AUTH_LOGIN_LINK')?></span></a>
		/
		<a href="<?=$arResult['REGISTER_URL']?>" class="pseudolink" data-toggle="modal" data-target="#modal_registration"><span class="link-text"><?=GetMessage("BITRONIC2_AUTH_REGISTER")?></span></a>
	</span>
<?endif;
if(method_exists($this, 'createFrame')) $frame->end();?>
</div>

<?
$this->SetViewTarget('bitronic2_modal_login');?>
<div class="modal fade modal-form modal_login" id="modal_login" tabindex="-1">
	<div class="modal-dialog">
		<button class="btn-close" data-toggle="modal" data-target="#modal_login">
			<span class="btn-text"><?=GetMessage('BITRONIC2_MODAL_CLOSE')?></span>
			<i class="flaticon-close47"></i>
		</button>
		<?
		if(method_exists($this, 'createFrame')) $frame = $this->createFrame()->begin(CRZBitronic2Composite::insertCompositLoader()); 
		
		if (!$USER->IsAuthorized()):?>
		<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form_login">
			<?if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			
			
			<h2><span class="header-text"><?=GetMessage('BITRONIC2_AUTH_FORM_TITLE')?></span></h2>
			<div class="switch-form-block"><?=GetMessage('BITRONIC2_AUTH_FORM_OR')?><button type="button" class="btn-form-switch" data-toggle="modal" data-target="#modal_registration"><span class="btn-text"><?=GetMessage('BITRONIC2_AUTH_FORM_REGISTER')?></span></button></div>
			<?
			if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
				CRZBitronic2CatalogUtils::ShowMessage($arResult['ERROR_MESSAGE']);
			?>

			<label class="textinput-wrapper">
				<span class="label-text">
					<span class="inner-wrap">
						<span class="inner">
							<i class="textinput-icon flaticon-user12"></i>
							<?=GetMessage("BITRONIC2_AUTH_LOGIN")?>
						</span>
					</span>
				</span>
				<input type="email" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" class="textinput" required tabindex="1">
				<span class="textinput-icons">
					<i class="icon-valid flaticon-check33"></i>
					<i class="icon-not-valid flaticon-x5"></i>
				</span>				
			</label>
			
			<label class="textinput-wrapper">
				<span class="label-text">
					<span class="inner-wrap">
						<span class="inner">
							<i class="flaticon-blockade"></i>
							<?=GetMessage("BITRONIC2_AUTH_PASSWORD")?>
						</span>
					</span>
				</span>
				<input type="password" name="USER_PASSWORD" id="USER_PASSWORD" class="textinput password" required tabindex="2">
				<span class="textinput-icons">
					<span class="btn-password-toggle">
						<i class="password-shown flaticon-eye36"></i>
						<i class="password-hidden flaticon-closed40"></i>
					</span>
					<i class="icon-valid flaticon-check33"></i>
					<i class="icon-not-valid flaticon-x5"></i>
				</span>
			</label>
			
			
			<?if ($arResult["CAPTCHA_CODE"]):?>
			<div class="form_registration"><div class="anti-robot clearfix">
				<label class="textinput-wrapper">
					<input type="text" name="captcha_word" maxlength="50" value="" id="captcha" class="textinput" required tabindex="4" data-progression data-helper="<?=GetMessage("BITRONIC2_AUTH_FIELD_HELPER_CAPTCHA")?>">
					<span class="textinput-icons">
						<i class="icon-valid flaticon-check33"></i>
						<i class="icon-not-valid flaticon-x5"></i>
					</span>
					<span class="label-text"><span class="inner-wrap"><span class="inner"><?=GetMessage("BITRONIC2_AUTH_CAPTCHA_PROMT")?>:</span></span></span>
					<span class="captcha img-container centering"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="<?=GetMessage("BITRONIC2_AUTH_CAPTCHA_TITLE")?>"></span>
				</label>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			</div></div>
			<?endif?>
			
			<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<label class="checkbox-styled">
				<input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" checked="checked">
				<span class="checkbox-content" tabindex="3">
					<i class="flaticon-check14"></i>
					<?=GetMessage("BITRONIC2_AUTH_REMEMBER_ME")?>
				</span>
			</label>
			<?endif?>
			
			<div>
				<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow" class="forgot-pass"><?=GetMessage('BITRONIC2_AUTH_FORGOT_PASSWORD')?></a>
			</div>
			<div class="textinput-wrapper submit-wrap">
				<button type="submit" class="btn-submit btn-main" tabindex="4"><span class="btn-text"><?=GetMessage('BITRONIC2_AUTH_LOGIN_BUTTON')?></span></button>
			</div>
		</form>
		<footer class="modal-footer">
			<?
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "modal", 
				array(
					"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
					"AUTH_URL"=>$arResult["AUTH_URL"],
					"POST"=>$arResult["POST"],
					"POPUP"=>"N",
					"SUFFIX"=>"form",
				), 
				$component, 
				array("HIDE_ICONS"=>"Y")
			);
			?>
			<div class="auth-privilegies">
			<?
			$APPLICATION->IncludeComponent('bitrix:main.include', '',
				array(
					"AREA_FILE_SHOW" => "file",
					"EDIT_TEMPLATE" => "include_areas_template.php",
					"PATH" => SITE_DIR."include_areas/header/auth_privilegies.php"
				),
				false,
				array("HIDE_ICONS"=>"N")
			);
			?>
			</div>
		</footer>
		<?endif;?>
		<?if(method_exists($this, 'createFrame')) $frame->end();?>
	</div>
</div>
<?$this->EndViewTarget();
