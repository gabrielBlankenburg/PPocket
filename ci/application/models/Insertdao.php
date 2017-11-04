<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/serializable.php';

class Insertdao extends CI_Model
{
    public function insert(Serializablee $tabela)
    {
        print_r($tabela->toArray()); die;
    }
}