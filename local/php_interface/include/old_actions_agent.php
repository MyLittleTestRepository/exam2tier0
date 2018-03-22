<?
function oldActionCheck()
{
	if (CModule::IncludeModule("iblock"))
	{

		//query
		$arSelect = Array("ID", "NAME", "DATE_ACTIVE_TO");
		$arFilter = Array("IBLOCK_ID" => INIT_CONST['IB_ACT_ID'], "!ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
		$res = CIBlockElement::GetList('', $arFilter, '', '', $arSelect);

		//calc
		$count = 0;
		while ($ob = $res->GetNextElement('', false))
			$count++;


		if ($count)
		{
			//write to log
			CEventLog::Add(array("SEVERITY"      => "SECURITY",
			                     "AUDIT_TYPE_ID" => "OLD_ACTIONS",
			                     "MODULE_ID"     => "iblock",
			                     "ITEM_ID"       => 'iblock:actions',
			                     "DESCRIPTION"   => "Устаревшие, но еще активные акции: " . $count . " шт.",));

			//get groups
			$gid = [];
			$filter = Array("ACTIVE" => "Y",
			                "ADMIN"  => "Y");
			$rsGroups = CGroup::GetList(($by = "id"), ($order = "asc"), $filter);
			while ($group =& $rsGroups->GetNext('', false))
				$gid[] = $group['ID'];

			//get admin list
			$admins = [];
			foreach ($gid as $id)
				$admins = array_merge($admins, CGroup::GetGroupUser($id));

			//get emails
			$emails = [];
			foreach ($admins as $userId)
			{
				$emails[] = CUser::GetByID($userId)->Fetch()['EMAIL'];
			}

			//send emails
			if (count($emails))
			{
				$arEventFields = array("EMAIL_TO" => implode(",", $emails),
				                       "COUNT"    => $count,);
				CEvent::Send("OLD_ACTIONS", SITE_ID, $arEventFields);
			}
		}
	}

	//set next agent
	return "oldActionCheck();";
}

?>