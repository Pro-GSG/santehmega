<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//***********************************
//setting section
//***********************************
?>
<div class="col-md-6">
	<form action="<?= $arResult["FORM_ACTION"] ?>" method="post">
		<?= bitrix_sessid_post(); ?>
		<div class="form-group">
			<h2><?= GetMessage("subscr_title_settings") ?></h2>
		</div>
		<div class="form-group required">
			<label for=""><?= GetMessage("subscr_email") ?><span class="required-asterisk">*</span>:</label>
			<div class="textinput-wrapper">
				<input type="email" name="EMAIL" class="textinput form-control"
				       value="<?=($arResult["SUBSCRIPTION"]["EMAIL"] != "" ? $arResult["SUBSCRIPTION"]["EMAIL"] : $arResult["REQUEST"]["EMAIL"])?>"/>
			</div>
		</div>
		<div class="form-group required">
			<label for=""><?= GetMessage("subscr_rub") ?><span class="required-asterisk">*</span>:</label>
		</div>
		<? foreach ($arResult["RUBRICS"] as $itemID => $itemValue): ?>
			<div class="form-group">
				<label class="checkbox-styled">
					<input type="checkbox" name="RUB_ID[]"
						   value="<?= $itemValue["ID"] ?>"<? if ($itemValue["CHECKED"]) echo " checked" ?> />
					<span class="checkbox-content">
						<i class="flaticon-check14"></i>
						<?= $itemValue["NAME"] ?>
					</span>
				</label>
			</div>
		<? endforeach; ?>
		<div class="form-group">
			<label for=""><?= GetMessage("subscr_fmt") ?></label>
		</div>
		<?
		$arResult["SUBSCRIPTION"]["FORMAT"] = empty($arResult["SUBSCRIPTION"]["FORMAT"]) ? 'html' : $arResult["SUBSCRIPTION"]["FORMAT"];
		?>
		<div class="form-group">
			<label class="radio-styled">
				<input type="radio" name="FORMAT"
					   value="text"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked" ?> />
				<span class="radio-content">
					<span class="radio-fake"></span>
					<span class="text"><?= GetMessage("subscr_text") ?></span>
				</span>
			</label>
			<label class="radio-styled">
				<input type="radio" name="FORMAT"
					   value="html"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked" ?> />
				<span class="radio-content">
					<span class="radio-fake"></span>
					<span class="text">HTML</span>
				</span>
			</label>
		</div>
		<div class="form-group">
			<p class="help-block"><?= GetMessage("subscr_settings_note1") ?></p>
			<p class="help-block"><?= GetMessage("subscr_settings_note2") ?></p>
		</div>
		<div class="form-group ui-section">
			<button name="Save" class="btn-main">
				<span class="text"><?= ($arResult["ID"] > 0 ? GetMessage("subscr_upd") : GetMessage("subscr_add")) ?></span>
			</button>
			<button type="reset" class="pseudolink" name="reset" >
				<span class="link-text"><?= GetMessage("subscr_reset") ?></span>
			</button>
		</div>
		<input type="hidden" name="PostAction" value="<?= ($arResult["ID"] > 0 ? "Update" : "Add") ?>"/>
		<input type="hidden" name="ID" value="<?= $arResult["SUBSCRIPTION"]["ID"]; ?>"/>
		<? if ($_REQUEST["register"] == "YES"): ?>
			<input type="hidden" name="register" value="YES"/>
		<? endif; ?>
		<? if ($_REQUEST["authorize"] == "YES"): ?>
			<input type="hidden" name="authorize" value="YES"/>
		<? endif; ?>
	</form>
</div>
