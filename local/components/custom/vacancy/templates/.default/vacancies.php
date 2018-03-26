<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die(); ?>
<? /** @var array $arParams */ ?>
<? $APPLICATION->IncludeComponent("custom:list.vacancy",
                                  "href",
                                  Array("IBLOCK_ID"   => $arParams['IBLOCK_ID'],    // Инфоблок
                                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],    // Тип инфоблока
                                  ),
                                  $component); ?>