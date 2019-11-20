<?php
  class Repo extends Model {

    protected $table = 'file_repository';

    public function upload($file, $data){

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
      }
      else {
        // Manage Logos
        if($data['file_type'] == 1){
          $this->resize(DIR_REPO . $filename, $filename, 270, 270, $ext);
          $this->resize(DIR_REPO . $filename, $filename, 180, 180, $ext);
          $this->resize(DIR_REPO . $filename, $filename, 90, 90, $ext);

          /** Crops **/
          $fileCrop =
          $this->squarecrop($filename, $filename, 180, $ext);
          $this->squarecrop($filename, $filename, 90, $ext);
        }
        // upload Metadata

        $insert_data = array(
          'title'       => $data['title'],
          'file_path'   => $filename,
          'file_size'   => $file['size'],
          'file_type'   => $data['file_type'],
          'disclosure'  => $data['disclosure'],
          'modified_by' => $data['uid']
        );
        $id = $this->create($insert_data);
        return $id;
      }
    }

    public function getFiles($entity, $record, $type = null){
      $sql = 'SELECT
                fr.*,
                mfr.*,
                lft.title AS file_type_label
              FROM '.$this->table.' AS fr
              INNER JOIN meta_file_repository AS mfr ON mfr.file_repository = fr.idfile_repository
              INNER JOIN lexicon_file_type AS lft ON lft.idlexicon_file_type = fr.file_type
              WHERE mfr.entity = :entity AND mfr.record = :record
              ';

      if(!is_null($type)){
        if(is_array($type)){
          $sql .= ' AND fr.file_type IN (' . implode(',', $type) . ')';
        }
        else {
          $sql .= ' AND fr.file_type = :type ';
        }
      }
      $sql .= ' ORDER BY fr.title ASC, fr.modified_at DESC';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
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

    public function getFileTypes(){
      $sql = 'SELECT * FROM lexicon_file_type';
      $stmt = $this->database->prepare($sql);

      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function unsetFileMeta($id){
      $sql = 'DELETE FROM meta_file_repository WHERE file_repository = :id';
      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $query = $stmt->execute();
      if($query){
        return true;
      }
      else {
        return false;
      }
    }

    public function resize($file, $name, $w, $h, $ext){
      list($width, $height) = getimagesize($file);

      $ratio = $width / $height;
      if($w/$h > $ratio){
        $newWidth   = $h * $ratio;
        $newHeight  = $h;
      }
      else {
        $newHeight = $w/$ratio;
        $newWidth = $w;
      }
      if($ext == 'jpg'){
        $src = imagecreatefromjpeg($file);
      }
      elseif($ext == 'png') {
        $src = imagecreatefrompng($file);

      }
      $dst = imagecreatetruecolor($newWidth, $newHeight);
      imagealphablending($dst, false );
      imagesavealpha($dst, true );
      imagecopyresampled($dst, $src, 0,0,0,0, $newWidth, $newHeight, $width, $height);

      if($ext == 'jpg'){
          imagejpeg($dst, DIR_REPO . $w .'x' . $h . '_' . $name, 85);
      }
      elseif($ext == 'png') {
          imagepng($dst, DIR_REPO .  $w .'x' . $h . '_' . $name );
      }
    }

    public function squarecrop($file, $name, $side, $ext){
      $file = DIR_REPO . $side . 'x' . $side . '_' . $file;
      list($width, $height) = getimagesize($file);

      if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
      } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
      }

      if($ext == 'jpg'){
        $src = imagecreatefromjpeg($file);
      }
      elseif($ext == 'png') {
        $src = imagecreatefrompng($file);
      }

      $crop = imagecreatetruecolor($side, $side);
      imagecopyresampled($crop, $src, 0, 0, $x, $y, $side, $side, $smallestSide, $smallestSide);

      if($ext == 'jpg'){
          imagejpeg($crop, DIR_REPO . 'cropx' . $side . '_' . $name, 85);
      }
      elseif($ext == 'png') {
          imagepng($crop, DIR_REPO .  'cropx' . $side . '_' . $name );
      }
    }

    public function getInfo($file){
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $info = $finfo->file($file);
      return $info;
    }

  }
