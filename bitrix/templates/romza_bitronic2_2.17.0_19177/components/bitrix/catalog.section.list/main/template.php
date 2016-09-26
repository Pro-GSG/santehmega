<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);

include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info_dynamic.php';

if(empty($arResult['SECTIONS']))
{
	return false;
}
?>
<div id="categories" class="categories" data-categories-enabled="true">
	<div class="container">
		<div class="wrapper">
			<div class="slides scroller">
				<div class="scroller__track scroller__track_h">
					<div class="scroller__bar scroller__bar_h"></div>
				</div>
				<?foreach($arResult['SECTIONS'] as $arSection):?>
					<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="slide">
						<div class="img-wrap">
							<?if(!empty($arSection['PICTURE']['SRC'])):
								$imgSrc = CResizer2Resize::ResizeGD2($arSection['PICTURE']['SRC'], $arParams['RESIZER_SECTION_ICON']);
							?>
								<span data-picture data-alt="<?=$arSection['PICTURE']['ALT']?>">
									<span data-src="<?=$imgSrc?>"></span>
									<span data-src="" data-media="(max-width: 767px)"></span>

									<!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->
									<noscript>
										<img src="<?=$imgSrc?>" alt="<?=$arSection['PICTURE']['ALT']?>">
									</noscript>
								</span>
							<?endif?>
						</div>
						<div class="category-name"><?=$arSection['NAME']?></div>
					</a><!-- /.slide -->
				<?endforeach?>
			</div><!-- /.slides -->
		</div><!-- /.wrapper -->
	</div><!-- /.container -->
</div><!-- /.categories -->


<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";