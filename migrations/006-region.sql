CREATE TABLE `monithon`.`lexicon_region` (
  `idregion` INT NOT NULL AUTO_INCREMENT,
  `region` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idregion`));

CREATE TABLE `monithon`.`meta_region` (
  `idmeta_region` INT NOT NULL,
  `entity` INT NULL,
  `record` INT NULL,
  `region` INT NULL,
  PRIMARY KEY (`idmeta_region`),
  INDEX `fk_region_meta_region_idx` (`region` ASC),
  CONSTRAINT `fk_region_meta_region`
    FOREIGN KEY (`region`)
    REFERENCES `monithon`.`lexicon_region` (`idregion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('1', 'Abruzzo');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('2', 'Basilicata');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('4', 'Campania');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('5', 'Emilia-Romagna');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('3', 'Calabria');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('6', 'Friuli - Venezia Giulia');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('7', 'Lazio');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('8', 'Liguria');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('9', 'Lombardia');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('10', 'Marche');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('11', 'Molise');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('12', 'Piemonte');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('13', 'Puglia');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('14', 'Sardegna');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('15', 'Sicilia');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('16', 'Toscana');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('17', 'Trentino - Alto Adige');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('18', 'Umbria');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('19', 'Valle d\'Aosta');
INSERT INTO `monithon`.`lexicon_region` (`idregion`, `region`) VALUES ('20', 'Veneto');


CREATE TABLE `monithon`.`lexicon_provincia` (
  `idprovincia` INT NOT NULL AUTO_INCREMENT,
  `provincia` VARCHAR(255) NOT NULL,
  `shorthand` VARCHAR(6) NULL,
  PRIMARY KEY (`idprovincia`));

ALTER TABLE `monithon`.`lexicon_provincia`
ADD COLUMN `region` INT NOT NULL AFTER `shorthand`,
ADD INDEX `fk_provincia_region_idx` (`region` ASC);
;
ALTER TABLE `monithon`.`lexicon_provincia`
ADD CONSTRAINT `fk_provincia_region`
  FOREIGN KEY (`region`)
  REFERENCES `monithon`.`lexicon_region` (`idregion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Agrigento", "AG",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Alessandria", "AL",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ancona", "AN",	10	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Aosta", "AO",	19	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Arezzo", "AR",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ascoli Piceno", "AP",	10	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Asti", "AT",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Avellino", "AV",	4	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Bari", "BA",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Barletta-Andria-Trani", "BT",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Belluno", "BL",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Benevento", "BN",	4	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Bergamo", "BG",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Biella", "BI",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Bologna", "BO",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Bolzano", "BZ",	17	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Brescia", "BS",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Brindisi", "BR",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Cagliari", "CA",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Caltanissetta", "CL",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Campobasso", "CB",	11	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Carbonia-Iglesias", "CI",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Caserta", "CE",	4	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Catania", "CT",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Catanzaro", "CZ",	3	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Chieti", "CH",	1	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Como", "CO",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Cosenza", "CS",	3	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Cremona", "CR",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Crotone", "KR",	3	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Cuneo", "CN",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Enna", "EN",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Fermo", "FM",	10	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ferrara", "FE",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Firenze", "FI",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Foggia", "FG",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Forlì-Cesena", "FC",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Frosinone", "FR",	7	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Genova", "GE",	8	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Gorizia", "GO",	6	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Grosseto", "GR",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Imperia", "IM",	8	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Isernia", "IS",	11	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("La Spezia", "SP",	8	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("L'Aquila", "AQ",	1	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Latina", "LT",	7	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Lecce", "LE",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Lecco", "LC",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Livorno", "LI",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Lodi", "LO",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Lucca", "LU",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Macerata", "MC",	10	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Mantova", "MN",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Massa-Carrara", "MS",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Matera", "MT",	2	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Messina", "ME",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Milano", "MI",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Modena", "MO",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Monza e della Brianza", "MB",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Napoli", "NA",	4	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Novara", "NO",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Nuoro", "NU",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Olbia-Tempio", "OT",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Oristano", "OR",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Padova", "PD",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Palermo", "PA",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Parma", "PR",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pavia", "PV",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Perugia", "PG",	18	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pesaro e Urbino", "PU",	10	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pescara", "PE",	1	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Piacenza", "PC",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pisa", "PI",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pistoia", "PT",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Pordenone", "PN",	6	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Potenza", "PZ",	2	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Prato", "PO",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ragusa", "RG",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ravenna", "RA",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Reggio Calabria", "RC",	3	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Reggio Emilia", "RE",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Rieti", "RI",	7	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Rimini", "RN",	5	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Roma", "RM",	7	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Rovigo", "RO",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Salerno", "SA",	4	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Medio Campidano", "VS",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Sassari", "SS",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Savona", "SV",	8	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Siena", "SI",	16	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Siracusa", "SR",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Sondrio", "SO",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Taranto", "TA",	13	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Teramo", "TE",	1	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Terni", "TR",	18	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Torino", "TO",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Ogliastra", "OG",	14	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Trapani", "TP",	15	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Trento", "TN",	17	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Treviso", "TV",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Trieste", "TS",	6	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Udine", "UD",	6	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Varese", "VA",	9	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Venezia", "VE",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Verbano-Cusio-Ossola", "VB",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Vercelli", "VC",	12	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Verona", "VR",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Vibo Valentia", "VV",	3	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Vicenza", "VI",	20	);
INSERT INTO lexicon_provincia (provincia, shorthand, region) VALUES("Viterbo", "VT",	7	);

CREATE TABLE `monithon`.`meta_provincia` (
  `idmeta_provincia` INT NOT NULL,
  `entity` INT NULL,
  `record` INT NULL,
  `provincia` INT NULL,
  PRIMARY KEY (`idmeta_provincia`),
  INDEX `fk_provincia_meta_provincia_idx` (`provincia` ASC),
  CONSTRAINT `fk_provincia_meta_provincia`
    FOREIGN KEY (`provincia`)
    REFERENCES `monithon`.`lexicon_provincia` (`idprovincia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
