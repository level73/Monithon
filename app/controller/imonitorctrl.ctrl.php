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

        //$this->Lite = new Lite;

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
            $this->set('js', array('components/imonitor.js?v=0.2', 'components/imonitor-geo.js?v=0.2'));

            if(httpCheck('post')):
                // Cleanup POST
                //dbga($_POST['imonitor']); die();
                //dbga($_FILES);

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
                    'contract_title'            => $data['report']['contract_title'],
                    'contract_object'           => $data['report']['contract_object'],
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
            $Errors = new Errors();
            $this->set('js', array('components/imonitor.js?v=0.2', 'components/imonitor-geo.js?v=0.2'));
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

                        'contract_title'            => $data['report']['contract_title'],
                        'contract_object'           => $data['report']['contract_object'],
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
                        'status' => ( $data['report']['status'] ?? DRAFT )

                    );


                    $Model->update($imonitorId, $newData);


                endif;
            endif;
            $Data = $Model->find($id);

            $title = $Data->title;
            $this->set('title', $title . ' - iMonitor');
            $this->set('data', $Data);
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
                $Model = new Imonitor();

                $logged = true;
                $this->set('logged', $logged);
                $this->set('street_map', array('version' => '1.9.4', 'sha' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='));
                $this->set('js', array('components/imonitor.js?v=0.2', 'components/imonitor-geo.js?v=0.2', 'components/imonitor-review.js?v=0.1'));

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
                    $status = $data['report']['status'] ??  DRAFT;

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

                        'contract_title'            => $data['report']['contract_title'],
                        'contract_object'           => $data['report']['contract_object'],
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
                        'status' => $status

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

                // Load Comments
                $this->set('comments', $Comments->findBy(array('entity' => T_REP_IMONITOR, 'record' => $id)));

                $title = $Data->title;
                $this->set('title', $title . ' - iMonitor');
                $this->set('data', $Data);
            endif;
        endif;
    }

    /** Frontend Views */
    public function summary($id){


    }
}