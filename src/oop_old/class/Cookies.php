<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/2/21
 * Time: 9:53 PM
 */

class Cookies
{
    protected $cookie = [];

    public function __construct()
    {
        $this->cookie = $_COOKIE;
    }

    public function all(array $only = [])
    {
        if (!empty($only)) {
            $arrValue = [];
            foreach ($only as $key) {
                if (isset($this->cookie[$key])) {
                    $arrValue[$key] = $this->cookie[$key];
                }

            }
            return $arrValue;
        }

        return $this->cookie;

    }

    public function get($key, $default = null)
    {
        $arrCookies = [];
        foreach ($key as $item) {
            if (isset($this->cookie[$item])) {
                $arrCookies[$item] = $this->cookie[$item];
            }
        }
        return (!empty($arrCookies)) ? $arrCookies : $default;
    }

    public function set($key, $value)
    {
        if (!empty($key) && !empty($value)) {
            setcookie($key, $value, time() + (86400 * 30), "/"); // set cookie for one day
            return true;
        } else {
            return false;
        }
    }

    public function remove($key)
    {
        if (isset($this->cookie[$key])) {
            unset($this->cookie[$key]);
            setcookie($key, null, -1, '/');
            return true;
        } else {
            return false;
        }
    }
}