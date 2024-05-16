<?php

class Session
{
    public static function setSessionData($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getSessionData($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;

    }

    public static function destroySession()
    {
        // Очистить все сессионные переменные
        session_unset();

        // Уничтожение сессии
        session_destroy();
    }
}