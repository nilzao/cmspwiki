<pre><?php
if (empty($_GET)){
	?>
	Dados do mysql:<br/>
	<form method="get">
	host<input type="text" name="host" value="localhost"><br/>
	database<input type="text" name="database" value="cmsp_db"><br/>
	user<input type="text" name="user" value="root"><br/>
	passwd<input type="password" name="passwd"><br/>
	<input type="submit" value="Go!">
	</form>
	<?php 
} else {
	//conecta no banco
	$conn = mysql_connect($_GET['host'],$_GET['user'],$_GET['passwd']);
	mysql_select_db($_GET['database'],$conn);
	
	//varrendo xmls, montando query e inserindo dados:

/*	// funcionarios da camara (ok)
	
	$xmlObj = simplexml_load_file('http://www2.camara.sp.gov.br/funcionarios/CMSP-XML-Funcionarios.xml');
	foreach ($xmlObj->Funcionario as $funcionario) {
		$query = "INSERT 
		INTO funcionario 
		(nome,cargo,centro_custo) 
		VALUES ('".(string) $funcionario->Nome_Servidor."',
				'".(string) $funcionario->Descricao_Cargo."',
				'".(string) $funcionario->Centro_de_Custos."')";
		mysql_query($query,$conn);
	}
	
*/
	 // vereadores (ok)
/*
	$xmlObj = simplexml_load_file('http://www2.camara.sp.gov.br/SIP/BaixarXML.aspx?arquivo=Presencas_2012_05_10_[0].xml');
	foreach ($xmlObj->Presencas->Vereador as $vereador) {
		$query = "INSERT
			INTO parlamentar 
			(id_interno,nome,nome_despesa_gabinete,partido) 
			VALUES ('".(string) $vereador['IDParlamentar']."',
					'".(string) $vereador['NomeParlamentar']."',
					'".(string) $vereador['NomeParlamentar']."',
					'".(string) $vereador['Partido']."')";
		mysql_query($query,$conn) or print (mysql_error());
	}
*/
/*	
	// gabinetes (ok)
	$fHandle = fopen('gabinete.csv', 'r');
	while (($arrayCsv = fgetcsv($fHandle,0,';','"')) !== FALSE) {
		$rs = mysql_query("SELECT * FROM parlamentar WHERE nome = '".$arrayCsv[1]."'");
		$sqlArray = mysql_fetch_array($rs);
		$query = "INSERT INTO gabinete 
		(num_ordem,id_parlamentar,partido)
		VALUES ('".$arrayCsv[0]."','".$sqlArray['id']."','".$arrayCsv[3]."')";
		mysql_query($query);
	}
*/
	
	// despesas por gabinete
	$arrayUrl = array();
	
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200904.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200905.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200906.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200907.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200908.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200909.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200910.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200911.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200912.xml';
	
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201001.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201002.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201003.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201004.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201005.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201006.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201007.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201008.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201009.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201010.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201011.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201012.xml';
	
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201101.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201102.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201103.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201104.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201105.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201106.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201107.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201108.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201109.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201110.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201111.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201112.xml';

	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201201.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201202.xml';

	foreach($arrayUrl as $url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->LIST_G_DEPUTADO->G_DEPUTADO as $g_vereador) {
			
			$rs = mysql_query("SELECT * FROM parlamentar WHERE nome_despesa_gabinete = '".$g_vereador->NM_DEPUTADO."'");
			$sqlArray = mysql_fetch_array($rs);
			$id_parlamentar = $sqlArray['id'];
			
			foreach($g_vereador->LIST_G_TIPO_DESPESA->G_TIPO_DESPESA as $g_tipo_despesa) {
				if (!substr_count($g_tipo_despesa->NM_TIPO_DESPESA, 'TOTAL') > 0 ) {
					$query = "SELECT * FROM despesatipo 
					WHERE descricao = '".$g_tipo_despesa->NM_TIPO_DESPESA."'";	
					$rsTipoDespesa = mysql_query($query,$conn) or print(mysql_error());
					if ($sqlArray = mysql_fetch_array($rsTipoDespesa)){
						$id_tipo_desp = $sqlArray['id'];
					} else {
						$query = "INSERT INTO despesatipo (descricao) VALUES ('".$g_tipo_despesa->NM_TIPO_DESPESA."')";
						mysql_query($query,$conn);
						$id_tipo_desp = mysql_insert_id($conn);
					}			
					$g_total_temp = 0;
						foreach($g_tipo_despesa->LIST_G_BENEFICIARIO->G_BENEFICIARIO as $g_beneficiario){
							$g_total_temp += $g_beneficiario->VL_DESP;
					}
					$query = "INSERT INTO despesa 
					(parlamentar_id,despesatipo_id,mes,ano,valor)
					VALUES('".$id_parlamentar."',
						   '".$id_tipo_desp."',
						   '".$g_tipo_despesa->NR_MES_REF."',
						   '".$g_tipo_despesa->NR_ANO_REF."',
						   '".$g_total_temp."')";
					if($id_parlamentar != 0){
						mysql_query($query,$conn) or print(mysql_error()."\n");
					}
				}		
			}
		}
	}
	
	
	// xml 2009 até março porco, em outro formato, fazer outro xgh
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200901.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200902.xml';
	$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200903.xml';

	foreach($arrayUrl as $url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->LIST_G_DEPUTADO->G_DEPUTADO as $g_vereador) {
			$rs = mysql_query("SELECT * FROM parlamentar WHERE nome_despesa_gabinete = '".$g_vereador->NM_DEPUTADO."'");
			$sqlArray = mysql_fetch_array($rs);
			$id_parlamentar = $sqlArray['id'];
			foreach ($g_vereador->LIST_G_TIPO_DESPESA->G_TIPO_DESPESA as $g_tipo_despesa){
				if (!substr_count($g_tipo_despesa->NM_TIPO_DESPESA, 'TOTAL') > 0 ) {
					$query = "SELECT * FROM despesatipo
										WHERE descricao = '".$g_tipo_despesa->NM_TIPO_DESPESA."'";	
					$rsTipoDespesa = mysql_query($query,$conn) or print(mysql_error());
					if ($sqlArray = mysql_fetch_array($rsTipoDespesa)){
						$id_tipo_desp = $sqlArray['id'];
					} else {
						$query = "INSERT INTO despesatipo (descricao) VALUES ('".$g_tipo_despesa->NM_TIPO_DESPESA."')";
						mysql_query($query,$conn);
						$id_tipo_desp = mysql_insert_id($conn);
					}
					$query = "INSERT INTO despesa
										(parlamentar_id,despesatipo_id,mes,ano,valor)
										VALUES('".$id_parlamentar."',
											   '".$id_tipo_desp."',
											   '".$g_tipo_despesa->NR_MES_REF."',
											   '".$g_tipo_despesa->NR_ANO_REF."',
											   '".$g_tipo_despesa->VL_DESP."')";
					if($id_parlamentar != 0){
						mysql_query($query,$conn) or print(mysql_error()."\n");
					}
				}
			}
		}
	}
	mysql_close($conn);
}
?>
</pre>
