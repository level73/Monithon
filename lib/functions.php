<?php

/** Function Library **/

/** #DEBUGGING **/
function dbga($array){

  echo "<div class=\"clearfix\"><pre>";
  print_r($array);
  echo "</pre></div>";
}

/** Style and Script loader **/
function loadCSS($css){
  if(!empty($css)){
    if(is_array($css)){
      foreach($css as $i => $file){
        echo "<link href=\"/public/css/" . $file . "\" rel=\"stylesheet\" type=\"text/css\" />\n";
      }
    }
    else {
      echo "<link href=\"/public/css/" . $css . "\" rel=\"stylesheet\" type=\"text/css\" />\n";
    }
  }
}

function loadJS($js){
  if(!empty($js)){
    if(is_array($js)){
      foreach($js as $i => $file){
        echo "<script src=\"/public/js/" . $file . "\"></script>\n";
      }
    }
    else {
      echo "<script src=\"/public/js/" . $file . "\"></script>\n";
    }
  }
}

function cssify($string){
    return strtolower(str_replace(' ', '-', cleanString($string)));
}

function image($image, $size = null){
    if(!is_null($size)){
        return URL_REPO. $size . '_' . $image->file_path;
    }
    else {
        return URL_REPO . $image->file_path;
    }
}
/** UTF8 Encoding deep for API calls **/
function utf8_encode_deep(&$input) {
	if (is_string($input)) {
		$input = utf8_encode($input);
	} else if (is_array($input)) {
		foreach ($input as &$value) {
			utf8_encode_deep($value);
		}

		unset($value);
	} else if (is_object($input)) {
		$vars = array_keys(get_object_vars($input));

		foreach ($vars as $var) {
			utf8_encode_deep($input->$var);
		}
	}
}

/** check for http server vars
  * @var string $method: the http method to check
  * @var bool $not_empty: check if the var is also filled with values
  * @return bool true if method used corresponds to what is being checked
  */
function httpCheck($method = 'post', $not_empty = false){
    $METHOD = strtoupper($method);
    if(strtoupper($_SERVER['REQUEST_METHOD']) === $METHOD){
        if($not_empty){
            if($METHOD == 'POST'){
                return (isset($_POST) && !empty($_POST) && count(array_keys($_POST)) > 0) ? true : false;
            } elseif($METHOD == 'GET') {
                return (isset($_GET) && !empty($_GET) && count(array_keys($_GET)) > 0) ? true : false;
            }
        }
        return true;
    } else {
        return false;
    }
}

/** check for value **/
function ckv($arr, $key){
  return (
    is_array($arr) && isset($arr) && (
      isset($arr[$key]) || array_key_exists($key, $arr) ) ?
      $arr[$key] : null
    );
}

function ckv_object($obj, $property){
  return (
    is_object($obj) && isset($obj) && (
      isset($obj->{$property})
    ) ?
    $obj->{$property} : null
  );
}

/** Database functions **/
function query_placeholders($params, $insert = false){
  $placeholders = array();
  if($insert == true){
    foreach($params as $field => $value){
      $placeholders[] = ':'.$field;
    }
  }
  else {
    foreach($params as $field => $value){
      $placeholders[] = $field . ' = :'.$field;
    }
  }
  return $placeholders;
}

/** Date format Print **/
function displayDate($date){
  if(!is_null($date)){
    $Date = DateTime::createFromFormat('Y-m-d', $date);
    return $Date->format('d/m/Y');
  }
  else {
    return null;
  }
}

/** Date Formatter for API dates
  * OC API dates come in the YYYYMMDD format
  * This function should be used to display these dates on the frontend
 **/
function ocDateFormatter($date){
    $date = substr_replace($date, '-', 4, 0);
    $date = substr_replace($date, '-', -2, 0);
    return displayDate($date);
}

/** check for value in meta object, return selected/checked **/
function metaCheck($meta, $data, $value, $type = 'select'){
  if(!empty($data)){
    foreach($data as $i){
      if($i->{$meta} == $value){
        return ($type == 'select' ? ' selected ' : ' checked ');
      }
    }
    return '';
  }
}

/** rearrange $_FILES **/
function rearrange_files($file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}

