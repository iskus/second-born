<?php
namespace core\sources;
class UsefulData
{
    public static $alphabets = [
        'ru' => [
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т',
            'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ],
        'en' => [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y', 'Z'
        ],
    ];

    public static function getRequest($key = false, $method = 'REQUEST', $type = false)
    {
        if (!$key) return $key;
        $method = strtoupper('_' . $method);
        switch ($method) {
            case '_POST':
                $value = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : false;
                break;
            case '_GET':
                $value = isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : false;
                break;
            case '_SESSION':
                $value = isset($_SESSION[$key]) ? htmlspecialchars($_SESSION[$key]) : false;
                break;
            case '_SERVER':
                $value = isset($_SERVER[$key]) ? htmlspecialchars($_SERVER[$key]) : false;
                break;

            case '_REQUEST':
            default:
                $value = isset($_REQUEST[$key]) ? htmlspecialchars($_REQUEST[$key]) : false;
                break;

        }
        if ($type) {
            $type = 'is_' . $type;
            return $type($value) ? htmlspecialchars($value) : false;
        }
        return $value;
        //TODO
    }

    public static function occurrence($ip = '', $to = 'utf-8')
    {
        $ip = ($ip) ? $ip : $_SERVER['REMOTE_ADDR'];
        $xml = simplexml_load_file('http://ipgeobase.ru:7020/geo?ip=' . $ip);
        if ($xml->ip->message) {
            if ($to == 'utf-8') {
                return $xml->ip->message;
            } else {
                if (function_exists('iconv')) {
                    return iconv("UTF-8", $to . "//IGNORE", $xml->ip->message);
                } else {
                    return "The library iconv is not supported by your server";
                }
            }
        } else {
            if ($to == 'utf-8') {
                return $xml->ip->region;
            } else {
                if (function_exists('iconv')) {
                    return iconv("UTF-8", $to . "//IGNORE", $xml->ip->region);
                } else {
                    return "The library iconv is not supported by your server";
                }
            }
        }
    }
}