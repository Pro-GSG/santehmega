<?
if (!empty($arResult["ORDER_ID"])){
	//Получение ID платежной системы для модуля кредитования
	$option = COption::GetOptionString(
	 'rsb.credit',
	 'PAY_SYSTEM_ID',
	 false,
	 SITE_ID
	);

	if ( $_REQUEST['PAY_SYSTEM_ID'] == $option ) {
		$arProps = CSaleOrderProps::GetList(array('ID'=>'ASC'), array('CODE'=>'CODE_TT'))->Fetch();
		if ( $arProps ) {
			$value = 362786; // Вместо 'Значения кода ТТ' разместите действующий КОД ТТ, выданный менеджером Банка
			
			/*
			В случае, если используется несколько регионов, то здесь необходимо разместить логику подстановки кода ТТ, для различных регионов, например:
			
			switch ($region) {
				case 'msk': // Если регион Москва
				$value = 1; // Значение кода ТТ для Москвы
				break;
				case 'stPt': // Если регион Санкт-Петербург
				$value = 2; // Значение кода ТТ для Санкт-Петербурга
				break;
				}
			
			И так далее.			
			*/
			
			if ($value){
				$arFields = array(
				'ORDER_ID' => $arResult["ORDER_ID"],
				'ORDER_PROPS_ID' => $arProps['ID'],
				'NAME' => $arProps['NAME'],
				'CODE' =>  $arProps['CODE'],
				'VALUE' => $value
				);
				CSaleOrderPropsValue::Add($arFields);
			}
		}
	}
}

?>