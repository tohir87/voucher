<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * ZendSoft Solutions
 * Excel library
 * 
 * @category   Library
 * @package    Payroll
 * @subpackage CSV
 * @author     Omoloye Tohir <otcleantech@gmail.com>
 * @copyright  Copyright © 2015 Zend Solutions Nigeria Ltd.
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */
class Csv_lib {

    /**
     * Codeigniter instance
     * 
     * @access private
     * @var object
     */
    private $CI;
    private $col_letters = array(
        0 => 'A',
        1 => 'B',
        2 => 'C',
        3 => 'D',
        4 => 'E',
        5 => 'F',
        6 => 'G',
        7 => 'H',
        8 => 'I',
        9 => 'J',
        10 => 'K',
        11 => 'L',
        12 => 'M',
        13 => 'N',
        14 => 'O',
        15 => 'P',
        16 => 'Q',
        17 => 'R',
        18 => 'S',
        19 => 'T',
        20 => 'U',
        21 => 'V',
        22 => 'W',
        23 => 'X',
        24 => 'Y',
        25 => 'Z',
        26 => 'AA',
        27 => 'AB',
        28 => 'AC',
        29 => 'AD',
        30 => 'AE',
        31 => 'AF',
        32 => 'AG',
        33 => 'AH',
        34 => 'AI',
        35 => 'AJ',
        36 => 'AK',
        37 => 'AL',
        38 => 'AM',
        39 => 'AN',
        40 => 'AO',
        41 => 'AP',
        42 => 'AQ',
        43 => 'AR',
        44 => 'AS',
        45 => 'AT',
        46 => 'AU',
        47 => 'AV',
        48 => 'AW',
        49 => 'AX',
        50 => 'AY',
        51 => 'AZ',
        52 => 'BA',
        53 => 'BB',
        54 => 'BC',
        55 => 'BD',
        56 => 'BE',
    );

    /**
     * Class constructor
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        // Load CI object
        $this->CI = get_instance();
    }

    public function product_report($intro, $header, $report_detail_data, $name) {

        //Create new PHPExcel object";
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Compare The Market");
        $objPHPExcel->getProperties()->setLastModifiedBy("CTM");
        $objPHPExcel->getProperties()->setTitle("Product Price Report");
        $objPHPExcel->getProperties()->setSubject("Product Price Report");
//        $objPHPExcel->getProperties()->setDescription("List of employee payroll details");
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Intro');
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('F4:F14')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4:G14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

        $rowCount = 4;
        foreach ($intro as $data) {
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $data[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $data[1]);
            $rowCount++;
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Prices');
        $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);

        // Set header
        $objPHPExcel->getActiveSheet()->mergeCells('D1:F1');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'WHOLESALE');
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('G1:I1');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'RETAIL');
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', $header[0]);
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', $header[1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', $header[2]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', $header[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', $header[4]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', $header[5]);
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', $header[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('H2', $header[4]);
        $objPHPExcel->getActiveSheet()->SetCellValue('I2', $header[5]);
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', $header[6]);

        $rowCount = 3;

        foreach ($report_detail_data as $dat) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $dat[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $dat[1]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $dat[2]);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $dat[5]);
            if (!empty($dat[3])) {
                $wcount = $rowCount;
                foreach ($dat[3] as $wholesale) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $wcount, $wholesale->metric);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $wcount, $wholesale->price_high);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $wcount, $wholesale->price_low);
                    $wcount++;
                }
            }
            if (!empty($dat[4])) {
                $rcount = $rowCount;
                foreach ($dat[4] as $retail) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rcount, $retail->metric);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rcount, $retail->price_high);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rcount, $retail->price_low);
                    $rcount++;
                }
            }

            
            $rowCount = 1 + ($wcount > $rcount) ? $wcount : $rcount;
        }

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '".xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}

/* End of file csv_helper.php */
/* Location: ./applicaton/library/csv_helper.php */