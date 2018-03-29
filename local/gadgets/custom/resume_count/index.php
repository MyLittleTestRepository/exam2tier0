<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arGadgetParams */

///////////////// ошибки

if (!CModule::IncludeModule("form"))
{
	ShowError(GetMessage('MODULE_NOT_FOUND'));
	return true;
}

if (!$arGadgetParams)
{
	ShowError(GetMessage("NO_SETTINGS"));
	return;
}

if (!$arGadgetParams['FORM_ID'])
{
	ShowError(GetMessage('NO_FORM'));
	return true;
}

////////////////// переменные

const CacheLife = 60 * 30; //время жизни кэша 30 минут
const DefHrefRoot = '/bitrix/admin/form_result_list.php?WEB_FORM_ID=#FORM_ID#';
const defHrefDay
= '&set_filter=Y&find_date_create_1_FILTER_PERIOD=day'
  . '&find_date_create_1_FILTER_DIRECTION=current'
  . '&find_date_create_1=#CUR_DATE#&find_date_create_2=#CUR_DATE#';
const defHrefAll = '&del_filter=Y';
const CacheDir = "/resume_count";

$countDay = null;
$countAll = null;
$hrefDay = null;
$hrefAll = null;

$currentDate = ConvertTimeStamp();
$cacheID = $arGadgetParams['FORM_ID'] . $arGadgetParams['URL_TEMPLATE'] . $currentDate;

$obCache = new CPageCache();

////////////////////// логика

if ($obCache->StartDataCache(CacheLife, $cacheID, CacheDir)) //начинаем кэширование
{
	$countAll = CFormResult::GetCount($arGadgetParams['FORM_ID']); //количество резюме в базе

	$Res = CFormResult::GetList($arGadgetParams['FORM_ID'], //запрашиваем свежие резюме из базы
	                            $by = "s_date_create",
	                            $order = "desc",
	                            $filter = ['DATE_CREATE_1' => $currentDate,
	                                       'DATE_CREATE_2' => $currentDate],
	                            $is_filtered,
	                            $check_rights = "Y");

	$countDay = $Res->SelectedRowsCount(); //количество свежих резюме

	if ($arGadgetParams['URL_TEMPLATE']) //устанавливаем url адреса для ссылок
	{
		$hrefDay = $arGadgetParams['URL_TEMPLATE'];
		$hrefAll = $arGadgetParams['URL_TEMPLATE'] . defHrefAll;
	}
	else
	{
		$arKeys = ['#CUR_DATE#', '#FORM_ID#'];
		$arRepl = [$currentDate, $arGadgetParams['FORM_ID']];
		$hrefDay = str_replace($arKeys, $arRepl, DefHrefRoot . defHrefDay);
		$hrefAll = str_replace($arKeys, $arRepl, DefHrefRoot . defHrefAll);
	}

	////////////////////////////////////////////// выводим шаблон страницы

	?>
    <p><?= GetMessage("REGISTERED") ?></p>
    <p><?= GetMessage("DAY") ?><a href="<?= $hrefDay ?>"><?= $countDay ?></a></p>
    <p><?= GetMessage("ALL") ?><a href="<?= $hrefAll ?>"><?= $countAll ?></a></p>
	<?

	//////////////////////////////////////////// закрываем кэш
	$obCache->EndDataCache();
}