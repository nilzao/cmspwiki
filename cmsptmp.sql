-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 17/05/2012 às 15:31:38
-- Versão do Servidor: 5.5.24-log
-- Versão do PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `cmsptmp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `gabinetes`
--

CREATE TABLE IF NOT EXISTS `gabinetes` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `id_vereador` int(11) NOT NULL,
  `num_gabinete` smallint(2) NOT NULL,
  `ramal` varchar(200) NOT NULL,
  `sala` smallint(6) NOT NULL,
  `fax` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vereador` (`id_vereador`),
  KEY `num_gabinete` (`num_gabinete`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gabinetes_despesas`
--

CREATE TABLE IF NOT EXISTS `gabinetes_despesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vereador` int(11) NOT NULL,
  `id_gabinete_despesa_tipo` smallint(2) NOT NULL,
  `id_gabinete_despesa_empresa` int(11) NOT NULL,
  `mes` smallint(2) NOT NULL,
  `ano` smallint(4) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vereador` (`id_vereador`),
  KEY `id_gabinete_despesa_tipo` (`id_gabinete_despesa_tipo`),
  KEY `id_empresa` (`id_gabinete_despesa_empresa`),
  KEY `mes` (`mes`),
  KEY `ano` (`ano`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27518 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gabinetes_despesas_empresas`
--

CREATE TABLE IF NOT EXISTS `gabinetes_despesas_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(20) NOT NULL,
  `razao_social` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cnpj` (`cnpj`),
  KEY `razao_social` (`razao_social`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1058 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gabinetes_despesas_tipo`
--

CREATE TABLE IF NOT EXISTS `gabinetes_despesas_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gabinetes_funcionarios`
--

CREATE TABLE IF NOT EXISTS `gabinetes_funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gabinete` smallint(2) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cargo` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_gabinete` (`id_gabinete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materias_tipo`
--

CREATE TABLE IF NOT EXISTS `materias_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `abreviacao` varchar(10) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo` (`codigo`),
  KEY `abreviacao` (`abreviacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE IF NOT EXISTS `projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_projeto` varchar(10) NOT NULL,
  `numero_projeto` smallint(6) NOT NULL,
  `data_projeto` date NOT NULL,
  `ementa` text NOT NULL,
  `tipo_norma` varchar(50) DEFAULT NULL,
  `numero_norma` varchar(20) DEFAULT NULL,
  `data_norma` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_projeto` (`tipo_projeto`),
  KEY `numero_projeto` (`numero_projeto`),
  KEY `data_projeto` (`data_projeto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39585 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos_autores`
--

CREATE TABLE IF NOT EXISTS `projetos_autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_projeto` int(11) NOT NULL,
  `id_vereador` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_projeto` (`id_projeto`),
  KEY `id_autor` (`id_vereador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36514 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vereadores`
--

CREATE TABLE IF NOT EXISTS `vereadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_out` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=687 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vereadores_nome_fix`
--

CREATE TABLE IF NOT EXISTS `vereadores_nome_fix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vereador` int(11) NOT NULL,
  `nome_errado` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_errado` (`nome_errado`),
  KEY `id_vereador` (`id_vereador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1021 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vereadores_nome_parlamentar`
--

CREATE TABLE IF NOT EXISTS `vereadores_nome_parlamentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vereador` int(11) NOT NULL,
  `nome_parlamentar` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nome_parlamentar` (`nome_parlamentar`),
  KEY `id_vereador` (`id_vereador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=379 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vereadores_vereancas`
--

CREATE TABLE IF NOT EXISTS `vereadores_vereancas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vereador` int(11) NOT NULL,
  `id_vereador_anterior` int(11) DEFAULT NULL,
  `data_ini` date NOT NULL,
  `data_fim` date NOT NULL,
  `situacao` varchar(100) DEFAULT NULL,
  `partido` varchar(20) DEFAULT NULL,
  `partido_obs` varchar(200) DEFAULT NULL,
  `obs` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vereador` (`id_vereador`),
  KEY `id_vereador_anterior` (`id_vereador_anterior`),
  KEY `data_ini` (`data_ini`),
  KEY `data_fim` (`data_fim`),
  KEY `partido` (`partido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3448 ;
