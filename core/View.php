<?php

namespace core;

use \core\Utility as U;

/**
 * @see http://chadminick.com/articles/simple-php-template-engine.html#sthash.Qk9ONavy.dpuf
 */
class View
{

    private $vars = array();
    private $errors = null;
    protected $model = null;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function &__get($name)
    {
        $attrs = null;
        if (isset($this->vars[$name])) {
            $attrs = &$this->vars[$name];
        }

        return $attrs;
    }

    public function __set($name, $value)
    {
        if ($name == 'templateFile') {
            throw new Exception("Cannot bind variable named 'templateFile'");
        }
        $this->vars[$name] = $value;
    }

    public function addError($error)
    {
        if ($this->errors === null) {
            $this->errors = array();
        }
        $this->errors[] = $error;
    }

    public function render($templateFile)
    {

        if (array_key_exists('templateFile', $this->vars)) {
            throw new Exception("Cannot bind variable called 'templateFile'");
        }

        if (is_object($this->model)) {
            extract(get_object_vars($this->model));
        }

        extract($this->vars);
        $errors = $this->errors;

        ob_start();
        if (file_exists(U::$TEMPLATES . $templateFile . '.php')) {
            include(U::$TEMPLATES . $templateFile . '.php');
        }
        echo ob_get_clean();
    }

}
