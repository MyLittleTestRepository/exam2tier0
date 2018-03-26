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
                        <li><?= $arResult['ITEMS'][$itemId]['NAME'] ?></li>
					<? endforeach; ?>
                </ul>
            </div>
        </li>
	<? endforeach; ?>
</ul>