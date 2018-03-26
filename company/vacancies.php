<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
?><?$APPLICATION->IncludeComponent("custom:list.vacancy", "vacancy", Array(
	"IBLOCK_ID" => "4",	// Инфоблок
		"IBLOCK_TYPE" => "vacancies",	// Тип инфоблока
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>