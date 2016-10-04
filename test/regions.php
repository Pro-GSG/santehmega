<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
// echo explode('/',$_COOKIE["YS_GEO_IP_CITY"])[2];
// echo "<pre>";
// print_r($_COOKIE);
// echo "</pre>";
?><? $APPLICATION->IncludeComponent("vregions:header.select", "main", Array(
	"CACHE_TIME"           => "3600",    // Время кеширования (сек.)
	"CACHE_TYPE"           => "A",    // Тип кеширования
	"COMPOSITE_FRAME_MODE" => "A",    // Голосование шаблона компонента по умолчанию
	"COMPOSITE_FRAME_TYPE" => "AUTO",    // Содержимое компонента
	"IBLOCK"               => "46",    // Код информационного блока
	"IBLOCK_TYPE"          => "aristov_vregions_iblock_type",    // Тип информационного блока
	"POPUP_QUESTION_TITLE" => "Мы угадали?",    // Заголовок окна с предложением региона
	"SHOW_POPUP_QUESTION"  => "Y",    // Показывать всплывающее окно с предложением региона при заходе на сайт?
	"SORT_BY1"             => "NAME",    // Поле для первой сортировки регионов
	"SORT_BY2"             => "SORT",    // Поле для второй сортировки регионов
	"SORT_ORDER1"          => "DESC",    // Направление для первой сортировки регионов
	"SORT_ORDER2"          => "ASC",    // Направление для второй сортировки регионов
),
	false
); ?>

<?
$bxReadyCityName = explode('/', $_COOKIE["YS_GEO_IP_CITY"])[2]; // bxready название города
$vregionsName = $_SESSION['VREGIONS_REGION']["NAME"]; // текущий регион из Регионов продаж
if ($bxReadyCityName != $vregionsName){ // если названия не совпадают
	$iblockID = COption::GetOptionString("aristov.vregions", "vregions_iblock_id");
	$res = CIBlockElement::GetList(Array(), Array('IBLOCK_ID' => $iblockID, 'NAME' => $bxReadyCityName), false, false, Array('NAME', 'CODE'));
	if ($ob = $res->GetNextElement()){ // смотрим есть ли в регионах такой регион
		$arFields = $ob->GetFields();
		header('Location: http://www.'.$arFields['CODE'].'.santehmega.com'.$_SERVER['REQUEST_URI']); // если есть редиректим
	}
}
?><? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>