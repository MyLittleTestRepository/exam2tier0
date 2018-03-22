<?
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("LocalEHandler", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("LocalEHandler", "OnBeforeIBlockElementDeleteHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", Array("LocalEHandler", "OnBeforeUserUpdateHandler"));

class LocalEHandler
{
	function OnBeforeIBlockElementUpdateHandler(&$arFields)
	{
		if ($arFields['IBLOCK_ID'] == INIT_CONST['IB_NEWS_ID']) //if news
		{
			if ($arFields['ACTIVE'] == 'N') //if deactivate
			{
				$arElFields = CIBlockElement::GetByID($arFields['ID'])->Fetch();
				if ($arElFields['ACTIVE'] == 'Y') //if activated
				{
					$time = mktime(0, 0, 0, date('m'), date('d') - 3);
					if ($arElFields['DATE_CREATE_UNIX'] > $time) //if < 3 day old
					{
						$GLOBALS['APPLICATION']->throwException("Вы деактивировали свежую
новость");
						return false;
					}
				}
			}
		}
	} //cancel deactivate new news

	function OnBeforeIBlockElementDeleteHandler($ID)
	{
		$arFields = CIBlockElement::GetByID($ID)->Fetch();
		if ($arFields['IBLOCK_ID'] == INIT_CONST['IB_CAT_ID']) //if catalog
		{
			if ($arFields['SHOW_COUNTER'] > 1 and $arFields['ACTIVE'] == 'Y') //if popular and active
			{
				//deactivate
				$arNewFields = ['ACTIVE' => 'N'];
				if (count($arFields['PROPERTY_VALUES']))//save properties
				{
					$arNewFields['PROPERTY_VALUES'] = $arFields['PROPERTY_VALUES'];
				}

				(new CIBlockElement())->Update($ID, $arNewFields); //update
				$GLOBALS['DB']->Commit(); //commit

				//throw
				$GLOBALS['APPLICATION']->throwException("Товар деактивирован. Количество просмотров: "
				                                        . $arFields['SHOW_COUNTER']);
				return false;
			}
		}
	} //cancel delete popular active product, but can delete popular inactive product!!!

	function OnBeforeUserUpdateHandler(&$arFields)
	{
		$arGroups = [];
		foreach ($arFields['GROUP_ID'] as $group)
			$arGroups[] = $group['GROUP_ID'];

		if (in_array(INIT_CONST['G_CONT_ED_ID'], $arGroups)) //if content editor
		{
			$arGroupUsersIds = CGroup::GetGroupUser(INIT_CONST['G_CONT_ED_ID']);

			if (!in_array($arFields['ID'], $arGroupUsersIds)) //if not in group
			{
				//get emails
				$emails = [];
				foreach ($arGroupUsersIds as $userId)
					$emails[] = CUser::GetByID($userId)->Fetch()['EMAIL'];

				//send emails
				if (count($emails))
				{
					$arEventFields = array("EMAIL_TO"       => implode(",", $emails),
					                       "NEW_USER_LOGIN" => $arFields['LOGIN'],
					                       "NEW_USER_EMAIL" => $arFields['EMAIL'],
					                       "COUNT"          => count($emails) + 1,);
					CEvent::Send("NEW_CONTENT_EDITOR", SITE_ID, $arEventFields);
				}

			}
		}
	} //new content editor
}

?>