function rearrange_files_imonitor($File_Post, $Data_Post){
    // Get value of keys
    $keys = array_keys($File_Post['name']['files']);
   // dbga($keys);

    $files_array = array();
    foreach($keys as $key){
        $files_array[$key]['name'] = $File_Post['name']['files'][$key]['file'];
        $files_array[$key]['full_path'] = $File_Post['full_path']['files'][$key]['file'];
        $files_array[$key]['file_type'] = $File_Post['type']['files'][$key]['file'];
        $files_array[$key]['tmp_name'] = $File_Post['tmp_name']['files'][$key]['file'];
        $files_array[$key]['error'] = $File_Post['error']['files'][$key]['file'];
        $files_array[$key]['size'] = $File_Post['size']['files'][$key]['file'];
        $files_array[$key]['label'] = $Data_Post[$key]['label'];
        $files_array[$key]['type'] = $Data_Post[$key]['type'];
    }
    return $files_array;
}

/** Shorten long titles **/
function hellip($title, $length = 60){
  return (strlen($title) > $length ? substr($title, 0, $length) . '&hellip;' : $title);
}
/** Check if user has permission **/
function hasPermission($user, $permission){
    $permissions = array_keys($user->permissions);
    if(is_array($permission)){
      foreach($permission as $p){
        if(in_array($p, $permissions)){
          return true;
        }
        else {
          return false;
        }
      }
    }
    else {
      if(in_array($permission, $permissions)){
        return true;
      }
      else {
        return false;
      }
    }
}

/** Check value for meta tables **/
function filterForMeta($data, $field){
  return (isset($data[$field]) && !empty($data[$field]) ?  (is_array($data[$field]) ? filter_var_array($data[$field], FILTER_SANITIZE_NUMBER_INT) : filter_var($data[$field], FILTER_SANITIZE_NUMBER_INT) ): null);
}

