<?php
/** @var array $arParams */
/** @var array $arResult */
/** @var string $templateFolder */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
$APPLICATION->AddHeadScript($templateFolder.'/include/jquery-1.8.2.min.js');
$APPLICATION->AddHeadScript($templateFolder.'/include/slides.min.jquery.js');
$APPLICATION->SetAdditionalCSS($templateFolder.'/include/style.css');
//var_dump($arResult['CATALOG']);
?>