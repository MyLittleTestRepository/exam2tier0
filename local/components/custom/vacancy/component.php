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

$this->includeComponentTemplate(vacancies);
