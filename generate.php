<?php
spl_autoload_register(function($class) {
    require_once ucfirst($class) . '.php';
});

$object = new Object($_POST['className'], ($_POST['isAbstract'] == 'true'), $_POST['baseClass']);

foreach ($_POST['property'] as $i => $name) {
    $object->addProperty(new Property($name, $_POST['type'][$i]));
}

$output = GlobalObject::getInstance();
$output .= $object;

echo $output;