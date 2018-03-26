<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */
$id = 0;
$this->setFrameMode(true);
?>
<ul>
	<? foreach ($arResult['SECTIONS'] as $section): ?>
        <li>
			<? $id++ ?>
            <input class="hide" id="hd-<?= $id ?>" type="checkbox">
            <label for="hd-<?= $id ?>"><?= $section['NAME'] ?></label>
            <div>
                <ul>
					<? foreach ($section['ITEMS'] as $itemId): ?>
						<?
						$this->AddEditAction($itemId,
						                     $arResult['ITEMS'][$itemId]['EDIT_LINK'],
						                     CIBlock::GetArrayByID($arResult['ITEMS'][$itemId]["IBLOCK_ID"],
						                                           "ELEMENT_EDIT"));
						$this->AddDeleteAction($itemId,
						                       $arResult['ITEMS'][$itemId]['DELETE_LINK'],
						                       CIBlock::GetArrayByID($arResult['ITEMS'][$itemId]["IBLOCK_ID"], "ELEMENT_DELETE"),
						                       array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
                        <li id="<?=$this->GetEditAreaId($itemId);?>">
                            <a href="<?= $arResult['ITEMS'][$itemId]['DETAIL_PAGE_URL'] ?>"><?= $arResult['ITEMS'][$itemId]['NAME'] ?></a>
                        </li>
					<? endforeach; ?>
                </ul>
            </div>
        </li>
	<? endforeach; ?>
</ul>