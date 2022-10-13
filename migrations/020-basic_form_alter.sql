alter table entity_report_basic
    add obiettivi text null after parte_di_piano;

alter table entity_report_basic
    add attivita text null after obiettivi;

alter table entity_report_basic
    add origine text null after attivita;

alter table entity_report_basic
    add soggetti_beneficiari text null after origine;

alter table entity_report_basic
    add contesto text null after soggetti_beneficiari;

alter table entity_report_basic
    add stato_di_avanzamento TINYINT null after avanzamento;
alter table entity_report_basic
    add stato_di_avanzamento_infrastrutturale tinyint default 0 null after stato_di_avanzamento;
alter table entity_report_basic
    add gs tinyint default 0 null after stato_di_avanzamento_infrastrutturale;

alter table entity_report_basic
    add problema_rilevato_1 tinyint default 0 null;
alter table entity_report_basic
    add problema_rilevato_2 tinyint default 0 null;
alter table entity_report_basic
    add problema_rilevato_3 tinyint default 0 null;
alter table entity_report_basic
    add problema_rilevato_4 tinyint default 0 null;
alter table entity_report_basic
    add problema_rilevato_5 tinyint default 0 null;
alter table entity_report_basic
    add problema_rilevato_6 tinyint default 0 null;
alter table entity_report_basic
    add questionario_utenti tinyint default 0 null after referenti_politici;
alter table entity_report_basic
    add questionario_altri tinyint default 0 null after questionario_utenti;
alter table entity_report_basic
    add cup_descr_natura text default null after stato_di_avanzamento;
alter table entity_report_basic
    add questionario_extra text default null after questionario_altri;


CREATE TABLE `meta_connection_relationship` (
                                                          `idmeta_connection_relationship` INT NOT NULL AUTO_INCREMENT,
                                                          `report` INT NOT NULL,
                                                          `r1_c2` TEXT NULL,
                                                          `r1_c3`   TEXT NULL,
                                                          `r1_c4`   TEXT NULL,
                                                          `r1_c5`   TEXT NULL,
                                                          `r1_c6`   TEXT NULL,
                                                          `r1_c7`   TEXT NULL,
                                                          `r1_c8`   TEXT NULL,
                                                          `r1_c9`   TEXT NULL,
                                                          `r1_c10`  TEXT NULL,
                                                          `r2_c3`   TEXT NULL,
                                                          `r2_c4`   TEXT NULL,
                                                          `r2_c5`   TEXT NULL,
                                                          `r2_c6`   TEXT NULL,
                                                          `r2_c7`   TEXT NULL,
                                                          `r2_c8`   TEXT NULL,
                                                          `r2_c9`   TEXT NULL,
                                                          `r2_c10`  TEXT NULL,
                                                          `r3_c4`   TEXT NULL,
                                                          `r3_c5`   TEXT NULL,
                                                          `r3_c6`   TEXT NULL,
                                                          `r3_c7`   TEXT NULL,
                                                          `r3_c8`   TEXT NULL,
                                                          `r3_c9`   TEXT NULL,
                                                          `r3_c10`  TEXT NULL,
                                                          `r4_c5`   TEXT NULL,
                                                          `r4_c6`   TEXT NULL,
                                                          `r4_c7`   TEXT NULL,
                                                          `r4_c8`   TEXT NULL,
                                                          `r4_c9`   TEXT NULL,
                                                          `r4_c10`  TEXT NULL,
                                                          `r5_c6`   TEXT NULL,
                                                          `r5_c7`   TEXT NULL,
                                                          `r5_c8`   TEXT NULL,
                                                          `r5_c9`   TEXT NULL,
                                                          `r5_c10`  TEXT NULL,
                                                          `r6_c7`   TEXT NULL,
                                                          `r6_c8`   TEXT NULL,
                                                          `r6_c9`   TEXT NULL,
                                                          `r6_c10`  TEXT NULL,
                                                          `r7_c8`   TEXT NULL,
                                                          `r7_c9`   TEXT NULL,
                                                          `r7_c10`  TEXT NULL,
                                                          `r8_c9`   TEXT NULL,
                                                          `r8_c10`  TEXT NULL,
                                                          `r9_c10`  TEXT NULL,
                                                          PRIMARY KEY (`idmeta_connection_relationship`));