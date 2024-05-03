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

alter table entity_report_lite
    add reviewed_by int null;

alter table entity_report_lite
    add constraint entity_report_lite_reviewd_by_auth_fk
        foreign key (reviewed_by) references auth (idauth);

alter table entity_report_lite add column (
    diffusione_twitter                    tinyint  null,
    diffusione_facebook                   tinyint  null,
    diffusione_instagram                  tinyint  null,
    diffusione_eventi                     tinyint  null,
    diffusione_open_admin                 tinyint  null,
    diffusione_blog                       tinyint  null,
    diffusione_offline                    tinyint  null,
    diffusione_incontri                   tinyint  null,
    diffusione_interviste                 tinyint  null,
    diffusione_altro                      text     null,
    media_connection                      tinyint  null,
    tv_locali                             tinyint  null,
    tv_nazionali                          tinyint  null,
    giornali_locali                       tinyint  null,
    giornali_nazionali                    tinyint  null,
    blog_online                           tinyint  null,
    media_other                           text     null,
    admin_connection                      tinyint  null,
    admin_response_no                     tinyint  null,
    admin_response_formal                 tinyint  null,
    admin_response_some                   tinyint  null,
    admin_response_promises               tinyint  null,
    admin_response_unlocked               tinyint  null,
    admin_response_flagged                tinyint  null,
    admin_altro                           text    null,
    impact_description                    text    null,
    status_impact                         tinyint  default 1 null
    );

alter table meta_connection
    add entity int default 2 not null after report;