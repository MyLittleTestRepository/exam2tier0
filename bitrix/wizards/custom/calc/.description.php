<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

$arWizardDescription['NAME'] = Loc::getMessage("NAME");
$arWizardDescription['DESCRIPTION'] = Loc::getMessage("DESC");
$arWizardDescription['VERSION'] = '1.0.0';
$arWizardDescription['STEPS'] = ['SelectOperation', 'InputFirstOperand', 'InputSecondOperand', 'PreResult', 'Result'];