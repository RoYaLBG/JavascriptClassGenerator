<?php

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Property
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $range = [];

    public function __construct($name, $type, $range = [])
    {
        if (!in_array($type,
            [
                Types::TYPE_BOOLEAN,
                Types::TYPE_NUMBER,
                Types::TYPE_STRING
            ]
        )) throw new \Exception('Illegal type');

        $this->name = $name;
        $this->type = $type;
        $this->range = $range;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    public function __toString()
    {
        $output = $this->generateGetter();
        $output .= "\n\n";
        $output .= $this->generateSetter();
        $output .= "\n\n";

        return $output;
    }

    /**
     * @return string
     */
    public function generateGetter()
    {
        $getter = "";
        $getter .= "get" . ucfirst($this->getName());
        $getter .= " = function() {\n\t\t";
        $getter .= "return this._" . $this->getName() . ";";
        $getter .= "\n\t}";

        return $getter;
    }

    /**
     * @return string
     */
    public function generateSetter()
    {
        $setter = "";
        $setter .= "set" . ucfirst($this->getName());
        $setter .= " = function(" . $this->getName() . ") {\n\t\t";
        $setter .= $this->generateValidation() . "";
        $setter .= "this._" . $this->getName() . " = " . $this->getName() . ";";
        $setter .= "\n\t}";

        return $setter;
    }

    private function generateValidation()
    {
        $validation = "";

        switch ($this->getType()):
            case Types::TYPE_STRING:
                $validation .= "if (this.isNullOrEmpty(" . $this->getName() . ")) { \n\t\t\t";
                $validation .= "throw new Error('The field should be a non-empty string');\n\t\t";
                $validation .= "}\n\t\t";
                break;
            case Types::TYPE_NUMBER:
                $validation .= "if (!this.isNumber(" . $this->getName() . ")) { \n\t\t\t";
                $validation .= "throw new Error('The field should be numeric');\n\t\t";
                $validation .= "}\n\t\t";
                $validation .= $this->generateRangeValidation();
                break;
            case Types::TYPE_BOOLEAN:
                $validation .= "if (typeof (" . $this->getName() . ") != 'boolean') { \n\t\t\t";
                $validation .= "throw new Error('The field should be either true or false');\n\t\t";
                $validation .= "}\n\t\t";
                break;
            default:
                break;
        endswitch;

        return $validation;
    }

    private function generateRangeValidation()
    {
        $validation = "";

        if (!empty($this->range)) {
            $validation = "if (" . $this->getName() . " < " . $this->range[0] . " || " . $this->getName() . " > " . $this->range[1] . ") {\n\t\t\t";
            $validation .= "throw new Error('The field is out of range');\n\t\t";
            $validation .= "}\n\t\t";
        }

        return $validation;
    }

}
