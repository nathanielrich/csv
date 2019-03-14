<?php

namespace NRich\CSV;


use NRich\CSV\Exception\CSVException;

/**
 * Class Export
 * @package NRich\CSV
 */
class Import extends CSVAbstract {

    /**
     * @param $path
     * @param bool $asArray
     * @return array
     * @throws CSVException
     */
    public function execute($path, $asArray = false)
    {
        if(!file_exists($path))
            throw new CSVException('file "'.$path.'" not found!');

        if( ($handle = fopen($path, 'r')) == false )
            throw new CSVException('can\'t read file "'.$path.'".');

        $result = [];

        while (($data = fgetcsv($handle, 1000, $this->_delimiter, $this->_enclosure, $this->_escape_char)) !== FALSE) {

            if(!$asArray)
                $data = (object) $data;

            $result[] = $data;

        }

        fclose($handle);

        return $result;

    }

}