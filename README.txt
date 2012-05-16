como utilizar:

importador:
1- criar a base de dados mysql, importar estrutura do banco cmsptmp.sql.gz
2- editar arquivo app/importer/lib/Config.php com dados de usuario, senha, host e nome do banco
3- rodar os importadores no console na ordem: 
	  1-"php index.php importer Vereadores"
	  2-"php index.php importer Gabinetes"
	  3-"php index.php importer Projetos"
		"php index.php importer ProjetosAutores"
		"php index.php importer Despesas"
		"php index.php importer Funcionarios"
		"php index.php importer MateriasTipo"
		
ou rodar no navegador:
	  1-index.php?a=importer&c=Vereadores
	  2-index.php?a=importer&c=Gabinetes
	  3-index.php?a=importer&c=Projetos
		index.php?a=importer&c=ProjetosAutores
		index.php?a=importer&c=Despesas
		index.php?a=importer&c=Funcionarios
		index.php?a=importer&c=MateriasTipo		

exporador / publicador:
	em desenvolvimento.
	
A proposta final é automatizar com um bot publicador. 

exemplo de wiki com os dados gerados:

http://www.capitalphp.com.br/wiki
