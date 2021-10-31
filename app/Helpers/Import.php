<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Import
{

    protected $path;
    protected $file_type;
    protected $reader;
    protected $worksheet_info;
    protected $spreadsheet;
    protected $sheet;
    protected $ival = 1;
    protected $headers;
    protected $row;
    protected $values;
    protected $error = false;
    protected $is_failed = false;
    protected $fail_message;
    protected $return = [];
    protected $returnFile;

    const STATUS_OK = 200;
    const STATUS_ERROR = 400;
    const STATUS_BREAK = 401;


    public function __construct($path)
    {
        $this->init($path);
    }

    public function init($path)
    {
        $this->path = $path;
        $this->identifyFile()
            ->createReader()
            ->loadSheetInfo()
            ->loadFile()
            ->getActiveSheet();
    }

    public function identifyFile()
    {
        $this->file_type = IOFactory::identify($this->path);
        return $this;
    }

    public function createReader()
    {
        $this->reader = IOFactory::createReader($this->file_type);
        return $this;
    }

    public function loadSheetInfo()
    {
        $this->worksheet_info = $this->reader->listWorksheetInfo($this->path);
        return $this;
    }

    public function loadFile()
    {
        $this->spreadsheet = $this->reader->load($this->path);
        return $this;
    }

    public function getActiveSheet()
    {
        $this->sheet = $this->spreadsheet->getActiveSheet();
        return $this;
    }

    public function isFailed()
    {
        return $this->is_failed;
    }

    public function hasError()
    {
        return $this->error;
    }

    public function getMessage()
    {
        return $this->fail_message;
    }

    public static function readFile($path, $callback)
    {
        $o = new self($path);
        $o->readData($callback);
        return $o;
    }

    public function readData($callback = null)
    {
        while ($this->ival <= $this->worksheet_info[0]['totalRows']) {
            $getData = [];
            $this->values = [];
            for ($i = 0; $i <= $this->worksheet_info[0]['totalColumns'] - 1; $i++) {
                $getData[$i] = $this->sheet
                    ->getCellByColumnAndRow($i + 1, $this->ival)
                    ->getValue();
            }
            foreach ($getData as $tkey => $val) {
                if (
                    $this->ival == 1
                    && (trim($val) != '' || (isset($getData[$tkey + 1]) && trim($getData[$tkey + 1]) != ''))
                ) {
                    $val = trim($val);
                    $this->headers[] = $val;
                } else if ($tkey < sizeof($this->headers)) {
                    $this->values[] = $val;
                }
            }

            if ($this->ival != 1) {
                if (empty(array_filter($this->values))) {
                    $this->ival++;
                    continue;
                }
                $this->row = array_combine($this->headers, $this->values);
                if (is_callable($callback)) {
                    list($error, $data) = $callback($this->row);
                    if ($error == self::STATUS_BREAK) {
                        $this->is_failed = true;
                        $this->fail_message = $data;
                        break;
                    } else if ($error == self::STATUS_ERROR) {
                        $this->error = true;
                        $this->return[] = $data;
                    }
                }
            }
            $this->ival++;
        }
    }

    public function createReturnFile($type)
    {
        $this->returnFile = new Export($type);
        $this->returnFile->fromArray(array_merge($this->headers, ['error']));
        if (sizeof($this->return) > 0) {
            $this->returnFile->fromArrays($this->return);
        }
        return $this;
    }

    public function save($name)
    {
        return $this->returnFile->save($name);
    }

    public function download($name)
    {
        return $this->returnFile->download($name);
    }
}
