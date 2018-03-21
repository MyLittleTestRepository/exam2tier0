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
$this->setFrameMode(true);
?>
    <script>
        $().ready(function () {
            $(function () {
                $('#slides').slides({
                    preload: false,
                    generateNextPrev: false,
                    autoHeight: true,
                    play: 4000,
                    effect: 'fade'
                });
            });
        });
    </script>
    <div class="sl_slider" id="slides">
        <div class="slides_container">
			<? foreach ($arResult["ITEMS"] as $arItem): ?>
				<?
				$this->AddEditAction($arItem['ID'],
				                     $arItem['EDIT_LINK'],
				                     CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'],
				                       $arItem['DELETE_LINK'],
				                       CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
				                       array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
                <div id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div>
                    <a>
                        <a href="<?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["DETAIL_PAGE_URL"]
                        ?>" title="<?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["NAME"] ?> "><img
                                    src="<?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["PREVIEW_PICTURE"]["SRC"] ?>" alt=""/></a>
                        <h2><a href="<?= $arItem["PROPERTIES"]['LINK']['VALUE'] ?>" title="<?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["NAME"] ?> "><? echo $arItem["NAME"]
                                ?></a></h2>
                        <?if(false):?><p><?=$arItem["PREVIEW_TEXT"]?></p><?endif;?>
                        <p><?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["NAME"] ?> всего
                            за <?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["PROPERTY_PRICE_VALUE"] ?> <?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["PROPERTY_PRICECURRENCY_VALUE"] ?></p>
                        <a href="<?= $arResult["CATALOG"][$arItem["PROPERTIES"]["LINK"]["VALUE"]]["DETAIL_PAGE_URL"] ?>" class="sl_more">Подробнее
                            &rarr;</a>
                    </div>
                </div>
			<? endforeach; ?>
        </div>
    </div>