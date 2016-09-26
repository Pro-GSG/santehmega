<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
?>
<div id="forum_comments">

<?if(strlen($arResult["ERROR_MESSAGE"]) > 0):?>
	<div class="message message-error">
		<?= $arResult["ERROR_MESSAGE"] ?>
	</div>
<?endif;?>
<?if(strlen($arResult["OK_MESSAGE"]) > 0):?>
	<div class="message message-success">
		<?= $arResult["OK_MESSAGE"] ?>
	</div>
<?endif;?>

<div class="form-wrap">
	<header><span class="text"><?=GetMessage('BITRONIC2_ADD_REVIEW')?></span></header>
	<form method="POST" enctype="multipart/form-data" name="form_comment" action="#" class="form_comment" id="form_comment_forum">
		<input type="hidden" name="back_page" value="<?= $arResult["CURRENT_PAGE"] ?>"/>
		<input type="hidden" name="ELEMENT_ID" value="<?= $arParams["ELEMENT_ID"] ?>"/>
		<input type="hidden" name="SECTION_ID" value="<?= $arResult["ELEMENT_REAL"]["IBLOCK_SECTION_ID"] ?>"/>
		<input type="hidden" name="IBLOCK_ID" value="<?= $arParams["IBLOCK_ID"]?>" />
		<input type="hidden" name="save_product_review" value="Y"/>
		<input type="hidden" name="preview_comment" value="N"/>
		<?= bitrix_sessid_post() ?>
		
		<? /* GUEST PANEL */
		if (!$arResult["IS_AUTHORIZED"]): ?>
			<div class="when-not-authorized">
				<label>
					<span class="text"><?=GetMessage("BITRONIC2_OPINIONS_NAME")?><span class="required-asterisk">*</span>:</span>
					<input name="REVIEW_AUTHOR" size="30" type="text" title="" class="textinput" placeholder="<?=GetMessage("BITRONIC2_OPINIONS_NAME")?>" value="<?= $arResult["REVIEW_AUTHOR"] ?>" required>
				</label>
				<? if ($arResult["FORUM"]["ASK_GUEST_EMAIL"] == "Y"): ?>
					<label>
						<span class="text"><?= GetMessage("BITRONIC2_OPINIONS_EMAIL") ?><span class="required-asterisk">*</span>:</span>
						<input type="text" name="REVIEW_EMAIL" size="30" title="" value="<?= $arResult["REVIEW_EMAIL"] ?>" class="textinput" placeholder="<?= GetMessage("BITRONIC2_OPINIONS_EMAIL") ?>">
					</label>
				<? endif; ?>
			</div>
		<? endif; ?>
		<?
		/* TODO
		<div class="rating">
			............
		</div>
		*/
		?>
		<div class="textarea-wrap">
			<label for="textarea-comment"><?=GetMessage('BITRONIC2_REVIEW_TEXT')?></label>
			<textarea id="textarea-comment" name="REVIEW_TEXT" cols="30" rows="5" placeholder="<?=GetMessage('BITRONIC2_ENTER_MESSAGE')?>" class="textinput" required></textarea>
		</div>
		<div class="form-footer">
			<?
			if (strLen($arResult["CAPTCHA_CODE"]) > 0): ?>
				<input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>">
				<label for="captcha_word_forum_comment"><?=GetMessage("BITRONIC2_F_CAPTCHA_PROMT")?><span class="required-asterisk">*</span>:</label>
				<div class="captcha" data-code="<?= $arResult["CAPTCHA_CODE"] ?>">
					<?/*<img src="/bitrix/tools/captcha.php?captcha_code=" alt="<?=GetMessage("BITRONIC2_F_CAPTCHA_TITLE")?>">*/?>
				</div>
				
				<input type="text" size="30" name="captcha_word" id="captcha_word_forum_comment" value="" tabindex="7" required class="textinput comment-captcha-input" placeholder="<?=GetMessage("B_B_MS_CAPTCHA_SYM_SHORT")?>" autocomplete="off">
			<? endif; ?>
			
			<button class="btn-main" value="<?=GetMessage("BITRONIC2_OPINIONS_SEND")?>" type="submit" name="send_button"><span class="btn-text"><?=GetMessage("BITRONIC2_OPINIONS_SEND")?></span></button>
		</div>

		<span class="required-info">
			<span class="required-asterisk">*</span> &mdash; <?=GetMessage('BITRONIC2_REQ_FIELDS')?>
		</span>
	</form>
