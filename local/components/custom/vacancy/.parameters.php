<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if (!CModule::IncludeModule('iblock'))
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
                                           "CACHE_TIME"  => ["DEFAULT" => 36000000]]

];
?>