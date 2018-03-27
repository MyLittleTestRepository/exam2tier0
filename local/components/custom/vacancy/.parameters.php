<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if (!CModule::IncludeModule('iblock'))
	return;
if (!CModule::IncludeModule('form'))
	return;

$arIblockTypes = CIBlockParameters::GetIBlockTypes();

$arIblockIds = [];
if (isset($arCurrentValues['IBLOCK_TYPE']))
{
	$DbRes = CIBlock::GetList('', ["TYPE" => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y']);
	while ($iblock = $DbRes->Fetch())
	{
		$arIblockIds[$iblock['ID']] = '[' . $iblock['ID'] . '] ' . $iblock['NAME'];
	}
}

$arFormIds = [];
$rsForms = CForm::GetList($by = "s_id", $order = "asc", [], $is_filtered);
while ($arForm = $rsForms->GetNext('', false))
{
	$arFormIds[$arForm['ID']] = '[' . $arForm['ID'] . '] ' . $arForm['NAME'];
}

$arComponentParameters = ['GROUPS'     => ["BASE" => ["NAME" => GetMessage('BASE'),
                                                      "SORT" => "10",]],
                          'PARAMETERS' => ["IBLOCK_TYPE" => ["PARENT"  => "BASE",
                                                             "NAME"    => GetMessage('IBLOCK_TYPE'),
                                                             "TYPE"    => "LIST",
                                                             "REFRESH" => "Y",
                                                             "VALUES"  => $arIblockTypes,],
                                           "IBLOCK_ID"   => ["PARENT" => "BASE",
                                                             "NAME"   => GetMessage('IBLOCK_ID'),
                                                             "TYPE"   => "LIST",
                                                             "VALUES" => $arIblockIds,],
                                           "FORM_ID"     => ["PARENT" => "BASE",
                                                             "NAME"   => GetMessage('FORM_ID'),
                                                             "TYPE"   => "LIST",
                                                             "VALUES" => $arFormIds,],
                                           "CACHE_TIME"  => ["DEFAULT" => 36000000],
                                           "SEF_MODE"    => ["vacancies" => ["NAME"      => GetMessage("VACANCIES"),
                                                                             "DEFAULT"   => "",
                                                                             "VARIABLES" => [],],
                                                             "vacancy"   => ["NAME"      => GetMessage("VACANCY"),
                                                                             "DEFAULT"   => "#ELEMENT_ID#/",
                                                                             "VARIABLES" => ["ELEMENT_ID"],],
                                                             "resume"    => ["NAME"      => GetMessage("RESUME"),
                                                                             "DEFAULT"   => "#ELEMENT_ID#/resume/",
                                                                             "VARIABLES" => ["ELEMENT_ID"],],],]

];
?>