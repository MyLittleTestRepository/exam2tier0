<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

class SelectOperation extends CWizardStep
{
	function InitStep()
	{
		$this->SetStepID('SelectOperation');
		$this->SetTitle(Loc::getMessage("SUBTITLE_SELECT"));
		$this->SetNextStep('InputFirstOperand');
		$this->GetWizard()->SetDefaultVar('operation', 'add');
	}

	function ShowStep()
	{
		$arOps['add'] = Loc::getMessage("OP_ADD");
		$arOps['sub'] = Loc::getMessage("OP_SUB");
		$arOps['mul'] = Loc::getMessage("OP_MUL");
		$arOps['div'] = Loc::getMessage("OP_DIV");
		$this->content = $this->ShowSelectField('operation', $arOps);
	}
}

class InputFirstOperand extends CWizardStep
{
	function InitStep()
	{
		$this->SetStepID('InputFirstOperand');
		$this->SetTitle(Loc::getMessage("SUBTITLE_OP1"));
		$this->SetPrevStep('SelectOperation');
		$this->SetNextStep('InputSecondOperand');
		$this->GetWizard()->SetDefaultVar('op1', 2);
	}

	function ShowStep()
	{
		$this->content = $this->ShowInputField('text', 'op1');
	}

	function OnPostForm()
	{
		if (!is_numeric($this->GetWizard()->GetVar('op1')))
			$this->SetError(Loc::getMessage("NEED_NUM"));
	}
}

class InputSecondOperand extends CWizardStep
{
	function InitStep()
	{
		$this->SetStepID('InputSecondOperand');
		$this->SetTitle(Loc::getMessage("SUBTITLE_OP2"));
		$this->SetPrevStep('InputFirstOperand');
		$this->SetNextStep('PreResult');
		$this->GetWizard()->SetDefaultVar('op2', 3);
	}

	function ShowStep()
	{
		$this->content = $this->ShowInputField('text', 'op2');
	}

	function OnPostForm()
	{
		if (!is_numeric($this->GetWizard()->GetVar('op2')))
			$this->SetError(Loc::getMessage("NEED_NUM"));
	}
}

class PreResult extends CWizardStep
{
	function InitStep()
	{
		$this->SetStepID('PreResult');
		$this->SetTitle(Loc::getMessage("SUBTITLE_CHECK"));
		$this->SetPrevStep('InputSecondOperand');
		$this->SetNextStep('Result');
	}

	function ShowStep()
	{
		$wiz =& $this->GetWizard();
		$this->content = $wiz->GetVar('op1') . ' ';
		switch ($wiz->GetVar('operation'))
		{
			case 'add':
				$this->content .= '+';
				break;
			case 'sub':
				$this->content .= '-';
				break;
			case 'mul':
				$this->content .= '*';
				break;
			case 'div':
				$this->content .= '/';
				break;
		}

		$this->content .= ' ' . $wiz->GetVar('op2') . ' = ';
		$wiz->SetVar('resultContent', $this->content); //save
		$this->content .= '???';
	}

	function OnPostForm()
	{
		$wiz =& $this->GetWizard();
		if ($wiz->GetVar('operation') == 'div' and !$wiz->GetVar('op2'))
			$this->SetError(Loc::getMessage("DIV_BY_ZERO"));
	}
}

class Result extends CWizardStep
{
	function InitStep()
	{
		$this->SetStepID('Result');
		$this->SetTitle(Loc::getMessage("SUBTITLE_RESULT"));
		$this->SetCancelStep('Result');
		$this->SetCancelCaption(Loc::getMessage("END"));
	}

	function ShowStep()
	{
		$wiz =& $this->GetWizard();

		$this->content = $wiz->GetVar('resultContent');
		$op1 = $wiz->GetVar('op1');
		$op2 = $wiz->GetVar('op2');

		switch ($wiz->GetVar('operation'))
		{
			case 'add':
				$this->content .= $op1 + $op2;
				break;
			case 'sub':
				$this->content .= $op1 - $op2;
				break;
			case 'mul':
				$this->content .= $op1 * $op2;
				break;
			case 'div':
				$this->content .= $op1 / $op2;
				break;
		}

		if (!$wiz->IsCancelButtonClick())
			CEventLog::Add(["SEVERITY"      => "SECURITY",
			                "AUDIT_TYPE_ID" => "WIZ_CALC",
			                "MODULE_ID"     => "main",
			                "ITEM_ID"       => '',
			                "DESCRIPTION"   => $this->content]);
	}
}