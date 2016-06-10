<?php

abstract class Entity
{
    public function init($row)
    {
        foreach ($row as $column => $value) {
            //Konvenciq za vsqka duma da e razdelena s znak _ (user_id) i wsichki kliuchove w bazata danni da sa s malki bukvi
            //Obrabotka ot Mysql standart kum camel case format (userId)
            $methodName = str_replace('_', ' ', $column);
            //Kogato veche sme premahnali znaka _ trqbva da napravim vsqka sledvashta duma da zapochva s GlavnaBukva
            $methodName = ucwords($methodName);
            //Sledvashtata manipulaciq maha vsichki prazni intervali
            $methodName = str_replace(' ', '', $methodName);
            //Dolepqme prefiksa SET kum imeto na poleto
            $methodName = 'set'.$methodName;

            $this->$methodName($value);
        }
        
        return $this;
    }
}

