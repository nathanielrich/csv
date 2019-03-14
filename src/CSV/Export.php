<?php

namespace NRich\CSV;


use NRich\CSV\Exception\CSVException;
use NRich\CSV\Exception\DataException;

/**
 * Class Export
 * @package NRich\CSV
 */
class Export extends CSVAbstract {

    /**
     * @var array
     */
    private $_data = [];

    /**
     * @var array
     */
    private $_headers = [];

    /**
     * @param $data
     * @param array|null $headers
     * @return $this Export
     * @throws DataException
     */
    public function build($data, array $headers = null)
    {
        if(is_object($data))
            $data = (array) $data;

        if(!is_array($data))
            throw new DataException("no data to build an csv file");

        if(!$headers) {
            $this->_buildHeaders($data);
        } else {
            $this->setHeaders($headers);
        }

        $this->_data = $data;

        return $this;
    }

    /**
     * Set´s the delimiter to semicolon instead of csv standard comma.
     * @return $this
     */
    public function windows()
    {
        $this->_delimiter = ';';

        return $this;
    }

    /**
     * @param array $headers
     * @return $this Export
     */
    public function setHeaders(array $headers)
    {
        $this->_headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->_buildCSV();
    }

    /**
     * @param $path
     * @return mixed
     * @throws CSVException
     */
    public function save($path)
    {
        if(!file_exists($path))
            if(!mkdir($path, 0700, true))
                throw new CSVException('Dir "'.$path.'" not exists. Mkdir() is failed!');

        $handle = fopen($path, 'w+');

        if(!fwrite($handle, $this->_buildCSV()))
            throw new CSVException('Can\'t write data at file "'.$path.'"');

        fclose($handle);

        return $path;
    }

    /**
     * @param null $filename
     * @param string $contentType
     * @param null $charset
     */
    public function download($filename = null, $contentType = null, $charset = null)
    {
        if(!$filename)
            $filename = 'export_' . date('YmdHis') . '.csv';

        header('Content-Disposition: attachment;filename="'.$filename.'";');
        header('Content-Type: '.($contentType ? $contentType : $this->_contentType ).'; charset=' . ($charset ? $charset : $this->_charset ));
        header('Pragma: no-cache');
        header('Expires: 0');

        echo $this->_buildCSV();
        exit;
    }

    /**
     * @param $path
     * @param null $filename
     * @return Symfony\Component\HttpFoundation\File\UploadedFile
     * @throws CSVException
     */
    public function getSymfonyUploadedFile($path, $filename = null)
    {
        if(!class_exists("Symfony\\Component\\HttpFoundation\\File\\UploadedFile"))
            throw new CSVException("Class Symfony\\Component\\HttpFoundation\\File\\UploadedFile not found!");

        if($filename) {


            if(substr($path, 0, strlen($filename) * -1) == $filename)
                $path = substr($path, 0, strlen($filename) * -1);

        } else {

            $pathParts = explode(DIRECTORY_SEPARATOR, $path);

            $filename = array_pop($pathParts);

            $path = implode(DIRECTORY_SEPARATOR, $path);

        }

        return new Symfony\Component\HttpFoundation\File\UploadedFile($path, $filename, $this->_contentType);
    }


    /**
     * @return string
     */
    private function _buildCSV()
    {
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, $this->_headers, $this->_delimiter, $this->_enclosure, $this->_escape_char);

        foreach ($this->_data as $row) {

            if(!is_array($row))
                $row = (array) $row;

            fputcsv($handle, $row, $this->_delimiter, $this->_enclosure, $this->_escape_char);

        }

        rewind($handle);

        $data = fread($handle, ftell($handle) + 1);

        fclose($handle);

        return rtrim($data, "\n");
    }

    /**
     * @param array $data
     */
    private function _buildHeaders(array $data)
    {
        if(!count($data))
            return;

        $row = (array) $data[0];

        $this->setHeaders(array_keys($row));
    }

}

