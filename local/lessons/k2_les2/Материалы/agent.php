<?

function AgentChekPrice()
{
	
	
	if(CModule::IncludeModule("iblock"))
	{
		$arSelect = Array("ID", "NAME", "PROPERTY_PRICE");
		$arFilter = Array("IBLOCK_ID"=> 2, "PROPERTY_PRICE" => false);
		$rsResCat = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		$arItems = array();
		while($arItemCat = $rsResCat->GetNext())
		{
			$arItems[] = $arItemCat;
		}
	
		CEventLog::Add(array(
				"SEVERITY" => "SECURITY",
				"AUDIT_TYPE_ID" => "CHECK_PRICE",
				"MODULE_ID" => "iblock",
				"ITEM_ID" => "",
				"DESCRIPTION" => "Проверка цен, нет цен для ".count($arItems)." элементов",
		));
	
		if(count($arItems) > 0)
		{
			$arFilter = Array(
					"GROUPS_ID" => Array(2)
			);
			$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $arFilter);
			$arEmail = array();
			while($arResUser = $rsUsers->GetNext())
			{
				$arEmail[] = $arResUser["EMAIL"];
			}

			if(count($arEmail) > 0)
			{
				$arEventFields = array(
						"TEXT" => "Проверка цен, нет цен для ".count($arItems)." элементов",
						"EMAIL" => implode(", ", $arEmail),
				);
				CEvent::Send("INFO_PRICE", "s1", $arEventFields);
			}
		}
	}
	
	return "AgentChekPrice();";
}
?>