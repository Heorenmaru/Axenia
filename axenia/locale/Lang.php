<?php

class Lang
{
    private static $availableLangs;
    private static $messageArray;   //массив сообщений из messages.php
    private static $currentLang;

    public static function availableLangs()
    {
        if (!isset(self::$availableLangs)) {
            self::$availableLangs = ["en" => '🇬🇧 English', "ru" => '🇷🇺 Русский', "ruUN" => '🔞 Русский (матерный)'];
        }

        return self::$availableLangs;
    }

    public static function defaultLangKey()
    {
        return "ru";
    }

    public static function getCurrentLangDesc()
    {
        return self::$availableLangs[isset(self::$currentLang) ? self::$currentLang : self::defaultLangKey()];
    }

    /**
     * Обязательно должен вызваться
     * @param string $lang 'ru' or 'en' or etc.
     */
    public static function init($lang = "ru")
    {
        self::availableLangs();
        self::loadMessages();
        self::$currentLang = $lang;
    }

    public static function isUncensored()
    {
        return self::$currentLang == 'ruUN';
    }

    public static function message($modificator, $param = NULL)
    {
        self::loadMessages();

        $out = self::$messageArray[$modificator][isset(self::$currentLang) ? self::$currentLang : self::defaultLangKey()];

        return $param != NULL ? Util::insert($out, $param) : $out;
    }

    public static function messageRu($modificator, $param = NULL)
    {
        self::loadMessages();

        $out = self::$messageArray[$modificator]["ru"];

        return $param != NULL ? Util::insert($out, $param) : $out;
    }

    public static function loadMessages()
    {
        if (!isset(self::$messageArray)) {
            self::$messageArray = include 'messages.php';
            //self::$messageArray = parse_ini_file("messages.ini", true);
        }
    }

}