<?
//const
define('INIT_CONST',[
	'IB_CAT_ID'=> 2,
	'IB_ACT_ID'=> 5,
]);

//include file names
$arLocInclude=[
	'old_actions_agent.php',
];

//include logic
localInclude($arLocInclude);
function localInclude($arFileNames){
	foreach ($arFileNames as $fileName){
		$fileName=$_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/".$fileName;
		if (file_exists($fileName))
			include($fileName);
	}
}
?>