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

//ЧПУ
$arDefaultUrlTemplates404 = ["vacancies" => "",
                             "vacancy"   => "#ELEMENT_ID#/",
                             "resume"    => "#ELEMENT_ID#/resume/",];

$arDefaultVariableAliases = ['ELEMENT_ID' => 'id'];

$arComponentVariables = ["ELEMENT_ID", "resume"];

if ($arParams["SEF_MODE"] == "Y")
{
	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404,
	                                                              $arParams["SEF_URL_TEMPLATES"]);

	$arVariables = array();

	$componentPage = CComponentEngine::ParseComponentPath($arParams["SEF_FOLDER"],
	                                                      $arUrlTemplates,
	                                                      $arVariables);

	if (!$componentPage)
	{
		$componentPage = "vacancies";
	}

	$arResult = array("FOLDER"        => $arParams["SEF_FOLDER"],
	                  "URL_TEMPLATES" => $arUrlTemplates,
	                  "VARIABLES"     => $arVariables);

}
else
{
	$arVariables = [];

	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases,
	                                                                    $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	if (isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
	{
		$componentPage = "vacancy";
		if (isset($arVariables["resume"]))
			$componentPage = "resume";
	}
	else
		$componentPage = "vacancies";


	$arResult = array("FOLDER"        => "",
	                  "URL_TEMPLATES" => Array("vacancies" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
	                                           "vacancy"   => htmlspecialcharsbx($APPLICATION->GetCurPage()
	                                                                             . '?'
	                                                                             . $arVariableAliases["ELEMENT_ID"]
	                                                                             . "=#ELEMENT_ID#"),
	                                           "resume"    => htmlspecialcharsbx($APPLICATION->GetCurPage()
	                                                                             . '?'
	                                                                             . $arVariableAliases["ELEMENT_ID"]
	                                                                             . "=#ELEMENT_ID#&resume"),),
	                  "VARIABLES"     => $arVariables,);
}

//start arParams execute
if (!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if (empty($arParams["IBLOCK_TYPE"]))
	$arParams["IBLOCK_TYPE"] = "vacancies";

$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$this->includeComponentTemplate($componentPage);