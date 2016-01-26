<?php

namespace core;

class Utility
{

    public static $ROOT = '';
    public static $CORE = '';
    public static $APP = '';
    public static $TEMPLATES = '';
    private static $PATH = '';
    private static $HOME = '';

    public static function init()
    {
        self::$ROOT = preg_replace('#/core$#', '/', __DIR__);
        self::$CORE = self::$ROOT . 'core/';
        self::$APP = self::$ROOT . 'app/';
        self::$TEMPLATES = self::$APP . 'templates/';
        self::$PATH = trim(shell_exec('echo $PATH'));

        spl_autoload_register(array(self, 'autoload'));
    }

    private static function autoload($name)
    {
        $path = self::$ROOT . str_replace('\\', '/', $name) . '.php';
        if (file_exists($path)) {
            include_once $path;
            return true;
        }

        throw new \Exception("Class `$name` not found.");
    }

    public static function ternary(&$value, $alternative)
    {
        if (isset($value) && !empty($value)) {
            return $value;
        } else {
            return $alternative;
        }
    }

    public static function path()
    {
        $route = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        foreach (func_get_args() as $arg) {
            if ($arg !== '') {
                $route .= '/' . $arg;
            }
        }
        return $route;
    }

    public static function dump($obj)
    {
        echo '<pre style="display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;color: #333;word-break: break-all;word-wrap: break-word;background-color: #f5f5f5;border: 1px solid #ccc;border-radius: 4px;">';
        var_dump($obj);
        echo '</pre>';
    }

    public static function addPath($s)
    {
        self::$PATH .= ':' . $s;
    }

    public static function setHome($s)
    {
        self::$HOME = $s;
    }

    public static function exec($command, &$returnCode = 0)
    {
        $output = array();
        exec('HOME=' . self::$HOME . ' && PATH=' . self::$PATH . ' && ' . $command . ' 2>&1', $output, $returnCode);
        return $output;
    }

    public static function execs($command, &$returnCode = 0)
    {
        $output = self::exec($command, $returnCode);
        return trim(implode("\n", $output));
    }

}
