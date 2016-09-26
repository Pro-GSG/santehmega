<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? $this->setFrameMode(true); ?>

<div class="form-wrap">
	<header><span class="text"><?=GetMessage('BITRONIC2_WRITE_REVIEW')?></span></header>
	<form method="POST" id="ys-guestbook" name="guestbook" action="<?=$APPLICATION->GetCurPageParam()?>" enctype="multipart/form-data" class="form_comment">
		<div class="feedback-content">
			<?foreach($arResult['FIELDS'] as $arItem):?>
				<? if (empty($arItem['HTML'])) continue; ?>
				<? if ($arItem['PROPERTY_TYPE'] == 'E'): ?>
					<?=$arItem['HTML']?><?continue?>
				<? endif; ?>
				<label>
					<span class="text"><?=$arItem['NAME']?><?=($arItem['IS_REQUIRED'] == 'Y')?'<span class="required-asterisk">*</span>':'';?>:</span>
					<?=$arItem['HTML'];?>
				</label>
			<?endforeach;?>
			<?
			/* TODO
			<div class="rating">
				............
			</div>
			*/
			?>

			<? if ($arParams['TEXT_SHOW'] == 'Y'): ?>
			<div class="textarea-wrap">
				<label for="textarea-comment"><?=GetMessage('BITRONIC2_REVIEW_TEXT')?></label>
				<textarea id="textarea-comment" name="<?=$arResult['CODE'];?>[text]" cols="30" rows="5" placeholder="<?=GetMessage('INPUT_MESSAGE')?>" class="textinput" required="required"><?=$arResult['DATA']['text'];?></textarea>
			</div>
			<? endif; ?>

			<div class="form-footer">
				<?if(!empty($arResult["CAPTCHA_CODE"])):?>
					<label for="captcha_word_feedback"><?=GetMessage("CAPTCHA_TITLE")?><span class="required-asterisk">*</span>:</label>
					<div class="captcha" data-code="<?= $arResult["CAPTCHA_CODE"] ?>">
						<?/*<img alt="<?=GetMessage("CAPTCHA_ALT")?>" src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CAPTCHA_CODE"]?>" />*/?>
					</div>
					<input type="hidden" name="captcha_code" id="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>"/>
					<input size="30" type="text" class="textinput comment-captcha-input" name="captcha_word" id="captcha_word_feedback" required="required" autocomplete="off" />
				<?endif;?>

				<button class="btn-main" value="<?=GetMessage("SEND")?>" type="submit" name="send_button"><span class="btn-text"><?=GetMessage("SEND")?></span></button>
			</div>
		</div>

		<span class="required-info">
			<span class="required-asterisk">*</span> &mdash; <?=GetMessage('BITRONIC2_REQ_FIELDS')?>
		</span>
	</form>
</div><!-- /.form-wrap -->

<? if(!empty($arResult['ERROR'])): ?>
<script>
    $(window).on('b2handlers', function(){
        $('.write-review_top').trigger('click');
    });
    RZB2.ajax.showMessage('<?=$arResult['ERROR'];?>', 'fail');
</script>
<? endif; ?>

<? if ($arResult['SUCCESS'] === TRUE): ?>

<? if(!empty($arResult['SUCCESS_TEXT'])): ?>
<script>
    $(window).on('b2ready', function(){
        $('a.combo-link[href="#comments"]').trigger('click');
    });
    RZB2.ajax.showMessage('<?=$arResult['SUCCESS_TEXT'];?>');
</script>
<? endif; ?>

<? endif; ?>