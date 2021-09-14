<?php
/** Controller for public profile pages */
class ProfileCtrl extends Ctrl {
    protected $Auth;
    protected $User;
    public    $Errors;

    protected $ASOC_Exp = Array(
        881,
        883,
        882,
        879,
        878,
        880,
        876,
        877,
        959,
    );


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
    }

    /** View profile page of Reporter
     *  @var $id: ID of the reporter
     */
    public function view($id){

        // Init relevant objects
        $Errors     = new Errors();
        $User       = new User();
        $Report     = new Report();
        $Avatar     = new Repo();
        $Region     = new Meta('region', true);
        $Provincia  = new Meta('provincia', true);

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);



        // Load Profile Info
        $Profile = $User->fullProfile($id);
        unset($Profile->password);
        // Format Twitter Handle
        $Profile->twitter =  (!empty($Profile->twitter) ? (substr($Profile->twitter, 0, 1) == "@" ? $Profile->twitter : "@" . $Profile->twitter) : null);
        if($Profile->role >= 3){
           if($Profile->role > 3){
                $ASOC_Profile = new Asoc();
                $asoc_profile = $ASOC_Profile->findBy(array('auth' => $id));

                if(!empty($asoc_profile)){
                    $asoc_profile[0]->regione = $Region->findLexiconEntry('idregion', $asoc_profile[0]->regione);
                    $asoc_profile[0]->provincia = $Provincia->findLexiconEntry('idprovincia', $asoc_profile[0]->provincia);
                    $Profile->ASOC = $asoc_profile[0];
                }
            }
        }


        // Load Report Info
        $Reports = $Report->findBy(array('created_by' => $id, 'status' => 7), array('field' => 'created_at', 'direction' => 'DESC'));
        $Files = new Repo();
        foreach($Reports as $i => $report){
            // ASOC EXP
            $Reports[$i]->ASOC_EXP = false;
            $Reports[$i]->ASOC_EXP = in_array($report->idreport_basic, $this->ASOC_Exp);
            // Get Files
            $Reports[$i]->files = $Files->getFiles(T_REP_BASIC, $report->idreport_basic, 2);
            foreach($Reports[$i]->files as $l => $file){
                $file->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
                $info = explode('/', $file->info);
                if ($info[0] == 'image') {
                    $Reports[$i]->images[] = $file;
                }
            }
        }

        // Calculate graph info
        $totalReports   = $Report->counter(7);
        $profileReports = count($Reports);
        $ratioReports   = ($profileReports * 100) / $totalReports;
        $ratioReports   = number_format($ratioReports, 2, ',', '.');

        /**  Counter per i Giudizi Sintetici
        $gsCounter = $this->Profile->gsByCreator($id);

        $ChartData = array(
            "Appena iniziato"           => 0,
            "In corso e procede bene"   => 0,
            "Procede con difficoltà"    => 0,
            "Bloccato"                  => 0,
            "Concluso e utile"          => 0,
            "Concluso e inefficace"     => 0
        );


        foreach ($gsCounter as $gs){
            $ChartData[$gs->giudizio_sintetico] = $gs->counter;;
        }
        $chartData['labels'] = array_keys($ChartData);
        $chartData['counters'] = array_values($ChartData);
*/



        // Set frontend variables
        $this->set('title', $Profile->username);
        $this->set('street_map', true);
        // $this->set('charts', 'https://cdn.jsdelivr.net/npm/apexcharts');
        $this->set('js', array('section/profile.js?ts=070921' ));
        $this->set('profile', $Profile);

        $this->set('ratio', array('total' => $totalReports, 'profile' => $profileReports, 'ratio' => $ratioReports));
        $this->set('reports', $Reports);
        // $this->set('gs', $chartData);
    }
}