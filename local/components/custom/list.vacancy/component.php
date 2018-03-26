<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

//start arParams execute
if (!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if (empty($arParams["IBLOCK_TYPE"]))
	$arParams["IBLOCK_TYPE"] = "vacancies";

$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

//start cache
if ($this->startResultCache())
{

	if (!CModule::IncludeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage('MODULE_NOT_FOUND'));
		return;
	}

	if (!$arParams["IBLOCK_ID"])
	{
		$this->abortResultCache();
		return;
	}

	{
		$arFilter = ["ACTIVE"      => "Y",
		             "IBLOCK_ID"   => $arParams["IBLOCK_ID"],
		             "!SECTION_ID" => false];
		$rsIBlock = CIBlockElement::GetList('', $arFilter);

		while ($item = $rsIBlock->GetNext('', false))
		{
			$arResult['ITEMS'][$item['ID']] = $item;
			$arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['ITEMS'][] = $item['ID'];
		}

		foreach ($arResult['SECTIONS'] as $section_id => $value)
		{
			$arResult['SECTIONS'][$section_id]['NAME'] = CIBlockSection::GetByID($section_id)->Fetch()['NAME'];
		}

	}

	//cache keys
	$this->setResultCacheKeys([]);

	//component template
	$this->includeComponentTemplate();
}