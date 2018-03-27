<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die(); ?>
<? /** @var array $arParams */ ?>
<? $tmp=$APPLICATION->IncludeComponent("bitrix:news.detail",
                                  "",
                                  ["CACHE_TIME"                => $arParams['CACHE_TIME'],
                                   "CACHE_TYPE"                => $arParams['CACHE_TYPE'],
                                   "DISPLAY_DATE"              => "Y",
                                   "DISPLAY_NAME"              => "Y",
                                   "DISPLAY_PICTURE"           => "Y",
                                   "DISPLAY_PREVIEW_TEXT"      => "Y",
                                   "ELEMENT_ID"                => $arResult['VARIABLES']['ELEMENT_ID'],
                                   "IBLOCK_ID"                 => $arParams['IBLOCK_ID'],
                                   "IBLOCK_TYPE"               => $arParams['IBLOCK_TYPE'],
                                   "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                                   "SET_BROWSER_TITLE"         => "Y",
                                   "SET_TITLE"                 => "Y",],
                                  $component); ?>
<br/>
<div>
    <a href="<?= CIBlock::ReplaceDetailUrl($arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["resume"],$arResult['VARIABLES']); ?>"
       class="btn btn-warning"><?= GetMessage("ADD_RESUME") ?></a>
</div>