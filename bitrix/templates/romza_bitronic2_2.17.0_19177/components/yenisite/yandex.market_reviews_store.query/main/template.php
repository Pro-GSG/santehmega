<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (method_exists($this, 'createFrame')) $this->createFrame(true);
if (is_array($arResult["REVIEWS"])):
	if (!isset($arResult["REVIEWS"]["errors"])):
		$f = 1;
		foreach ($arResult["REVIEWS"]["shopOpinions"]["opinion"] as $review):?>
			<div class="comment item<? if ($f): ?> active<? $f = 0; endif ?>">
				<div class="text"><?= $review["text"] ?></div>
				<div class="info">
					<div class="rating-stars" data-rating="<?=($review["grade"]+3)?>" data-disabled="true">
						<i class="flaticon-black13" data-index="1"></i>
						<i class="flaticon-black13" data-index="2"></i>
						<i class="flaticon-black13" data-index="3"></i>
						<i class="flaticon-black13" data-index="4"></i>
						<i class="flaticon-black13" data-index="5"></i> 
					</div>
					<div class="author"><?= $review["author"] ?></div>
					<div class="date"><?=date('d.m.Y', $review["date"]/1000)?></div>
				</div>
			</div>
		<? endforeach ?>
	<? else: ?>
		<?= GetMessage('ERROR'); ?>
		<?
		global $USER;
		if ($USER->IsAdmin()) :?>
			<div class="debug">
				<p><?= GetMessage('ADMIN_INFO'); ?></p>
				<?= GetMessage('ERROR_LIST'); ?>
				<ul>
					<? foreach ($arResult["REVIEWS"]["errors"] as $err) : ?>
						<li><?= $err; ?></li>
					<? endforeach ?>
				</ul>
				<a href="http://api.yandex.ru/market/content/doc/dg/concepts/error-codes.xml"
				   target="_blank"><?= GetMessage('ERROR_INFO'); ?></a>
			</div>
		<? endif ?>
		<?
	endif; ?>
<? else:
	echo GetMessage('ERROR');
	global $USER;
	if ($USER->IsAdmin()) {
		?>
		<div class="debug"><?
		?><p><? echo GetMessage('ADMIN_INFO'); ?></p><?
		echo 'query error ' . $json['errno'];
		?></div><?
	}
endif ?>


