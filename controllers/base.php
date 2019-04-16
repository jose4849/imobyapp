<?php

class Base extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('mbase');
        $this->load->helper('text');
        //if(LOCAL) $this->fp->setEnabled(true);
        if ($this->uri->segment(2) == 'business' ||
                $this->uri->segment(2) == 'business_arch' ||
                $this->uri->segment(2) == 'changepass'
        ) {
            if ($this->session->userdata('logged_in')) {
                redirect(BASE . 'user/presentaties');
            } else {
                redirect(BASE);
            }
        }
    }

    function index($objectid="") {
        $this->load->model('mmobileapps');
        $this->load->model('motherpage');
        $this->load->model('mfrontpage');
        require_once (APPPATH . 'libraries/Mobile_Detect.php');
        $detect = new Mobile_Detect();
        if (
                $detect->isAndroid() ||
                $detect->isAndroidtablet() ||
                $detect->isIphone() ||
                $detect->isBlackberry() ||
                $detect->isBlackberrytablet() ||
                $detect->isPalm() ||
                $detect->isWindowsphone() ||
                $detect->isIpad() ||
                $detect->isMobile()
        ) {
            redirect(BASE . 'mobile/index/' . $objectid);
        } else {
            if (is_numeric($objectid)) {
                redirect('http://imoby.nl/mobileview?code=' . $objectid . '+&Bekijken=Bekijken');
            } else {
                //redirect('http://imoby.nl/');
            }
        }

        $data['title'] = 'Imoby.nl';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => true,
            'isOverons' => false,
            'isWoning' => false,
            'isAuto' => false,
            'isProducten' => false,
            'isContact' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('home', 6);
        $data['loginFailed'] = $this->session->userdata('loginfailed');
        $data['hpages'] = $this->motherpage->getPages('home');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vindex', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function contact() {
        redirect('http://imoby.nl/');
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => true,
            'isBusiness' => false
        );
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vcontact', $data);
        $this->load->view('base/vfooter');
    }

    function overons() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $this->load->model('motherpage');
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => true,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('overons', 6);
        $data['hpages'] = $this->motherpage->getPages('overons');
        $this->load->view('base/vheader', $data);
        $this->load->view('base/voverons', $data);
        $this->load->view('base/vfooter');
    }

    function vastgoed() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => true,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('woning', 6);
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vvastgoed', $data);
        $this->load->view('base/vfooter');
    }

    function auto() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => true,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('auto', 6);
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vauto', $data);
        $this->load->view('base/vfooter');
    }

    function support() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => true,
            'isContact' => false,
            'isBusiness' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('producten', 6);
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vsupport', $data);
        $this->load->view('base/vfooter');
    }

    /**
     * 
     * unzip objecten file 
     * 
     */
    function extract_objecten() {
        redirect('http://imoby.nl/');
        $this->load->library('unzip');
        $this->load->helper('file');
        $this->download_objecten('http://xml-publish.realworks.nl/servlets/ogexport?koppeling=HUISKOPPELING&user=Imoby&password=imo123&og=WONEN&versie=12', 'downloads/realworks_objecten.zip');

        delete_files('downloads/latest/');
        $this->unzip->extract('downloads/realworks_objecten.zip', 'downloads/latest/');
        print_r(get_filenames('downloads/latest/'));
    }

    /**
     * 
     * download realworks zip
     */
    function download_objecten($url, $loc) {
        redirect('http://imoby.nl/');
        set_time_limit(300);
        $urlStr = file_get_contents($url);

        if (!empty($urlStr)) {
            file_put_contents($loc, $urlStr);
        } else {
            $this->download_objecten($url, $loc);
        }
    }

    function read_xml() {
        redirect('http://imoby.nl/');
        set_time_limit(300);
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');
        $this->load->helper('file');
        $this->load->library('simplexml');


        $xmlfile = get_filenames('downloads/latest/');

        $xmlStr = file_get_contents('downloads/latest/' . $xmlfile[1]);
        $xmlParser = new SimpleXMLElement($xmlStr);

        //get xml objects
        $xmlObs = $xmlParser->Object;

        $this->mobject->trancate_objects();
        $this->mobjectmedia->trancate_objectmedias();

        //itterate each objects
        foreach ($xmlObs as $xmlOb) {
            $objData = array();
            $objData['NVMVestigingNR'] = $xmlOb->NVMVestigingNR;
            $objData['ObjectTiaraID'] = $xmlOb->ObjectTiaraID;
            $objData['Adres'] = $xmlOb->ObjectDetails->Adres->Nederlands->Straatnaam . " "
                    . $xmlOb->ObjectDetails->Adres->Nederlands->Huisnummer . " "
                    . $xmlOb->ObjectDetails->Adres->Nederlands->Postcode . ","
                    . $xmlOb->ObjectDetails->Adres->Nederlands->Woonplaats;

            $objData['Status'] = $xmlOb->ObjectDetails->StatusBeschikbaarheid->Status;
            $objData['Date'] = $xmlOb->ObjectDetails->DatumInvoer;

            //save each objects
            $saveObject = $this->mobject->save_object($objData);

            //get medialist of each objects
            $medias = $xmlOb->MediaLijst->Media;

            //itterate each media
            foreach ($medias as $key => $media) {
                $mediaData = array();
                $mediaData['NVMVestigingNR'] = $objData['NVMVestigingNR'];
                $mediaData['object_id'] = $saveObject;
                $mediaData['media_group'] = $media->Groep;
                $mediaData['media_url'] = mysql_real_escape_string($media->URL);

                $saveMedia = $this->mobjectmedia->save_medialist($mediaData);
            }


            //$this->download_objecten($xmlOb->MediaLijst->Media[1]->URL,'downloads/images/'.$xmlOb->NVMVestigingNR.'_0.jpg');
        }

        echo 'Xml Data saved in database completed';
    }

    function statistics() {
        redirect('http://imoby.nl/');
        $this->load->model('mobject');
        $data = array();
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => true
        );
        $data['monthlyXml'] = "<graph yAxisMinValue='0' yAxisMaxValue='87' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' >
    <set name='27-12-2011' value='1.0E-8' color='99D2EE' showName='1' hoverText='27-12-2011'/>
    <set name='28-12-2011' value='58' color='99D2EE' showName='0' hoverText='28-12-2011'/>
    <set name='29-12-2011' value='10' color='99D2EE' showName='0' hoverText='29-12-2011'/>
    <set name='30-12-2011' value='7' color='99D2EE' showName='0' hoverText='30-12-2011'/>
    <set name='31-12-2011' value='7' color='99D2EE' showName='0' hoverText='31-12-2011'/>
    <set name='01-01-2012' value='7' color='99D2EE' showName='0' hoverText='01-01-2012'/>
    <set name='02-01-2012' value='10' color='99D2EE' showName='0' hoverText='02-01-2012'/>
    <set name='03-01-2012' value='29' color='99D2EE' showName='0' hoverText='03-01-2012'/>
    <set name='04-01-2012' value='61' color='99D2EE' showName='0' hoverText='04-01-2012'/>
    <set name='05-01-2012' value='80' color='99D2EE' showName='0' hoverText='05-01-2012'/>
    <set name='06-01-2012' value='74' color='99D2EE' showName='1' hoverText='06-01-2012'/>
    <set name='07-01-2012' value='73' color='99D2EE' showName='0' hoverText='07-01-2012'/>
    <set name='08-01-2012' value='30' color='99D2EE' showName='0' hoverText='08-01-2012'/>
    <set name='09-01-2012' value='17' color='99D2EE' showName='0' hoverText='09-01-2012'/>
    <set name='10-01-2012' value='10' color='99D2EE' showName='0' hoverText='10-01-2012'/>
    <set name='11-01-2012' value='20' color='99D2EE' showName='0' hoverText='11-01-2012'/>
    <set name='12-01-2012' value='14' color='99D2EE' showName='0' hoverText='12-01-2012'/>
    <set name='13-01-2012' value='7' color='99D2EE' showName='0' hoverText='13-01-2012'/>
    <set name='14-01-2012' value='9' color='99D2EE' showName='0' hoverText='14-01-2012'/>
    <set name='15-01-2012' value='87' color='99D2EE' showName='0' hoverText='15-01-2012'/>
    <set name='16-01-2012' value='29' color='99D2EE' showName='1' hoverText='16-01-2012'/>
    <set name='17-01-2012' value='7' color='99D2EE' showName='0' hoverText='17-01-2012'/>
    <set name='18-01-2012' value='43' color='99D2EE' showName='0' hoverText='18-01-2012'/>
    <set name='19-01-2012' value='7' color='99D2EE' showName='0' hoverText='19-01-2012'/>
    <set name='20-01-2012' value='54' color='99D2EE' showName='0' hoverText='20-01-2012'/>
    <set name='21-01-2012' value='44' color='99D2EE' showName='0' hoverText='21-01-2012'/>
    <set name='22-01-2012' value='39' color='99D2EE' showName='0' hoverText='22-01-2012'/>
    <set name='23-01-2012' value='35' color='99D2EE' showName='0' hoverText='23-01-2012'/>
    <set name='24-01-2012' value='10' color='99D2EE' showName='0' hoverText='24-01-2012'/>
    <set name='25-01-2012' value='20' color='99D2EE' showName='0' hoverText='25-01-2012'/>
    <set name='26-01-2012' value='8' color='99D2EE' showName='1' hoverText='26-01-2012'/>
    </graph>";
        $data['countSoldObj'] = $this->mobject->count_sold_objects();
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vstatistics', $data);
        $this->load->view('base/vfooter');
    }

    //test function
    function show_xml() {
        redirect('http://imoby.nl/');
        $this->load->helper('file');
        $xmlfile = get_filenames('downloads/02232/extract/');
        print_r($xmlfile);
        $xmlStr = file_get_contents('downloads/02232/extract/' . $xmlfile[0]);
        $xmlParser = new SimpleXMLElement($xmlStr);
        $xmlObs = $xmlParser->Object;
        $output = array();
        foreach ($xmlObs as $xmlOb) {
            $output['user'] = $xmlOb->NVMVestigingNR;
            $output['object_number'] = $xmlOb->ObjectTiaraID;


            $output['country'] = $xmlOb->ObjectDetails->Adres->children()->getName();
            $output['streetnaam'] = $xmlOb->ObjectDetails->Adres->children()->children()->Straatnaam;
            $output['huisnummer'] = $xmlOb->ObjectDetails->Adres->children()->children()->Huisnummer;
            $output['postcode'] = $xmlOb->ObjectDetails->Adres->children()->children()->Postcode;
            $output['woonplaats'] = $xmlOb->ObjectDetails->Adres->children()->children()->Woonplaats;
            $output['land'] = $xmlOb->ObjectDetails->Adres->children()->children()->Land;




            foreach ($xmlOb->ObjectDetails->children() as $objectChild) {
                if ($objectChild->getName() == 'Koop' ||
                        $objectChild->getName() == 'Huur'
                ) {
                    $output['sale_rent'] = $objectChild->getName();
                    $saleName = $objectChild->getName();
                    $output['prijsvoorvoegsel'] = $xmlOb->ObjectDetails->$saleName->Prijsvoorvoegsel;
                    $output['koopprijs'] = $xmlOb->ObjectDetails->$saleName->Koopprijs;
                    $output['koopconditie'] = $xmlOb->ObjectDetails->$saleName->KoopConditie;
                }
            }

            $output['aanvaarding'] = $xmlOb->ObjectDetails->Aanvaarding;

            $output['objectaanmelding'] = $xmlOb->ObjectDetails->ObjectAanmelding;

            $output['datuminvoer'] = $xmlOb->ObjectDetails->DatumInvoer;

            $output['datumwijziging'] = $xmlOb->ObjectDetails->DatumWijziging;

            $output['status'] = $xmlOb->ObjectDetails->StatusBeschikbaarheid->Status;

            $output['transactiedatum'] = $xmlOb->ObjectDetails->StatusBeschikbaarheid->TransactieDatum;

            $output['bouwvorm'] = $xmlOb->ObjectDetails->Bouwvorm;

            foreach ($xmlOb->ObjectDetails->children() as $objectChild) {
                if ($objectChild->getName() == 'Internetplaatsingen') {

                    $output['plaatsing'] = $xmlOb->ObjectDetails->Internetplaatsingen->Internetplaatsing->Plaatsing->{0};
                }
            }

            $output['aanbiedingstekst'] = $xmlOb->ObjectDetails->Aanbiedingstekst;
        }

        echo '<pre>';
        print_r($output);
    }

    function read_wonen() {
        redirect('http://imoby.nl/');
        $this->load->helper('file');
        $xmlfile = get_filenames('downloads/latest/');

        $xmlStr = file_get_contents('downloads/WONEN_20120103.xml');
        $xmlParser = new SimpleXMLElement($xmlStr);
        $xmlObs = $xmlParser->Object;
        $output = "";


        foreach ($xmlObs as $xmlOb) {
            foreach ($xmlOb->children() as $wonen) {
                if ($wonen->getName() == 'Wonen') {
                    $output .= $wonen->WonenDetails->Bestemming->HuidigGebruik . '<br/>';
                    $output .= $wonen->WonenDetails->Bestemming->HuidigeBestemming . '<br/>';
                    $output .= $wonen->WonenDetails->Bestemming->PermanenteBewoning . '<br/>';
                    $output .= $wonen->WonenDetails->Bestemming->Recreatiewoning . '<br/>';
                    foreach ($wonen->WonenDetails->MatenEnLigging->Liggingen as $ligging) {
                        $liggings = array();
                        foreach ($ligging->children() as $ligging)
                            $liggings[] = $ligging;
                    }
                    $output .= join(',', $liggings) . '<br/>';
                    $output .= $wonen->WonenDetails->MatenEnLigging->Inhoud . '<br/>';
                    $output .= $wonen->WonenDetails->MatenEnLigging->GebruiksoppervlakteWoonfunctie . '<br/>';
                    $output .= $wonen->WonenDetails->MatenEnLigging->PerceelOppervlakte . '<br/>';
                    $output .= $wonen->WonenDetails->Bouwjaar->JaarOmschrijving->Jaar . '<br/>';
                    $output .= $wonen->WonenDetails->Bouwjaar->InAanbouw . '<br/>';
                    $output .= $wonen->WonenDetails->Onderhoud->Binnen->Waardering . '<br/>';
                    $output .= $wonen->WonenDetails->Onderhoud->Buiten->Waardering . '<br/>';
                    $output .= $wonen->WonenDetails->Diversen->Isolatievormen->Isolatie . '<br/>';
                    $output .= $wonen->WonenDetails->Diversen->Dak->Type . '<br/>';

                    foreach ($wonen->WonenDetails->Installatie->SoortenVerwarming as $verwarming) {
                        $verwarmings = array();
                        foreach ($verwarming->children() as $verwarm) {
                            $verwarmings[] = $verwarm;
                        }
                    }
                    $output .= join(',', $verwarmings) . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->CVKetel->CVKetelType . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->CVKetel->Bouwjaar . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->CVKetel->Brandstof . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->CVKetel->Eigendom . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->CVKetel->Combiketel . '<br/>';
                    $output .= $wonen->WonenDetails->Installatie->SoortenWarmWater->WarmWater . '<br/>';
                    $output .= $wonen->WonenDetails->VoorzieningenWonen->Voorziening . '<br/>';
                    $output .= $wonen->WonenDetails->Tuin->Tuintypen->Tuintype . '<br/>';
                    $output .= $wonen->WonenDetails->Tuin->Kwaliteit . '<br/>';
                    $output .= $wonen->WonenDetails->Hoofdtuin->Type . '<br/>';
                    $output .= $wonen->WonenDetails->Hoofdtuin->Achterom . '<br/>';
                    $output .= $wonen->WonenDetails->Garage->Soorten->Soort;

                    $output .= '<hr/><br/>';
                    $output .= $wonen->Woonhuis->SoortWoning . '<br/>';
                    $output .= $wonen->Woonhuis->TypeWoning . '<br/>';
                    $output .= $wonen->Woonhuis->KwaliteitWoning . '<br/>';
                    $output .= $wonen->Verdiepingen->Aantal . '<br/>';
                    $output .= $wonen->Verdiepingen->AantalKamers . '<br/>';
                    $output .= $wonen->Verdiepingen->AantalSlaapKamers . '<br/>';
                    $output .= '<hr/><br/>';
                    $output .= $wonen->Woonlagen->Kelder->VerdiepingNr . '<br/>';
                    $output .= $wonen->Woonlagen->Kelder->AantalKamers . '<br/>';
                    $output .= $wonen->Woonlagen->BeganeGrondOfFlat->VerdiepingNr . '<br/>';
                    $output .= $wonen->Woonlagen->BeganeGrondOfFlat->AantalKamers . '<br/>';

                    foreach ($wonen->Woonlagen->BeganeGrondOfFlat->Keuken as $keutypes) {

                        foreach ($keutypes as $type) {
                            $types = array();
                            foreach ($type as $key => $value) {
                                $types[] = $value;
                            }
                        }
                    }
                    $output .= '<b>' . join(',', $types) . '</b>';
                    foreach ($wonen->Woonlagen->BeganeGrondOfFlat->Woonkamer as $woonkamertypes) {

                        foreach ($woonkamertypes->children()->Types as $type) {
                            $woonkamer = array();
                            foreach ($type as $key => $value) {
                                $woonkamer[] = $value;
                            }
                        }
                    }

                    $output .= '<br/><b>' . join(',', $woonkamer) . '</b>';
                    $oopervlakte = 0;
                    foreach ($wonen->Woonlagen->BeganeGrondOfFlat->Woonkamer as $woonkamertypes) {

                        foreach ($woonkamertypes->children()->Afmetingen as $type) {
                            $oopervlakte = $type->children();
                        }
                    }
                    $output .= $oopervlakte . '<br/>';
                    $output .= $wonen->Woonlagen->BeganeGrondOfFlat->Woonkamer->Trap . '<br/>';
                    foreach ($wonen->Woonlagen->BeganeGrondOfFlat->Badkamer as $voorzien) {
                        foreach ($voorzien->Voorzieningen as $voorziening) {
                            $voorziens = array();
                            foreach ($voorziening as $key => $value) {
                                $voorziens[] = $value;
                            }
                        }
                    }

                    $output .= '<br/><b>' . join(',', $voorziens) . '</b>';
                    foreach ($wonen->Woonlagen->BeganeGrondOfFlat->OverigeRuimten as $ruimten) {
                        $ruimtens = array();
                        foreach ($ruimten as $ruimt) {
                            $ruimtens[] = $ruimt;
                        }
                    }
                    $output .= '<br/><b>' . join(',', $ruimtens) . '</b><br/>';
                    $output .= $wonen->Woonlagen->Verdieping->VerdiepingNr . '<br/>';
                    $output .= $wonen->Woonlagen->Verdieping->AantalKamers . '<br/>';
                    foreach ($wonen->Woonlagen->Verdieping as $Voorzieningen) {

                        foreach ($Voorzieningen->Badkamer as $Badkamer) {
                            foreach ($Badkamer->Voorzieningen as $voorziening) {
                                $voorzienings = array();
                                foreach ($voorziening as $key => $value) {
                                    $voorzienings[] = $value;
                                }
                            }
                        }
                    }
                    $output .= '<br/><b>' . join(',', $voorzienings) . '</b><br/>';
                    foreach ($wonen->Woonlagen->Verdieping as $overigeRuimte) {
                        $overigeRuimtens = array();
                        foreach ($overigeRuimte->OverigeRuimten as $ruimte) {

                            foreach ($ruimte as $key => $value) {

                                $overigeRuimtens[] = $value;
                            }
                        }
                    }

                    $output .= '<br/><b>' . join(',', $overigeRuimtens) . '</b><br/>';
                    $output .= $wonen->Woonlagen->Vliering->VerdiepingNr . '<br/>';
                    $output .= $wonen->Woonlagen->Vliering->AantalKamers . '<br/>';
                    foreach ($wonen->Woonlagen->Vliering as $Overige) {
                        foreach ($Overige->OverigeRuimten as $overigeRuimte) {
                            $vlierings = array();
                            foreach ($overigeRuimte as $key => $value) {
                                $vlierings[] = $value;
                            }
                        }
                    }
                    $output .= '<br/><b>' . join(',', $vlierings) . '</b><br/>';
                }
            }

            $output.= "<hr/>";
        }


        echo $output;
    }

    function show_statistics() {
        redirect('http://imoby.nl/');
        echo "<?xml version='1.0' encoding='utf-8' ?>";
        //write root node as chart
        //write chart type node
        //write row node for headers
        //write days , months
        //write row node for data
        //write value according to day or month
        //end nodes
    }

    function business() {
        redirect('http://imoby.nl/');
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');
        $this->load->library('pagination');

        $data = array();
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => true
        );
        $offset = $this->uri->segment(3);
        if (empty($offset)) {
            $offset = 0;
        }
        $limit = 30;
        $config['total_rows'] = $this->mobject->count_available_objects();
        $config['per_page'] = $limit;
        $config['base_url'] = BASE . 'base/business/';
        $this->pagination->initialize($config);


        $objects = $this->mobject->get_available_objects($limit, $offset);

        foreach ($objects as $key => $object) {

            $medias = $this->mobjectmedia->get_object_medias($object['object_id']);


            $objects[$key]['media_group'] = $medias[0]['media_group'];
            $objects[$key]['url'] = $medias[0]['media_url'];
        }


        $data['objects'] = $objects;
        $data['pagination'] = $this->pagination->create_links();

        $data['countSoldObj'] = $this->mobject->count_sold_objects();
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vbusiness', $data);
        $this->load->view('base/vfooter');
    }

    function business_arch() {
        redirect('http://imoby.nl/');
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');
        $this->load->library('pagination');

        $data = array();
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => true
        );
        $offset = $this->uri->segment(3);
        if (empty($offset)) {
            $offset = 0;
        }
        $limit = 30;
        $config['total_rows'] = $this->mobject->count_sold_objects();
        $config['per_page'] = $limit;
        $config['base_url'] = BASE . 'base/business_arch/';
        $this->pagination->initialize($config);


        $objects = $this->mobject->get_sold_objects($limit, $offset);

        foreach ($objects as $key => $object) {

            $medias = $this->mobjectmedia->get_object_medias($object['object_id']);


            $objects[$key]['media_group'] = $medias[0]['media_group'];
            $objects[$key]['url'] = $medias[0]['media_url'];
        }


        $data['objects'] = $objects;
        $data['pagination'] = $this->pagination->create_links();

        $data['countSoldObj'] = $config['total_rows'];
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vbusiness', $data);
        $this->load->view('base/vfooter');
    }

    function qrcode() {
        redirect('http://imoby.nl/');
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');

        $data = array();
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => true
        );
        $uriData = $this->uri->segment(3);
        if (!empty($uriData)) {
            $object = $this->mobject->get_object_by_code($uriData);
            $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['object_id']);
            $object[0]['media_url'] = $media_urls[0]['media_url'];
            $object[0]['media_group'] = $media_urls[0]['media_group'];
            $data['objects'] = $object;
            $data['qrcodeImage'] = BASE . 'qr_images/qr.php?w=481&f=4&c=' . $object[0]['ObjectTiaraID'] . '&d=' . urlencode(BASE . 'base/' . $object[0]['ObjectTiaraID']);
        } else {
            $data['objects'] = "";
            $data['qrcodeImage'] = "";
        }



        $data['countSoldObj'] = $this->mobject->count_sold_objects();
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vqrcode', $data);
        $this->load->view('base/vfooter');
    }

    function changepass() {
        redirect('http://imoby.nl/');
        $this->load->model('mobject');
        $data = array();
        $data['title'] = 'Imoby';
        $data['logo'] = 'logo.png';
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isVastgoed' => false,
            'isAuto' => false,
            'isSupport' => false,
            'isContact' => false,
            'isBusiness' => true
        );

        $data['countSoldObj'] = $this->mobject->count_sold_objects();
        $this->load->view('base/vheader', $data);
        $this->load->view('base/vchangepass', $data);
        $this->load->view('base/vfooter');
    }

    function qrcodeprocess() {
        redirect('http://imoby.nl/');
        $qrDataGet = explode('|', $this->input->post('data'));

        echo BASE . 'qr_images/qr.php?w=' . $qrDataGet[0] . '&f=4&c=' . $qrDataGet[1] . '&d=' . urlencode(BASE . 'base/' . $qrDataGet[1]);
    }

    function update_pass() {
        redirect('http://imoby.nl/');
        $this->load->model('muser');

        if ($this->session->userdata('logged_in')) {
            $changed = $this->muser->changePassword();
            if ($changed == 1) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    function test() {
        redirect('http://imoby.nl/');
        set_time_limit(400);
        $this->load->library('mobile_detect');
        $detect = new Mobile_Detect();
        if (
                $detect->isMobile() ||
                $detect->isAndroid() ||
                $detect->isAndroidtablet() ||
                $detect->isIphone() ||
                $detect->isBlackberry() ||
                $detect->isBlackberrytablet() ||
                $detect->isPalm() ||
                $detect->isWindowsphone() ||
                $detect->isIpad()
        ) {
            echo "hello for android user";
        } else {
            echo '<a href="' . BASE . 'base/mobilewebsite/123456">Download</a>';
            echo "hello for all";
        }
    }

    function mobilewebsite() {
        $id = $this->uri->segment(3);
        $fileContent = 'Nederlands:
Het onderstaande script moet in de head worden opgenomen van de html pagina.
Dit script zorgt ervoor dat een bezoeker met een mobiele telefoon de vraag
krijgt of de bezoeker de mobiele pagina wil bezoeken. 

Engels:
The script below should be included in the head of the html page.
This script allows a visitor with a cell phone asked if the visitor
wants to visit the mobile page.

<script type="text/javascript" src="' . BASE . 'base/mobilescript/' . $id . '/imoby.js"></script>';
        file_put_contents('tempfile/instructions.txt', $fileContent);
        $file = "instructions.txt";
        header('Content-type:application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        readfile('tempfile/' . $file);
    }

    function mobilescript() {
        $id = $this->uri->segment(3);
        $filename = $this->uri->segment(4);
        if (!empty($filename) && $filename == "imoby.js") {
            if (!empty($id)) {

                echo 'if(screen.width <= 699) { if(confirm("U bezoekt onze website met een mobiele telefoon. We beschikken over een mobiele site. Wilt u deze bekijken?")){
                                window.location = "' . BASE . $id
                . '"} }';
            }
        }
    }

    function render_map() {
        redirect('http://imoby.nl/');
        $location_name = "mirput Section 11, Dhaka, Bangladesh";
        $locations = $this->get_GeoLocation($location_name);
        $data = array();
        if ($locations != -1 && $locations != 0) {
            $data['locations'] = $locations;
        }
        $this->load->view('base/vmap', $data);
    }

    function get_GeoLocation($location_name) {
        redirect('http://imoby.nl/');
        if (!empty($location_name)) {
            $xmlStr = file_get_contents("http://maps.googleapis.com/maps/api/geocode/xml?address=" . urlencode($location_name) . "&sensor=false");
            if (!empty($xmlStr)) {

                $xmlObj = new SimpleXMLElement($xmlStr);
                if ($xmlObj->status != 'ZERO_RESULTS') {
                    $data = array();
                    $data['lat'] = $xmlObj->result->geometry->location->{'lat'};
                    $data['lng'] = $xmlObj->result->geometry->location->{'lng'};
                    return $data;
                } else {
                    return 0;
                }
            } else {
                return -1;
            }
        } else {
            return 0;
        }
    }

    function get_file() {
        redirect('http://imoby.nl/');
        echo $str = file_get_contents('http://www.taggle.nl/mobilescript/326056/taggle.js');
        file_put_contents('imoby.js', $str);
    }

    function woning() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $this->load->model('motherpage');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isWoning' => true,
            'isAuto' => false,
            'isProducten' => false,
            'isContact' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('woning', 3);
        $data['videos'] = $this->mfrontpage->get_videos_by_type('woning', 3);
        $data['hpages'] = $this->motherpage->getPages('woning');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vwoning', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function products() {
        redirect('http://imoby.nl/');
        $this->load->model('motherpage');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isWoning' => false,
            'isAuto' => false,
            'isProducten' => true,
            'isContact' => false
        );
        $data['ppages'] = $this->motherpage->getPages('producten');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vproducten', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function aboutus() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $this->load->model('motherpage');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => true,
            'isWoning' => false,
            'isAuto' => false,
            'isProducten' => false,
            'isContact' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('overons', 3);
        $data['videos'] = $this->mfrontpage->get_videos_by_type('overons', 3);
        $data['hpages'] = $this->motherpage->getPages('overons');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vwoning', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function car() {
        redirect('http://imoby.nl/');
        $this->load->model('mfrontpage');
        $this->load->model('motherpage');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isWoning' => false,
            'isAuto' => true,
            'isProducten' => false,
            'isContact' => false
        );
        $data['pages'] = $this->mfrontpage->get_page_by_type('auto', 3);
        $data['videos'] = $this->mfrontpage->get_videos_by_type('auto', 3);
        $data['hpages'] = $this->motherpage->getPages('auto');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vwoning', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function contactus() {
        redirect('http://imoby.nl/');
        $this->load->model('motherpage');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => false,
            'isOverons' => false,
            'isWoning' => false,
            'isAuto' => false,
            'isProducten' => false,
            'isContact' => true
        );
        $data['cpages'] = $this->motherpage->getPages('contact');
        $this->load->view('imoby_front/vheader', $data);
        $this->load->view('imoby_front/vcontacts', $data);
        $this->load->view('imoby_front/vfooter');
    }

    function preview($objectid="") {
        redirect('http://imoby.nl/');
        $this->load->model('mmobileapps');
        $data = array();
        $data['title'] = "Imoby.nl";
        $data['selectedMenu'] = array(
            'isHome' => true,
            'isOverons' => false,
            'isWoning' => false,
            'isAuto' => false,
            'isProducten' => false,
            'isContact' => false
        );
        if (is_numeric($objectid) && !empty($objectid)) {
            $app = $this->mmobileapps->get_app_by_appid($objectid);
            if (!empty($app) && $app[0]['mode'] == 'application') {
                $data['iframeLink'] = BASE . 'mobile/home/' . $objectid;
            } elseif (!empty($app) && $app[0]['mode'] == 'total_aanbod') {

                $data['iframeLink'] = BASE . 'mobile/aanbod/' . $objectid;
            } else {

                $data['iframeLink'] = BASE . 'mobile/wonen_object/' . $objectid;
            }
            $this->load->view('imoby_front/vheader', $data);
            $this->load->view('imoby_front/vmobihome', $data);
            $this->load->view('imoby_front/vfooter');
        } else {
            redirect(BASE);
        }
    }

    function download_vcard() {
        //redirect('http://imoby.nl/');
        $imobyAgentNumber = $this->uri->segment(3);
        if (!empty($imobyAgentNumber) && is_numeric($imobyAgentNumber)) {
            if (file_exists('fileserver/bofiles/downloads/' . $imobyAgentNumber . '/vcard.vcf')) {
                header('Content-type:application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename('vcard.vcf'));
                readfile('fileserver/bofiles/downloads/' . $imobyAgentNumber . '/vcard.vcf');
            }
        }
    }

    function submitContact() {
        redirect('http://imoby.nl/');
        $this->load->model('muser');
        $mailContent = array();
        $mailContent['to'] = 'himel@bengalsols.com';
        $mailContent['subject'] = 'Imoby Client\'s Contacts';

        $mailContent['msg_body'] = "Name: {$_POST['Name']} <br/>E-mail: {$_POST['Email']}
            <br/>Subject: {$_POST['Subject']}<br/>Message: <br/>{$_POST['Message']}";

        $sended = $this->muser->send_email($mailContent);
        if ($sended) {
            echo 1;
        } else {
            print_r($_POST);
        }
    }

    function add_subscriber() {
        redirect('http://imoby.nl/');
        $this->load->model('msubscriber');
        $subscriber_email = $this->input->post('email', true);
        $exist = $this->subscriber_exist($subscriber_email);
        if ($exist) {
            echo 0;
        } else {
            $info = array();
            $info['subscriber_email'] = $subscriber_email;
            $info['created_dt'] = date('Y-m-d H:i:s');
            $info['modified_dt'] = date('Y-m-d H:i:s');
            $this->msubscriber->save_subscriber($info);
            echo 1;
        }
    }

    function subscriber_exist($email) {
        redirect('http://imoby.nl/');
        $this->load->model('msubscriber');
        return $this->msubscriber->check_subscriber($email);
        
    }

    function webinclude() {
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');
        $this->load->model('mstatistics');
        $this->load->model('mmessage');
        $this->load->model('mppresentation');
        
        $uriData = $this->uri->segment(3);
        if (is_numeric($uriData) && !empty($uriData)) {

            $object = $this->mobject->get_object_by_code($uriData);
            $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);

            if ($object[0]['custom_object_id'] == 0) {
                $object[0]['media_url'] = substr($media_urls[0]['media_url'], 0, strlen($media_urls[0]['media_url']) - 1) . '1';
            } else {
                $object[0]['media_url'] = $media_urls[count($media_urls) - 1]['media_url'];
            }
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user_id'] = $object[0]['NVMVestigingNR'];
            $data['object_id'] = $object[0]['ObjectTiaraID'];
            //$this->load->view('user/vheader',$data);
            $this->load->view('base/vwebinclude',$data);
            //$this->load->view('user/vfooter');
        }
        
    }
    function videopreview() {
        $this->load->model('mobject');
        $this->load->model('mobjectmedia');
        $this->load->model('mstatistics');
        $this->load->model('mmessage');
        $this->load->model('mppresentation');
        
        $uriData = $this->uri->segment(3);
        if (is_numeric($uriData) && !empty($uriData)) {

            $object = $this->mobject->get_object_by_code($uriData);
            $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);

            if ($object[0]['custom_object_id'] == 0) {
                $object[0]['media_url'] = substr($media_urls[0]['media_url'], 0, strlen($media_urls[0]['media_url']) - 1) . '1';
            } else {
                $object[0]['media_url'] = $media_urls[count($media_urls) - 1]['media_url'];
            }
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user_id'] = $object[0]['NVMVestigingNR'];
            $data['object_id'] = $object[0]['ObjectTiaraID'];
            //$this->load->view('user/vheader',$data);
            $this->load->view('base/vvideopreview',$data);
            //$this->load->view('user/vfooter');
        }
        
    }

