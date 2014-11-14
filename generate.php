<?php
spl_autoload_register(function($class) {
    require_once ucfirst($class) . '.php';
});

$object = new Object($_POST['className'], ($_POST['isAbstract'] == 'true'), $_POST['baseClass']);
foreach ($_POST['property'] as $i => $name) {
    $range = [];

    if (!empty($_POST['from'][$i]) && !empty($_POST['to'][$i])) {
        $range[] = $_POST['from'][$i];
        $range[] = $_POST['to'][$i];
    }

    $object->addProperty(new Property($name, $_POST['type'][$i], $range));
}

$output = GlobalObject::getInstance();
$output .= $object;

echo $output;