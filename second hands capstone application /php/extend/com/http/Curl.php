<?php
namespace com\http;
/**
 * Curl 封装
 */
class Curl {

    /**
     * 
     * @param type $method 请求方式
     * @param type $url 地址
     * @param type $fields 附带参数，可以是数组，也可以是字符串
     * @param type $userAgent 浏览器UA
     * @param type $httpHeaders header头部，数组形式
     * @param type $username 用户名
     * @param type $password 密码
     * @return boolean
     */
    public  function execute($method, $url, $fields = '', $httpHeaders = '') {
        $ch = $this->create();
        if (false === $ch) {
            return false;
        }
        if (is_string($url) && strlen($url)) {
            $ret = curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            return false;
        }
        //是否显示头部信息

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        
        $method = strtolower($method);
        if ('post' == $method) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            if (is_array($fields)) {
                $sets = array();
                foreach ($fields AS $key => $val) {
                    $sets[] = $key . '=' . urlencode($val);
                }
                $fields = implode('&', $sets);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        } else if ('put' == $method) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        } else if ('delete' == $method) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }else if ('get' == $method) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        if (is_array($httpHeaders)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
        }
        $ret = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return array(curl_error($ch), curl_errno($ch));
        } else {
            curl_close($ch);
            if (!is_string($ret) || !strlen($ret)) {
                return false;
            }
            return $ret;
        }
    }



    /**
     * 发送POST请求
     * @param type $url 地址
     * @param type $fields 附带参数，可以是数组，也可以是字符串
     * @param type $userAgent 浏览器UA
     * @param type $httpHeaders header头部，数组形式
     * @param type $username 用户名
     * @param type $password 密码
     * @return boolean
     */
    public function post($url, $fields, $httpHeaders = '') {
        $ret = $this->execute('POST', $url, $fields, $httpHeaders);
        if (false === $ret) {
            return false;
        }
        if (is_array($ret)) {
            return false;
        }
        return $ret;
    }

    public function put($url, $fields, $httpHeaders = '') {
        $ret = $this->execute('PUT', $url, $fields, $httpHeaders);
        if (false === $ret) {
            return false;
        }
        if (is_array($ret)) {
            return false;
        }
        return $ret;
    }

    /**
     * GET
     * @param type $url 地址
     * @param type $userAgent 浏览器UA
     * @param type $httpHeaders header头部，数组形式
     * @param type $username 用户名
     * @param type $password 密码
     * @return boolean
     */
    public function get($url, $httpHeaders = '') {
        $ret = $this->execute('GET', $url, "", $httpHeaders);
        if (false === $ret) {
            return false;
        }
        if (is_array($ret)) {
            return false;
        }
        return $ret;
    }

    public function delete($url, $httpHeaders = '') {
        $ret = $this->execute('DELETE', $url, "", $httpHeaders);
        if (false === $ret) {
            return false;
        }
        if (is_array($ret)) {
            return false;
        }
        return $ret;
    }

    /**
     * curl支持 检测
     * @return boolean
     */
    public function create() {
        $ch = null;
        if (!function_exists('curl_init')) {
            return false;
        }
        $ch = curl_init();
        if (!is_resource($ch)) {
            return false;
        }
        return $ch;
    }

}

?>
