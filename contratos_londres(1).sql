-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 19-09-2011 a las 18:49:05
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `contratos_londres`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `avales`
-- 

CREATE TABLE `avales` (
  `clave_aval` int(10) NOT NULL auto_increment,
  `clave_cliente` int(10) NOT NULL,
  `nombre_aval` varchar(35) NOT NULL,
  `rfc_aval` varchar(13) NOT NULL,
  `domicilio_aval` varchar(200) NOT NULL,
  `ciudad_aval` varchar(30) NOT NULL,
  `cp_aval` varchar(5) NOT NULL,
  `tel_aval` varchar(30) default NULL,
  `fax_aval` varchar(15) default NULL,
  `email_aval` varchar(70) default NULL,
  PRIMARY KEY  (`clave_aval`),
  KEY `nombre_aval` (`nombre_aval`,`ciudad_aval`),
  KEY `rfc_cliente` (`rfc_aval`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Avales' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `avales`
-- 

INSERT INTO `avales` VALUES (1, 1, 'Gerardo Manuel Arreola Salazar', 'FUL990109QWE', 'Conocido', 'Tijuana', '11000', '9009988', '9009988', 'alguno@hotmail.com');
INSERT INTO `avales` VALUES (2, 3, 'Sutano', 'SUTS110909WER', 'Conocido.', 'Tecate', '11000', '1112223', NULL, NULL);
INSERT INTO `avales` VALUES (3, 3, 'Fulano', 'FULA110909WER', 'Conocido', 'Tijuana', '22000', '11111111', NULL, NULL);
INSERT INTO `avales` VALUES (4, 4, 'Hector Villegas', 'asdjasdjakl', 'jasdjd', 'jklj', 'jklj', 'klj', 'kljkl', 'jkl');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clientes`
-- 

CREATE TABLE `clientes` (
  `clave_cliente` int(10) NOT NULL auto_increment,
  `nombre_cliente` varchar(35) NOT NULL,
  `rfc_cliente` varchar(13) NOT NULL,
  `domicilio_cliente` varchar(200) NOT NULL,
  `ciudad_cliente` varchar(30) NOT NULL,
  `cp_cliente` varchar(5) NOT NULL,
  `tel_cliente` varchar(30) default NULL,
  `fax_cliente` varchar(15) default NULL,
  `email_cliente` varchar(70) default NULL,
  PRIMARY KEY  (`clave_cliente`),
  KEY `nombre_cliente` (`nombre_cliente`,`ciudad_cliente`),
  KEY `rfc_cliente` (`rfc_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Clientes' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `clientes`
-- 

INSERT INTO `clientes` VALUES (1, 'Alonso Martinez', 'AOMT850430QW4', 'Conocido', 'Tijuana', '33004', '6229098', NULL, NULL);
INSERT INTO `clientes` VALUES (3, 'Maria del Socorro Aragon Lopez', 'AOMS750106TY9', 'De las Aguas #23609 B-34. Villa Fontana', 'Tijuana', '22505', '6647019137', '9001212', 'coco_aragon@hotmail.com');
INSERT INTO `clientes` VALUES (4, 'Francisco Javier Martinez Corral', 'MACF770422SR9', 'Blvd. Real de San Francisco #23480, Real de San Francisco', 'Tijuana', '22450', '1029588', NULL, 'jamaco@gmail.com');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cobradores`
-- 

CREATE TABLE `cobradores` (
  `clave_cobrador` int(10) NOT NULL auto_increment,
  `nombre_cobrador` varchar(35) NOT NULL,
  `rfc_cobrador` varchar(13) NOT NULL,
  `domicilio_cobrador` varchar(200) NOT NULL,
  `ciudad_cobrador` varchar(30) NOT NULL,
  `cp_cobrador` varchar(5) NOT NULL,
  `tel_cobrador` varchar(30) default NULL,
  `fax_cobrador` varchar(15) default NULL,
  `email_cobrador` varchar(70) default NULL,
  `activo` smallint(1) default '0',
  PRIMARY KEY  (`clave_cobrador`),
  KEY `nombre_cobrador` (`nombre_cobrador`,`ciudad_cobrador`),
  KEY `rfc_cobrador` (`rfc_cobrador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Cobradores' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `cobradores`
-- 

INSERT INTO `cobradores` VALUES (1, 'xx', 'xx', 'x', 'x', 'x', 'x', 'x', 'x', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `contrato`
-- 

CREATE TABLE `contrato` (
  `clave_contrato` int(10) NOT NULL auto_increment,
  `contrato` int(10) NOT NULL,
  `credito` smallint(1) default '1',
  `clave_empresa` smallint(3) NOT NULL,
  `clave_cliente` int(10) NOT NULL,
  `fecha_contrato` date NOT NULL,
  `forma_pago` varchar(150) NOT NULL,
  `promocion` varchar(150) default NULL,
  `no_pagos` tinyint(3) default '0',
  `interes` float default '0',
  `moratorio` float default '0',
  `cenganche` float default '0',
  `cinteres` float default '0',
  `acuenta` smallint(1) default '0',
  `cprecio` float NOT NULL,
  `cacuenta` float default '0',
  `civa` int(11) NOT NULL,
  `ctotal` float default '0',
  `clave_inv` int(11) NOT NULL,
  `clave_inv_acuenta` int(11) default '0',
  `cefectivo` float default '0',
  `no_cheque` varchar(50) default NULL,
  `ccheque` float default '0',
  `banco_cheque` varchar(50) default NULL,
  `clave_vendedor` int(10) NOT NULL,
  `clave_cobrador` int(10) default '0',
  `clave_testigo` int(10) NOT NULL,
  `garantia` smallint(1) default '1',
  `fecha_garantia` date default NULL,
  `partes_garantia` varchar(200) default NULL,
  `aspecto_mec` varchar(150) default NULL,
  `aspecto_car` varchar(150) default NULL,
  `aplicado` smallint(1) default '0',
  `clave_usuario` smallint(3) default NULL,
  PRIMARY KEY  (`clave_contrato`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `contrato`
-- 

INSERT INTO `contrato` VALUES (1, 5, 1, 1, 1, '2011-09-18', '5', '5', 5, 5, 5, 5, 5, NULL, 5, 5, 5, 5, 12, NULL, 5, '5', 5, '5', 1, 1, 1, 0, '0000-00-00', NULL, '5', '5', 0, 7);
INSERT INTO `contrato` VALUES (6, 500, 1, 1, 1, '0000-00-00', 'qqq', 'qqq', 127, 555, 555, 555, 555, NULL, 555, 555, 555, 555, 12, NULL, 555, '555', 555, '555', 1, 1, 1, 1, '0000-00-00', NULL, 'qqq', 'qqq', 0, 7);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `empresa`
-- 

CREATE TABLE `empresa` (
  `clave_empresa` smallint(3) NOT NULL auto_increment,
  `nombre_empresa` varchar(35) NOT NULL,
  `rfc_empresa` varchar(13) NOT NULL,
  `domicilio_empresa` varchar(200) NOT NULL,
  `ciudad_empresa` varchar(30) NOT NULL,
  `cp_empresa` varchar(5) NOT NULL,
  `tel_empresa` varchar(30) default NULL,
  `fax_empresa` varchar(15) default NULL,
  `email_empresa` varchar(70) default NULL,
  `representante_empresa` varchar(55) default NULL,
  `activo_empresa` smallint(1) default '0',
  PRIMARY KEY  (`clave_empresa`),
  KEY `nombre_empresa` (`nombre_empresa`,`ciudad_empresa`),
  KEY `rfc_empresa` (`rfc_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Empresas' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `empresa`
-- 

INSERT INTO `empresa` VALUES (1, 'Sanchez Taboada', 'ALT690909OPW', 'Blvd. Sanchez Taboada #53 Esquina Diego Rivera, Colonia Zona del Rio ', 'Tijuana', '22900', '(664) 6342255, (664) 6342290', NULL, NULL, 'Juan Carlos Reyes', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fotos`
-- 

CREATE TABLE `fotos` (
  `clave_foto` int(11) NOT NULL auto_increment,
  `clave_inv` int(11) NOT NULL default '0',
  `comentario` varchar(250) default NULL,
  `foto` varchar(50) NOT NULL default '',
  `portada` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`clave_foto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `fotos`
-- 

INSERT INTO `fotos` VALUES (1, 12, ' ', 'archivos/jettaplata1.jpg', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `inventario_auto`
-- 

CREATE TABLE `inventario_auto` (
  `clave_inv` int(11) NOT NULL auto_increment,
  `clave_auto` smallint(6) NOT NULL default '0',
  `especificaciones` varchar(250) NOT NULL default '',
  `km` float default NULL,
  `precio` float default NULL,
  `ano` smallint(4) NOT NULL default '0',
  `puertas` smallint(1) default NULL,
  `motor` varchar(20) default NULL,
  `fotos` smallint(2) default NULL,
  `clave_empresa` smallint(6) default NULL,
  `vendido` smallint(1) default '0',
  `acambio` smallint(1) default '0',
  `serie` varchar(50) NOT NULL default '0',
  `pedimento` varchar(25) NOT NULL default '0',
  `fecha_pedimento` date default NULL,
  `proveedor` varchar(70) default NULL,
  `aduana` varchar(100) default NULL,
  PRIMARY KEY  (`clave_inv`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Volcar la base de datos para la tabla `inventario_auto`
-- 

INSERT INTO `inventario_auto` VALUES (10, 101, 'blanco, lujo', 132000, 3200, 1999, 4, '6', 0, 1, 0, 0, '992838374447', '11822993', NULL, NULL, NULL);
INSERT INTO `inventario_auto` VALUES (11, 75, 'hihjkhjkhjk', 88888, 900, 2000, 4, '6', 0, 1, NULL, 1, '0980980', '809809809', NULL, 'kljlkjkl', NULL);
INSERT INTO `inventario_auto` VALUES (12, 51, 'negro de lujo, corre perron', 131000, 3000, 1998, 4, '4', 1, 1, NULL, 1, 'po09809', '90809', NULL, 'remate', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `marca`
-- 

CREATE TABLE `marca` (
  `clave_marca` smallint(6) NOT NULL auto_increment,
  `marca` varchar(25) NOT NULL default '',
  `comentario` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`clave_marca`),
  UNIQUE KEY `marca` (`marca`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Volcar la base de datos para la tabla `marca`
-- 

INSERT INTO `marca` VALUES (1, 'Honda', 'Accord, Civid, Pilot, etc');
INSERT INTO `marca` VALUES (2, 'Ford', 'Focus, Explorer, etc');
INSERT INTO `marca` VALUES (3, 'Volkswagen', 'Jetta, Golf, Passat, Caribe');
INSERT INTO `marca` VALUES (4, 'Chevrolet', 'S10, Malibu, Cavalier');
INSERT INTO `marca` VALUES (5, 'Acura', 'Integra, T100');
INSERT INTO `marca` VALUES (7, 'Nissan', 'Altima, Sentra, Frontier');
INSERT INTO `marca` VALUES (8, 'ISUZU', 'Tropper, Rodeo');
INSERT INTO `marca` VALUES (9, 'Suzuki', 'Sidekick');
INSERT INTO `marca` VALUES (10, 'Dodge', 'Durango, Grand Caravan, Intrepid');
INSERT INTO `marca` VALUES (11, 'Mercury', 'sable');
INSERT INTO `marca` VALUES (12, 'TOYOTA', 'CAMRY');
INSERT INTO `marca` VALUES (13, 'Pontiac', 'Transport');
INSERT INTO `marca` VALUES (14, 'Buick', 'lesabre');
INSERT INTO `marca` VALUES (15, 'Mazda', '626');
INSERT INTO `marca` VALUES (16, 'GMC', 'Suburban');
INSERT INTO `marca` VALUES (17, 'Hyundai', 'sonata');
INSERT INTO `marca` VALUES (18, 'Lincoln', 'town car');
INSERT INTO `marca` VALUES (19, 'Chrysler', 'Town Country');
INSERT INTO `marca` VALUES (20, 'Audi', 'a6');
INSERT INTO `marca` VALUES (21, 'Jeep', 'Grand cherokee');
INSERT INTO `marca` VALUES (22, 'GEO', 'PRIMZ');
INSERT INTO `marca` VALUES (23, 'PLYMOUTH', 'GRAND VOYAGER');
INSERT INTO `marca` VALUES (24, 'Mitsubishi', 'Galant');
INSERT INTO `marca` VALUES (25, 'Oldsmobile', 'cutlas supreme');
INSERT INTO `marca` VALUES (26, 'Chevrolet 3500', 'doble rodado');
INSERT INTO `marca` VALUES (27, 'Dodge 3500', 'doble rodado');
INSERT INTO `marca` VALUES (28, 'Mercedez benz', 'importado');
INSERT INTO `marca` VALUES (29, 'Saturn Ls', '4 puertas');
INSERT INTO `marca` VALUES (30, 'Cadillac', 'automovil');
INSERT INTO `marca` VALUES (31, 'EAGLE SUMMIT', 'BLANCO');
INSERT INTO `marca` VALUES (32, 'Executive', 'motor home');
INSERT INTO `marca` VALUES (33, 'PEUGEOT', '206 SX');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `monedas`
-- 

CREATE TABLE `monedas` (
  `clave_moneda` int(10) NOT NULL auto_increment,
  `moneda` varchar(35) NOT NULL,
  `activo` smallint(1) default '0',
  PRIMARY KEY  (`clave_moneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Monedas' AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `monedas`
-- 

INSERT INTO `monedas` VALUES (2, 'Dolar', 1);
INSERT INTO `monedas` VALUES (3, 'Peso', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `referencias`
-- 

CREATE TABLE `referencias` (
  `clave_referencia` int(10) NOT NULL auto_increment,
  `clave_cliente` int(10) NOT NULL,
  `nombre_referencia` varchar(35) NOT NULL,
  `rfc_referencia` varchar(13) NOT NULL,
  `domicilio_referencia` varchar(200) NOT NULL,
  `ciudad_referencia` varchar(30) NOT NULL,
  `cp_referencia` varchar(5) NOT NULL,
  `tel_referencia` varchar(30) default NULL,
  `fax_referencia` varchar(15) default NULL,
  `email_referencia` varchar(70) default NULL,
  PRIMARY KEY  (`clave_referencia`),
  KEY `nombre_referencia` (`nombre_referencia`,`ciudad_referencia`),
  KEY `rfc_referencia` (`rfc_referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Referencias' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `referencias`
-- 

INSERT INTO `referencias` VALUES (1, 1, 'Jose Manuel Arreola Aragon', 'AAJM040202QWE', 'Conocido', 'Tijuana', '22505', '7019137', NULL, 'josesito@hotmail.com');
INSERT INTO `referencias` VALUES (2, 3, 'Maximiliano Tadeo Arreola Aragon', 'AAMT000330YH8', 'Conocido.', 'Tijuana', '22205', '6642222193', NULL, 'max@hotmail.com');
INSERT INTO `referencias` VALUES (3, 4, 'Luis Ramirez', 'kjhjk', 'hjk', 'hjk', 'hjk', 'h', 'jkh', 'jk');
INSERT INTO `referencias` VALUES (4, 4, 'Paul Chavez', 'nnmkbnm', 'bnm', 'b', 'nmb', 'nm', 'bnm', 'bnm');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `referencias_aval`
-- 

CREATE TABLE `referencias_aval` (
  `clave_referencia` int(10) NOT NULL auto_increment,
  `clave_aval` int(10) NOT NULL,
  `nombre_referencia` varchar(35) NOT NULL,
  `rfc_referencia` varchar(13) NOT NULL,
  `domicilio_referencia` varchar(200) NOT NULL,
  `ciudad_referencia` varchar(30) NOT NULL,
  `cp_referencia` varchar(5) NOT NULL,
  `tel_referencia` varchar(30) default NULL,
  `fax_referencia` varchar(15) default NULL,
  `email_referencia` varchar(70) default NULL,
  PRIMARY KEY  (`clave_referencia`),
  KEY `nombre_referencia` (`nombre_referencia`,`ciudad_referencia`),
  KEY `rfc_referencia` (`rfc_referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Referencias' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `referencias_aval`
-- 

INSERT INTO `referencias_aval` VALUES (2, 1, 'Jose Guzman', 'GUZJ770422LPW', 'Conocido', 'Tecate', '22000', '900998', NULL, 'guz@gotmail.com');
INSERT INTO `referencias_aval` VALUES (3, 4, 'Jose Antonio Aguirre', 'jhjk', 'hjk', 'hjk', 'hjk', 'hjk', 'hjk', 'hjk');
INSERT INTO `referencias_aval` VALUES (4, 4, 'Piedrita', 'klj', 'kljkl', 'j', 'lj', 'klj', 'klj', 'klj');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `testigos`
-- 

CREATE TABLE `testigos` (
  `clave_testigo` int(10) NOT NULL auto_increment,
  `nombre_testigo` varchar(35) NOT NULL,
  `rfc_testigo` varchar(13) NOT NULL,
  `domicilio_testigo` varchar(200) NOT NULL,
  `ciudad_testigo` varchar(30) NOT NULL,
  `cp_testigo` varchar(5) NOT NULL,
  `tel_testigo` varchar(30) default NULL,
  `fax_testigo` varchar(15) default NULL,
  `email_testigo` varchar(70) default NULL,
  `activo` smallint(1) default '0',
  PRIMARY KEY  (`clave_testigo`),
  KEY `nombre_testigo` (`nombre_testigo`,`ciudad_testigo`),
  KEY `rfc_testigo` (`rfc_testigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Testigos' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `testigos`
-- 

INSERT INTO `testigos` VALUES (1, 'fff', 'fff', 'f', 'f', 'f', 'f', 'f', 'f', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_auto`
-- 

CREATE TABLE `tipo_auto` (
  `clave_auto` smallint(6) NOT NULL auto_increment,
  `clave_marca` smallint(6) NOT NULL default '0',
  `modelo` varchar(30) NOT NULL default '',
  `estilo` varchar(20) NOT NULL default '',
  `comentarios` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`clave_auto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=200 ;

-- 
-- Volcar la base de datos para la tabla `tipo_auto`
-- 

INSERT INTO `tipo_auto` VALUES (1, 1, 'Accord', 'automovil', '');
INSERT INTO `tipo_auto` VALUES (2, 1, 'Civic', 'automovil', '');
INSERT INTO `tipo_auto` VALUES (3, 2, 'Explorer Sport', 'todoterreno', '2 ptas.');
INSERT INTO `tipo_auto` VALUES (5, 3, 'Jetta', 'automovil', 'hjkhjkhkjhjk');
INSERT INTO `tipo_auto` VALUES (6, 4, 'S10', 'pickup', '');
INSERT INTO `tipo_auto` VALUES (14, 7, 'Frontier', 'pickup', 'Levantada');
INSERT INTO `tipo_auto` VALUES (15, 1, 'Odissey', 'minivan', '.');
INSERT INTO `tipo_auto` VALUES (16, 2, 'F-150', 'Pickup', 'Lariat');
INSERT INTO `tipo_auto` VALUES (17, 4, 'Montecarlo', 'automovil', '.');
INSERT INTO `tipo_auto` VALUES (18, 2, 'Focus', 'automovil', '.');
INSERT INTO `tipo_auto` VALUES (19, 4, 'G3500', 'pickup', 'carga');
INSERT INTO `tipo_auto` VALUES (20, 7, 'Xterra', 'todoterreno', '.');
INSERT INTO `tipo_auto` VALUES (21, 8, 'Tropper', 'todoterreno', '.');
INSERT INTO `tipo_auto` VALUES (22, 2, 'Expedition XLT', 'todoterreno', 'XLT');
INSERT INTO `tipo_auto` VALUES (23, 2, 'Expedition E. B.', 'todoterreno', 'Eddie Bawer');
INSERT INTO `tipo_auto` VALUES (24, 2, 'escape xls', 'todoterreno', 'xls');
INSERT INTO `tipo_auto` VALUES (25, 4, 'malibu', 'automovil', 'ls');
INSERT INTO `tipo_auto` VALUES (26, 4, 'astro', 'minivan', 'ls pasajeros');
INSERT INTO `tipo_auto` VALUES (27, 4, 'silverado 1500', 'pickup', '4x4 cabina y media');
INSERT INTO `tipo_auto` VALUES (28, 4, 'lumina', 'automovil', 'ls');
INSERT INTO `tipo_auto` VALUES (29, 2, 'Explorer', 'todoterreno', 'xlt');
INSERT INTO `tipo_auto` VALUES (30, 2, 'Explorer E.B.', 'todoterreno', 'Eddie Bawer');
INSERT INTO `tipo_auto` VALUES (31, 2, 'Ranger', 'pickup', 'xlt');
INSERT INTO `tipo_auto` VALUES (32, 2, 'Windstar', 'minivan', 'le');
INSERT INTO `tipo_auto` VALUES (33, 2, 'Focus', 'automovil', 'se');
INSERT INTO `tipo_auto` VALUES (34, 2, 'Excursion xlt', 'todoterreno', 'xlt');
INSERT INTO `tipo_auto` VALUES (35, 4, 'Excursion', 'todoterreno', 'xlt, 10 cilindros, asientos de piel, vidrios y seguros electricos, rines de lujo, a/c, radio am/fm cd.');
INSERT INTO `tipo_auto` VALUES (36, 2, 'Crown Victoria', 'automovil', 'blanco');
INSERT INTO `tipo_auto` VALUES (37, 4, 'cavalier', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (38, 4, 'suburban', 'todoterreno', 'c1500');
INSERT INTO `tipo_auto` VALUES (39, 2, 'explorer xls', 'todoterreno', 'xls');
INSERT INTO `tipo_auto` VALUES (40, 2, 'mustang', 'automovil', 'techo duro');
INSERT INTO `tipo_auto` VALUES (41, 2, 'mustang convertible', 'automovil', 'convertible');
INSERT INTO `tipo_auto` VALUES (42, 2, 'focus zx3', 'automovil', 'zx3');
INSERT INTO `tipo_auto` VALUES (43, 10, 'Durango', 'todoterreno', 'slt');
INSERT INTO `tipo_auto` VALUES (44, 10, 'Stratus se', 'automovil', 'se');
INSERT INTO `tipo_auto` VALUES (45, 10, 'Grand Caravan', 'minivan', 'se');
INSERT INTO `tipo_auto` VALUES (46, 11, 'Sable', 'automovil', 'se');
INSERT INTO `tipo_auto` VALUES (47, 7, 'SENTRA', 'automovil', 'SEDAN');
INSERT INTO `tipo_auto` VALUES (48, 7, 'maxima', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (49, 7, 'Altima gxe', 'automovil', 'gxe');
INSERT INTO `tipo_auto` VALUES (50, 3, 'Jetta gls', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (51, 3, 'Jetta gl', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (52, 12, 'Camry', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (53, 12, 'Corolla', 'automovil', 'Sedan');
INSERT INTO `tipo_auto` VALUES (55, 13, 'Montana', 'minivan', 'transport');
INSERT INTO `tipo_auto` VALUES (56, 13, 'Transport', 'minivan', 'Sedan');
INSERT INTO `tipo_auto` VALUES (57, 8, 'Axiom', 'todoterreno', '4x4');
INSERT INTO `tipo_auto` VALUES (58, 14, 'Lesabre', 'automovil', 'blanco');
INSERT INTO `tipo_auto` VALUES (59, 15, '626', 'automovil', 'gris');
INSERT INTO `tipo_auto` VALUES (60, 16, 'Suburban', 'todoterreno', 'oro');
INSERT INTO `tipo_auto` VALUES (61, 17, 'Sonata', 'automovil', 'vino');
INSERT INTO `tipo_auto` VALUES (62, 17, 'Santa Fe', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (63, 17, 'Accent', 'automovil', 'gris');
INSERT INTO `tipo_auto` VALUES (64, 18, 'Town Car', 'automovil', 'arena');
INSERT INTO `tipo_auto` VALUES (65, 18, 'Navigator', 'todoterreno', 'blanco');
INSERT INTO `tipo_auto` VALUES (66, 9, 'Sidekcik', 'todoterreno', 'Blanco');
INSERT INTO `tipo_auto` VALUES (67, 4, 'Blazer', 'todoterreno', '2 ptas.');
INSERT INTO `tipo_auto` VALUES (68, 2, 'Taurus', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (69, 19, 'Town Country', 'minivan', 'lx');
INSERT INTO `tipo_auto` VALUES (70, 10, 'Ram 1500', 'pickup', 'sencillo');
INSERT INTO `tipo_auto` VALUES (71, 12, '4Runner', 'todoterreno', 'Todo terreno');
INSERT INTO `tipo_auto` VALUES (72, 12, 'Tundra', 'pickup', 'cabina y media');
INSERT INTO `tipo_auto` VALUES (73, 15, 'Mpv', 'minivan', 'mpv');
INSERT INTO `tipo_auto` VALUES (74, 7, 'Axxes', 'minivan', 'Mini Van');
INSERT INTO `tipo_auto` VALUES (75, 20, 'A6', 'automovil', 'piel');
INSERT INTO `tipo_auto` VALUES (76, 21, 'Grand Cherokee', 'todoterreno', '4x4');
INSERT INTO `tipo_auto` VALUES (77, 4, 'Primz', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (78, 19, 'PT Crusier', 'automovil', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (79, 19, 'PT Crusier', 'automovil', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (80, 10, 'Dakota', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (81, 2, 'Aerostar', 'minivan', 'mini van');
INSERT INTO `tipo_auto` VALUES (82, 2, 'Escort zx2', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (83, 22, 'Primz', 'automovil', 'primz');
INSERT INTO `tipo_auto` VALUES (84, 16, 'Sierra 2500', 'pickup', 'pikcup');
INSERT INTO `tipo_auto` VALUES (85, 1, 'Passport', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (86, 15, 'B2500', 'pickup', 'pikcup');
INSERT INTO `tipo_auto` VALUES (87, 11, 'Villager State', 'minivan', 'MINI VAN');
INSERT INTO `tipo_auto` VALUES (88, 11, 'Villager', 'minivan', 'MIni Van');
INSERT INTO `tipo_auto` VALUES (89, 23, 'Grand Voyager', 'minivan', 'MIni Van');
INSERT INTO `tipo_auto` VALUES (90, 3, 'Passat', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (91, 12, 'Land Crusier', 'todoterreno', 'Vagoneta');
INSERT INTO `tipo_auto` VALUES (92, 12, 'Tundra sr5', 'pickup', 'Pickup');
INSERT INTO `tipo_auto` VALUES (93, 12, 'Tacoma sr5', 'pickup', 'pikcup');
INSERT INTO `tipo_auto` VALUES (94, 2, 'E350', 'minivan', 'Van de Carga');
INSERT INTO `tipo_auto` VALUES (95, 11, 'Mountainner', 'todoterreno', 'Vagoneta');
INSERT INTO `tipo_auto` VALUES (96, 11, 'Cougar', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (97, 3, 'Cabriolet convertible', 'automovil', 'convertible');
INSERT INTO `tipo_auto` VALUES (98, 24, 'Mirage', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (99, 24, 'Eclipse convertible', 'automovil', 'Convertible');
INSERT INTO `tipo_auto` VALUES (100, 4, 'Avalanche c1500', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (101, 4, 'Impala', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (102, 2, 'Explorer truck', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (103, 2, 'Panel E150', 'minivan', 'panel');
INSERT INTO `tipo_auto` VALUES (104, 2, 'Escort lx', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (105, 16, 'Safari', 'minivan', 'mini van');
INSERT INTO `tipo_auto` VALUES (106, 4, 'Vandura 2500', 'minivan', 'Van pasajeros');
INSERT INTO `tipo_auto` VALUES (107, 4, 'Monte Carlos', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (108, 4, 'Trailblazer', 'todoterreno', 'Vagoneta');
INSERT INTO `tipo_auto` VALUES (109, 10, 'Ram 2500', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (110, 2, 'Escort gt', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (111, 2, 'Econoline', 'minivan', 'panel');
INSERT INTO `tipo_auto` VALUES (112, 16, 'Sonoma', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (113, 12, 'T100', 'pickup', 'cabina y media');
INSERT INTO `tipo_auto` VALUES (114, 12, 'Rav4', 'todoterreno', 'Vagoneta');
INSERT INTO `tipo_auto` VALUES (115, 3, 'New betlee convertible', 'automovil', 'Convertible');
INSERT INTO `tipo_auto` VALUES (116, 3, 'Golf', 'automovil', '2 ptas.');
INSERT INTO `tipo_auto` VALUES (117, 16, 'Sierra 2500', 'pickup', 'pickup');
INSERT INTO `tipo_auto` VALUES (118, 24, 'Outlander', 'minivan', 'automatico');
INSERT INTO `tipo_auto` VALUES (119, 25, 'Silohuette', 'minivan', 'mini van');
INSERT INTO `tipo_auto` VALUES (120, 26, '2000', 'pickup', 'doble rodado');
INSERT INTO `tipo_auto` VALUES (121, 27, '2001', 'pickup', 'doble rodado');
INSERT INTO `tipo_auto` VALUES (122, 2, 'Mondeo', 'automovil', 'nacional');
INSERT INTO `tipo_auto` VALUES (123, 28, 'CL430', 'todoterreno', 'piel');
INSERT INTO `tipo_auto` VALUES (124, 3, 'new beetle', 'automovil', 'techo duro');
INSERT INTO `tipo_auto` VALUES (125, 13, 'Grand Am', 'automovil', '2 puertas');
INSERT INTO `tipo_auto` VALUES (126, 29, 'Ls', 'automovil', 'standar');
INSERT INTO `tipo_auto` VALUES (127, 21, 'Liberty', 'todoterreno', 'sport');
INSERT INTO `tipo_auto` VALUES (128, 15, 'B3000', 'pickup', 'automatico');
INSERT INTO `tipo_auto` VALUES (129, 17, 'XG 300', 'automovil', 'automatico');
INSERT INTO `tipo_auto` VALUES (130, 2, 'E 250', 'minivan', 'panel de carga');
INSERT INTO `tipo_auto` VALUES (131, 30, 'Deville', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (132, 24, 'Lancer', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (133, 5, 'CL', 'automovil', 'coupe');
INSERT INTO `tipo_auto` VALUES (134, 10, 'Neon', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (135, 16, 'Yukon Denali', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (136, 1, 'Crv lx', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (137, 21, 'Wrangler', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (138, 14, 'Century', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (139, 24, 'Galant', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (140, 24, 'Galant', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (141, 1, 'Element', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (142, 11, 'Grand marquiz', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (143, 13, 'Grand Prix GT', 'automovil', 'ROJO');
INSERT INTO `tipo_auto` VALUES (144, 15, 'Tribute', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (145, 21, 'Grand Wagonner', 'todoterreno', 'vagoneta');
INSERT INTO `tipo_auto` VALUES (146, 4, 'Tahoe C1500', 'todoterreno', 'Color arena');
INSERT INTO `tipo_auto` VALUES (147, 13, 'Matiz', 'automovil', 'nacional');
INSERT INTO `tipo_auto` VALUES (148, 15, 'Protege', 'automovil', 'sedan');
INSERT INTO `tipo_auto` VALUES (149, 18, 'LS', 'automovil', 'negro');
INSERT INTO `tipo_auto` VALUES (150, 28, 'ML350', 'todoterreno', 'dorado');
INSERT INTO `tipo_auto` VALUES (151, 28, 'Bensmi350', 'automovil', 'dorado');
INSERT INTO `tipo_auto` VALUES (152, 25, 'Alero', 'automovil', 'gris');
INSERT INTO `tipo_auto` VALUES (153, 25, 'Bravada', 'todoterreno', 'Color blanco');
INSERT INTO `tipo_auto` VALUES (154, 2, 'F350 HD Diesel', 'pickup', '4x4');
INSERT INTO `tipo_auto` VALUES (155, 14, 'Rendezvouz', 'todoterreno', 'awd');
INSERT INTO `tipo_auto` VALUES (156, 7, 'Murano', 'todoterreno', 'gr');
INSERT INTO `tipo_auto` VALUES (157, 7, 'Murano', 'todoterreno', 'gr');
INSERT INTO `tipo_auto` VALUES (158, 16, 'Envoy', 'todoterreno', 'oro');
INSERT INTO `tipo_auto` VALUES (159, 4, 'Tracker', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (160, 4, 'Tracker', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (161, 2, 'Escape', 'todoterreno', 'azul');
INSERT INTO `tipo_auto` VALUES (162, 7, 'Quest', 'minivan', 'bln');
INSERT INTO `tipo_auto` VALUES (163, 4, 'Express carga', 'minivan', 'blanco');
INSERT INTO `tipo_auto` VALUES (164, 9, 'Grand Vitara', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (165, 8, 'Ascender', 'todoterreno', 'verde');
INSERT INTO `tipo_auto` VALUES (166, 4, 'G20', 'minivan', 'pasajeros');
INSERT INTO `tipo_auto` VALUES (167, 13, 'Sunfire', 'automovil', '2 puertas');
INSERT INTO `tipo_auto` VALUES (168, 13, 'Aztec', 'todoterreno', 'automatico');
INSERT INTO `tipo_auto` VALUES (169, 10, 'Intrepid', 'automovil', 'gris');
INSERT INTO `tipo_auto` VALUES (170, 7, 'Pathfinder', 'todoterreno', 'verde');
INSERT INTO `tipo_auto` VALUES (171, 16, 'Jimmy', 'todoterreno', 'verde');
INSERT INTO `tipo_auto` VALUES (172, 2, 'Club wagon', 'minivan', 'negro');
INSERT INTO `tipo_auto` VALUES (173, 21, 'Cherokee', 'todoterreno', 'rojo');
INSERT INTO `tipo_auto` VALUES (174, 13, 'Vibe', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (175, 29, 'vue', 'todoterreno', 'gris');
INSERT INTO `tipo_auto` VALUES (176, 2, 'Bronco II', 'todoterreno', 'Blanco');
INSERT INTO `tipo_auto` VALUES (177, 10, 'Ram le 250', 'minivan', 'Van de pasajeros');
INSERT INTO `tipo_auto` VALUES (178, 2, 'F350 Camion Doble Rodado', 'pickup', 'caja cerrada');
INSERT INTO `tipo_auto` VALUES (179, 7, '240 SX SE', 'automovil', 'verde');
INSERT INTO `tipo_auto` VALUES (180, 4, 'Express pasajeros', 'minivan', 'color vino');
INSERT INTO `tipo_auto` VALUES (181, 31, 'SUMMIT', 'automovil', 'BLANCO');
INSERT INTO `tipo_auto` VALUES (182, 8, 'rodeo', 'todoterreno', 'color rojo');
INSERT INTO `tipo_auto` VALUES (183, 32, 'Executive', 'minivan', 'motor home');
INSERT INTO `tipo_auto` VALUES (184, 4, 'Equinox', 'todoterreno', 'AWD');
INSERT INTO `tipo_auto` VALUES (185, 33, '206 SX', 'automovil', 'GRIS');
INSERT INTO `tipo_auto` VALUES (186, 7, 'Platina,', 'automovil', 'gris');
INSERT INTO `tipo_auto` VALUES (187, 25, 'Cutlass supreme', 'automovil', 'azul');
INSERT INTO `tipo_auto` VALUES (188, 19, 'Town Country', 'minivan', 'guinda');
INSERT INTO `tipo_auto` VALUES (189, 16, 'SAVANA', 'minivan', 'CARGA');
INSERT INTO `tipo_auto` VALUES (190, 19, 'PACIFICA', 'minivan', 'COLOR AZUL');
INSERT INTO `tipo_auto` VALUES (191, 15, 'MX-6', 'automovil', 'ROJO');
INSERT INTO `tipo_auto` VALUES (192, 4, 'Astra', 'automovil', 'nacional');
INSERT INTO `tipo_auto` VALUES (193, 4, 'HHR', 'automovil', 'GRIS');
INSERT INTO `tipo_auto` VALUES (194, 4, 'Cheyenne', 'pickup', 'Blanco');
INSERT INTO `tipo_auto` VALUES (195, 4, 'Chevy Monza', 'automovil', 'blanco');
INSERT INTO `tipo_auto` VALUES (196, 4, 'Cobalt', 'automovil', 'negro');
INSERT INTO `tipo_auto` VALUES (197, 15, '6 S', 'automovil', 'NEGRO');
INSERT INTO `tipo_auto` VALUES (198, 7, 'Titan', 'pickup', 'azul');
INSERT INTO `tipo_auto` VALUES (199, 2, 'F-250', 'pickup', 'Rojo');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `clave_usuario` smallint(3) NOT NULL auto_increment,
  `login_usuario` varchar(15) NOT NULL,
  `pass_usuario` varchar(50) NOT NULL,
  `nombre_usuario` varchar(35) NOT NULL,
  `permisos_usuario` smallint(1) NOT NULL,
  `activo_usuario` smallint(1) default NULL,
  PRIMARY KEY  (`clave_usuario`),
  UNIQUE KEY `login_usuario` (`login_usuario`),
  KEY `pass_usuario` (`pass_usuario`,`nombre_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (1, ' Admin', '1cb790bfdf33547fc8f22a5d3a4722ce', 'Administrador', 0, 1);
INSERT INTO `usuarios` VALUES (7, 'Gera', 'f4a8950e22ec7b2d306f9b0f5fc141b5', 'Gerardo Arreola', 1, 1);
INSERT INTO `usuarios` VALUES (8, ' prueba', 'c893bad68927b457dbed39460e6afd62', 'prueba', 3, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vendedores`
-- 

CREATE TABLE `vendedores` (
  `clave_vendedor` int(10) NOT NULL auto_increment,
  `nombre_vendedor` varchar(35) NOT NULL,
  `rfc_vendedor` varchar(13) NOT NULL,
  `domicilio_vendedor` varchar(200) NOT NULL,
  `ciudad_vendedor` varchar(30) NOT NULL,
  `cp_vendedor` varchar(5) NOT NULL,
  `tel_vendedor` varchar(30) default NULL,
  `fax_vendedor` varchar(15) default NULL,
  `email_vendedor` varchar(70) default NULL,
  `activo` smallint(1) default '0',
  PRIMARY KEY  (`clave_vendedor`),
  KEY `nombre_vendedor` (`nombre_vendedor`,`ciudad_vendedor`),
  KEY `rfc_vendedor` (`rfc_vendedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Vendedores' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `vendedores`
-- 

INSERT INTO `vendedores` VALUES (1, 'hhhhhhh', 'hhhhhhhhhh', 'h', 'h', 'h', 'h', 'h', 'h', 1);
