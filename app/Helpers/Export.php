<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Http\Response;
use App\Helpers\MimeTypes;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Export
{

    const EXTENTIONS = [
        'xlsx' => 'Xlsx',
        'xls' => 'Xls',
        'csv' => 'Csv',
    ];

    public $type;
    public $ext;

    public $spreadsheet;
    public $sheet;
    public $i = 1;

    public function __construct($ext)
    {
        $this->ext = $ext;
        $this->type = $this::EXTENTIONS[$ext];
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    public function fromArrays($array)
    {
        foreach ($array as $data) {
            $this->sheet->fromArray($data, null, 'A' . $this->i);
            $this->i++;
        }
        return $this;
    }

    public function fromArray($data)
    {
        $this->sheet->fromArray($data, null, 'A' . $this->i);
        $this->i++;
        return $this;
    }

    public function save($name)
    {
        $writer = IOFactory::createWriter($this->spreadsheet, $this->type);
        return $writer->save($name);
    }

    public function download($name)
    {
        $streamedResponse = new StreamedResponse();
        $streamedResponse->setCallback(function () {
            $writer = IOFactory::createWriter($this->spreadsheet, $this->type);
            $writer->save('php://output');
        });
        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set('Content-Type', MimeTypes::getMimeType($this->ext));
        $streamedResponse->headers->set('Content-Disposition', 'attachment; filename="' . $name . '"');
        return $streamedResponse->send();
    }
}
