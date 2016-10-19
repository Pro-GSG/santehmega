<?
function yaMarketAgentFirst() {
    BXClearCache(true, "/y-market/");
    $ch = curl_init();
    
// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "http://santehmega.com/EXPORT_YML/y-market/");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 40);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);


// grab URL and pass it to the browser
    curl_exec($ch);

// close cURL resource, and free up system resources
    curl_close($ch);
    return "yaMarketAgentFirst();";
}

function yaMarketAgentSkovoroda() {
    BXClearCache(true, "/y-market/");
    $ch = curl_init();

// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "http://skovoroda-online.ru/EXPORT_YML/skovoroda/");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 40);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);


// grab URL and pass it to the browser
    curl_exec($ch);

// close cURL resource, and free up system resources
    curl_close($ch);
    return "yaMarketAgentSkovoroda();";
}

function vregionsRedirect(){
	CModule::IncludeModule('iblock');
	$bxReadyCityName = explode('/', $_COOKIE["YS_GEO_IP_CITY"])[2]; // bxready название города
	$vregionsName = $_SESSION['VREGIONS_REGION']["NAME"]; // текущий регион из Регионов продаж
	$iblockID = COption::GetOptionString("aristov.vregions", "vregions_iblock_id");
	$vregions_default = COption::GetOptionString("aristov.vregions", "vregions_default");

// 	echo "<pre>";
// 	print_r(explode('.', $_SERVER["VREGIONS_DEFAULT"]));
// 	echo "</pre>";

	$domains = explode('.', $_SERVER["SERVER_NAME"]);
	$poddomen = $domains[0];
	if ($poddomen == $_SESSION["VREGIONS_DEFAULT"]['CODE']){
		header('Location: http://santehmega.com'.$_SERVER['REQUEST_URI']); // регион по умолчанию без домена
	}

	$res = CIBlockElement::GetList(Array(), Array('IBLOCK_ID' => $iblockID, 'NAME' => $bxReadyCityName, 'ACTIVE' => 'Y'), false, false, Array('ID', 'NAME', 'CODE'));
	if ($ob = $res->GetNextElement()){ // смотрим есть ли в регионах регион с таким именем
		$arFields = $ob->GetFields();
		if ($arFields['CODE'] != $_SESSION["VREGIONS_DEFAULT"]['CODE']){
			if ($poddomen != $arFields['CODE']){ // если нужен другой поддомен
				header('Location: http://'.$arFields['CODE'].'.santehmega.com'.$_SERVER['REQUEST_URI']); // если есть редиректим
				return;
			}
		}else{
			if (count($domains) > 2){
				header('Location: http://santehmega.com'.$_SERVER['REQUEST_URI']); // несуществующий регион на домен по умолчанию
				return;
			}
		}
	}else{
		if (count($domains) > 2){
			header('Location: http://santehmega.com'.$_SERVER['REQUEST_URI']); // несуществующий регион на домен по умолчанию
			return;
		}
	}
}
?>