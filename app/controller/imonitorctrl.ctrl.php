<?php

class ImonitorCtrl extends Ctrl
{

    protected $Auth;
    protected $User;
    public    $Errors;


    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
        $this->Errors = new Errors;
        $this->Auth = new Auth;

        $logged = false;
        if($this->Auth->isLoggedIn()){
            $this->User = $this->Auth->getProfile();
            $this->set('user', $this->User);
            $logged = true;
        }
        $this->set('logged', $logged);
        // Load Language labels
        require_once ROOT . DS . "lang" . DS . "imonitor.it.php";
    }

    public function create(){

        if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login?r=1');
        }

        else {
            $logged = true;
            $this->set('logged', $logged);
            $this->set('title', 'Nuovo Report iMonitor');
            $this->set('street_map', array( 'version' => '1.9.4', 'sha' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='));
            $Errors = new Errors();
            $this->set('js', array('components/imonitor.js?v=0.2.4', 'components/imonitor-geo.js?v=0.3'));

            if(isset($_COOKIE['tender'])){
                $this->set('tender', $_COOKIE['tender']);
            }

            if(httpCheck('post')):
                // Cleanup POST

                $data = $_POST['imonitor'];


                // Set up Subcontractors to JSON
                $subcontractors = null;
                if( strtolower( $data['report']['contract_subcontracting']) === 'yes' && !empty( $data['report']['subcontractors'] )):
                    $subcontractors = json_encode($data['report']['subcontractors']);
                endif;

                // Set up Site Inspections
                $inspections = null;
                if(strtolower($data['report']['site_inspection']) === 'yes' && !empty($data['report']['inspection_site'])):
                    $inspections = json_encode($data['report']['inspection_site']);
                endif;

                // Set up Interviews
                $interviews = null;
                if(!empty($data['report']['contract_interviewed'])):
                    $interviews = json_encode($data['report']['contract_interviewed']);
                endif;

                // Set up connection subjects
                $connections = null;
                if(!empty($data['report']['connectionsubject'])):
                    $connections = json_encode($data['report']['connectionsubject']);
                endif;

                // Setup data mapping
                $Data = array(
                    'opentender_url'            => $data['contract']['opentender_url'],
                    'opentender_data'           => $data['contract']['opentender_json'],
                    'title'                     => $data['report']['title'],
                    'author'                    => $data['report']['author'],
                    'project_eu_funded'         => $data['report']['eu_funded'],
                    'project_url'               => $data['report']['project_url'],
                    'project_funding'           => $data['report']['project_funding'],
                    'project_policy'            => $data['report']['project_policy'],
                    'project_programme'         => $data['report']['project_programme'],
                    'project_cup'               => $data['report']['project_cup'],
                    'contract_title'            => $data['report']['contract_title'],
                    'contract_object'           => $data['report']['contract_object'],
                    'contract_cig'              => $data['report']['contract_cig'],
                    'contract_body'             => $data['report']['contract_body'],
                    'contract_supplier'         => $data['report']['contract_supplier'],
                    'contract_value'            => $data['report']['contract_value'],
                    'contract_type'             => $data['report']['contract_type'],
                    'contract_signature_date'   => $data['report']['contract_signature_date'],
                    'contract_date_start'       => $data['report']['contract_date_start'],
                    'contract_date_end'         => $data['report']['contract_date_end'],
                    'contract_sites'            => $data['report']['contract_sites'],

                    'delivery_schedule'         => $data['report']['delivery_schedule'],
                    'supervisor'                => $data['report']['supervisor'],

                    'contract_subcontracting'   => strtolower($data['report']['contract_subcontracting']),
                    'contract_subcontractors'   => $subcontractors,
                    'subcontracting_value'      => $data['report']['subcontracting_value'],
                    'subcontracting_percentage' => $data['report']['subcontracting_percentage'],

                    'contract_modifications'                => strtolower($data['report']['contract_modifications']),
                    'contract_modification_date'            => $data['report']['contract_modification_date'],
                    'contract_modification_days'            => $data['report']['contract_modification_days'],
                    'contract_modification_days_percent'    => $data['report']['contract_modification_days_percent'],
                    'contract_modification_value'           => $data['report']['contract_modification_value'],
                    'contract_modification_value_diff'      => $data['report']['contract_modification_value_diff'],
                    'contract_modification_value_percent'   => $data['report']['contract_modification_value_percent'],


                    'supplier_name'                         => $data['report']['supplier_name'],
                    'supplier_address'                      => $data['report']['supplier_address'],
                    'supplier_postcode'                     => $data['report']['supplier_postcode'],
                    'supplier_city'                         => $data['report']['supplier_city'],
                    'supplier_nuts'                         => $data['report']['supplier_nuts'],
                    'supplier_country'                      => $data['report']['supplier_country'],
                    'supplier_phone'                        => $data['report']['supplier_phone'],
                    'supplier_email'                        => $data['report']['supplier_email'],
                    'supplier_website'                      => $data['report']['supplier_website'],
                    'supplier_other'                        => $data['report']['supplier_other'],
                    'supplier_company_id'                   => $data['report']['supplier_company_id'],
                    'supplier_id_type'                      => $data['report']['supplier_id_type'],
                    'supplier_activitycodes'                => $data['report']['supplier_activitycodes'],
                    'supplier_foundation'                   => $data['report']['supplier_foundation'],
                    'supplier_legalrep'                     => $data['report']['supplier_legalrep'],
                    'supplier_shareholder'                  => $data['report']['supplier_shareholder'],
                    'supplier_otherindividuals'             => $data['report']['supplier_otherindividuals'],
                    'supplier_additionalinfo'               => $data['report']['supplier_additionalinfo'],

                    // STEP 2 - Contract Implementation
                    'site_inspection'                       => strtolower($data['report']['site_inspection']),
                    'inspection_site'                       => $inspections,
                    'inspection_fail_access_denied'         => $data['report']['inspection_fail_access_denied'],    // CB
                    'inspection_fail_located'               => $data['report']['inspection_fail_located'],          // CB
                    'inspection_fail_resources'             => $data['report']['inspection_fail_resources'],        // CB
                    'inspection_fail_other'                 => $data['report']['inspection_fail_other'],

                    'implementation_status'                 => strtolower($data['report']['implementation_status']),
                    'contract_delay_reason'                 => $data['report']['contract_delay_reason'],

                    'contract_following_schedule'           => strtolower($data['report']['contract_following_schedule']),
                    'contract_following_schedule_reason'    => $data['reason']['contract_following_schedule_reason'],

                    'contract_quantity_quality'             => strtolower($data['report']['contract_quantity_quality']),
                    'contract_quantity_quality_reason'      => $data['report']['contract_quantity_quality_reason'],

                    'contract_payments'                     => strtolower($data['report']['contract_payments']),
                    'contract_payments_reason'              => $data['report']['contract_payments_reason'],

                    'contract_modifications_writing'        => strtolower($data['report']['contract_modifications_writing']),
                    'contract_modifications_writing_reason' => $data['report']['contract_modifications_writing_reason'],

                    'contract_provisions_fulfilled'        => strtolower($data['report']['contract_provisions_fulfilled']),
                    'contract_provisions_fulfilled_reason' => $data['report']['contract_provisions_fulfilled_reason'],

                    'contract_supplier_fully_deliver'           => strtolower($data['report']['contract_supplier_fully_deliver']),
                    'contract_supplier_fully_deliver_reason'    => $data['report']['contract_supplier_fully_deliver_reason'],

                    'contract_supply_acceptable_state'          => strtolower($data['report']['contract_supply_acceptable_state']),
                    'contract_supply_acceptable_state_reason'   => $data['report']['contract_supply_acceptable_state_reason'],

                    'contract_procured_goods_intended'          => strtolower($data['report']['contract_procured_goods_intended']),
                    'contract_procured_goods_intended_reason'   => $data['report']['contract_procured_goods_intended_reason'],
                    'contract_works_project_operational'        => strtolower($data['report']['contract_works_project_operational']),
                    'contract_works_project_operational_reason' => $data['report']['contract_works_project_operational_reason'],

                    'contract_implementation_additional_information' => strtolower($data['report']['contract_implementation_additional_information']),

                    'contract_investigation_webresearch'                => $data['report']['contract_investigation_webresearch'],            //CB
                    'contract_investigation_documentation'              => $data['report']['contract_investigation_documentation'],          //CB
                    'contract_investigation_inspection'                 => $data['report']['contract_investigation_inspection'],             //CB
                    'contract_investigation_interviewcontracting'       => $data['report']['contract_investigation_interviewcontracting'],   //CB
                    'contract_investigation_interviewsupervisor'        => $data['report']['contract_investigation_interviewsupervisor'],    //CB
                    'contract_investigation_interviewresponsible'       => $data['report']['contract_investigation_interviewresponsible'],   //CB
                    'contract_investigation_interviewbeneficiaries'     => $data['report']['contract_investigation_interviewbeneficiaries'], //CB
                    'contract_investigation_interviewother'             => $data['report']['contract_investigation_interviewother'],         //CB
                    'contract_investigation_other'                      => $data['report']['contract_investigation_other'],

                    'contract_doctype_access_contract'          => strtolower($data['report']['contract_doctype_access_contract']),
                    'contract_doctype_access_contract_ext'      => strtolower($data['report']['contract_doctype_access_contract_ext']),
                    'contract_doctype_access_contract_reports'  => strtolower($data['report']['contract_doctype_access_contract_reports']),
                    'contract_doctype_access_pos_invoices'      => strtolower($data['report']['contract_doctype_access_pos_invoices']),
                    'contract_doctype_access_technical'         => strtolower($data['report']['contract_doctype_access_technical']),
                    'contract_doctype_access_bid'               => strtolower($data['report']['contract_doctype_access_bid']),

                    'contract_doctype_access_problem_incomplete'    => $data['report']['contract_doctype_access_problem_incomplete'],  // CB
                    'contract_doctype_access_problem_not_obtained'  => $data['report']['contract_doctype_access_problem_not_obtained'],  // CB
                    'contract_doctype_access_problem_not_granted'   => $data['report']['contract_doctype_access_problem_not_granted'],  // CB
                    'contract_doctype_access_problem_other'         => $data['report']['contract_doctype_access_problem_other'],

                    'contract_interviewed'          => $interviews,
                    'contract_online_sources'       => $data['report']['contract_online_sources'],


                    // STEP 3 - Results & Impact


                    'dissemination_x'               => (strtolower($data['report']['dissemination_x']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_facebook'        => (strtolower($data['report']['dissemination_facebook']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_instagram'       => (strtolower($data['report']['dissemination_instagram']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_events'          => (strtolower($data['report']['dissemination_events']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_website'         => (strtolower($data['report']['dissemination_website']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_offline'         => (strtolower($data['report']['dissemination_offline']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_meetings'        => (strtolower($data['report']['dissemination_meetings']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_media'           => (strtolower($data['report']['dissemination_media']) == 'yes' ? 'yes' : 'no'), // CB
                    'dissemination_other'           => (strtolower($data['report']['dissemination_other']) == 'yes' ? 'yes' : 'no'), // CB
                    'connection_subjects'           => $connections,
                    'media_dissemination'           =>   (strtolower($data['report']['media_dissemination']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_localtv'         =>   (strtolower($data['report']['shot_by_media_localtv']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_nationaltv'      =>   (strtolower($data['report']['shot_by_media_nationaltv']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_localpaper'      =>   (strtolower($data['report']['shot_by_media_localpaper']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_nationalpaper'   =>   (strtolower($data['report']['shot_by_media_nationalpaper']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_online'          =>   (strtolower($data['report']['shot_by_media_online']) == 'yes' ? 'yes' : 'no'), // CB
                    'shot_by_media_other'           =>   (strtolower($data['report']['shot_by_media_other']) == 'yes' ? 'yes' : 'no'), // CB
                    'contact_public_admin'          =>   (strtolower($data['report']['contact_public_admin']) == 'yes' ? 'yes' : 'no'), // CB
                    'public_admin_response'         =>   $data['report']['public_admin_response'],
                    'case_description'              =>   $data['report']['case_description'],



                    // Status/Op Fields
                    'created_by' => $this->User->id,
                    'status' => DRAFT

                );
                $Data = array_filter($Data);

                $Model = new Imonitor();



                $creation = $Model->create($Data);
                if($creation):
                    $ImonitorFiles = new ImonitorRepo();
                    // Handle File Uploads
                    $files = rearrange_files_imonitor($_FILES['imonitor'], $_POST['imonitor']['files']);
                    foreach($files as $file):
                        if($file['error'] == UPLOAD_ERR_OK):
                            $file['imonitor'] = $creation;
                            $ImonitorFiles->upload($file);
                        endif;
                    endforeach;



                    header('Location: /imonitor/edit/' . $creation . '?save=success');
                else:
                    $this->set('data', $Data);
                    header('Location: /imonitor/create/?save=fail');
                endif;


            endif;

        }


    }

    public function edit($id){
        if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login?r=1');
        }

        else {
            $logged = true;
            $this->set('logged', $logged);
            $this->set('street_map', array('version' => '1.9.4', 'sha' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='));

            $Comments = new Comment();
            $Errors = new Errors();

            $this->set('js', array('components/imonitor.js?v=0.2.4', 'components/imonitor-geo.js?v=0.3'));
            // Get The Report
            $Model = new Imonitor();
            $r = $Model->find($id);

            // Check for ownership or permissions
            if( hasPermission($this->User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD)) || $this->User->id == $r->created_by):
                if(httpCheck()):
                    $imonitorId = $_POST['imonitor']['id'];

                     $data = $_POST['imonitor'];
                     //dbga($_POST['imonitor']); die();

                    // Set up Subcontractors to JSON
                    $subcontractors = null;
                    if( strtolower( $data['report']['contract_subcontracting']) === 'yes' && !empty( $data['report']['subcontractors'] )):
                        $subcontractors = json_encode($data['report']['subcontractors']);
                    endif;
                    // Set up Site Inspections
                    $inspections = null;
                    if(strtolower($data['report']['site_inspection']) === 'yes' && !empty($data['report']['inspection_site'])):
                        $inspections = array_map('array_filter', $data['report']['inspection_site']);
                        $inspections = json_encode($inspections);
                    endif;

                    // Set up Interviews
                    $interviews = null;
                    if(!empty($data['report']['contract_interviewed'])):
                        $interviews = array_map('array_filter', $data['report']['contract_interviewed']);
                        $interviews = json_encode($interviews);
                    endif;

                    // Set up connection subjects
                    $connections = null;
                    if(!empty($data['report']['connectionsubject'])):
                        $connections = json_encode($data['report']['connectionsubject']);
                    endif;

                    // Setup data mapping
                    $newData = array(
                        // 'opentender_url'            => $data['contract']['opentender_url'],
                        // 'opentender_data'           => $data['contract']['opentender_json'],
                        'title'                     => $data['report']['title'],
                        'author'                    => $data['report']['author'],

                        'project_eu_funded'         => $data['report']['eu_funded'],
                        'project_url'               => $data['report']['project_url'],
                        'project_funding'           => $data['report']['project_funding'],
                        'project_policy'            => $data['report']['project_policy'],
                        'project_programme'         => $data['report']['project_programme'],
                        'project_cup'               => $data['report']['project_cup'],

                        'contract_title'            => $data['report']['contract_title'],
                        'contract_object'           => $data['report']['contract_object'],
                        'contract_body'             => $data['report']['contract_body'],
                        'contract_cig'              => $data['report']['contract_cig'],
                        'contract_supplier'         => $data['report']['contract_supplier'],
                        'contract_value'            => $data['report']['contract_value'],
                        'contract_type'             => $data['report']['contract_type'],
                        'contract_signature_date'   => $data['report']['contract_signature_date'],
                        'contract_date_start'       => $data['report']['contract_date_start'],
                        'contract_date_end'         => $data['report']['contract_date_end'],

                        'contract_sites'            => $data['report']['contract_sites'],

                        'delivery_schedule'         => $data['report']['delivery_schedule'],
                        'supervisor'                => $data['report']['supervisor'],

                        'contract_subcontracting'   => strtolower($data['report']['contract_subcontracting']),
                        'contract_subcontractors'   => $subcontractors,
                        'subcontracting_value'      => $data['report']['subcontracting_value'],
                        'subcontracting_percentage' => $data['report']['subcontracting_percentage'],

                        'contract_modifications'                => strtolower($data['report']['contract_modifications']),
                        'contract_modification_date'            => $data['report']['contract_modification_date'],
                        'contract_modification_days'            => $data['report']['contract_modification_days'],
                        'contract_modification_days_percent'    => $data['report']['contract_modification_days_percent'],
                        'contract_modification_value'           => $data['report']['contract_modification_value'],
                        'contract_modification_value_diff'      => $data['report']['contract_modification_value_diff'],
                        'contract_modification_value_percent'   => $data['report']['contract_modification_value_percent'],


                        'supplier_name'                         => $data['report']['supplier_name'],
                        'supplier_address'                      => $data['report']['supplier_address'],
                        'supplier_postcode'                     => $data['report']['supplier_postcode'],
                        'supplier_city'                         => $data['report']['supplier_city'],
                        'supplier_nuts'                         => $data['report']['supplier_nuts'],
                        'supplier_country'                      => $data['report']['supplier_country'],
                        'supplier_phone'                        => $data['report']['supplier_phone'],
                        'supplier_email'                        => $data['report']['supplier_email'],
                        'supplier_website'                      => $data['report']['supplier_website'],
                        'supplier_other'                        => $data['report']['supplier_other'],
                        'supplier_company_id'                   => $data['report']['supplier_company_id'],
                        'supplier_id_type'                      => $data['report']['supplier_id_type'],
                        'supplier_activitycodes'                => $data['report']['supplier_activitycodes'],
                        'supplier_foundation'                   => $data['report']['supplier_foundation'],
                        'supplier_legalrep'                     => $data['report']['supplier_legalrep'],
                        'supplier_shareholder'                  => $data['report']['supplier_shareholder'],
                        'supplier_otherindividuals'             => $data['report']['supplier_otherindividuals'],
                        'supplier_additionalinfo'               => $data['report']['supplier_additionalinfo'],


                        // STEP 2 - Contract Implementation
                        'site_inspection'                       => strtolower($data['report']['site_inspection']),
                        'inspection_site'                       => $inspections,
                        'inspection_fail_access_denied'         => evaluateCB($data['report'], 'inspection_fail_access_denied'),    // CB
                        'inspection_fail_located'               => evaluateCB($data['report'], 'inspection_fail_located'),          // CB
                        'inspection_fail_resources'             => evaluateCB($data['report'], 'inspection_fail_resources'),        // CB
                        'inspection_fail_other'                 => $data['report']['inspection_fail_other'],

                        'implementation_status'                 => strtolower($data['report']['implementation_status']),
                        'contract_delay_reason'                 => $data['report']['contract_delay_reason'],

                        'contract_following_schedule'           => strtolower($data['report']['contract_following_schedule']),
                        'contract_following_schedule_reason'    => $data['report']['contract_following_schedule_reason'],

                        'contract_quantity_quality'             => strtolower($data['report']['contract_quantity_quality']),
                        'contract_quantity_quality_reason'      => $data['report']['contract_quantity_quality_reason'],

                        'contract_payments'                     => strtolower($data['report']['contract_payments']),
                        'contract_payments_reason'              => $data['report']['contract_payments_reason'],

                        'contract_modifications_writing'        => strtolower($data['report']['contract_modifications_writing']),
                        'contract_modifications_writing_reason' => $data['report']['contract_modifications_writing_reason'],

                        'contract_provisions_fulfilled'        => strtolower($data['report']['contract_provisions_fulfilled']),
                        'contract_provisions_fulfilled_reason' => $data['report']['contract_provisions_fulfilled_reason'],

                        'contract_supplier_fully_deliver'           => strtolower($data['report']['contract_supplier_fully_deliver']),
                        'contract_supplier_fully_deliver_reason'    => $data['report']['contract_supplier_fully_deliver_reason'],

                        'contract_supply_acceptable_state'          => strtolower($data['report']['contract_supply_acceptable_state']),
                        'contract_supply_acceptable_state_reason'   => $data['report']['contract_supply_acceptable_state_reason'],

                        'contract_procured_goods_intended'          => strtolower($data['report']['contract_procured_goods_intended']),
                        'contract_procured_goods_intended_reason'   => $data['report']['contract_procured_goods_intended_reason'],
                        'contract_works_project_operational'        => strtolower($data['report']['contract_works_project_operational']),
                        'contract_works_project_operational_reason' => $data['report']['contract_works_project_operational_reason'],

                        'contract_implementation_additional_information' => strtolower($data['report']['contract_implementation_additional_information']),

                        'contract_investigation_webresearch'                => evaluateCB($data['report'], 'contract_investigation_webresearch'),            //CB
                        'contract_investigation_documentation'              => evaluateCB($data['report'], 'contract_investigation_documentation'),          //CB
                        'contract_investigation_inspection'                 => evaluateCB($data['report'], 'contract_investigation_inspection'),             //CB
                        'contract_investigation_interviewcontracting'       => evaluateCB($data['report'], 'contract_investigation_interviewcontracting'),   //CB
                        'contract_investigation_interviewsupervisor'        => evaluateCB($data['report'], 'contract_investigation_interviewsupervisor'),   //CB
                        'contract_investigation_interviewresponsible'       => evaluateCB($data['report'], 'contract_investigation_interviewresponsible'),   //CB
                        'contract_investigation_interviewbeneficiaries'     => evaluateCB($data['report'], 'contract_investigation_interviewbeneficiaries'), //CB
                        'contract_investigation_interviewother'             => evaluateCB($data['report'], 'contract_investigation_interviewother'),         //CB
                        'contract_investigation_other'                      => $data['report']['contract_investigation_other'],

                        'contract_doctype_access_contract'          => strtolower($data['report']['contract_doctype_access_contract']),
                        'contract_doctype_access_contract_ext'      => strtolower($data['report']['contract_doctype_access_contract_ext']),
                        'contract_doctype_access_contract_reports'  => strtolower($data['report']['contract_doctype_access_contract_reports']),
                        'contract_doctype_access_pos_invoices'      => strtolower($data['report']['contract_doctype_access_pos_invoices']),
                        'contract_doctype_access_technical'         => strtolower($data['report']['contract_doctype_access_technical']),
                        'contract_doctype_access_bid'               => strtolower($data['report']['contract_doctype_access_bid']),

                        'contract_doctype_access_problem_incomplete'    => evaluateCB($data['report'], 'contract_doctype_access_problem_incomplete'),  // CB
                        'contract_doctype_access_problem_not_obtained'  => evaluateCB($data['report'], 'contract_doctype_access_problem_not_obtained'),  // CB
                        'contract_doctype_access_problem_not_granted'   => evaluateCB($data['report'], 'contract_doctype_access_problem_not_granted'),  // CB
                        'contract_doctype_access_problem_other'         => $data['report']['contract_doctype_access_problem_other'],

                        'contract_interviewed'          => $interviews,
                        'contract_online_sources'       => $data['report']['contract_online_sources'],


                        // STEP 3 - Results & Impact
                        'dissemination_x'               => (strtolower($data['report']['dissemination_x']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_facebook'        => (strtolower($data['report']['dissemination_facebook']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_instagram'       => (strtolower($data['report']['dissemination_instagram']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_events'          => (strtolower($data['report']['dissemination_events']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_website'         => (strtolower($data['report']['dissemination_website']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_offline'         => (strtolower($data['report']['dissemination_offline'])== 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_meetings'        => (strtolower($data['report']['dissemination_meetings']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_media'           => (strtolower($data['report']['dissemination_media']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_other'           => (strtolower($data['report']['dissemination_other']) == 'yes' ? 'yes' : 'no'), // CB
                        'connection_subjects'           => $connections,
                        'media_dissemination'           =>   (strtolower($data['report']['media_dissemination']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_localtv'         =>   (strtolower($data['report']['shot_by_media_localtv']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_nationaltv'      =>   (strtolower($data['report']['shot_by_media_nationaltv']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_localpaper'      =>   (strtolower($data['report']['shot_by_media_localpaper']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_nationalpaper'   =>   (strtolower($data['report']['shot_by_media_nationalpaper']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_online'          =>   (strtolower($data['report']['shot_by_media_online']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_other'           =>   (strtolower($data['report']['shot_by_media_other']) == 'yes' ? 'yes' : 'no'), // CB
                        'contact_public_admin'          =>   (strtolower($data['report']['contact_public_admin']) == 'yes' ? 'yes' : 'no'), // CB
                        'public_admin_response'         =>   $data['report']['public_admin_response'],
                        'case_description'              =>   $data['report']['case_description'],
                        // Status/Op Fields
                        //'created_by' => $this->User->id,
                        'status' => ( isset($data['report']['status']) ? $data['report']['status'] : DRAFT )

                    );


                    $Model->update($imonitorId, $newData);

                    $ImonitorFiles = new ImonitorRepo();
                    // Handle File Uploads
                    $files = rearrange_files_imonitor($_FILES['imonitor'], $_POST['imonitor']['files']);
                    foreach($files as $file):
                        if($file['error'] == UPLOAD_ERR_OK):
                            $file['imonitor'] = $imonitorId;
                            $ImonitorFiles->upload($file);
                        endif;
                    endforeach;

                    if($data['report']['status'] == PENDING_REVIEW){
                        // Set up emailer
                        $subject = "iMonitor - Report ready for review";
                        $message = "The iMonitor report '<strong>" . $data['report']['title'] . "</strong>'  is ready for review. Access the Monithon instance and proceed to review the report.";

                        $Emailer = new Emailer();
                        $Emailer->compose(IMONITOR_RECIPIENT, $subject, $message);

                        $send = $Emailer->deliver();

                        if($send){
                            $this->Errors->set(5);
                        }
                        else {
                            $this->Errors->set(300);
                        }
                    }
                endif;
            endif;
            $Data = $Model->find($id);
            $Files = new ImonitorRepo();
            $files = $Files->getFiles($id);

            // Load Comments
            $this->set('comments', $Comments->findBy(array('entity' => T_REP_IMONITOR, 'record' => $id)));

            $title = $Data->title;
            $this->set('title', $title . ' - iMonitor');
            $this->set('data', $Data);
            $this->set('files', $files);
        }
    }


    public function review($id){
        if(!$this->Auth->isLoggedIn()):
            header('Location: /user/login?r=1');
        else :
            // Get The Report
            $Model = new Imonitor();
            $r = $Model->find($id);
            if( hasPermission( $this->User, array( P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD ) ) && $r->status > DRAFT  && $this->User->id != $r->created_by ):

                $Comments = new Comment();
                $Errors = new Errors();


                $logged = true;
                $this->set('logged', $logged);
                $this->set('street_map', array('version' => '1.9.4', 'sha' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='));
                $this->set('js', array('components/imonitor.js?v=0.2.4', 'components/imonitor-geo.js?v=0.3', 'components/imonitor-review.js?v=0.1'));

                if(httpCheck()):
                    $imonitorId = $_POST['imonitor']['id'];

                    $data = $_POST['imonitor'];
                    $comments = $_POST['comment'];
                    //dbga($_POST['imonitor']); die();

                    // Set up Subcontractors to JSON
                    $subcontractors = null;
                    if( strtolower( $data['report']['contract_subcontracting']) === 'yes' && !empty( $data['report']['subcontractors'] )):
                        $subcontractors = json_encode($data['report']['subcontractors']);
                    endif;
                    // Set up Site Inspections
                    $inspections = null;
                    if(strtolower($data['report']['site_inspection']) === 'yes' && !empty($data['report']['inspection_site'])):
                        $inspections = array_map('array_filter', $data['report']['inspection_site']);
                        $inspections = json_encode($inspections);
                    endif;

                    // Set up Interviews
                    $interviews = null;
                    if(!empty($data['report']['contract_interviewed'])):
                        $interviews = array_map('array_filter', $data['report']['contract_interviewed']);
                        $interviews = json_encode($interviews);
                    endif;

                    // Set up connection subjects
                    $connections = null;
                    if(!empty($data['report']['connectionsubject'])):
                        $connections = json_encode($data['report']['connectionsubject']);
                    endif;

                    //set up status
                    $status = (isset($data['report']['status']) ? $data['report']['status'] : PENDING_REVIEW);

                    // Setup data mapping
                    $newData = array(
                        // 'opentender_url'            => $data['contract']['opentender_url'],
                        // 'opentender_data'           => $data['contract']['opentender_json'],
                        'title'                     => $data['report']['title'],
                        'author'                    => $data['report']['author'],

                        'project_eu_funded'         => $data['report']['eu_funded'],
                        'project_url'               => $data['report']['project_url'],
                        'project_funding'           => $data['report']['project_funding'],
                        'project_policy'            => $data['report']['project_policy'],
                        'project_programme'         => $data['report']['project_programme'],
                        'project_cup'               => $data['report']['project_cup'],

                        'contract_title'            => $data['report']['contract_title'],
                        'contract_object'           => $data['report']['contract_object'],
                        'contract_cig'              => $data['report']['contract_cig'],
                        'contract_body'             => $data['report']['contract_body'],
                        'contract_supplier'         => $data['report']['contract_supplier'],
                        'contract_value'            => $data['report']['contract_value'],
                        'contract_type'             => $data['report']['contract_type'],
                        'contract_signature_date'   => $data['report']['contract_signature_date'],
                        'contract_date_start'       => $data['report']['contract_date_start'],
                        'contract_date_end'         => $data['report']['contract_date_end'],

                        'contract_sites'            => $data['report']['contract_sites'],

                        'delivery_schedule'         => $data['report']['delivery_schedule'],
                        'supervisor'                => $data['report']['supervisor'],

                        'contract_subcontracting'   => strtolower($data['report']['contract_subcontracting']),
                        'contract_subcontractors'   => $subcontractors,
                        'subcontracting_value'      => $data['report']['subcontracting_value'],
                        'subcontracting_percentage' => $data['report']['subcontracting_percentage'],

                        'contract_modifications'                => strtolower($data['report']['contract_modifications']),
                        'contract_modification_date'            => $data['report']['contract_modification_date'],
                        'contract_modification_days'            => $data['report']['contract_modification_days'],
                        'contract_modification_days_percent'    => $data['report']['contract_modification_days_percent'],
                        'contract_modification_value'           => $data['report']['contract_modification_value'],
                        'contract_modification_value_diff'      => $data['report']['contract_modification_value_diff'],
                        'contract_modification_value_percent'   => $data['report']['contract_modification_value_percent'],


                        'supplier_name'                         => $data['report']['supplier_name'],
                        'supplier_address'                      => $data['report']['supplier_address'],
                        'supplier_postcode'                     => $data['report']['supplier_postcode'],
                        'supplier_city'                         => $data['report']['supplier_city'],
                        'supplier_nuts'                         => $data['report']['supplier_nuts'],
                        'supplier_country'                      => $data['report']['supplier_country'],
                        'supplier_phone'                        => $data['report']['supplier_phone'],
                        'supplier_email'                        => $data['report']['supplier_email'],
                        'supplier_website'                      => $data['report']['supplier_website'],
                        'supplier_other'                        => $data['report']['supplier_other'],
                        'supplier_company_id'                   => $data['report']['supplier_company_id'],
                        'supplier_id_type'                      => $data['report']['supplier_id_type'],
                        'supplier_activitycodes'                => $data['report']['supplier_activitycodes'],
                        'supplier_foundation'                   => $data['report']['supplier_foundation'],
                        'supplier_legalrep'                     => $data['report']['supplier_legalrep'],
                        'supplier_shareholder'                  => $data['report']['supplier_shareholder'],
                        'supplier_otherindividuals'             => $data['report']['supplier_otherindividuals'],
                        'supplier_additionalinfo'               => $data['report']['supplier_additionalinfo'],


                        // STEP 2 - Contract Implementation
                        'site_inspection'                       => strtolower($data['report']['site_inspection']),
                        'inspection_site'                       => $inspections,
                        'inspection_fail_access_denied'         => evaluateCB($data['report'], 'inspection_fail_access_denied'),    // CB
                        'inspection_fail_located'               => evaluateCB($data['report'], 'inspection_fail_located'),          // CB
                        'inspection_fail_resources'             => evaluateCB($data['report'], 'inspection_fail_resources'),        // CB
                        'inspection_fail_other'                 => $data['report']['inspection_fail_other'],

                        'implementation_status'                 => strtolower($data['report']['implementation_status']),
                        'contract_delay_reason'                 => $data['report']['contract_delay_reason'],

                        'contract_following_schedule'           => strtolower($data['report']['contract_following_schedule']),
                        'contract_following_schedule_reason'    => $data['report']['contract_following_schedule_reason'],

                        'contract_quantity_quality'             => strtolower($data['report']['contract_quantity_quality']),
                        'contract_quantity_quality_reason'      => $data['report']['contract_quantity_quality_reason'],

                        'contract_payments'                     => strtolower($data['report']['contract_payments']),
                        'contract_payments_reason'              => $data['report']['contract_payments_reason'],

                        'contract_modifications_writing'        => strtolower($data['report']['contract_modifications_writing']),
                        'contract_modifications_writing_reason' => $data['report']['contract_modifications_writing_reason'],

                        'contract_provisions_fulfilled'        => strtolower($data['report']['contract_provisions_fulfilled']),
                        'contract_provisions_fulfilled_reason' => $data['report']['contract_provisions_fulfilled_reason'],

                        'contract_supplier_fully_deliver'           => strtolower($data['report']['contract_supplier_fully_deliver']),
                        'contract_supplier_fully_deliver_reason'    => $data['report']['contract_supplier_fully_deliver_reason'],

                        'contract_supply_acceptable_state'          => strtolower($data['report']['contract_supply_acceptable_state']),
                        'contract_supply_acceptable_state_reason'   => $data['report']['contract_supply_acceptable_state_reason'],

                        'contract_procured_goods_intended'          => strtolower($data['report']['contract_procured_goods_intended']),
                        'contract_procured_goods_intended_reason'   => $data['report']['contract_procured_goods_intended_reason'],
                        'contract_works_project_operational'        => strtolower($data['report']['contract_works_project_operational']),
                        'contract_works_project_operational_reason' => $data['report']['contract_works_project_operational_reason'],

                        'contract_implementation_additional_information' => strtolower($data['report']['contract_implementation_additional_information']),

                        'contract_investigation_webresearch'                => evaluateCB($data['report'], 'contract_investigation_webresearch'),            //CB
                        'contract_investigation_documentation'              => evaluateCB($data['report'], 'contract_investigation_documentation'),          //CB
                        'contract_investigation_inspection'                 => evaluateCB($data['report'], 'contract_investigation_inspection'),             //CB
                        'contract_investigation_interviewcontracting'       => evaluateCB($data['report'], 'contract_investigation_interviewcontracting'),   //CB
                        'contract_investigation_interviewsupervisor'        => evaluateCB($data['report'], 'contract_investigation_interviewsupervisor'),   //CB
                        'contract_investigation_interviewresponsible'       => evaluateCB($data['report'], 'contract_investigation_interviewresponsible'),   //CB
                        'contract_investigation_interviewbeneficiaries'     => evaluateCB($data['report'], 'contract_investigation_interviewbeneficiaries'), //CB
                        'contract_investigation_interviewother'             => evaluateCB($data['report'], 'contract_investigation_interviewother'),         //CB
                        'contract_investigation_other'                      => $data['report']['contract_investigation_other'],

                        'contract_doctype_access_contract'          => strtolower($data['report']['contract_doctype_access_contract']),
                        'contract_doctype_access_contract_ext'      => strtolower($data['report']['contract_doctype_access_contract_ext']),
                        'contract_doctype_access_contract_reports'  => strtolower($data['report']['contract_doctype_access_contract_reports']),
                        'contract_doctype_access_pos_invoices'      => strtolower($data['report']['contract_doctype_access_pos_invoices']),
                        'contract_doctype_access_technical'         => strtolower($data['report']['contract_doctype_access_technical']),
                        'contract_doctype_access_bid'               => strtolower($data['report']['contract_doctype_access_bid']),

                        'contract_doctype_access_problem_incomplete'    => evaluateCB($data['report'], 'contract_doctype_access_problem_incomplete'),  // CB
                        'contract_doctype_access_problem_not_obtained'  => evaluateCB($data['report'], 'contract_doctype_access_problem_not_obtained'),  // CB
                        'contract_doctype_access_problem_not_granted'   => evaluateCB($data['report'], 'contract_doctype_access_problem_not_granted'),  // CB
                        'contract_doctype_access_problem_other'         => $data['report']['contract_doctype_access_problem_other'],

                        'contract_interviewed'          => $interviews,
                        'contract_online_sources'       => $data['report']['contract_online_sources'],


                        // STEP 3 - Results & Impact
                        'dissemination_x'               => (strtolower($data['report']['dissemination_x']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_facebook'        => (strtolower($data['report']['dissemination_facebook']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_instagram'       => (strtolower($data['report']['dissemination_instagram']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_events'          => (strtolower($data['report']['dissemination_events']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_website'         => (strtolower($data['report']['dissemination_website']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_offline'         => (strtolower($data['report']['dissemination_offline'])== 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_meetings'        => (strtolower($data['report']['dissemination_meetings']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_media'           => (strtolower($data['report']['dissemination_media']) == 'yes' ? 'yes' : 'no'), // CB
                        'dissemination_other'           => (strtolower($data['report']['dissemination_other']) == 'yes' ? 'yes' : 'no'), // CB
                        'connection_subjects'           => $connections,
                        'media_dissemination'           => (strtolower($data['report']['media_dissemination']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_localtv'         => (strtolower($data['report']['shot_by_media_localtv']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_nationaltv'      =>   (strtolower($data['report']['shot_by_media_nationaltv']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_localpaper'      =>   (strtolower($data['report']['shot_by_media_localpaper']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_nationalpaper'   =>   (strtolower($data['report']['shot_by_media_nationalpaper']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_online'          =>   (strtolower($data['report']['shot_by_media_online']) == 'yes' ? 'yes' : 'no'), // CB
                        'shot_by_media_other'           =>   (strtolower($data['report']['shot_by_media_other']) == 'yes' ? 'yes' : 'no'), // CB
                        'contact_public_admin'          =>   (strtolower($data['report']['contact_public_admin']) == 'yes' ? 'yes' : 'no'), // CB
                        'public_admin_response'         =>   $data['report']['public_admin_response'],
                        'case_description'              =>   $data['report']['case_description'],
                        // Status/Op Fields
                        //'created_by' => $this->User->id,
                        'status' => $status,
                        'reviewed_by' => $this->User->id,

                    );

                    // Save Comments
                    if(!empty($comments)){
                        foreach($comments as $field => $comment){
                            $saved = $Comments->save($comment, $field, T_REP_IMONITOR, $id, $this->User->id);
                        }
                    }

                    $Model->update($imonitorId, $newData);


                endif;

                $Data = $Model->find($id);
                $Files = new ImonitorRepo();
                $files = $Files->getFiles($id);


                // Load Comments
                $this->set('comments', $Comments->findBy(array('entity' => T_REP_IMONITOR, 'record' => $id)));

                $title = $Data->title;
                $this->set('title', $title . ' - iMonitor');
                $this->set('data', $Data);
                $this->set('files', $files);
            else:
                header('Location: /user/edit');
                endif;
        endif;
    }

    /** Frontend Views */
    public function summary($id){


    }

    public function pdf($id){
        if(!$this->Auth->isLoggedIn() ){
            header('Location: /user/login?r=1');
        }

        $Report = new Imonitor();
        $Repo = new ImonitorRepo();
        $report = $Report->find($id);
        $documents = $Repo->getFiles($id);

        if($this->User->role <= 2 || $this->User->id == $report->created_by):
            $tmp = sys_get_temp_dir();
            $fontDir = realpath('../../public/font/');
            $dompdf = new Dompdf\Dompdf([
                //'isRemoteEnabled' => true,
                'fontDir' =>   $fontDir,
                'fontCache' => $fontDir,
                'tempDir' => $tmp,
                'chroot' => $tmp,
            ]);



            // Monithon Logo Path
            $MonithonLogo = ROOT . DS . 'public' . DS . 'images' . DS . 'monithon-logo-2022.png';
            $iMonitorLogo = ROOT . DS . 'public' . DS . 'images' . DS . 'imonitor.png';
            /**
             * @font-face{
             * font-family: 'PT Sans';
             * font-style: normal;
             * font-weight: 400;
             * src: url('/public/fonts/PTSans-Regular.ttf') format('truetype');
             * }
             * h1, h2, h3, h4, h5, h6, p, span, li, dl, td, th, div { font-family: 'PT Sans'; }
             */
            $html = '<!DOCTYPE html>
                        <html>
                        <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $html .= "<style>
                            * { font-family: DejaVu Sans; }
                            td { padding: 2pt; margin-bottom: 3px; border-bottom: 1px dotted #AAAAAA; }
                            p, span, td { font-size: 12pt; }    
                            .value_green { color: green; }
                            .value_yellow{ color: #ffc107; }
                            .value_red { color:red; }
                            .value_na { color: #666666; }
                            .smalltext{ font-size: 10pt; color: #555555; }   
                            p strong { color: #292727; }                
                            p { padding-left: 8pt; }
                            
                            h1 { margin-bottom: 20pt; padding: 5pt 10pt; color: white; background-color: #181E27; }
                            h3 { margin-top: 20pt; color: #181E27; border-bottom: 1px solid #181E27; padding-bottom: 5pt; }
                          </style></head><body>";
            $html .= '<img src="' . imageEmbed( $MonithonLogo ). '" width="80" height="80">';
            $html .= '<img src="' . imageEmbed( $iMonitorLogo ). '" width="249" height="80">';
            $html .= "<br /><div class='smalltext'>LAST MOD: ". date('d/m/Y H:i:s', strtotime($report->modified_at)) . "</div>";
            $html .= "<h1>".$report->title."</h1>";
            $html .= '<h3>' . S1SA_LABEL_TEXT . '</h3>';

            $html .= "<p>Ă, Â, Î, Ș, and Ț</p>";

            $html .= setData(S1SA_FIELD_EUFUNDED, $report->project_eu_funded, ['boolean']);
            if($report->project_eu_funded > 0):
                $html .= setData(S1SA_FIELD_EUFUNDINFO, $report->project_url, ['link']);
                $html .= setData(S1SA_FIELD_FUNDINGAMOUNT, $report->project_funding . ' €');
                $html .= setData(S1SA_FIELD_MAINPOLICY, $report->project_policy, ['policy']);
                $html .= setData(S1SA_FIELD_PROGRAMME, $report->project_programme);
                //$html .= setData();
            endif;
            // Integrity Indicators
            if(!empty($report->opentender_data)):
                $ot_data = json_decode($report->opentender_data, true);
                //die(dbga($ot_data));
                $html .= '<h3>' . S1SB_LABEL_CONTRACTINTEGRITY . ' (<a href="https://opentender.eu" style="font-size: 12pt; ">OpenTender.eu</a> - <span class="integrity_score" style="color: ' . colorCalculator($ot_data['ot']['score']['INTEGRITY']) . '">' . $ot_data['ot']['score']['INTEGRITY'] . '</span>)</h3>';
                $indicators = $ot_data['ot']['indicators'];
                $html .= '<table>';
                foreach($indicators as $indicator):
                    if(substr($indicator['type'], 0, 5) === 'INTEG'):

                        $color = colorCalculator($indicator['value']);
                        //dbga($indicator);
                        //$html .= '<p><strong>' . constant($indicator['type']) . '</strong>: <span class="' . $classCode . '">' . $indicator['value'] .'</span></p>';
                        $html .= '<tr><td style="padding: 2pt;">' . constant($indicator['type']) . '</td><td><span style="color: '.$color.'">' . $indicator['value'] .'</span></td>';
                    endif;
                endforeach;
                $html.='</table>';
                //    echo $html;
                //die();
            endif;
            $html .= '<h3>' . S1SB_LABEL_TEXT . '</h3>';
            $html .= setData(S1SB_FIELD_CONTRACTTITLE, $report->contract_title);
            $html .= setData(S1SB_FIELD_CONTRACTOBJECT, $report->contract_object);
            $html .= setData(S1SB_FIELD_CONTRACTINGBODY, $report->contract_body);
            $html .= setData(S1SB_FIELD_SUPPLIER, $report->contract_supplier);
            $html .= setData(S1SB_FIELD_CONTRACTVALUE, $report->contract_value . ' €');
            $html .= setData(S1SB_FIELD_CONTRACTTYPE, $report->contract_type, ['contract_type']);
            $html .= setData(S1SB_FIELD_SIGNATUREDATE, $report->contract_signature_date);
            $html .= setData(S1SB_FIELD_STARTDATE, $report->contract_date_start);
            $html .= setData(S1SB_FIELD_ENDDATE, $report->contract_date_end);
            $html .= setData(S1SB_FIELD_DELIVERYSITE, $report->contract_sites, ['sites']);
            $html .= setData(S1SB_FIELD_DELIVERYSCHEDULE, $report->delivery_schedule);
            $html .= setData(S1SB_FIELD_SUPERVISOR, $report->supervisor);
            $html .= setData(S1SB_LABEL_SUBCONTRACTING, $report->contract_subcontracting, ['triple']);
            if($report->contract_subcontracting == 'yes'):
                $html .= setData(S1SB_LABEL_SUBCONTRACTORS, $report->contract_subcontractors, ['subcontractors']);
                $html .= setData(S1SB_LABEL_VALUESUBCONTRACTS, $report->subcontracting_value . ' €');
                $html .= setData(S1SB_LABEL_PERCENTAGESUBCONTRACTS, $report->subcontracting_percentage . '%');
            endif;
            $html .= setData(S1SB_LABEL_CONTRACTMOD, $report->contract_modifications, ['triple']);
            if($report->contract_modifications == 'yes'):
                $html .= setData(S1SB_LABEL_EXTENDEDDATE, $report->contract_modification_date);
                $html .= setData(S1SB_LABEL_DAYSEXTENDED, $report->contract_modification_days);
                $html .= setData(S1SB_LABEL_PERCENTINCREASEDURATION, $report->contract_modification_days_percent .'%');
                $html .= setData(S1SB_LABEL_NEWCONTRACTVALUE, $report->contract_modification_value . ' €');
                $html .= setData(S1SB_LABEL_NEWCONTRACTVALUEDIFF, $report->contract_modification_value_diff . ' €');
                $html .= setData(S1SB_LABEL_PERCENTINCREASEVALUE, $report->contract_modification_value_percent .'%');
            endif;

            $html .= '<h3>' . S1SC_LABEL_TEXT . '</h3>';

            $html .= '<h4>' . S1SC_LABEL_COMPANYINFO . '</h4>';
            $html .= setData(S1SC_LABEL_COMPANYNAME, $report->supplier_name);
            $html .= setData(S1SC_LABEL_COMPANYADDRESS, $report->supplier_address);
            $html .= setData(S1SC_LABEL_COMPANYPOSTALCODE, $report->supplier_postcode);
            $html .= setData(S1SC_LABEL_COMPANYCITY, $report->supplier_city);
            $html .= setData(S1SC_LABEL_COMPANYNUTSCODE, $report->supplier_nuts);
            $html .= setData(S1SC_LABEL_COMPANYCOUNTRY, $report->supplier_country);

            $html .= '<h4>' . S1SC_LABEL_COMPANYCONTACTINFO . '</h4>';
            $html .= setData(S1SC_LABEL_COMPANYPHONENUMBER, $report->supplier_phone);
            $html .= setData(S1SC_LABEL_COMPANYEMAIL, $report->supplier_email);
            $html .= setData(S1SC_LABEL_COMPANYWEBSITE, $report->supplier_website);
            $html .= setData(S1SC_LABEL_COMPANYOTHER, $report->supplier_other);

            $html .= '<h4>' . S1SC_LABEL_COMPANYREGISTRATIONINFO . '</h4>';
            $html .= setData(S1SC_LABEL_COMPANYREGISTRATIONID, $report->supplier_company_id);
            $html .= setData(S1SC_LABEL_COMPANYIDTYPE, $report->supplier_id_type);
            $html .= setData(S1SC_LABEL_COMPANYBUSINESSACTIVITYCODES, $report->supplier_activitycodes);
            $html .= setData(S1SC_LABEL_COMPANYFOUNDATION, $report->supplier_foundation);
            $html .= setData(S1SC_LABEL_COMPANYLEGALREP, $report->supplier_legalrep);
            $html .= setData(S1SC_LABEL_COMPANYSHAREHOLDERS, $report->supplier_shareholder);
            $html .= setData(S1SC_LABEL_COMPANYOTHERINDIVIDUALS, $report->supplier_otherindividuals);
            $html .= setData(S1SC_LABEL_COMPANYADDITIONALINFO, $report->supplier_additionalinfo);

            $html .= '<h2>' . S2_TITLE_LABEL . '</h2>';
            $html .= '<h3>' . S2SA_TITLE_TEXT . '</h3>';

            $html .= setData(S2SA_LABEL_SITEINSPECTION, $report->site_inspection, ['triple']);
            if($report->site_inspection == 'yes'):
                $html .= setData(S2SA_LABEL_SITEINSPECTED, $report->inspection_site, ['inspections']);
            else:
                $html .= setData(S2SA_OPTION_INSPECTIONFAIL_1, $report->inspection_fail_access_denied, ['boolean']);
                $html .= setData(S2SA_OPTION_INSPECTIONFAIL_2, $report->inspection_fail_located, ['boolean']);
                $html .= setData(S2SA_OPTION_INSPECTIONFAIL_3, $report->inspection_fail_resources, ['boolean']);
                $html .= setData(GENERIC_LABEL_OTHER, $report->inspection_fail_other);
            endif;

            $html .= setData(S2SA_LABEL_IMPLEMENTATIONSTATUS, $report->implementation_status, ['implementation_status']);
            if($report->implementation_status == 1):
                $html .= setData(S2SA_LABEL_IMPLEMENTATIONSTATUSINFO, $report->contract_delay_reason);

            elseif($report->implementation_status == 2):
                $html .= setData(S2SA_LABEL_IMPLEMENTATIONSCHEDULE, $report->contract_following_schedule, ['triple']);
                $html .= setData('', $report->contract_following_schedule_reason);
                $html .= setData(S2SA_LABEL_QUANTITYQUALITY, $report->contract_quantity_quality, ['triple']);
                $html .= setData('', $report->contract_quantity_quality_reason);
                $html .= setData(S2SA_LABEL_PAYMENTS, $report->contract_payments, ['triple']);
                $html .= setData('', $report->contract_payments_reason);
                if($report->contract_modifications == 'yes'):
                    $html .= setData(S2SA_LABEL_CONTRACTMODSINWRITING, $report->contract_modifications_writing, ['triple']);
                    $html .= setData('', $report->contract_modifications_writing_reason);
                endif;
                $html .= setData(S2SA_LABEL_CONTRACTPROVISIONSFULFILLED, $report->contract_provisions_fulfilled, ['triple']);
                $html .= setdata('', $report->contract_provisions_fulfilled_reason);

            elseif($report->implementation_status == 3):
                $html .= setData(S2SA_LABEL_SUPPLIERDELIVER, $report->contract_supplier_fully_deliver, ['triple']);
                $html .= setData('', $report->contract_supplier_fully_deliver_reason);
                $html .= setData(S2SA_LABEL_DELIVEREDGOODS, $report->contract_supply_acceptable_state, ['triple']);
                $html .= setData('', $report->contract_supply_acceptable_state_reason);
                $html .= setData(S2SA_LABEL_PROCUREDGOODS, $report->contract_procured_goods_intended, ['triple']);
                $html .= setData('', $report->contract_procured_goods_intended_reason);
                $html .= setData(S2SA_LABEL_WORKSCONTRACT, $report->contract_works_project_operational, ['triple']);
                $html .= setData('', $report->contract_works_project_operational_reason);
            endif;
            $html .= setData(S2SA_LABEL_ADDITIONALINFO, $report->contract_implementation_additional_information);

            $html .= '<h3>' . S2SB_TITLE_TEXT . '</h3>';
            $html .= '<h4>' . S2SB_LABEL_SOURCES . '</h4>';
            $html .= setData(S2SB_LABEL_SOURCES_WEB, $report->contract_investigation_webresearch, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_DOCS, $report->contract_investigation_documentation, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_SITE, $report->contract_investigation_inspection, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_INTERVIEW_REPS, $report->contract_investigation_interviewcontracting, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_INTERVIEW_SUPERVISOR, $report->contract_investigation_interviewsupervisor, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_INTERVIEW_RCI, $report->contract_investigation_interviewresponsible, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_BENEFICIARIES, $report->contract_investigation_interviewbeneficiaries, ['boolean']);
            $html .= setData(S2SB_LABEL_SOURCES_OTHER, $report->contract_investigation_interviewother, ['boolean']);

            $html .= '<h4>' . S2SB_LABEL_DOCUMENTATIONACCESS . '</h4>';
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_1, $report->contract_doctype_access_contract, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_2, $report->contract_doctype_access_contract_ext, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_3, $report->contract_doctype_access_contract_reports, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_4, $report->contract_doctype_access_pos_invoices, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_5, $report->contract_doctype_access_technical, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESS_6, $report->contract_doctype_access_bid, ['boolean']);

            $html .= '<h4>' . S2SB_LABEL_DOCUMENTATIONACCESSFAIL . '</h4>';
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESSFAIL_1, $report->contract_doctype_access_problem_incomplete, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESSFAIL_2, $report->contract_doctype_access_problem_not_obtained, ['boolean']);
            $html .= setData(S2SB_OPTION_DOCUMENTATIONACCESSFAIL_3, $report->contract_doctype_access_problem_not_granted, ['boolean']);
            $html .= setData('', $report->contract_doctype_access_problem_other);

            $html .= setData(S2SB_LABEL_INTERVIEWS, $report->contract_interviewed, ['interviews']);

            $html .= setData(S2SB_LABEL_ONLINESOURCES, $report->contract_online_sources);

            $html .= '<h2>' . S3_TITLE_TEXT . '</h2>';
            $html .= '<h3>' . S3S_TITLE_CONNECTIONS . '</h3>';

            $html .= '<p><strong>' . S3S_LABEL_CONNECTIONS . '</strong></p>';
            $html .= setData(S3S_OPTION_CONNECTIONS_1,  $report->dissemination_x,           ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_2,  $report->dissemination_facebook,    ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_3,  $report->dissemination_instagram,   ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_4,  $report->dissemination_events,      ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_5,  $report->dissemination_website,     ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_6,  $report->dissemination_offline,     ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_7,  $report->dissemination_meetings,    ['boolean']);
            $html .= setData(S3S_OPTION_CONNECTIONS_8,  $report->dissemination_media,       ['boolean']);
            $html .= setData(GENERIC_LABEL_OTHER,       $report->dissemination_other,       ['boolean']);

            $html .= setData(S3S_LABEL_CONNECTION_PERSON, $report->connection_subjects, ['connections']);

            $html .= setData(S3S_LABEL_MEDIA, $report->media_dissemination, ['boolean']);
            if($report->media_dissemination == 'yes'):
                $html .= setData(S3S_OPTION_WHICHMEDIA_1, $report->shot_by_media_localtv, ['boolean']);
                $html .= setData(S3S_OPTION_WHICHMEDIA_2, $report->shot_by_media_nationaltv, ['boolean']);
                $html .= setData(S3S_OPTION_WHICHMEDIA_3, $report->shot_by_media_localpaper, ['boolean']);
                $html .= setData(S3S_OPTION_WHICHMEDIA_4, $report->shot_by_media_nationalpaper, ['boolean']);
                $html .= setData(S3S_OPTION_WHICHMEDIA_5, $report->shot_by_media_online, ['boolean']);
                $html .= setData(GENERIC_LABEL_OTHER, $report->shot_by_media_other, ['boolean']);
            endif;

            $html .= setData(S3S_LABEL_CONTACTWITHADMINISTRATION, $report->contact_public_admin, ['boolean']);
            if($report->contact_public_admin == 'yes'):
                $html .= setData(S3S_LABEL_ADMINISTRATIONQUESTIONS, $report->public_admin_response, ['admin_responses']);
            endif;
            $html .= setData(S3S_LABEL_CASEDESCRIPTION, $report->case_description);


            $html .= setDocuments($documents);

            // die($html);
            $html .= '</body></html>';
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $dompdf->stream();
        else:
            header('Location: /user/ops');
        endif;

    }

    public function img_test( ){
        echo "<img src=" . imageEmbed(ROOT . DS . 'public' . DS . 'images' . DS . 'monithon-logo-2022.png' ) . ">";
    }
}