//        function webinclude(){
//                $this->load->model('mobject');
//                $this->load->model('mobjectmedia');
//                $this->load->model('mstatistics');
//		$this->load->model('mmessage');
//		$this->load->model('mppresentation');
//                $data = array();
//		$data['logo'] = "logo.png";
//		$data['title'] = 'Imoby';
//                $uriData = $this->uri->segment(3);
//                if(is_numeric($uriData) && !empty($uriData)){
//                        $object = $this->mobject->get_object_by_code($uriData);
//                        $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);
//                        if($object[0]['custom_object_id'] == 0){
//				$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
//			}else{
//				$object[0]['media_url'] = $media_urls[count($media_urls)-1]['media_url'];
//			}
//			//$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
//                        
//			$object[0]['media_group'] = $media_urls[0]['media_group'];
//                        $data['objects'] = $object;
//                        
//                        
//                        $images = $this->mobjectmedia->get_objmedia_by_obj_id($uriData);
//			if($object[0]['custom_object_id'] == 0){
//				$soundLink = SOUNDS;
//                                $randVal = mt_rand(1, 5);
//                                //echo $randVal;
//                        $xmlData = '<slickboard>';
//                        $xmlData .= '<sound><clip id="music" url="'.$soundLink.'sound_'.$randVal.'.mp3" delay="0" stream="5" timeout="30" retry="2" /></sound>';
//                        $xmlData .= '<action><item type="sound_play" target="music" event="timer" delay="0" loop="0" /><item type="global_volume" event="timer" delay="0" volume="0.5" /></action>';
//                        foreach($images as $image){
//				$xmlData .= '<object>';
//				
//				$xmlData .= '<image url="'.DOWNLOADS.$image['NVMVestigingNR'].'/'.$image['object_id'].'/'.$image['media_name'].'" fill="trim" width="480" height="300" />';
//				
//				$xmlData .= '  <slide duration="5" preload="2" />
//						<transition_in type="fade" duration="2" />
//					    </object>';
//                        }
//                        $xmlData .= '<object offset_x="0" offset_y="460">
//                                        <rect width="650" height="20" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" shadow="control_bar" />
//                                        <rect width="650" height="20" fill_color="4488ff" fill_alpha=".5" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" />
//                                        <object id="play" offset_x="8" offset_y="0" >
//                                            <rect width="10" height="15" fill_alpha="0" state="hit" />
//
//                                            <polygon fill_color="ffffff" state="checked" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//                                            <polygon fill_color="ffffff" state="checked_over" glow="control" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//                                            <polygon fill_color="ffaaaa" state="checked_press" glow="control" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//
//                                            <rect x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" />
//                                            <rect x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" />
//                                            <rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" />
//                                            <rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" />
//                                            <rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" />
//                                            <rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" />
//
//                                            <action>
//                                                <item type="slideshow_toggle" />
//                                                <item type="sounds_pause" event="check" />
//                                                <item type="sounds_resume" event="uncheck" />
//                                            </action>
//                                        </object>
//                                        <object id="volume" offset_x="530" offset_y="2" >
//                                            <rect width="100" height="15" fill_color="224488" corner_tl="10" corner_tr="10" corner_br="10" corner_bl="10"  shadow="inner" />
//                                            <object id="speaker_cloak">
//                                                <rect x="95" y="0" width="1" height="1" fill_alpha="0"  />
//                                            </object>
//                                            <object id="speaker_constrain">
//                                                <rect x="2" y="4" width="96" height="10" fill_alpha="0"  />
//                                            </object>
//                                            <object id="speaker" shadow="default">
//                                                <rect x="2" y="2" width="26" height="15" fill_alpha="0" state="hit" />
//                                                <polygon fill_color="ffffff">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <polygon fill_color="ffffff" state="over" glow="control">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <polygon fill_color="ffaaaa" state="press" glow="control">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <object>
//                                                    <circle x="15" y="8" radius="6" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha="1" line_thickness="3" />
//                                                    <cloak target="speaker_cloak" radius_1="50" radius_2="75" />
//                                                </object>
//                                                <object> 
//                                                    <circle x="15" y="8" radius="10" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".75" line_thickness="2" />
//                                                    <cloak target="speaker_cloak" radius_1="25" radius_2="50" />
//                                                </object>
//                                                <object>
//                                                    <circle x="15" y="8" radius="14" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".5" line_thickness="1" />
//                                                    <cloak target="speaker_cloak" radius_1="0" radius_2="30" />
//                                                </object>
//                                                <constrain target="speaker_constrain" reflect="0" />
//                                                <action>
//                                                    <item type="adjust_global_volume" event="slider" />
//                                                    <item type="drag" target="speaker" />
//                                                </action>
//                                            </object>
//                                        </object>
//                                    </object>
//                                    <filter>
//                                        <shadow id="default" />
//                                        <shadow id="control_bar" knockout="true" distance="5" alpha=".25" blurX="10" blurY="10" />
//                                        <shadow id="inner" inner="true" distance="3" alpha=".25" blurX="5" blurY="5" />
//                                        <glow id="control" color="ff4400" alpha=".9" blurX="10" blurY="10" inner="false" />
//                                    </filter>
//                                </slickboard>';
//				file_put_contents('slickboard/webinclude.xml', $xmlData);
//			}else{
//				//echo $this->session->userdata('imobycode');
//				//die();
//				
//				$customJsData = $this->mppresentation->getpp_byid($object[0]['custom_object_id']);
//				//print_r($customJsData);die();
//				$presen = json_decode($customJsData[0]['jsondata']);
//				//var_dump($presen);
//				//echo $presen['film0']['imglarge'];
//				$xmlfile = 'slickboard/webinclude.xml';
//				$xmlwrite = fopen($xmlfile, 'w') or die('Cannot open file:  '.$xmlfile);
//				
//				$data1 = '<slickboard>';
//				 //echo get_class($presen);
//				foreach(get_object_vars($presen) as $key=>$value){
//                                    if($key == 'bgaudio'){
//                                        
//				    $data1 .= '<sound><clip id="music" url="'.DOWNLOADS.$object[0]['NVMVestigingNR'].'/'.$presen->bgaudio.'" delay="0" stream="5" timeout="30" retry="2" /></sound>';
//				    $data1 .= '<action><item type="sound_play" target="music" event="timer" delay="0" loop="0" /><item type="global_volume" event="timer" delay="0" volume="0.5" /></action>';
//				
//                                    }
//                                }
//				for($i=1; $i<=$presen->filmcount; $i++){
//					$image = $presen->$i->newimage != '' ? DOWNLOADS.$object[0]['NVMVestigingNR'].'/'.$presen->$i->newimage : DOWNLOADS.$object[0]['NVMVestigingNR'].'/'.$presen->$i->image;
//                                        $image = str_replace('640x480', '480x300', $image);
//				    $img = '<object><image url="'. $image .'" fill="trim" width="480" height="300" />';
//				    $slide = '<slide duration="'. $presen->$i->slideduration .'" preload="2" />';
//				    if($presen->$i->effectnumber > 0){
//					$effect = '<transition_in type="fly" duration="'. $presen->$i->effectduration .'" startPoint="'. $presen->$i->effectnumber .'" /></object>';
//				    }else{
//					$effect = '<transition_in type="fade" duration="'. $presen->$i->effectduration .'" /></object>';
//				    }
//				    $data1 .= $img . $slide . $effect;
//				}
//				
//				$ctrlbarStart = '<object offset_x="0" offset_y="460"><rect width="650" height="20" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" shadow="control_bar" /><rect width="650" height="20" fill_color="4488ff" fill_alpha=".5" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" />';
//				$backButton = '<object id="backward" offset_x="25" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><action><item type="slideshow_backward" /></action></object>';
//				$playButton = '<object id="play" offset_x="8" offset_y="0" ><rect width="10" height="15" fill_alpha="0" state="hit" /><rect x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><polygon fill_color="ffffff" state="checked" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffffff" state="checked_over" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffaaaa" state="checked_press" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><action><item type="slideshow_toggle" /><item type="sounds_pause" event="check" /><item type="sounds_resume" event="uncheck" /></action></object>';
//				$forwardButton = '<object id="forward" offset_x="122" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><action><item type="slideshow_forward" /></action></object>';
//				$volumeButton = '<object id="volume" offset_x="530" offset_y="2" ><rect width="100" height="15" fill_color="224488" corner_tl="10" corner_tr="10" corner_br="10" corner_bl="10"  shadow="inner" /><object id="speaker_cloak"><rect x="95" y="0" width="1" height="1" fill_alpha="0"  /></object><object id="speaker_constrain"><rect x="2" y="4" width="96" height="10" fill_alpha="0"  /></object><object id="speaker" shadow="default"><rect x="2" y="2" width="26" height="15" fill_alpha="0" state="hit" /><polygon fill_color="ffffff"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><object><circle x="15" y="8" radius="6" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha="1" line_thickness="3" /><cloak target="speaker_cloak" radius_1="50" radius_2="75" /></object><object> <circle x="15" y="8" radius="10" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".75" line_thickness="2" /><cloak target="speaker_cloak" radius_1="25" radius_2="50" /></object><object><circle x="15" y="8" radius="14" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".5" line_thickness="1" /><cloak target="speaker_cloak" radius_1="0" radius_2="30" /></object><constrain target="speaker_constrain" reflect="0" /><action><item type="adjust_global_volume" event="slider" /><item type="drag" target="speaker" /></action></object></object>';
//				$ctrlbarEnd = '</object><filter><shadow id="default" /><shadow id="control_bar" knockout="true" distance="5" alpha=".25" blurX="10" blurY="10" /><shadow id="inner" inner="true" distance="3" alpha=".25" blurX="5" blurY="5" /><glow id="control" color="ff4400" alpha=".9" blurX="10" blurY="10" inner="false" /></filter>';
//				
//				$data1 .= $ctrlbarStart . $playButton . $volumeButton . $ctrlbarEnd ;
//				$data1 .= '</slickboard>';
//				
//				fwrite($xmlwrite, $data1);
//				fclose($xmlwrite);
//				
//				$result = BASE.$xmlfile.'?unique_id='.time();
//				$data['xmlSrc'] = $result;
//			}
//
//                }
//                //$data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
//                //$this->load->view('user/vheader',$data);
//                
//                $this->load->view('base/vwebinclude',$data);
//                //$this->load->view('user/vfooter');
//        }

    function getSetObject() {

        $q = $this->db->get('objects');
        $result = $q->result_array();
        unset($result[0]);
        echo '<pre>';
        $insertData = array();
        foreach ($result as $r) {
            $insertData['ObjectTiaraID'] = $r['ObjectTiaraID'];
            $insertData['duration'] = 50;
            $insertData['NVMVestigingNR'] = $r['NVMVestigingNR'];
            $insertData['is_done'] = 0;
            $this->db->insert('object_pending_3gp ', $insertData);
        }
    }

    function wachtwoordvergeten() {
        $this->load->view('base/vpassrecovery');
    }

    function check_username_available() {
        $this->load->model('muser');
        $username = $this->input->post('username', true);
        $getUsername = $this->muser->username_exist($username);
        if ($getUsername) {
            $mail_data['to'] = $username;
            $mail_data['subject'] = "Reset Password for your imoby account";
            $key = md5(date('Y-m-d H:i:s') . $username . $getUsername);
            $this->muser->updateUserCode($username, $key);
            $path = BASE . 'base/confirm/' . $key;
            $mail_data['msg_body'] = <<<EOF
                    <h2>Nieuw wachtwoord aanmaken voor uw Imoby account</h2>
                    <a href="{$path}">Klik hier</a> om een nieuw wachtwoord aan te maken

EOF;
            //  : Testen code igniter mail, send_email uitgezet voor wachtwoordvergeten en gebruik maken van send_email_CodeIgniter
            //$this->send_email($mail_data);
            $this->send_email_CodeIgniter($mail_data);
            echo $getUsername;
        } else {
            echo 0;
        }
    }

    /*
     * Extra mail functionaliteit omdat send_email niet lijkt te werken op linux server. Moet aangepast worden naar 1 mail functionaliteit // TODO
     */
    function send_email_CodeIgniter($mail_data){
        $this->load->library('email');
        
        $config['mailtype'] = 'html';
	$this->email->initialize($config);
        
        $this->email->from('info@imoby.nl', 'Imoby BV');
        $this->email->to($mail_data['to']);
        
        $this->email->subject($mail_data['subject']);
        $this->email->message($mail_data['msg_body']);	
        $this->email->send();
    }
    
    
    function send_email($mail_data, $attach=false, $file="", $rname="") {

        $this->load->library("phpmailer");

        $this->phpmailer->AddAddress($mail_data['to']);
        $this->phpmailer->Subject = $mail_data['subject'];
        $this->phpmailer->IsHTML();
        $this->phpmailer->Body = $mail_data['msg_body'];
        if ($attach) {
            $this->phpmailer->AddAttachment($file, $rname);
        }
        $send = $this->phpmailer->Send();
        if ($send) {
            return $send;
        } else {
            return false;
        }
    }

    function confirm() {
       // error_reporting(E_ALL);
        $this->load->model('muser');
        $postRequest = $this->input->post('code', true);

        if ($postRequest) {

            $user = $this->muser->getUsernameByCode($this->input->post('code', true));
            $updated = $this->muser->updatePassword($user[0]['id']);
            $response = array();

            $response['debug'] = $updated;
            if ($updated == 1) {

                $mail_data['to'] = $user[0]['username'];
                $mail_data['subject'] = 'Imoby.nl nieuw wachtwoord';
                $mail_data['msg_body'] = <<<EOF
<h2>Imoby.nl: nieuw wachtwoord</h2>
<br/>
<p>Beste {$user[0]['username']},  hierbij uw nieuwe wachtwoord</p>
<p>
    Nieuw wachtwoord: {$_POST['newpass']}
</p>
<p>
    Dank u.
</p>
EOF;
                $this->send_email($mail_data);
                $response['status'] = 200;
                $response['msg'] = 'Uw nieuwe wachtwoord is succesvol aangemaakt. Een email is verzonden naar uw emailadres  ' . $user[0]['username'];
            } else {
                $response['status'] = 500;
                $response['msg'] = 'Sorry, het wachtwoord is niet veranderd. Het nieuwe wachtwoord en de bevestiging van het nieuwe<br/> wachtwoord komen niet overeen. Let op: het wachtwoord moet minimaal 4 karakters bevatten.';
            }
            echo json_encode($response);
        } else {

            $key = $this->uri->segment(3);
            $data = array();
            if (!empty($key)) {
                $codeExist = $this->muser->hasCode($key);
                if (!empty($codeExist)) {
                    $data['code'] = $key;
                } else {
                    $data['code'] = '';
                }
            } else {
                $data['code'] = "";
            }
            $this->load->view('base/vchangepass', $data);
        }
    }

}