<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters['LUNCH_WEEKEND'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('LUNCH_WEEKEND'),
	'TYPE' => 'STRING',
	'MULTIPLE' => 'N',
	'DEFAULT' => GetMessage('LUNCH_WEEKEND_DEF'),
);

$arTemplateParameters['TIME_WORK_FROM'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('TIME_WORK_FROM'),
	'TYPE' => 'STRING',
	'MULTIPLE' => 'N',
	'DEFAULT' => '08:00',
);
$arTemplateParameters['TIME_WORK_TO'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('TIME_WORK_TO'),
	'TYPE' => 'STRING',
	'MULTIPLE' => 'N',
	'DEFAULT' => '18:00',
);
$arTemplateParameters['TIME_WEEKEND_FROM'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('TIME_WEEKEND_FROM'),
	'TYPE' => 'STRING',
	'MULTIPLE' => 'N',
	'DEFAULT' => '10:00',
);
$arTemplateParameters['TIME_WEEKEND_TO'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('TIME_WEEKEND_TO'),
	'TYPE' => 'STRING',
	'MULTIPLE' => 'N',
	'DEFAULT' => '15:00',
);




$arTemplateParameters["LUNCH"]['NAME'] = GetMessage('LUNCH');
$arTemplateParameters["LUNCH"]['PARENT'] = 'BASE';
$arTemplateParameters["TIME_WORK"]['HIDDEN'] = 'Y';
$arTemplateParameters["TIME_WEEKEND"]['HIDDEN'] = 'Y';