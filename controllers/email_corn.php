<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_corn extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function fatchemail() {
        $inbox = imap_open("{mail.testimoby.nl:995/pop3/ssl/novalidate-cert}", "catchall@testimoby.nl", "Oqd2XGzBd");
        $messages = array();
        /* grab emails */
        $emails = imap_search($inbox, 'ALL');
        $output = '';
        rsort($emails);
        $i = 0;
        foreach ($emails as $email_number) {

            $data = array();
            $overview = imap_fetch_overview($inbox, $email_number, 0);
            $message = imap_fetchbody($inbox, $email_number,"1.1");
            $message = trim(substr(quoted_printable_decode($message), 0, 100));
            $structure = imap_fetchstructure($inbox, $email_number);
            
            
            
            
            $header = imap_headerinfo($inbox, $email_number);

            $from = $header->from;
            $mailfrom = $messages[$i]['from'] = $fromaddress = $from[0]->mailbox . "@" . $from[0]->host;
            $toadres = $header->to;
            $mailto = $messages[$i]['to'] = $toadres[0]->mailbox . "@" . $toadres[0]->host;
            $mailsubject = $messages[$i]['subject'] = $overview[0]->subject;
            $mailbody = $messages[$i]['body'] = $message;
            /* account check start */
            $this->db->where('dealer_imoby_email', $mailto);
            $query = $this->db->get('email_account');
            $result = $query->result();
            // if email address is check start
            if ($query->num_rows() > 0) {
                $dealer_id = $result[0]->dealer_id;
                $emaildata = array(
                    'dealer_id' => $dealer_id,
                    'from' => $mailfrom,
                    'subject' => $mailsubject,
                    'body' => $mailbody,
                    'type' => 1,
                    'status' => 1
                );
                $this->db->insert('email', $emaildata);
                $imobyemailid = $this->db->insert_id();
                if ($query->num_rows() > 0) {
                    // email attachment 
                    $message = array();
                    $message["attachment"]["type"][0] = "text";
                    $message["attachment"]["type"][1] = "multipart";
                    $message["attachment"]["type"][2] = "message";
                    $message["attachment"]["type"][3] = "application";
                    $message["attachment"]["type"][4] = "audio";
                    $message["attachment"]["type"][5] = "image";
                    $message["attachment"]["type"][6] = "video";
                    $message["attachment"]["type"][7] = "other";
                    $structure = imap_fetchstructure($inbox, $email_number);
                    $parts = $structure->parts;
                    $fpos = 2;
                    for ($i = 1; $i < count($parts); $i++) {
                        $message["pid"][$i] = ($i);
                        $part = $parts[$i];
                        if (strtolower($part->disposition) == "attachment") {
                            $message["type"][$i] = $message["attachment"]["type"][$part->type] . "/" . strtolower($part->subtype);
                            $message["subtype"][$i] = strtolower($part->subtype);
                            $ext = $part->subtype;
                            $params = $part->dparameters;
                            $filename = $part->dparameters[0]->value;
                            $mege = "";
                            $data = "";
                            $mege = imap_fetchbody($inbox, $jk, $fpos);
                            $filename = "$filename";
                            $data = $this->getdecodevalue($mege, $part->type);
                            $isDir = (is_dir(FILEDIR . "/emailattachment/" . $imobyemailid)) ? true : mkdir(FILEDIR . "/emailattachment/" . $imobyemailid, 0777);
                            if ($isDir) {
                                $fp = fopen(FILEDIR . "/emailattachment/" . $imobyemailid . "/" . $filename, w);
                                fputs($fp, $data);
                                fclose($fp);
                                $fpos+=1;
                            }
                        }
                    }
                    // email attachment 
                     
                }
                
  
            } 
            imap_delete($inbox,$i);
            echo $mailto.'<br>';  
            $i++;
        }
        
        
        
        imap_expunge($inbox);       
        imap_delete($inbox,1);
        imap_expunge($inbox);
        imap_close($inbox);
        
        echo "Done";
    }
    
    function dmail(){
        $inbox = imap_open("{mail.testimoby.nl:995/pop3/ssl/novalidate-cert}", "catchall@testimoby.nl", "Oqd2XGzBd");
        $messages = array();
        /* grab emails */
        $emails = imap_search($inbox, 'ALL');
        $output = '';
        rsort($emails);
        $i = 1;
        foreach ($emails as $email_number) {
            imap_delete($inbox,$i); 
            $i++;
        }
        imap_expunge($inbox);
        imap_close($inbox);
    }
    
    
    function getdecodevalue($message, $coding) {
        switch ($coding) {
            case 0:
            case 1:
                $message = imap_8bit($message);
                break;
            case 2:
                $message = imap_binary($message);
                break;
            case 3:
            case 5:
            case 6:
            case 7:
                $message = imap_base64($message);
                break;
            case 4:
                $message = imap_qprint($message);
                break;
        }
        return $message;
    }

}
