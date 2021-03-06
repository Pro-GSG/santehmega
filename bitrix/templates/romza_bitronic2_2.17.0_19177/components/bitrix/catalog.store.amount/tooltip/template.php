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
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info.php';
if(empty($arResult["STORES"])) return;

$arParams['MIN_AMOUNT'] = intval($arParams['MIN_AMOUNT']);
if ($arParams['MIN_AMOUNT'] < 1) $arParams['MIN_AMOUNT'] = 5;

$arParams['MANY_VAL'] = 2 * $arParams['MIN_AMOUNT'];
$arParams['AVERAGE_VAL'] = $arParams['MIN_AMOUNT'];

if(!function_exists('rzSwitchAmount')) {
	function rzSwitchAmount($amount, $arParams) {
		$amount = (float)$amount;
		switch (true) {
			case ($amount >= $arParams['MANY_VAL']):
				$class = 'many';
				$title = $arParams['MANY_NAME'];
				break;
			case ($amount >= $arParams['AVERAGE_VAL']):
				$class = 'average';
				$title = $arParams['AVERAGE_NAME'];
				break;
			case (($amount < $arParams['AVERAGE_VAL'] && $amount != 0)):
				$class = 'few';
				$title = $arParams['FEW_NAME'];
				break;
			default:
				$class = 'none';
				$title = $arParams['NONE_NAME'];
		}
		return array($class,$title);
	}
}

$containerId = htmlspecialcharsBx("catalog_store_amount_div_{$arParams["CONTAINER_ID_POSTFIX"]}_{$arParams["~ELEMENT_ID"]}");
if(isset($arResult["IS_SKU"]) && $arResult["IS_SKU"] == 1 && isset($arResult["JS"]["SKU"])):
	foreach ($arResult["JS"]["SKU"] as $keyOffer => $arJSOffer)
	{
		$strProps = '';
		ob_start();
			?><header><?=GetMessage('S_BLOCK_TITLE')?></header><?
			foreach($arResult["STORES"] as $pid => $arItem)
			{
				?><div class="quantity"><?=$arItem["TITLE"]?> <?=$arItem["DESCRIPTION"] ? "({$arItem["DESCRIPTION"]})" : ''?>:
				<?switch($arParams['STORE_DISPLAY_TYPE']):
				case 'graph':?>
					<? $arAmount = rzSwitchAmount($arJSOffer[$arItem['ID']], $arParams); ?>
					<div class="store-indicator <?=$arAmount[0]?>">
						<div class="many average few"></div>
						<div class="many average"></div>
						<div class="many"></div>
					</div>
					<?break;
				case 'number':?>
					<strong><?= (int)$arJSOffer[$arItem['ID']] ?></strong>
					<?break;
				default:
				case 'text':?>
					<strong><?= getStringCatalogStoreAmount($arJSOffer[$arItem['ID']], $arParams['MIN_AMOUNT']) ?></strong>
					<?break?>
				<? endswitch ?>
				</div>
				<div class="address"><?=$arItem["ADDRESS"]?></div><?
			}		
		$arResult["JS"]["SKU"][$keyOffer]['DISPLAY_PROPERTIES'] = ob_get_contents();
		ob_end_clean();
	}
	?>
	<script type="text/javascript">
		require(['back-end/ajax/catalog_store'], function(){
			var obStoreAmount = new JCCatalogStoreSKU({
				'OFFERS': <?=CUtil::PhpToJSObject($arResult["JS"]["SKU"])?>,
				'CONTAINER_ID': '<?=$containerId?>'
			});
		});
	</script>
	<?unset($arResult["STORES"]);
endif;?>
		<?if(!empty($arResult["STORES"])):?>
			<header><?=GetMessage('S_BLOCK_TITLE')?></header>
			<?foreach($arResult["STORES"] as $pid => $arItem):?>
				<div class="quantity"><?=$arItem["TITLE"]?> <?=$arItem["DESCRIPTION"] ? "({$arItem["DESCRIPTION"]})" : ''?>:
					<?switch($arParams['STORE_DISPLAY_TYPE']):
						case 'graph':?>
							<? $arAmount = rzSwitchAmount($arItem["AMOUNT"], $arParams); ?>
							<div class="store-indicator <?=$arAmount[0]?>">
								<div class="many average few"></div>
								<div class="many average"></div>
								<div class="many"></div>
							</div>
						<?break;
						case 'number':?>
							<strong><?= (int)$arItem["AMOUNT"] ?></strong>
						<?break;
						default:
						case 'text':?>
							<strong><?= getStringCatalogStoreAmount($arItem["AMOUNT"], $arParams['MIN_AMOUNT']) ?></strong>
						<?break?>
					<? endswitch ?>
				</div>
				<div class="address"><?=$arItem["ADDRESS"]?></div>
			<?endforeach;?>
		<?endif?>
<?
// echo "<pre style='text-align:left;'>";print_r($arResult);echo "</pre>";