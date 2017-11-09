<?php
defined('BASEPATH') OR exit('No direct script access allowed');
interface Serializablee
{
    function toArray();
    static function getClassName();
    static function getChavePrimariaNome();
}

?>