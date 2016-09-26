<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");

$style = (is_array($arResult["ORDER_PROP"]["RELATED"]) && count($arResult["ORDER_PROP"]["RELATED"])) ? "" : "display:none";
?>
<div style="<?=$style?>">
	<h3><?=GetMessage("BITRONIC2_SOA_TEMPL_RELATED_PROPS")?></h3>
	<div class="buyer-info"><?=PrintPropsForm($arResult["ORDER_PROP"]["RELATED"], $arParams["TEMPLATE_LOCATION"])?></div>
</div>