<?php
class Person
{
    private $ID;
    private $name;
    private $surname;
    private $sex;
    private $birthDate;
    public function __construct($ID, $name, $surname, $sex, $birthDate)
    {
        $this->ID = $ID;
        $this->name = $name;
        $this->surname = $surname;
        $this->sex = $sex;
        $this->birthDate = $birthDate;
    }

    public function __set($var, $value)
    {
        throw new \LogicException("Variable $var is read-only");
    }

    public function __get($var)
    {
        return $this->$var;
    }

    public function getAgeInDays()
    {
        $ageTime = strtotime($this->birthDate);
        $t = time();
        $age = ($ageTime < 0) ? ( $t + ($ageTime * -1) ) : $t - $ageTime;
        $day = 60 * 60 * 24;
        return $age / $day;
    }
}
?>
