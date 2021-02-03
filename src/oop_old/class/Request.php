<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/1/21
 * Time: 2:58 PM
 */

namespace src\oop;


class Request
{
    protected $get = [];
    protected $post = [];
    protected $server = [];

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
    }

    public function query($key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

    public function post($key, $default = null)
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
    }

    public function get($key, $default = null)
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        } elseif (isset($this->get[$key])) {
            return $this->get[$key];
        } else {
            return $default;
        }
    }

    public function all(array $only = [])
    {
        return array_merge($this->get, $this->post);
    }

    public function has($key)
    {
        return (isset($this->post[$key]) || isset($this->get[$key])) ? true : false;
    }

    public function ip()
    {
        if (!empty($this->server['HTTP_CLIENT_IP'])) {
            $ip = $this->server['HTTP_CLIENT_IP'];
        } elseif (!empty($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $this->server['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $this->server['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function userAgent()
    {
        return $this->server['HTTP_USER_AGENT'];
    }

    // returns Cookie object

    // returns Session object

}
