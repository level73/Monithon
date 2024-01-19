create table entity_report_lite
(
    idreport_lite        int auto_increment,
    project_url          varchar(255)                       null,
    project_code         varchar(255)                       null,
    api_data             JSON                               null,
    q1                   text                               null,
    q2                   text                               null,
    stato_di_avanzamento int                                null,
    giudizio_sintetico   int                                null,
    giudizio             text                               null,
    status               int                                null,
    created_at           datetime default CURRENT_TIMESTAMP null,
    modified_at          datetime default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    created_by           int                                null,
    constraint entity_report_lite_pk
        primary key (idreport_lite),
    constraint entity_report_lite_auth_idauth_fk
        foreign key (created_by) references auth (idauth)
);

create index entity_report_lite_giudizio_sintetico_index
    on entity_report_lite (giudizio_sintetico);

create index entity_report_lite_project_code_index
    on entity_report_lite (project_code);

create index entity_report_lite_stato_di_avanzamento_index
    on entity_report_lite (stato_di_avanzamento);