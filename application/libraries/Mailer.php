<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailer
 *
 * @author Tohir
 */
class Mailer {

    /**
     *
     * @var tbemail
     */
    protected $email;

    //CI instance
    private $CI;


    public function __construct($inConfig = array()) {
        if (!class_exists('Tbemail')) {
            require_once 'Tbemail.php';
        }
        $this->email = new tbemail();
        $config = [];
        $configFile = APPPATH . 'config/email.php';
        if (file_exists($configFile)) {
            include $configFile;
            if (empty($config)) {
                throw new Exception('Config for mailer is empty');
            }
        }
        $this->email->initialize(array_merge((array) $inConfig, $config));
        $this->email->from(NO_REPLY_EMAIL, BUSINESS_NAME);

    }

    public function setSender($sender) {
        $senderArr = $this->breakAddressLine($sender);
        return $this->setFrom($senderArr[0]['email'], $senderArr[0]['name']);
    }

    /**
     * Sets sender of mail
     * @param type $email
     * @param type $name
     * @return \mailer
     */
    public function setFrom($email, $name = '') {
        $this->email->from($email, $name);
        return $this;
    }

    public function loadSystemMessage($view_script, array $vars = []) {
        $vars['company'] = utils\DefaultCompany::instance();
        return $this->loadCompanyMessage($view_script, $vars);
    }
    
   

    /**
     * 
     * Sends message to user using specified SMTP Config
     * @param string $subject subject of the message
     * @param string $message html or text content of the email
     * @param string|array $to list of recipients in to field
     * @param string|array $cc CC field, similar to $to
     * @param string|array $bcc BCC field, similar to $to
     * @param array $attachments array of filenames or attachment spec, attachment spec is in the form 
     *   array('filename' => $path_to_file, 'disposition' => inline|attachment)
     * @param array $extraHeaders name value pairs of extra headers to add.
     * @return boolean true|false status of the sending.
     */
    public function sendMessage($subject, $message, $to, $cc = '', $bcc = '', $from='', $attachments = array(), $extraHeaders = array()) {
        $this->email
                ->subject($subject)
                ->message($message)
                ->to($to)
        ;
        if ($cc) {
            $this->email->cc($cc);
        }

        if ($bcc) {
            $this->email->bcc($bcc);
        }
		
		if ($from) {
			$this->email->from($from);
		}

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                if (is_array($attachment)) {
                    $filename = $attachment['file'];
                    $disposition = $attachment['disposition'];
                } else {
                    $filename = $attachment;
                    $disposition = 'attachment';
                }
                $this->email->attach($filename, $disposition);
            }
        }
        if (!empty($extraHeaders)) {
            foreach ($extraHeaders as $header => $value_s) {
                $value_s = is_array($value_s) ? $value_s : array($value_s);
                foreach ($value_s as $value) {
                    $this->email->addCustomHeader($header, $value);
                }
            }
        }

        $result = $this->email->send();
        $this->reset();
        return $result;
    }

    public function reset() {
        $this->email->clear(true);
        return $this;
    }

    public function breakAddressLine($line) {
        $parts = preg_split('/\s*,\s*/', $line);
        $addresses = array();
        foreach ($parts as $address) {
            $address = trim($address);
            $matches = array();
            if (preg_match('/^(.*)<(.+@.+)>$/', $address, $matches)) {
                $addresses[] = array(
                    'name' => trim($matches[1]),
                    'email' => trim($matches[2]),
                );
            } else {
                $addresses[] = array('email' => $address, 'name' => null);
            }
        }

        return $addresses;
    }

}
