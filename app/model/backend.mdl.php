<?php

class Backend extends Model
{
    public function reports(){
        $sql = 'SELECT 
                    `erb`.`idreport_basic`,
                    `erb`.`titolo`,
                    `erb`.`autore`,
                    `erb`.`id_open_coesione`,
                    `erb`.`api_data`,
                    `erb`.`oc_project_code`,
                    `erb`.`indirizzo`,
                    `erb`.`cap`,
                    `erb`.`lat_`,
                    `erb`.`lon_`,
                    `erb`.`descrizione`,
                    `erb`.`parte_di_piano`,
                    `erb`.`giudizio_sintetico`,
                    `erb`.`avanzamento`,
                    `erb`.`risultato_progetto`,
                    `erb`.`valutazione_risultati`,
                    `erb`.`punti_di_forza`,
                    `erb`.`punti_deboli`,
                    `erb`.`problemi_amministrativi`,
                    `erb`.`diffusione_twitter`,
                    `erb`.`diffusione_facebook`,
                    `erb`.`diffusione_instagram`,
                    `erb`.`diffusione_eventi`,
                    `erb`.`diffusione_open_admin`,
                    `erb`.`diffusione_blog`,
                    `erb`.`diffusione_offline`,
                    `erb`.`diffusione_incontri`,
                    `erb`.`diffusione_interviste`,
                    `erb`.`diffusione_altro`,
                    `erb`.`media_connection`,
                    `erb`.`tv_locali`,
                    `erb`.`tv_nazionali`,
                    `erb`.`giornali_locali`,
                    `erb`.`giornali_nazionali`,
                    `erb`.`blog_online`,
                    `erb`.`media_other`,
                    `erb`.`admin_connection`,
                    `erb`.`admin_response_no`,
                    `erb`.`admin_response_formal`,
                    `erb`.`admin_response_some`,
                    `erb`.`admin_response_promises`,
                    `erb`.`admin_response_unlocked`,
                    `erb`.`admin_response_flagged`,
                    `erb`.`admin_altro`,
                    `erb`.`impact_description`,
                    `erb`.`rischi`,
                    `erb`.`soluzioni_progetto`,
                    `erb`.`raccolta_informazioni`,
                    `erb`.`visita_diretta`,
                    `erb`.`intervista_responsabili_progetto`,
                    `erb`.`intervista_utenti_beneficiari`,
                    `erb`.`intervista_altri_utenti`,
                    `erb`.`intervista_autorita_gestione`,
                    `erb`.`intervista_soggetto_programmatore`,
                    `erb`.`raccolta_info_web`,
                    `erb`.`raccolta_info_attuatore`,
                    `erb`.`referenti_politici`,
                    `erb`.`intervista_intervistati`,
                    `erb`.`intervista_domande`,
                    `erb`.`intervista_risposte`,
                    `erb`.`problemi_tecnici`,
                    `erb`.`risultato_insoddisfacente`,
                    `erb`.`non_efficace`,
                    `erb`.`non_sufficiente`,
                    `erb`.`necessita_interventi_extra`,
                    `erb`.`created_at`,
                    `erb`.`modified_at`,
                    `erb`.`created_by`,
                    `erb`.`reviewed_by`,
                    `erb`.`status`,
                    `erb`.`status_tab_3`,
                    `erb`.`tab_3_created_at`,
                    `erb`.`author_type`,
                    `erb`.`legacy_id`,
                    `erb`.`immagine_monitoraggio_daASOC`,
                    `erb`.`video_daASOC`,
                    `erb`.`immagine_team1_daASOC`,
                    `erb`.`immagine_team2_daASOC`,
                    `erb`.`immagine_team3_daASOC`,
                    a.username,
                    a.city,
                    a.bio,
                    ea.`remote_id`,ea.`istituto`,ea.`tipo_istituto`,ea.`comune`,ea.`link_blog`,ea.`link_elaborato`,ea.provincia, ea.shorthand, ea.region 
                FROM entity_report_basic AS erb  
                    LEFT JOIN auth AS a ON a.idauth = erb.created_by 
                    LEFT JOIN (
                        SELECT 
                        `remote_id`,`istituto`,`tipo_istituto`,`comune`,`link_blog`,`link_elaborato`,`auth`, lp.provincia, lp.shorthand, lr.region 
                        FROM `entity_asoc` as ea1 
                        LEFT JOIN lexicon_region AS lr ON lr.idregion = ea1.regione 
                        LEFT JOIN lexicon_provincia AS lp ON lp.idprovincia = ea1.provincia 
                        WHERE auth != 349
                    ) AS ea ON ea.auth = a.idauth  
                WHERE erb.status >= 7
                ORDER BY idreport_basic ASC';
        $stmt = $this->database->prepare($sql);
        $query = $stmt->execute();
        if($query){
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        else {
            return false;
        }
    }
}