<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Talentbase
 * PDF generator lib 2
 * 
 * @category   Library
 * @package    Company
 * @subpackage PDF Generator
 * @author     Tohir Omoloye. <otclentech@gmail.com>
 * @copyright  Copyright © 2016 ZendSoft Solutions Ltd.
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */
class Pdf_lib extends mPDF {

    /**
     * Codeigniter instance
     * 
     * @access private
     * @var object
     */
    private $CI;

    /**
     * PDF header
     * 
     * @access private
     * @var string
     */
    private $header;

    /**
     * PDF Footer
     * 
     * @access private
     * @var string
     */
    private $footer;

    /**
     * Class construct
     * 
     * @access public
     * @return void 
     */
    public function __construct() {

        parent::__construct();

        // Load CI
        $this->CI = get_instance();
    }

// End func __construct

    /**
     * PDF Header settings
     * 
     * @access private
     * @param string $header 
     * @return string 
     */
    private function _set_pdf_header($header = '') {

        if ($header == '') {
            return $this->SetHeader($this->header = BUSINESS_NAME);
        }

        return $this->SetHeader($this->header = $header);
    }

// End func _set_pdf_header

    /**
     * PDF Footer settings
     * 
     * @access private
     * @param string $footer
     * @return  string 
     */
    private function _set_pdf_footer($footer = '') {

        if ($footer == '') {
            return $this->SetFooter($this->footer = 'Copyright @ ' . date('Y') . ' ' . BUSINESS_NAME);
        }

        return $this->SetFooter($this->footer = $footer);
    }

// End func _set_pdf_footer

    /**
     * Build pdf file base on html tags.
     * 
     * @access public
     * @param array $data an array data of header, footer, html tags embeded in a string
     * @return void
     */
    public function build_pdf(array $data) {
        if (!empty($data)) {

            $f = 'test.pdf';

            if (isset($data['file_name'])) {
                $f = $data['file_name'] . '.pdf';
            }

            $this->WriteHTML($data['html']);

            $this->Output(FILE_PATH . $f, 'F');
            exit();
        }
    }

// End func build_pdf

    /**
     * Build pdf file base on html tags.
     * 
     * @access public
     * @param array $data an array data of header, footer, html tags embeded in a string
     * @return void
     */
    public function output_pdf(array $data) {

        if (!empty($data)) {

            $f = 'test.pdf';

            if (isset($data['file_name'])) {
                $f = $data['file_name'] . '.pdf';
            }

            $this->WriteHTML($data['html']);

            $this->Output();
            exit();
        }
    }

// End func build_pdf
}

// End class Pdf_lib_ext
