<?php
class Profile extends Model {

    public function gsByCreator($id){
        $sql = 'SELECT COUNT(idreport_basic) AS counter, giudizio_sintetico FROM entity_report_basic WHERE created_by = :id GROUP BY giudizio_sintetico';
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

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