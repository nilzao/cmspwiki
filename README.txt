A ferramenta CMSPWiki, criada durante a 1° Hackathon - Desafio de dados abertos 
da Maratona hacker da Câmara Municipal de São Paulo em 12/05/2012.

De acordo com a Lei nº 12.527, de 18 de Novembro de 2011 - 
Lei geral de acesso à informação pública, a Câmara Municipal de São Paulo 
disponibilizou acesso a arquivos no formato XML, sobre os orçamentos da câmara 
e dos gabinetes, votações em sessões ordinárias e extraordinárias, tramitação 
dos projetos, relação de funcionários.

A proposta do CMSPWiki é tratar esses arquivos XML, wikificando os dados disponíveis, 
possibilitando um resumo das informações.

Tornando mais acessíveis e compreensíveis a população em geral que já está 
familiarizada com esse formato.

Para cumprimento do disposto na Lei nº 12.527, de 18 de novembro de 2011, os órgãos 
e entidades públicas deverão utilizar todos os meios e instrumentos legítimos de que 
dispuserem, sendo obrigatória a divulgação em sítios oficiais da rede mundial de 
computadores (internet). Os sítios deverão, na forma de regulamento, atender, entre 
outros, aos seguintes requisitos do parágrafo 2:

I - conter ferramenta de pesquisa de conteúdo que permita o acesso à informação de 
forma objetiva, transparente, clara e em linguagem de fácil compreensão;

II - possibilitar a gravação de relatórios em diversos formatos eletrônicos, inclusive 
abertos e não proprietários, tais como planilhas e texto, de modo a facilitar a análise 
das informações;

III - possibilitar o acesso automatizado por sistemas externos em formatos abertos, 
estruturados e legíveis por máquina;

IV - divulgar em detalhes os formatos utilizados para estruturação da informação;

V - garantir a autenticidade e a integridade das informações disponíveis para acesso;

VI - manter atualizadas as informações disponíveis para acesso;

VII - indicar local e instruções que permitam ao interessado comunicar-se, por via 
eletrônica ou telefônica, com o órgão ou entidade detentora do sítio; e

VIII - adotar as medidas necessárias para garantir a acessibilidade de conteúdo para 
pessoas com deficiência, nos termos do art. 17 da Lei no 10.098, de 19 de dezembro de 
2000, e do art. 9o da Convenção sobre os Direitos das Pessoas com Deficiência, aprovada 
pelo Decreto Legislativo no 186, de 9 de julho de 2008.

===================================================================================
Feito em Php, utilizando o banco de dados MySql.

O sistema é dividido em 3 etapas:
importador, exportador, publicador.

O importador normaliza os xmls e txts disponibilizados em uma base mysql relacional.
A normalização é muito importante, pois corrige muitas inconsistências encontradas
nos arquivos disponibilizados pela Câmara Municipal de São Paulo.
Esta foi a etapa mais difícil de concluir, pois os xmls e txts possuem formatos
distintos, vindo de bases de dados de sistemas diferentes sem cruzamento de informação. 
A carga inicial deste processo pode demorar algumas horas, gerando aproximadamente
500 mil registros. (atendendo o ítem VI do § 2 
da Lei geral de acesso à informação pública).

O exportador extrai os dados da base mysql relacional, publicando arquivos
no formato aberto json, que podem ser utilizados por outros desenvolvedores de forma
mais simples do que os xmls e txts disponibilizados (atendendo os ítens II e III do § 2 
da Lei geral de acesso à informação pública).

O publicador, interpreta or arquivos gerados no formato json, trata o conteúdo
gerando o formato wiki, e publica em um sistema mediawiki especificado (atendendo os
ítens I, IV, V, VII e VIII do § 2 da Lei geral de acesso à informação pública).

===================================================================================

como utilizar:

importador:
1- criar a base de dados mysql, importar estrutura do banco cmsptmp.sql
2- editar arquivo app/importer/lib/Config.php com dados de usuario, senha, host e nome do banco
3- rodar o importador no console: 
	  "php index.php importer"
   ou rodar no navegador (provavel timeout):
	  index.php?a=importer

exportador:
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


===================================================================================
Lista de pendências

Caso este projeto seja vencedor do 1° Hackathon CMSP Dados Abertos 2012
e utilizado oficialmente na Câmara Municipal de São Paulo

- Exigência de formatos e consistência nos arquivos xml e txt disponibilizados pela CMSP.
- Melhorias no desempenho do importador, fazer importador incremental.
- Refatoração de classes do sistema
- Envolver as classes refaturadas com classes de teste utilizando a metodologia tdd.
- Documentação Uml do sistema
- Generalizar o sistema para todos órgãos públicos enquadrados na Lei geral de acesso
  à informação pública
- Criação do wiki central http://www.transparenciawiki.com.br ou .org.br ou .gov.br
- Implementar autenticação do robô publicador no Wiki, para configurar dados não editáveis
  por humanos.
- Padronizar e melhorar os dados gerados wikificados pelo publicador.
