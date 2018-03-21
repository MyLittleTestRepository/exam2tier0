<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
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

//Собираем массив айдишников товаров
$arID = array();
foreach ($arResult['ITEMS'] as $arItem)
	$arID[] = $arItem['PROPERTIES']['LINK']['VALUE'];


//Настраиваем фильтры
$arFilter = array("IBLOCK_ID" => IBCLOCK_CAT_ID,
                  "ACTIVE"    => "Y",
                  "ID"        => $arID);

//Настраиваем выборку
//$arSelectFields=array();
$arSelectFields = array("IBLOCK_ID",
                        "ID",
                        "NAME",
                        "DETAIL_PAGE_URL",
                        "DETAIL_PICTURE",
                        "PROPERTY_PRICE",
                        "PROPERTY_PRICECURRENCY");

//запрашиваем данные из таблицы
$BDRes = CIBlockElement::GetList('', $arFilter, '', '', $arSelectFields);

//разбираем ответ
while ($arRes = $BDRes->GetNextElement('', false))
{
	//собираем подмассив элемента в arResult
	//пишем напрямую в arResult
	//отражаем раздел arResult для текущего элемента на временный идентификатор
	$arTemp =& $arResult['CATALOG'][$arRes->fields['ID']];

	//копируем поля элемента
	$arTemp = $arRes->fields;

	//копируем нужные свойства
	$arProps = $arRes->GetProperties();
	foreach ($arProps as $key => $prop)
	{
		$arTemp['PROPERTIES'][$key]['NAME'] = $prop['NAME'];
		$arTemp['PROPERTIES'][$key]['VALUE'] = $prop['VALUE'];
	}

	//сжимаем картинку
	$arSize["width"] = $arParams["PREVIEW_PIC_W"];
	$arSize["height"] = $arParams["PREVIEW_PIC_H"];
	$file = CFile::GetFileArray($arTemp['DETAIL_PICTURE']);
	$arTemp['PREVIEW_PICTURE']['SRC'] = CFile::ResizeImageGet($file, $arSize)['src'];
}

//кэшируем результат
$this->__component->setResultCacheKeys(['CATALOG']);
?>