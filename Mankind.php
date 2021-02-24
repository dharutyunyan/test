<?php

class Mankind implements Iterator
{
    public $persons;
    private static $instance = null;

    public function __construct($persons)
    {
        if(is_array($persons)){
            $this->persons = $persons;
        }
    }

    public static function getInstance($persons)
    {
        if (self::$instance == null) {
          self::$instance = new Mankind($persons);
        }
        return self::$instance;
    }

    public function loadPersonsFromCsv($path)
    {
        $persons = [];
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $persons[] = new Person($data[0], $data[1], $data[2], $data[3], $data[4]);
            }
            fclose($handle);
        }
        $this->persons = $persons;
    }

    public function getPersonByID($id){
        $filteredPersons = array_filter($this->persons,  function($v, $k) use($id) {
            return $v->ID == $id;
        }, ARRAY_FILTER_USE_BOTH);
        return array_shift($filteredPersons);
    }

    public function mensPercent(){
        $mens = array_filter($this->persons,  function($v, $k) {
            return $v->sex == 'M';
        }, ARRAY_FILTER_USE_BOTH);
        $mensCount = count($mens);
        $mensPercent = $mensCount * 100 / count($this->persons);
        return round($mensPercent, 2);
    }

    public function rewind()
    {
        reset($this->persons);
    }

    public function current()
    {
        return current($this->persons);;
    }

    public function key()
    {
        return $this->current()->ID;
    }

    public function next()
    {
        return next($this->persons);
    }

    public function valid()
    {
        $key = key($this->persons);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
}
?>
