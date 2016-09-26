<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';
?>
<? if (!empty($arResult['ITEMS'])): ?>
	<h3><?= $arParams['HEADER'] ?></h3>
	<? if ($arResult['show_cloud']): ?>
		<?
		$minFont = 12;
		$maxFont = 20;
		$fontSteps = $maxFont - $minFont;
		$range = max(.01, $fontSteps) * 1.0001;
		?>
		<div class="brands-tagcloud" data-switch=".brand-tag">
			<? foreach ($arResult['ITEMS'] as $arItem): ?>
				<?
				$cnt = (int)$arResult['BRANDS_CNT'][$arItem['UF_XML_ID']];
				$fontSize = $minFont + 1 + floor($fontSteps * ($cnt - $arResult['BRANDS_CNT_MIN']) / $range);
				if($cnt > 0):?>
					<a class="brand-tag" href="<?= $arItem['LINK'] ?>" style="font-size: <?= $fontSize ?>px"><?= $arItem['NAME'] ?>
						<sup><?= $cnt ?></sup></a>
				<?endif;?>
			<? endforeach ?>
		</div><!-- /.brands-tagcloud -->
	<? else: ?>
		<div class="brands-carousel brands-outer">
			<button class="slider-arrow prev">
				<i class="flaticon-arrow133"></i>
			</button>
			<button class="slider-arrow next">
				<i class="flaticon-right20"></i>
			</button>
			<div class="brands-inner"> <? $id = 'bx_dynamic_' . $this->randString(20) ?>
				<div class="slidee" id="<?= $id ?>"><?
					$frame = $this->createFrame($id, false)->begin();
					if (!empty($arResult['ITEMS'])):
						foreach ($arResult['ITEMS'] as $arItem):?>
						<a href="<?= $arItem['LINK'] ?>" class="brand">
							<img src="<?= $arItem['PICT']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
							</a><?

						endforeach;
					endif;
					$frame->end();
					?>
				</div>
			</div>
			<!-- /.brands-inner -->
		</div><!-- /.brands-outer -->
	<? endif ?>
<? endif ?>