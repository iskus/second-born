<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 12.06.15
 * Time: 17:47
 */
namespace libs;
require_once("phpQuery/phpQuery/phpQuery.php");

class ParserYopta
{
    public $url;
    public $page;
    public $pq;

    public function __construct($url = false)
    {
        if ($url) $this->setPage($url);
    }

    public function setPage($url = false)
    {
        if (!$url) return false;
        $this->url = $url;
        $this->page = $this->getPage();
        $this->pq = \phpQuery::newDocumentHTML($this->page);
    }

    public function curlExecUTF8($ch)
    {
        $data = curl_exec($ch);
        if (!is_string($data)) return $data;
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if (!isset($charset)) {
            preg_match('@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s*charset=([^\s"]+))?@i', $data, $matches);
            if (isset($matches[3]))
                $charset = $matches[3];
        }
        if (!isset($charset)) {
            $encoding = mb_detect_encoding($data);
            if ($encoding)
                $charset = $encoding;
        }
        if (!isset($charset)) {
            if (strstr($content_type, "text/html") === 0)
                $charset = "ISO 8859-1";
        }
        if (isset($charset) && strtoupper($charset) != "UTF-8") {
            $data = iconv($charset, 'UTF-8', $data);
            $data = str_replace($charset, 'UTF-8', $data);
        }
        return $data;
    }

    protected function getPage()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = $this->curlExecUTF8($ch);
        curl_close($ch);
        return $page;
    }
}