<?php

class ImonitorRepo extends Model
{
    protected $table = 'file_imonitor_repository';



    public function upload($file){

        // Check File Info
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($file['tmp_name']),
                array(
                    'jpg'   => 'image/jpeg',
                    'png'   => 'image/png',
                    'gif'   => 'image/gif',
                    'doc'   => 'application/msword',
                    'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xls'   => 'application/vnd.ms-excel',
                    'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'csv'   => 'text/csv',
                    'pdf'   => 'application/pdf',

                ),
                true
            )) {
            $this->Errors->set(651);
        }

        // file ok, generate filename
        $filename = sha1_file($file['tmp_name']) . '.' . $ext;
        if(!move_uploaded_file( $file['tmp_name'], DIR_REPO . $filename )){
            $this->Errors->set(652);
            return false;
        }

        $insert_data = array(
            'label'       => $file['label'],
            'type'        => $file['type'],
            'imonitor'    => $file['imonitor'],
            'file_path'   => $filename,
            'file_size'   => $file['size'],
            'file_type'   => $file['file_type'],

        );
        $id = $this->create($insert_data);
        return $id;

    }

    public function getFiles($record, $type = null){
        $sql = 'SELECT
                fr.*                
              FROM '.$this->table.' AS fr
              WHERE fr.imonitor = :record
              ';

        if(!is_null($type)){
            if(is_array($type)){
                $sql .= ' AND fr.type IN (' . implode(',', $type) . ')';
            }
            else {
                $sql .= ' AND fr.type = :type ';
            }
        }
        $sql .= ' ORDER BY fr.label ASC, fr.modified_at DESC';

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':record', $record, PDO::PARAM_INT);
        if(!is_null($type) && !is_array($type)){
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        }
        $query = $stmt->execute();

        if(!$query){
            $this->Errors->set(502);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function getFile($id){
        $sql = 'SELECT * from '.$this->table.' WHERE ' . $this->pkey . ' = :id';
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $query = $stmt->execute();

        if(!$query){
            $this->Errors->set(502);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        }
        else {
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    public function checkOwner($id, $user){
        $sql = 'SELECT created_by AS owner FROM ' . $this->table . ' AS rr 
                INNER JOIN entity_imonitor AS erb ON erb.idimonitor = mrr.imonitor 
                WHERE ' . $this->pkey . ' = :id';

        //  echo $sql;

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $query = $stmt->execute();

        if(!$query){
            $this->Errors->set(502);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        }
        else {
            $check = $stmt->fetch(PDO::FETCH_OBJ);

            if($check->owner == $user->id){
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function deleteFile($file){
        if(is_object($file)){
            $id = $file->{$this->pkey};
            $path = DIR_REPO . $file->file_path;
            if(file_exists($path)){
                unlink($path);
            }
            $this->delete($id);

            return true;
        }


    }
}