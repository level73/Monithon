create table file_imonitor_repository
(
    idfile_imonitor_repository int auto_increment
        primary key,
    imonitor                   int                                 null,
    label                      text                                null,
    type                       varchar(32)                         null,
    file_path                  varchar(255)                        null,
    file_size                  int                                 null,
    file_type                  varchar(255)                        null,
    created_at                 timestamp default CURRENT_TIMESTAMP null,
    modified_at                timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    constraint file_imonitor_repository_entity_imonitor_idimonitor_fk
        foreign key (imonitor) references entity_imonitor (idimonitor)
);
