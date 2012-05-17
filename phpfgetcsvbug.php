<?php
/*
 * Delimitador de texto padrão '"' da função fgetcsv em arquivos mal formatados
 * Neste caso, sorte não existir caracteres # dentro dos textos
 * Podendo utilizar 
 *  - explode('#',$string)
 *  - fgetcsv($handle,0,'#',"\x01")
 */
$strFile = "PL#311#03/06/2003#\"XXX'###
PL#312#03/06/2003#\"YYY\"#Lei#13.814#13/05/2004";
file_put_contents('csvbug.txt', $strFile);

//$url = http://www2.camara.sp.gov.br/projetos/projetos.txt
//$url = 'dadosExt/projetos.txt';
$url = 'csvbug.txt';
$handle = fopen($url,'r');
$handle2 = fopen($url,'r');
$handle3 = fopen($url,'r');

$i=0; $i2=0;$i3=0;
while (!feof($handle)) {
	if ($data1 = fgets($handle)) {
		$data1 = explode('#', $data1);
		$i++;
	}
	if ($data2 = fgetcsv($handle2,0,'#',"\x01")) {
		$i2++;
	}
	//inconsistencia ao usar delimitador padrão de texto '"'
	if ($data3 = fgetcsv($handle3,0,'#')) {
		$i3++;
	}
	/*
	if ($data1[0] != $data3[0] 
		|| $data1[1] != $data3[1]
		|| $data1[2] != $data3[2] ){
		echo "\n $i \n===========\n";
		print_r($data1);
		echo "\n-----------\n";
		print_r($data3);
		echo "\n===========\n";
		die();
	}
	*/
}
echo "\n$i - $i2 - $i3\n";
