<?php

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Object
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $isAbstract;

    /**
     * @var string?
     */
    private $base;

    /**
     * Collection of properties
     *
     * @var Property[]
     */
    private $properties;

    public function __construct($name, $isAbstract, $base = null)
    {
        $this->name = $name;
        $this->isAbstract = $isAbstract;
        $this->base = $base;
    }

    /**
     * @return string?
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Property $property
     * @return void
     */
    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }

    public function __toString()
    {
        return $this->generateAutomaticInvokedFunction();
    }

    private function generateAutomaticInvokedFunction()
    {
        $avf = "";
        $avf .= "var " . ucfirst($this->getName()) . " = (function () { \n\t";
        $avf .= $this->generateConstructor();
        $avf .= $this->generateInheritance();

        foreach ($this->getProperties() as $property) {
            $avf .= ucfirst($this->getName()) . '.prototype.' . $property->generateSetter();
            $avf .= "\n\n\t";
            $avf .= ucfirst($this->getName()) . '.prototype.' . $property->generateGetter();
            $avf .= "\n\n\t";
        }

        $avf .= $this->generateToString();

        $avf .= "\n\n\treturn " . ucfirst($this->getName()) . ";";

        $avf .= "\n})();";

        return $avf;
    }

    private function generateConstructor()
    {
        $constructor = "";
        $constructor .= "function " . ucfirst($this->getName());
        $constructor .= "(";


        foreach ($this->getProperties() as $property) {
            $constructor .= $property->getName() . ",";
        }

        $constructor = rtrim($constructor, ",");

        $constructor .= ") { \n\t\t";

        if ($this->isAbstract()) {
            $constructor .= "if (this.constructor === " . ucfirst($this->getName()) . ") {\n\t\t\t";
            $constructor .= "throw new Error('Cannot instantiate abstract class');\n\t\t";
            $constructor .= "}\n\n\t\t";
        } else if ($this->getBase() && strlen($this->getBase()) > 0) {
            $constructor .= ucfirst($this->getBase()) . ".call(this,";

            foreach ($this->getProperties() as $property) {
                $constructor .= $property->getName() . ",";
            }

            $constructor = rtrim($constructor, ",");
            $constructor .= ");\n\t\t";
        }

        foreach ($this->getProperties() as $property) {
            $constructor .= "this.set" . ucfirst($property->getName()) . "(" . $property->getName() . ");\n\t\t";
        }

        $constructor = rtrim($constructor, "\t");

        $constructor .= "\t}\n\n";

        return $constructor;
    }

    private function generateToString()
    {
        $toString = "";
        $toString .= ucfirst($this->getName()) . ".prototype.toString = function() { \n\t\t";
        $toString .= "return ";

        foreach ($this->getProperties() as $property) {
            $toString .= "'" . ucfirst($property->getName()) . ": ' + this.get" . ucfirst($property->getName()) . "() + ";
        }

        $toString = rtrim($toString, "+ ");
        $toString .= ";\n\t};";

        return $toString;
    }

    private function generateInheritance()
    {
        $inheritance = "";

        if ($this->getBase() && strlen($this->getBase()) > 0) {
            $inheritance .= "\t";
            $inheritance .= ucfirst($this->getName()) . ".inherits(" . ucfirst($this->getBase()) . ");\n\n";
        }

        $inheritance .= "\t";

        return $inheritance;
    }
}