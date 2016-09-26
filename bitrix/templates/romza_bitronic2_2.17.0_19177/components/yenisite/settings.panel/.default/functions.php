<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!function_exists('showSettingsItem')) {
	function showSettingsItem($arItem, $curValue) {
		if ($arItem["CODE"] == 'theme-demo') {
			$type = "COLOR_THEME";
		} elseif (isset($arItem["type"])) {
			$type = $arItem["type"];
		}
		// echo "<pre style='text-align:left;'>";print_r($curValue);echo "</pre>";
		// echo "<pre style='text-align:left;'>";print_r($arItem);echo "</pre>";
		if ($type != 'HIDDEN' && $arItem["CODE"] != 'preset') echo '<div class="col-sm-6 col-xs-12">';
		if ($arItem["CODE"] === 'preset') echo '<div class="col-xs-12">';
		switch ($type) {
			case 'HIDDEN':
				?>
				<input type="hidden" name="SETTINGS[<?= $arItem["CODE"] ?>]" id="settings_<?= $arItem["CODE"] ?>" value="<?= $curValue ?>" data-name="<?= $arItem["CODE"] ?>" data-default="<?= $arItem['default'] ?>">
			<? break;

			case "COLOR_THEME":
				?>
				<div class="setting-desc"><?= GetMessage('BITRONIC2_COLOR_THEME_STYLE') ?>
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div>
				<div class="setting-content">
					<?foreach ($arItem['values'] as $stylingType => $arValues):

						if (in_array($curValue, $arValues)) {
							$curValueGroup = $stylingType;
						}
						if (in_array($arItem['default'], $arValues)) {
							$defaultType = $stylingType;
						}
						?>
						<label class="radio-styled">
							<input type="radio" name="styling-type" data-name="styling-type"
								   value="<?= $stylingType ?>" <?= ($curValueGroup == $stylingType) ? 'checked="checked"' : '' ?>
								<? if ($defaultType == $stylingType):?> data-default<?endif ?>>
						<span class="radio-content">
							<span class="radio-fake"></span>
							<span class="label-text"><?= GetMessage('BITRONIC2_COLOR_THEME_STYLE_' . strtoupper($stylingType)) ?></span>
						</span>
						</label>
					<?endforeach?>

					<div class="setting-desc">
						<?= $arItem['name'] ?>:
						<? if ($arItem['preview']):?>
							<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
						<? endif ?>
					</div>
					<div id="theme-demos-wrap" data-styling-type="<?=$curValueGroup?>">
						<?foreach ($arItem['values'] as $stylingType => $arValues):?>
							<ul class="setting-content theme-demos <?= $stylingType ?>">
								<?foreach ($arValues as $value):?>
									<li class="theme-demo <?= $value ?> <?= ($curValue == $value) ? ' active' : '' ?>"
										data-theme='<?= $value ?>' <?= ($arItem['default'] == $value) ? 'data-default' : '' ?>></li>
								<?endforeach?>
							</ul>
						<?endforeach?>
					</div>
					<input type="hidden" name="SETTINGS[<?= $arItem["CODE"] ?>]" value="<?= $curValue ?>" id="theme-demo" data-name="<?= $arItem["CODE"] ?>">
				</div>
				<?break;

			case 'RADIO':
				?>
				<div class="setting-desc <?// TODO hidden-xs
				?>"><?= $arItem['name'] ?>:
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div>
				<div class="setting-content <?// TODO hidden-xs
				?>">
					<?foreach ($arItem["values"] as $key => $value):?>
						<label class="radio-styled">
							<input type="radio" name="SETTINGS[<?= $arItem["CODE"] ?>]" data-name="<?= $arItem["CODE"] ?>"
								   value="<?= $value ?>" <?= ($curValue == $value) ? ' checked' : '' ?>
								<?if($arItem['default'] == $value):?> data-default<?endif?>
								>
					<span class="radio-content"<?if(!empty($arItem['titles'][$value])):?> title="<?=$arItem['titles'][$value]?>"<?endif?>>
						<span class="radio-fake"></span>
						<span
							class="label-text">
							<?if(!empty($arItem['names'][$value])):?>
								<?= $arItem['names'][$value] ?>
							<?else:?>
								<?= GetMessage('BITRONIC2_' . strtoupper($arItem["CODE"]) . '_' . strtoupper($value)) ?>
							<?endif?>
						</span>
					</span>
						</label>
					<?endforeach?>
				</div><!-- .setting-content -->
				<? break;

			case 'STATEBOX':
				?>
				<div class="setting-desc aligns"><?= $arItem['name'] ?>:
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div>
				<? if (!in_array($arItem['default'], $arItem['values'])):
					showSettingsItem(
						array(
							'CODE' => $arItem['CODE'],
							'default' => $arItem['default'],
							'type' => 'HIDDEN'
						),
						$arItem['default']
					);
				endif ?>
				<div class="setting-content aligns">
					<?foreach ($arItem["values"] as $key => $value):?>
						<label class="align-btn-label">
							<input type="radio" class="statebox" name="SETTINGS[<?= $arItem["CODE"] ?>]" data-name="<?= $arItem["CODE"] ?>"
								   value="<?= $value ?>" <?= ($curValue == $value) ? ' checked' : '' ?>
								<?if($arItem['default'] == $value):?> data-default<?endif?>
								>
						<span <?if(!empty($arItem['titles'][$value])):?>title="<?=$arItem['titles'][$value]?>"<?endif?>
							class="align-btn btn-silver">
							<?if(!empty($arItem['names'][$value])):?>
								<?= $arItem['names'][$value] ?>
							<?else:?>
								<?= GetMessage('BITRONIC2_' . strtoupper($arItem["CODE"]) . '_' . strtoupper($value)) ?>
							<?endif?>
						</span>
						</label>
					<?endforeach?>
				</div><!-- .setting-content -->
				<? break;

			case 'SELECT': ?>
				<div class="setting-desc">
					<?= $arItem['name'] ?>:
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div><!-- .setting-desc -->
				<div class="setting-content">
					<select name="SETTINGS[<?= $arItem["CODE"] ?>]" id="settings_<?= $arItem["CODE"] ?>" title="<?= $arItem['name'] ?>" data-name="<?= $arItem["CODE"] ?>"
							data-autowidth="true">
						<?foreach ($arItem["values"] as $value):?>
							<option value="<?= $value ?>"<?= ($curValue == $value) ? ' selected' : '' ?>
								<?if($arItem['default'] == $value):?> data-default<?endif?>
								>
								<?if(!empty($arItem['names'][$value])):?>
									<?= $arItem['names'][$value] ?>
								<?else:?>
									<?= GetMessage('BITRONIC2_' . strtoupper($arItem["CODE"]) . '_' . strtoupper($value)) ?>
								<?endif?>
							</option>
						<?endforeach?>
					</select>
				</div><!-- .setting-content -->
			<? break;

			case 'CHECKBOX':?>
				<div class="setting-desc"><?=$arItem['header']?></div><!-- .setting-desc -->
				<div class="setting-content">
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
					<input type="hidden" name="SETTINGS[<?= $arItem["CODE"] ?>]" id="settings_<?= $arItem["CODE"] ?>_hidden" value="<?= $arItem['values'][1]?>">
					<label class="checkbox-styled" for="settings_<?= $arItem["CODE"] ?>"<?if(!empty($arItem['label-id'])):?> id="<?=$arItem['label-id']?>"<?endif?>>
						<input name="SETTINGS[<?= $arItem["CODE"] ?>]" type="checkbox" id="settings_<?= $arItem["CODE"] ?>" value="<?= $arItem['values'][0]?>"
							   data-name="<?= $arItem["CODE"] ?>"
							   <?= ($curValue == $arItem['values'][0]) ? ' checked ' : '' ?>
							   <?if($arItem['default'] == $arItem['values'][0]):?> data-default="1"<?else:?> data-default="0"<?endif?>
							/>
						<span class="checkbox-content"><i class="flaticon-check14"></i>&nbsp;<?= $arItem['name'] ?></span></label>
				</div><!-- .setting-content -->
			<? break;

			case 'CHECKBOX_MOBILE': ?>
			<div class="setting-desc">
			</div><!-- .setting-desc -->
			<div class="setting-content">
				<div class="pull-left"><?

					$isDisabled = $arItem['states']['mobile']['state'] == 'disabled';

					if ($isDisabled) {
						$checked = true;
						if ($arItem['states']['mobile']['status'] == 'unchecked') {
							$checked = false;
						}
					}
					?>

					<input type="hidden" name="SETTINGS[<?= $arItem["CODE"] ?>_MOBILE]" id="settings_<?= $arItem["CODE"] ?>_MOBILE_hidden" value="<?= ($isDisabled && $checked ? $arItem['values'][0] : $arItem['values'][1])?>">
					<label class="checkbox-styled" for="settings_<?= $arItem["CODE"] ?>_MOBILE">
						<input name="SETTINGS[<?= $arItem["CODE"] ?>_MOBILE]" type="checkbox" id="settings_<?= $arItem["CODE"] ?>_MOBILE" value="<?= $arItem['values'][0]?>"
							   data-name="<?= $arItem["CODE"] ?>_mobile"<? if($isDisabled): ?> disabled<? endif ?>
							<?if(isset($checked)):?>
								<?= ($checked) ? 'checked' : '' ?><? unset($checked) ?>
							<? else :?>
								<?= ($curValue['mobile'] == $arItem['values'][0]) ? ' checked ' : '' ?>
							<? endif ?>
							<?if($arItem['default_MOBILE'] == $arItem['values'][0]):?> data-default="1"<?else:?> data-default="0"<?endif?>
							/>
						<span class="checkbox-content"><i class="flaticon-check14"></i>&nbsp;<span class="icon flaticon-phone12" title="<?=GetMessage('BITRONIC2_TITLE_FOR_MOBILE')?>" data-tooltip></span></span></label>
					<br><?

					$isDisabled = $arItem['states']['desktop']['state'] === 'disabled';

					if ($isDisabled) {
						$checked = true;
						if ($arItem['states']['desktop']['status'] === 'unchecked') {
							$checked = false;
						}
					}
					?>

					<input type="hidden" name="SETTINGS[<?= $arItem["CODE"] ?>]" id="settings_<?= $arItem["CODE"] ?>_hidden" value="<?= ($isDisabled && $checked ? $arItem['values'][0] : $arItem['values'][1])?>">
					<label class="checkbox-styled" for="settings_<?= $arItem["CODE"] ?>">
						<input name="SETTINGS[<?= $arItem["CODE"] ?>]" type="checkbox" id="settings_<?= $arItem["CODE"] ?>" value="<?= $arItem['values'][0]?>"
							   data-name="<?= $arItem["CODE"] ?>"<? if($isDisabled): ?> disabled<? endif ?>
							<?if(isset($checked)):?>
								<?= ($checked) ? 'checked' : '' ?><? unset($checked) ?>
							<? else :?>
								<?= ($curValue['orig'] == $arItem['values'][0]) ? ' checked ' : '' ?>
							<? endif ?>
							<?if($arItem['default'] == $arItem['values'][0]):?> data-default="1"<?else:?> data-default="0"<?endif?>
							/>
						<span class="checkbox-content"><i class="flaticon-check14"></i>&nbsp;<span class="icon flaticon-computer" title="<?=GetMessage('BITRONIC2_TITLE_FOR_PC')?>" data-tooltip></span></span></label>
				</div>
				<div class="combined_name"><?= $arItem['name'] ?><? if ($arItem['preview']):?>

					<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
				<? endif ?></div>
				<div class="clearfix"></div>
			</div><!-- .setting-content -->
			<? break;

			case 'SLIDER': ?>
				<div class="setting-desc">
					<?= $arItem['name'] ?>:
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div><!-- .setting-desc -->
				<div class="setting-content">
					<input type="text" name="SETTINGS[<?= $arItem["CODE"] ?>]" id="settings_<?= $arItem["CODE"] ?>"
						   class="textinput <?= $arItem["CODE"] ?>-input" value="<?= (!empty($curValue)) ? $curValue : $arItem['default'] ?>"
						   data-name="<?= $arItem["CODE"] ?>" data-default="<?= $arItem['default'] ?>">
					<div class="simple-slider <?= $arItem["CODE"] ?>-slider" id="<?= $arItem["CODE"] ?>-slider"
						 data-name="<?= $arItem["CODE"] ?>" data-start="<?= (!empty($curValue)) ? $curValue : $arItem['default'] ?>"
						 data-min="<?= $arItem["min"] ?>" data-max="<?= $arItem["max"] ?>" data-step="<?= $arItem["step"] ?>"
						 <?if ($arItem["preview"]): ?>data-set="true"<? endif ?>
						 <?if(!empty($arItem['postfix'])):?> data-postfix="<?=$arItem['postfix']?>"<? endif ?>
						></div>
				</div><!-- .setting-content -->
				<? break;

			case 'COLOR': ?>
				<div class="setting-desc">
					<?= $arItem['name'] ?>:
					<? if ($arItem['preview']):?>
						<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
					<? endif ?>
				</div><!-- .setting-desc -->
				<div class="setting-content">
					<?
					$curValue = (!empty($curValue)) ? $curValue : $arItem['default'];
					$dataType = ($curValue{0} == '#') ? 'color' : 'pattern';
					?>
					<? if (isset($arItem['choose'])): ?>
						<select class="type-choose" name="<?= $arItem["CODE"] ?>_type" id="<?= $arItem["CODE"] ?>_type" title="">
							<? foreach ($arItem['choose'] as $val => $name): ?>
								<option value="<?= $val ?>"<?= ($dataType == $val) ? ' selected' : '' ?>><?= $name ?></option>
							<? endforeach ?>
						</select>
						<? if (isset($arItem['choose']['pattern'])): ?>
							<div class="data-type type-pattern" <?= ($dataType != 'pattern') ? 'style="display:none;"' : '' ?>>
								<?
								$arFiles = glob($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/images/' . CRZBitronic2Settings::getModuleId() . '/patterns/*.{jpg,png,gif,jpeg}',GLOB_BRACE);
								?>
								<ul class="select-suboptions set-color" data-name="<?= $arItem["CODE"] ?>"
									data-option="color" data-switch="li">
									<?
									natsort($arFiles);
									$filterType = ($arItem['filter']{0} == '!') ? 'not' : '';
									$filterVal = ($filterType == 'not') ? substr($arItem['filter'], 1) : $arItem['filter'];
									foreach ($arFiles as $file): ?>
										<?
										$baseName = basename($file);
										if(isset($arItem['filter'])) {
											if($filterType == 'not') {
												if(strpos($baseName,$filterVal) === false) {
													continue;
												}
											} else {
												if(strpos($baseName,$filterVal) !== false) {
													continue;
												}
											}
										}?>
										<?
										$bgValue = 'url(' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $file) . ')'
										?>
										<li class="<?= ($curValue == $bgValue) ? ' active' : '' ?>"
											style="background: <?= $bgValue ?>" data-value="<?= $bgValue ?>" title="<?= $baseName?>" data-tooltip></li>
									<? endforeach ?>
								</ul>
							</div>
						<? endif ?>
					<? endif ?>
					<div class="data-type type-color"<?= ($dataType != 'color') ? 'style="display:none;"' : '' ?>>
						<input type="text" class="textinput minicolors set-color" data-name="<?= $arItem["CODE"] ?>" value="<?= $curValue ?>"
							   data-default="<?= $arItem['default'] ?>" title="">
					</div>
					<input type="hidden" class="color-setting" name="SETTINGS[<?= $arItem["CODE"] ?>]" data-name="<?= $arItem["CODE"] ?>"
						   id="settings_<?= $arItem["CODE"] ?>" value="<?= $curValue ?>"
						   data-property="<?=$arItem['property']?>" data-selector="<?= $arItem['selector']?>" />
				</div><!-- .setting-content -->
				<? break;
		}
		if ($type != 'HIDDEN' && $arItem["CODE"] != 'preset') echo '</div>';
		if ($arItem["CODE"] === 'preset') echo '</div>';
	}
}

if (!function_exists('showSliderSettings')) {
	function showSliderSettings() {
?>
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-6">
											<div class="setting-desc">
												<?=GetMessage('BITRONIC2_SETTING_BS_CUR_BLOCK')?>:
											</div>
											<div class="setting-content">
												<label class="radio-styled">
													<input type="radio" name="bs_cur-block" data-name="bs_cur-block" value="text">
													<span class="radio-content">
														<span class="radio-fake"></span>
														<span class="label-text"><?=GetMessage('BITRONIC2_SETTING_BS_CUR_BLOCK_TEXT')?></span>
													</span>
												</label>
												<label class="radio-styled">
													<input type="radio" name="bs_cur-block" data-name="bs_cur-block" value="media" checked data-default>
													<span class="radio-content">
														<span class="radio-fake"></span>
														<span class="label-text"><?=GetMessage('BITRONIC2_SETTING_BS_CUR_BLOCK_MEDIA')?></span>
													</span>
												</label>
											</div><!-- .setting-content -->
										</div><!-- .col-sm-6 -->
									</div><!-- .row -->
								</div><!-- .col-sm-6 -->
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-6 bs_anim-wrap">
											<div class="setting-desc">
												<?=GetMessage('BITRONIC2_SETTING_BS_ANIMATION')?>:
												<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
											</div>
											<div class="setting-content">
												<select name="bs_anim" data-name="bs_anim">
													<option value="swoop" selected data-default>swoop</option>
													<option value="fade">fade</option>
													<option value="flipX">flipX</option>
													<option value="flipY">flipY</option>
													<option value="whirl">whirl</option>
													<option value="slideUpBig">slideUp</option>
													<option value="slideDownBig">slideDown</option>
													<option value="slideLeftBig">slideLeft</option>
													<option value="slideRightBig">slideRight</option>
													<option value="shrink">shrink</option>
													<option value="expand">expand</option>
													<option value="flipBounceX">flipBounceX</option>
													<option value="flipBounceY">flipBounceY</option>
													<option value="perspectiveUp">perspectiveUp</option>
													<option value="perspectiveDown">perspectiveDown</option>
												</select>
											</div>
										</div><!-- .col-sm-6 -->
										<div class="col-sm-6" id="bs_text-align-wrap">
											<div class="setting-desc">
												<?=GetMessage('BITRONIC2_SETTING_BS_TEXT-ALIGN')?>:
												<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
											</div>
											<div class="setting-content">
												<label class="align-btn-label">
													<input type="radio" class="statebox" name="bs_text-align" data-name="bs_text-align" value="left" checked data-default>
													<i class="align-btn btn-silver flaticon-alignment"></i>
												</label><label class="align-btn-label">
													<input type="radio" class="statebox" name="bs_text-align" data-name="bs_text-align" value="center">
													<i class="align-btn btn-silver flaticon-alignment1"></i>
												</label><label class="align-btn-label">
													<input type="radio" class="statebox" name="bs_text-align" data-name="bs_text-align" value="right">
													<i class="align-btn btn-silver flaticon-right-alignment"></i>
												</label>
											</div>
										</div><!-- .col-sm-6 -->
									</div><!-- .row -->
								</div><!-- .col-sm-6 -->
							</div><!-- .row -->

							<div class="row">
								<div class="col-sm-6">
									<div class="setting-desc">
										<?=GetMessage('BITRONIC2_SETTING_BS_H-LIMITS')?>:
										<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
									</div>
									<div class="setting-content percents">
										<div class="range-slider percents h-limits" data-name="h-limits"></div>
										<span class="text percents"><?=GetMessage('BITRONIC2_SETTING_BS_H-LIMITS-START')?>:</span>
										<input type="text" class="textinput percents limit-start">
										<span class="text percents"><?=GetMessage('BITRONIC2_SETTING_BS_H-LIMITS-END')?>:</span>
										<input type="text" class="textinput percents limit-end">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="setting-desc">
										<?=GetMessage('BITRONIC2_SETTING_BS_V-LIMITS')?>:
										<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
									</div>
									<div class="setting-content percents">
										<div class="range-slider percents v-limits" data-name="v-limits"></div>
										<span class="text percents"><?=GetMessage('BITRONIC2_SETTING_BS_V-LIMITS-START')?>:</span>
										<input type="text" class="textinput percents limit-start">
										<span class="text percents"><?=GetMessage('BITRONIC2_SETTING_BS_V-LIMITS-END')?>:</span>
										<input type="text" class="textinput percents limit-end">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="setting-desc aligns">
										<?=GetMessage('BITRONIC2_SETTING_BS_H-ALIGN')?>:
										<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
									</div>
									<div class="setting-content aligns">
										<label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_h-align" data-name="bs_h-align" value="left" checked data-default>
											<i class="align-btn btn-silver flaticon-object6"></i>
										</label><label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_h-align" data-name="bs_h-align" value="center">
											<i class="align-btn btn-silver flaticon-object7"></i>
										</label><label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_h-align" data-name="bs_h-align" value="right">
											<i class="align-btn btn-silver flaticon-object5"></i>
										</label>
									</div>
								</div><!-- .col-sm-6 -->
								<div class="col-sm-6">
									<div class="setting-desc aligns">
										<?=GetMessage('BITRONIC2_SETTING_BS_V-ALIGN')?>:
										<i class="has-preview flaticon-43-3" title="<?= GetMessage('BITRONIC2_SETTING_HAS_PREVIEW') ?>" data-tooltip></i>
									</div>
									<div class="setting-content aligns">
										<label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_v-align" data-name="bs_v-align" value="top" checked data-default>
											<i class="align-btn btn-silver flaticon-object11"></i>
										</label><label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_v-align" data-name="bs_v-align" value="center">
											<i class="align-btn btn-silver flaticon-object8"></i>
										</label><label class="align-btn-label">
											<input type="radio" class="statebox" name="bs_v-align" data-name="bs_v-align" value="bottom">
											<i class="align-btn btn-silver flaticon-object10"></i>
										</label>
									</div>
								</div><!-- .col-sm-6 -->
							</div><!-- .row -->
<?
	}
}

if (!function_exists('showSliderDummy')) {
	function showSliderDummy() {
?>
						<div class="dummy-wrap">
							<div class="big-slider dummy">
								<div class="container">
									<div class="content" style="padding-bottom: 24.30%" data-bs_height="24.30%">
										<div class="slide active">
											<div class="media" style="right: 51%; left: 0" data-h-align="right">
												<span data-src="">
													<span class="img demo">MEDIA</span>
												</span>
											</div>
											<div class="text" style="left: 51%; right: 0">
												<div class="wrap demo">
													<div class="content">
														text text<br>
														text text text<br>
														text
													</div>
												</div>
											</div>
										</div><!-- /.slide -->
									</div><!-- /.content -->
								</div><!-- /.container -->
							</div><!-- /.big-slider -->
						</div><!-- .dummy-wrap -->
<?
	}
}
