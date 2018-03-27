<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die(); ?>
<? /** @var array $arParams */
if (!CModule::IncludeModule('iblock'))
	return;?>
<? $APPLICATION->IncludeComponent("bitrix:form.result.new",
                                  "",
                                  Array('VACANT_ID'   => $arResult["VARIABLES"]["ELEMENT_ID"],
                                        "VACANT_NAME"                 => CIBlockElement::GetByID($arResult["VARIABLES"]["ELEMENT_ID"])->GetNext('',false)['NAME'],
                                        "CACHE_TIME"  => $arParams['CACHE_TIME'],
                                        "CACHE_TYPE"  => $arParams['CACHE_TYPE'],
                                        "SUCCESS_URL" => CIBlock::ReplaceDetailUrl($arResult["FOLDER"]
                                                                                   . $arResult["URL_TEMPLATES"]["vacancies"],
                                                                                   $arResult['VARIABLES']),
                                        'LIST_URL'=> CIBlock::ReplaceDetailUrl($arResult["FOLDER"]
                                                                              . $arResult["URL_TEMPLATES"]["vacancies"],
                                                                              $arResult['VARIABLES']),
                                        "WEB_FORM_ID" => $arParams['FORM_ID']),
                                  $component); ?>
