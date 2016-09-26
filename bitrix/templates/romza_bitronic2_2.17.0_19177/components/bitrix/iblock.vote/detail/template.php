<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);?>

<?
include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/include/debug_info.php';

if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
{
	if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
		$votesValue = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
	else
		$votesValue = 0;
}
else
	$votesValue = round($arResult["PROPERTIES"]["rating"]["VALUE"]);

$votesCount = intval($arResult["PROPERTIES"]["vote_count"]["VALUE"]);
	
if(isset($arParams["AJAX_CALL"]) && $arParams["AJAX_CALL"]=="Y")
{
	$APPLICATION->RestartBuffer();

	die(json_encode( array(
		"value" => $votesValue,
		"votes" => $votesCount
		)
	));
}

$templateData['~AJAX_PARAMS'] = $arResult['~AJAX_PARAMS'];

$bActive = !($arResult["VOTED"] || $arParams["READ_ONLY"]==="Y");
$bNotRated = ($votesCount < 1);
$onclick = "RZB2.ajax.Vote.do_vote(this, ".$arResult["AJAX_PARAMS"].", event)";
?>
<div class="info rating rating-w-comments" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	<div class="rating-stars<?=$bNotRated?' no-rate-yet':''?>" data-rating="<?=intval($votesValue)?>" data-itemid="<?=$arResult["ID"]?>" data-params="<?=$arResult['~AJAX_PARAMS']['SESSION_PARAMS']?>" data-disabled="<?=!$bActive ? 'true' : 'false'?>">
		<meta itemprop="ratingValue" content="<?=intval($votesValue)?>">
		<meta itemprop="worstRating" content="0">
		<?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>

		<i data-value="<?=$i?>" data-index="<?=$i+1?>" title="<?=$name?>" class="flaticon-black13"></i>
		<?endforeach?>
		<?if($bNotRated && $arParams['GAMIFICATION']):?>

		<div class="be-first"><?=GetMessage('BITRONIC2_IBLOCK_VOTE_BE_FIRST')?></div>
		<?endif?>

	</div>
	<span class="comments">
		(<?=GetMessage('BITRONIC2_T_IBLOCK_VOTES_COUNT')?>
		<span itemprop="ratingCount reviewCount" class='review-number'><?=$votesCount?></span>)
		<?
		/* TODO
		(<span class="positive">+5</span>/<span class="negative">-3</span>)
		*/
		?>
	</span>
</div><!-- /.info.rating -->