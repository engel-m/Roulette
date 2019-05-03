<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/24/18
 * Time: 18:17
 */

namespace System;


class Session
{
    protected $data;


    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->loadSessionData();
    }

    public function end()
    {
        session_destroy();
    }

    public function get(string $key)
    {
        if (array_key_exists($key, $this->data) === false) {
            return null;
        }

        return $this->data[$key];
    }

    public function set($key, $data): void
    {
        $this->data[$key] = $data;

        $this->storeSessionData();
    }

    public function reset(): void
    {
        session_destroy();
        session_start();

        $this->loadSessionData();
    }

    private function loadSessionData(): void
    {
        $this->data = [];

        foreach ($_SESSION as $key => $value) {
            $this->data[$key] = @unserialize($value) ?? null;
        }
    }

    private function storeSessionData(): void
    {
        session_unset();

        foreach ($this->data as $key => $value) {
            $_SESSION[$key] = serialize($value);
        }
    }
}