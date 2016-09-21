<?php

class Common
{
    public function __construct()
    {

    }

    public function curl_get($url,$timeout=15,array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_NOBODY=>false,
            //CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0',
            //CURLOPT_FOLLOWLOCATION=>1,
            CURLOPT_TIMEOUT => $timeout
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 失败返回false
     */
    public function curl_post($url, $timeout=10,array $post = array(), array $options = array())
    {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * utf编码转gbk
     * @param $str
     * @return mixed
     */
    public function utftogbk($str) {
        $string = charset_encode("utf-8", "gb2312", $str);
        return $string;
    }

    public function gbktoutf($string) {
        $string = charset_encode("gb2312", "utf-8", $string);
        return $string;
    }

    public function charset_encode($_input_charset, $_output_charset, $input) {
        $output = "";
        $string = $input;
        if (is_array($input)) {
            $key = array_keys($string);
            $size = sizeof($key);
            for ($i = 0; $i < $size; $i ++) {
                $string [$key [$i]] = charset_encode($_input_charset, $_output_charset, $string [$key [$i]]);
            }
            return $string;
        } else {
            if (!isset($_output_charset))
                $_output_charset = $_input_charset;
            if ($_input_charset == $_output_charset || $input == null) {
                $output = $input;
            } elseif (function_exists("mb_convert_encoding")) {
                $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
            } elseif (function_exists("iconv")) {
                $output = iconv($_input_charset, $_output_charset, $input);
            } else
                die("sorry, you have no libs support for charset change.");
            return $output;
        }
    }


}