<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

//form list
if (!CModule::IncludeModule('form'))
	return;
$arFormsId = [];
$rsForms = CForm::GetList($by = "s_id", $order = "asc", [], $is_filtered);
while ($arForm = $rsForms->GetNext('', false))
{
	$arFormsId[$arForm['ID']] = '[' . $arForm['ID'] . '] ' . $arForm['NAME'];
}

$arParameters = [];
$arParameters['PARAMETERS']['FORM_ID'] = ["PARENT"  => "BASE",
                                          "NAME"    => GetMessage("FORM_ID"),
                                          "TYPE"    => "LIST",
                                          "VALUES"  => $arFormsId,
                                          "DEFAULT" => "1",
                                          "REFRESH" => "Y"];
$arParameters['USER_PARAMETERS']['URL_TEMPLATE'] = ["PARENT"  => "BASE",
                                                    "NAME"    => GetMessage("URL_TEMPLATE"),
                                                    "TYPE"    => "STRING",
                                                   "DEFAULT" => ''];
?>