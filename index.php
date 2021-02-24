<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require dirname(__FILE__) . '/Person.php';
require dirname(__FILE__) . '/Mankind.php';



$person = new Person(95, 'Davit', 'Harutyunyan', 'M', '29.05.1990');
$person1 = new Person(68, 'Davkhjkit', 'Harutyhjkhkdunyan', 'M', '29.05.1990');
//$person->name = 'Vaxo';
$mankind = Mankind::getInstance([$person , $person1]);

$mankind->loadPersonsFromCsv(dirname(__FILE__) . '/data.csv');
$personById = $mankind->mensPercent();
var_dump($personById);
exit;
//echo $person->getAgeInDays();
foreach ($mankind as $key => $value) {
    var_dump($key);
    var_dump($value);
}

?>
