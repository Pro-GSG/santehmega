<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "магазин сантехники, купить акриловую ванну, купить душевую кабину, сантехника в ростове");
$APPLICATION->SetPageProperty("keywords", "магазин сантехники в #VREGION_WHERE#, купить душевую кабину, смеситель для ванны, купить мебель для ванной, купить акриловую ванну");
$APPLICATION->SetPageProperty("description", "Сертифицированная сантехника Iddis, Grohe, Berholm и других фирм. Предлагаем купить душевую кабину, смесители для ванны и прочую сантехнику Гарантия – 1-25 лет, монтаж, демонтаж, ремонт. Купите мебель для ванной или сантехнику с доставкой по России, #VREGION_NAME#. Тел. 8-800-500-65-62");
$APPLICATION->SetPageProperty("title", "Интернет-магазин сантехники: душевые кабины, смесители для ванны и другие товары, #VREGION_NAME#. Тел. 8-800-500-65-62");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Интернет-магазин сантехники: душевые кабины, смесители для ванны и другие товары, #VREGION_NAME#. Тел. 8-800-500-65-62");
global $rz_b2_options;
?>
<main class="home-page" data-page="home-page">
	<h1 class="home-page-h1"><?$APPLICATION->ShowTitle()?></h1>
	<?
	if($rz_b2_options['block_home-main-slider'] == 'Y' || $rz_b2_options["menu-catalog"] == "side") {
		$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include_areas/index/big-slider.php", "EDIT_TEMPLATE" => "include_areas_template.php"), false, array("HIDE_ICONS" => "Y"));
	}
	if($rz_b2_options['block_home-rubric'] == 'Y') {
		$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/categories.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"Y"));
	}
	if($rz_b2_options['block_home-cool-slider'] == 'Y') {
		$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include_areas/index/cool-slider.php", "EDIT_TEMPLATE" => "include_areas_template.php"), false, array("HIDE_ICONS" => "Y"));
	}
	if($rz_b2_options['block_home-specials'] == 'Y') {
		$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include_areas/index/main_spec.php", "EDIT_TEMPLATE" => "include_areas_template.php"), false, array("HIDE_ICONS" => "Y"));
	}
	?>
	<?if ($rz_b2_options['block_home-our-adv'] == 'Y'):?>
		<div class="container hidden-xs">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/benefits.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"N"));?>
		</div>
	<? endif ?>
	<? if ('Y' == $rz_b2_options['block_home-feedback']): ?>
		<? \Yenisite\Core\Tools::IncludeArea('index', 'feedback', false, true) ?>
	<? endif ?>
	<? if ($rz_b2_options['block_home-catchbuy'] == 'Y') {
		$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include_areas/index/catchbuy.php", "EDIT_TEMPLATE" => "include_areas_template.php"), false, array("HIDE_ICONS" => "Y"));
	}
	?>
	
	<div class="promo-banners container wow fadeIn">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/banner1.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => $rz_b2_options['block_show_ad_banners']));?>
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/banner2.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => $rz_b2_options['block_show_ad_banners']));?>
	</div>
	
	<div class="text-content container wow fadeIn">
		<div class="text-content-flex">
			<div class="about">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/about_title.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"N"));?>
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/about_text.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"N"));?>
			</div>
			<?if ($rz_b2_options['block_home-news'] == 'Y'):?>
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include_areas/index/news.php", "EDIT_TEMPLATE" => "include_areas_template.php"), false, array("HIDE_ICONS" => "Y"));?>
			<?endif?>
			<?if($rz_b2_options['block_home-voting'] == 'Y'):?>
				<div class="hidden-sm hidden-xs questionnaire-wrap">
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/voting.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"Y"));?>
				</div>
			<? endif ?>
		</div>
		<?if ($rz_b2_options['block_home-brands'] == 'Y'):?>
		<div class="row brands-wrap wow fadeIn" data-brands-view-type="<?= ($rz_b2_options['brands_cloud'] == 'Y') ? 'tags' : 'carousel' ?>">
			<div class="col-sm-12">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file",	"PATH" => SITE_DIR."include_areas/index/brands.php",	"EDIT_TEMPLATE" => "include_areas_template.php"	), false, array("HIDE_ICONS"=>"Y"));?>
			</div><!-- /.col-sm-12 -->
		</div><!-- /.row.brands-wrap -->
		<? endif ?>
	</div><!-- /.text-content.container -->
</main><!-- /.home-page -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>