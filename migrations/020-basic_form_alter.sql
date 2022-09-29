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