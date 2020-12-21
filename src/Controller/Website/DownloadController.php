<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadController extends AbstractController
{

    /**
     * @Route("/downloads/excel", name="download")
     */
    public function downloadExcel(){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("All Months");

        for($x=1; $x<13; $x++){
            $d = strtotime("+" . $x . " Months");
            $sheet->getCell('A'.$x)->setValue(date("F", $d));
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "months.xlsx";

        $temp_file= tempnam(sys_get_temp_dir(), $filename);

        $writer->save($temp_file);

        return $this->file($temp_file, $filename, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