</div><!-- /.form-wrap -->

<? if (count($arResult['MESSAGES']) < 1 && $arParams['GAMIFICATION']): ?>
<div class="mar-b-15"><?=GetMessage('BITRONIC2_BE_FIRST')?></div>
<? endif ?>

<? foreach ($arResult["MESSAGES"] as $arItem):
	if($arItem['LOGIN'])
	{
		$arItem['AUTHOR_NAME'] = "{$arItem['NAME']} {$arItem['SECOND_NAME']} {$arItem['LAST_NAME']}";
		if(empty($arItem['AUTHOR_NAME'])) $arItem['AUTHOR_NAME'] = $arItem['LOGIN'];
	}
	?>
	<div class="comment-wrap" itemprop="review" itemscope itemtype="http://schema.org/Review" id="blg-comment-<?=$arItem["ID"]?>">
			<header>
				<div class="date">
					<meta itemprop="datePublished" content="<?=$arItem["POST_DATE"]?>">
					<?=$arItem["POST_DATE"]?>
				</div>
				<div class="user-info" itemprop="author" itemscope itemtype="http://schema.org/Person">
					<div class="avatar">
						<?if(!empty($arItem['AVATAR']['FILE']['src'])):?>
							<img src="<?=$arItem['AVATAR']['FILE']['src']?>" alt="<?=$arItem['AUTHOR_NAME']?>">
						<?else:?>
							<i class="flaticon-user12"></i>
						<?endif?>
					</div>
					<div class="name" itemprop="name">
						<?=$arItem['AUTHOR_NAME']?>
					</div>
				</div>
			</header>
			<div class="content">
				<?
				/* TODO
				<div class="rating">
					..............
				</div>
				*/
				?>
				<?
				/* TODO
				<div class="pros">
					..............
				</div>
				<div class="cons">
					..............
				</div>
				*/
				?>
				<?// COMMENT TEXT
				$explode_pos = 400;
				if(strlen($arItem["POST_MESSAGE_TEXT"]) > $explode_pos)
				{
					$explode_pos = strpos($arItem["POST_MESSAGE_TEXT"], " ", $explode_pos);
					$arItem['TEXT_SHORT'] = substr($arItem["POST_MESSAGE_TEXT"], 0, $explode_pos);
					$arItem['TEXT_FULL'] = substr($arItem["POST_MESSAGE_TEXT"], $explode_pos);
				}
				else
				{
					$arItem['TEXT_SHORT'] = $arItem["POST_MESSAGE_TEXT"];
				}
				?>
				<div class="comment-text" itemprop="reviewBody">
					<?=$arItem['TEXT_SHORT']?>
					<div class="hidden-block">
						<?=$arItem['TEXT_FULL']?>
					</div>
				</div>
			</div><!-- /.content -->
			<footer>
				<?if(strlen($arItem['TEXT_FULL']) > 0):?>
					<span class="link">
						<span class="text when-closed"><?=GetMessage('BITRONIC2_REVIEW_TEXT_SHOW')?></span>
						<span class="text when-opened"><?=GetMessage('BITRONIC2_REVIEW_TEXT_HIDE')?></span>
					</span>
				<?endif?>
				<?
				/* TODO
				<span class="usefulness">
					..................
				</span>
				*/
				?>
			</footer>
		</div><!-- /.comment-wrap -->
<? endforeach; ?>

<? if (strlen($arResult["NAV_STRING"]) > 0 && $arResult["NAV_RESULT"]->NavPageCount > 1): ?>
	<?=$arResult["NAV_STRING"]?>
<? endif; ?>
</div>
<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";