<?php

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class GlobalObject
{
    private static $inst = null;

    private function __construct() { }

    /**
     * @return GlobalObject
     */
    public static function getInstance()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    public function __toString()
    {
        $output = "";
        $output .= $this->generateGlobalInheritance();
        $output .= $this->generateGlobalValidations();

        return $output;
    }

    private function generateGlobalInheritance()
    {
        $inheritance = "";

        $inheritance .= "Object.prototype.inherits = function(parent) {\n\t";
        $inheritance .= "this.prototype = Object.create(parent.prototype);\n\t";
        $inheritance .= "this.prototype.constructor = this;\n}\n\n";

        return $inheritance;
    }

    private function generateGlobalValidations()
    {
        $validation = "";

        $validation .= "Object.prototype.isNullOrEmpty = function(field) {\n\t";
        $validation .= "if (!field || field == null || field == '') {\n\t\t";
        $validation .= "return true;\n\t";
        $validation .= "}\n\t";
        $validation .= "return false;\n}\n\n";

        $validation .= "Object.prototype.isNumber = function(field) {\n\t";
        $validation .= "if (field ^ 0 == field) {\n\t\t";
        $validation .= "return true;\n\t";
        $validation .= "}\n\t";
        $validation .= "return false;\n}\n\n";

        return $validation;
    }
}