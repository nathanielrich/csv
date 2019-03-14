<?php

namespace NRich\CSV;


abstract class CSVAbstract {

    /**
     * @var string
     */
    protected $_delimiter = ',';

    /**
     * @var string
     */
    protected $_enclosure = '"';

    /**
     * @var string
     */
    protected $_escape_char = "\\";

    /**
     * @var string
     */
    protected $_charset = 'UTF-8';

    /**
     * @var null|string
     */
    protected $_contentType = 'text/csv';

    /**
     * Export constructor.
     * @param null $delimiter
     * @param null $enclosure
     * @param null $escapeChar
     * @param null $charset
     * @param string $contentType
     */
    public function __construct($delimiter = null, $enclosure = null, $escapeChar = null, $charset = null, $contentType = null)
    {
        if($delimiter)
            $this->_delimiter = $delimiter;

        if($enclosure)
            $this->_enclosure = $enclosure;

        if($escapeChar)
            $this->_escape_char = $escapeChar;

        if($charset)
            $this->_charset = $charset;

        if($contentType)
            $this->_contentType = $contentType;
    }

}