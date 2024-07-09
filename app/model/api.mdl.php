<?php

  class Api extends Model {
        public function periodReports() {

            $sql = "SELECT 
                        idreport_basic AS uid, 
                        titolo AS title, 
                        autore AS author, 
                        modified_at AS modified_at, 
                        created_at AS created_at, 
                        api_data, 
                        is_gender_topic AS has_gender_policy, 
                        lat_ AS latitude, lon_ AS longitude
                    FROM entity_report_basic 
                    WHERE status = 7 AND created_at > '2022-09-07'";

            $stmt = $this->database->prepare($sql);



            $query = $stmt->execute();
            if(!$query){
                $this->Errors->set(501);
                if(SYSTEM_STATUS == 'development'){
                    dbga($stmt->errorInfo());
                }
                return $this->Errors;
            } else {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }

        }
  }
