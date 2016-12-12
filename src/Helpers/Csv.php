<?php

namespace SeniorProgramming\FanCourier\Helpers;

use SeniorProgramming\Fancourier\Exceptions\FanCourierInstanceException;
use CURLFile;

class Csv {
    protected $fh   =   NULL;
    protected $lineLength   =   NULL;
    protected $lineSeparator    =   "\n";
    protected $columnSeparator    =   ",";
    protected $headers  =   [];

    public function __construct($lineSeparator = "\t", $columnSeparator = ",")
    {
        $this->setLineSeparator($lineSeparator);
        $this->setColumnSeparator($columnSeparator);
    }

    public function setLineSeparator($lineSeparator)
    {
        $this->lineSeparator = $lineSeparator;
    }

    public function setColumnSeparator($columnSeparator)
    {
        $this->columnSeparator = $columnSeparator;
    }

    public function getLineSeparator()
    {
        return $this->lineSeparator;
    }

    public function getColumnSeparator()
    {
        return $this->columnSeparator;
    }

    public function getLineLength()
    {
        return $this->lineLength;
    }

    public function setString($string)
    {
        $this->fh   =   fopen('data://text/plain;base64,' . base64_encode($string), 'r');
    }

    function __destruct()
    {
        fclose($this->fh);
    }

    public function generateRows()
    {
        $this->reset();
        $headers    =   $this->getHeaders();
        $data   =   [];
        while($line =   $this->getCurrentLine()) {
            $object =   array_combine($headers, $line);
            $data[] = ((object)$object);
        }
        return $data;    
    }

    protected function getCurrentLine()
    {
        return fgetcsv($this->fh, $this->getLineLength(), $this->getColumnSeparator());
    }

    public function setHeaders($headers)
    {
        array_walk($headers, function (&$val){
            $val =  strtolower(str_replace(' ', '_', $val));
        });
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        if(!$this->headers)
        {
            $this->setHeaders($this->getCurrentLine());
        }

        return $this->headers;
    }

    public function reset()
    {
        $this->headers  =   NULL;
        rewind($this->fh);
    }

    public static function stringToObjects($datastring, $separators = ["\n", ","])
    {
        $csv = (new Csv($separators[0], $separators[1]));
        $csv->setString($datastring);
        return $csv->generateRows();
    }
    
    public static function convertToCSV($data, $header) {
        $return_data = [];
        foreach ($data as $key => $value) {
            
            $filename = tempnam("/tmp", "FanCourier".  time(). ".csv");
            $csv = fopen($filename, 'w');
            try {
                reset($value);
                $columns = array_keys(current($value));
                
                foreach ($columns as &$val) {
                    $val = $header[$val];
                }

                fputcsv($csv, $columns);
                
                foreach ($value as $row) {
                    fputcsv($csv, $row);
                }
                
            } catch (\Exception $exc) {
                throw new FanCourierInstanceException($exc->getTraceAsString());
            } finally {
                fclose($csv);
            }
            $return_data[$key] = new CURLFile($filename, 'text/csv');
        }
        return $return_data;
    }
}