/** Check file type and echo format **/
function typeOfFile($mime){
  if(in_array($mime, array( 'jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'))){ return 'image'; }
  elseif(in_array($mime, array('xls' => 'application/vnd.ms-excel', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'csv' => 'text/csv',))){ return 'spreadsheet'; }
  elseif(in_array($mime, array( 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',))){ return 'document'; }
  else{ return 'pdf'; }
}

/** Clean string - converts to flat chars, no accents or punctuation **/
function cleanString($string){
    $unwanted_array = array(
                        'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A',
                        'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C',
                        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I',
                        'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
                        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U',
                        'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss', 'à'=>'a', 'á'=>'a',
                        'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i',
                        'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
                        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u',
                        'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ğ'=>'G',
                        'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i', 'ş'=>'s', 'ü'=>'u',
                        'ă'=>'a', 'Ă'=>'A', 'ș'=>'s', 'Ș'=>'S', 'ț'=>'t', 'Ț'=>'T'
                        );
    return strtr( $string, $unwanted_array );
}

function emptyParagraph($str){
  if(empty( strip_tags(trim(trim( str_replace('N.A.', '', $str)))) )){
    return true;
  }
  else {
    return false;
  }
}

/** make printable list from multidimensional array of objects **/
function printList($array, $prop, $print = false){
  $list = array();
  foreach($array as $i){
    $list[] = $i->$prop;
  }
  $list = implode(', ', $list);
  if($print == true){
    echo $list;
  }
  return $list;
}


function FileSizeConvert($bytes){
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

/** Recursive Strip Tags **/
function recursiveStripTags($data) {
  foreach ($data as $key => $value) {
    if(is_array($value)) {
      $data[$key] = recursiveStripTags($value);
    }
    else {
      $data[$key] = strip_tags($value);
    }
  }
  return $data;
}

/** Print Styles for status **/
function status($status){
  switch($status){
    case 1:
      $string = 'BOZZA';
      break;
    case 3:
      $string = 'IN ATTESA DI REVISIONE';
      break;
    case 5:
      $string = 'IN REVISIONE';
      break;
    case 7:
      $string = 'PUBBLICATO';
      break;
    default:
      $status = 0;
      $string = 'N.A.';
      break;
  }
  $s = '<div class="status status-' . $status . '" data-toggle="tooltip" data-placement="top" title="' . $string . '"></div>';
  echo $s;
}

function user_status($status){
  if($status == 2){
    $string = 'ATTIVO';
  }
  else {
    $string = 'NON ATTIVO';
  }
  echo '<div class="user_status user_status-'.$status.'" data-toggle="tooltip" data-placement="top" title="' . $string . '"></div>';
}

function avatar($Profile, $large = false, $responsive = false, $avatar_class = 'avatar'){
    if($large == true &&  (isset($Profile->avatar->file_path) && file_exists(ROOT . DS . 'public' . DS . 'resources' . DS . 'cropx180_' . $Profile->avatar->file_path))){
        echo '<img src="/resources/cropx180_' . $Profile->avatar->file_path . '" alt="AVATAR" class="'.$avatar_class.' img-responsive ' . ($responsive == true ? 'img-fluid' : '') . '">';
    }
    elseif (isset($Profile->avatar->file_path) && file_exists(ROOT . DS . 'public' . DS . 'resources' . DS . 'cropx90_' . $Profile->avatar->file_path)){
        echo '<img src="/resources/cropx90_' . $Profile->avatar->file_path . '" alt="AVATAR" class="'.$avatar_class.' img-responsive ' . ($responsive == true ? 'img-fluid' : '') . '">';
    }
    else {
        echo '<img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed='.urlencode(strtolower(str_replace(' ', '_', $Profile->username))).'&background=' . urlencode('#FFFFFF') . '" class="'.$avatar_class.' img-responsive img-fluid">';
    }
}

function showComment($comments, $field){
    foreach($comments as $comment){
        if($comment->field == $field){
            echo '<div class="commented-wrapper ' . ($comment->status == 3 ? 'status-solved' : 'status-pending') . '">';
            echo   '<span class="timestamp">' . strftime('%d/%m/%Y %H:%M', strtotime($comment->created_at)) . '</span>';
            if($comment->status == 3){
                   echo '<span class="badge badge-success float-right">risolto</span>';
            }
            else {
                echo '<button class="btn btn-sm btn-default commented-delete" type="button" data-comment="' . $comment->idcomment . '"><i class="far fa-times"></i></button>';
            }

            echo    '<div class="commented-text">' . $comment->comment . '</div>
                  </div>';
        }
    }
}


/** Prepare Video URLs for Embedding **/
function prepareEmbed($url){
    // Check if Youtube or Vimeo
    if(stristr($url, 'youtube.com/watch')){
        //get ID
        $split = str_split($url, strpos($url, 'v='));
        echo $split;
    }
    else if(stristr('youtu.be')){

    }
    else if(stristr($url, 'vimeo')){

    }
    else {
        return $url;
    }
}

// Convert Giudizio Sintetico to INT vals for
function GS_to_int($string){
    $vals = array('N.D.', 'Appena iniziato', 'In corso e procede bene', 'Procede con difficoltà', 'Bloccato', 'Concluso e utile', 'Concluso e inefficace');
    if(in_array($string, $vals)){
        return array_search($string, $vals);
    }
    else {
        return 7;
    }
}

// Check for ASOC Exp Badge
function AsocExp($report){
    echo $report->ASOC_EXP==true ? '<a href="https://www.ascuoladiopencoesione.it/it/asoc-experience-contest" target="_blank" class="asoc-exp-badge">ASOC Experience - Il Monitoraggio Continua!</a>' : '';
}


function t($string){ echo $string; }



function apiHellip($text){
    if(strlen($text) > 500){
        $text = substr($text, 0, 494) . '...';
    }
    return $text;
}

function themeToCode($theme){
    $themes = array(
        "Ricerca e innovazione" => "01",
      "Agenda digitale" => "02",
      "Competività imprese" => "03",
      "Energia" => "04",
      "Ambiente" => "05",
      "Cultura e turismo"  => "06",
        "Trasporti"  => "07",
        "Occupazione"  => "08",
        "Inclusione sociale"  => "09",
        "Infanzia e anziani"  => "10",
        "Istruzione"  => "11",
        "Città e aree rurali"  => "12",
        "Rafforzamento PA"  => "13",

    );

    return (array_key_exists($theme, $themes) ? $themes[$theme] : -1);
}

function reportListItems($report, $list){
    $list_entry = array();
    foreach($list as $prop => $txt){
        if($report->{$prop} > 0){
            $label = t_report($txt, false);
            $list_entry[] = '<li>' . $label . '</li>';
        }
    }

    echo implode('', $list_entry);
}

function cycleAnswers($field){
    switch($field){
        case 1:
            return 'SI';
            break;
        case 2:
            return 'NO';
            break;
        case 3:
            return 'NON SAPREI';
            break;
        default:
            return 'N.D.';
    }
}

function generateGDELabel($gde, $sda, $type, $print = true){
    if($sda < 3){
        $labels = GDE_LABELS['labels_opt_1'];
    } elseif($sda < 6){
        $labels = GDE_LABELS['labels_opt_2'];
    }
    else{
        $labels = GDE_LABELS['labels_opt_3'];
    }

    if($print){
        echo $labels[$gde][$type];
        return null;
    }
    else {
        return $labels[$gde][$type];
    }

}

/*** iMonitor Helpers **/
function cvo($object, $prop){
    return (
    is_object($object) && isset($object) && (
    isset($object->{$prop})
    ) ?
        $object->{$prop} : null
    );
}
function placeholderize($str){
    echo ucfirst(strtolower($str)) . '&hellip;';
}

function evaluateCB($data, $field){
    return (array_key_exists($field, $data) ?  1 : 0);
}

/** PDF Generation Helpers **/

function setData($label, $value, $options = array()){
    $html = '';
    if(!empty( $value )):
        $html = '<p><strong>' . $label . ':</strong> ';
        if(in_array('link', $options)):
            $html .= '<a href="' . $value . '">' . $value . '</a>';
        elseif(in_array('boolean', $options)):
            $html .= boolean_flip($value);
        elseif(in_array('policy', $options)):
            $html .= policy_map($value);
        elseif(in_array('contract_type', $options)):
            $html .= contract_type_map($value);
        elseif(in_array('date', $options)):
            $html .= $value;
        elseif(in_array('triple', $options)):
            $html .= triple($value);
        elseif(in_array('sites', $options)):
            $html .= sites($value);
        elseif(in_array('inspections', $options)):
            $html .= inspections($value);
        elseif(in_array('subcontractors', $options)):
            $html .= subcontractors($value);
        elseif(in_array('interviews', $options)):
            $html .= interviews($value);
        elseif(in_array('connections', $options)):
            $html .= connections($value);
        elseif(in_array('implementation_status', $options)):
            $html .= implementation_status($value);
        elseif(in_array('admin_responses', $options)):
            $html .= admin_responses($value);
        else:
            $html .= $value;
        endif;
        $html .= '</p>';
    endif;
    return $html;
}
function boolean_flip($value){
    return ( $value == 1 || strtolower($value) == 'yes' || $value == 2 ?  GENERIC_RADIOLABEL_YES : GENERIC_RADIOLABEL_NO );
}
function policy_map($policy){
    switch($policy):
        case 1: return S1SA_OPTION_MAINPOLICY_1;
        case 2: return S1SA_OPTION_MAINPOLICY_2;
        case 3: return S1SA_OPTION_MAINPOLICY_3;
        case 4: return S1SA_OPTION_MAINPOLICY_4;
    endswitch;
}
function contract_type_map($type){
    switch($type):
        case 'Goods': return S1SB_RADIOLABEL_CONTRACTTYPE_1;
        case 'Works': return S1SB_RADIOLABEL_CONTRACTTYPE_2;
        case 'Services': return S1SB_RADIOLABEL_CONTRACTTYPE_3;
        default: return 'N.A.';
    endswitch;
}

function sites($sites){
    $sites = json_decode($sites, true);
    $return = '<ul>';
    foreach($sites as $site){
        $return .= '<li><a href="https://www.google.com/maps/place/' . $site['lat']. ',' . $site['lng'] . '">' . $site['address'] . '</a> (' . $site['lat']. ', ' . $site['lng'] . ')</li>';
    }
    $return .= '</ul>';
    return $return;
}
function subcontractors($subs){
    $subs = json_decode($subs, true);
    $return = '<ul>';
    foreach($subs as $sub){
        $return .= '<li>' . S1SB_FIELD_SUBCONTRACTORS_NAME . ': ' . $sub['name'] . ' (' .S1SB_FIELD_SUBCONTRACTORS_VALUE. ': ' . $sub['value'] . ' €)</li>';
    }
    $return .= '</ul>';
    return $return;
}

function connections($connections){
    $connections = json_decode($connections, true);
    $return = '<ul>';
    foreach($connections as $connection){
        $return .= '<li>['.$connection['connectiontype'].'] - ' . S3S_LABEL_CONNECTION_PERSON_NAME . ': ' . $connection['name'] . ' (' .S3S_LABEL_CONNECTION_PERSON_ROLE. ': ' . $connection['role'] . ' - ' . $connection['org'] . ')</li>';
    }
    $return .= '</ul>';
    return $return;
}

function interviews($subs){
    $subs = json_decode($subs, true);
    $return = '<ul>';
    foreach($subs as $sub){
        $return .= '<li>' . $sub['name'] . ' (' . $sub['role'] . ')</li>';
    }
    $return .= '</ul>';
    return $return;
}

function triple($value){
    switch($value):
        case 'yes': return GENERIC_RADIOLABEL_YES;
        case 'no': return GENERIC_RADIOLABEL_NO;
        case 'unknown': return GENERIC_RADIOLABEL_UNKNOWN;
        endswitch;
}

function inspections($value){
    $sites = json_decode($value, true);
    $return = '<ul>';
    foreach($sites as $site){
        $return .= '<li>' . $site['site'] . ' (' . $site['date'] . ')</li>';
    }
    $return .= '</ul>';
    return $return;
}

function implementation_status($value){
    switch($value):
        case 1: return S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_1 . ' - ' . S2SA_HELP_IMPLEMENTATIONSTATUS_1;
        case 2: return S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_2 . ' - ' . S2SA_HELP_IMPLEMENTATIONSTATUS_2;
        case 3: return S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_3 . ' - ' . S2SA_HELP_IMPLEMENTATIONSTATUS_3;
    endswitch;
}
function admin_responses($value){
    switch($value):
        case 1: return S3S_OPTION_ADMINISTRATIONQUESTIONS_1;
        case 2: return S3S_OPTION_ADMINISTRATIONQUESTIONS_2;
        case 3: return S3S_OPTION_ADMINISTRATIONQUESTIONS_3;
        case 4: return S3S_OPTION_ADMINISTRATIONQUESTIONS_4;
        case 5: return S3S_OPTION_ADMINISTRATIONQUESTIONS_5;
        case 6: return S3S_OPTION_ADMINISTRATIONQUESTIONS_6;
    endswitch;
}

function setDocuments($docs){
    $return = '<ul>';
    foreach($docs as $doc){
        $return .= '<li><a href="' . APPURL .  '/resources/' . $doc->file_path . '">' . $doc->label . '</a> (' . $doc->type . ') - ' . FileSizeConvert($doc->file_size) . '</li>';
    }
    $return .= '</ul>';
    return $return;
}
function imageEmbed($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    if(!$data):
        return false;
    else:
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    endif;
}

function colorCalculator($val){
    if(empty($val)):
        return 'rgb(111,111,111)';
    else:
        $rounded_val = round($val);
        $colors = array(
            0 => 'rgb(231,39,14)',
            1 => 'rgb(246,91,22)',
            2 => 'rgb(255,148,31)',

            3 => 'rgb(255,202,39)',
            4 => 'rgb(255,240,44)',
            5 => 'rgb(255,243,43)',

            6 => 'rgb(171,240,39)',
            7 => 'rgb(107,220,33)',
            8 => 'rgb(50,198,26)',
            9 => 'rgb(2,182,22)'
        );

        $color_index = ( $rounded_val == 100 ? 9 : $rounded_val/10);
        $color = $colors[$color_index];
        return $color;
    endif;
}

function generateRadials($val){

}

/** Report Lite View helpers */
function checkDiffusione($report){
    if(   $report->diffusione_twitter == 1 ||
        $report->diffusione_facebook == 1 ||
        $report->diffusione_instagram == 1 ||
        $report->diffusione_eventi == 1 ||
        $report->diffusione_open_admin == 1 ||
        $report->diffusione_blog == 1 ||
        $report->diffusione_offline == 1 ||
        $report->diffusione_incontri == 1 ||
        $report->diffusione_interviste == 1 ||
        !empty($report->diffusione_altro) ):
        return true;
    else:
        return false;
    endif;
}