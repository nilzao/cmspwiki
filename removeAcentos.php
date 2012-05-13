<?php
function removeAcentos($Msg){
	$search  = array('A', 'B', 'C', 'D', 'E');
	$acentos = array(
	 "[ÂÀÁÄÃ]",
	 "[âãàáä]",
	 "[ÊÈÉË]",
	 "[êèéë]",
	 "[ÎÍÌÏ]",
	 "[îíìï]",
	 "[ÔÕÒÓÖ]",
	 "[ôõòóö]",
	 "[ÛÙÚÜ]",
	 "[ûúùü]",
	 "ç",
	 "Ç");
	$sem_acentos = array(
	 "A",
	 "a",
	 "E",
	 "e",
	 "I",
	 "i",
	 "O",
	 "o",
	 "U",
	 "u",
	 "c",
	 "C");
	return str_replace($acentos, $sem_acentos, $Msg);
}

