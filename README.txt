como utilizar:

importador:
1- criar a base de dados mysql, importar estrutura do banco cmsptmp.sql
2- editar arquivo app/importer/lib/Config.php com dados de usuario, senha, host e nome do banco
3- rodar o importador no console: 
	  "php index.php importer"
   ou rodar no navegador (provavel timeout):
	  index.php?a=importer

exporador;
1- dar permissões de escrita ao diretório ./dadosJson
2- rodar o exportador no console:
		"php index.php exporter"
	ou rodar no navegador (provavel timeout):
		index.php?a=exporter 

publicador:
1- editar o arquivo app/publisher/lib/Config.php com endereço raiz do wiki
2- rodar o publicador no console:
		"php index.php publisher"
	ou rodar no navegador (provavel timeout):
		index.php?a=publisher

exemplo de wiki com os dados gerados dentro das 48h do 1o Hackaton desafiodadosabertos.org:

http://www.capitalphp.com.br/wiki
