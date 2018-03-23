<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die(); ?>
<?
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

foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] = number_format($arItem['PRICES']['PRICE']['PRINT_VALUE'], 0, '.', ' ');
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] .= ' ' . $arItem['PROPERTIES']['PRICECURRENCY']['VALUE_ENUM'];

	$arResult['ITEMS'][$key] = $arItem;
}

{
	//Настраиваем фильтры
	$arFilter = array("IBLOCK_ID" => $arParams['IBLOCK_ID'],
	                  "ACTIVE"    => "Y");
	if ($arParams["SECTION_ID"])
		$arFilter["SECTION_ID"] = $arParams["SECTION_ID"];

	//Настраиваем группировку
	$arGroupBy = array("PROPERTY_MATERIAL");

	//запрашиваем данные из таблицы
	$BDRes = CIBlockElement::GetList('', $arFilter, $arGroupBy);
	while ($Item = $BDRes->GetNext('', false))
		$arResult['SECTION_MATERIALS'][$Item['PROPERTY_MATERIAL_VALUE']] = $Item['CNT'];
}
?>