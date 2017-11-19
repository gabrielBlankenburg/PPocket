<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/serializable.php';
interface MuitosParaMuitos extends Serializablee
{
    public static function getClassNparaN();
    public function insereChavesNparaN();
    public static function getChaveRelacionamentoNome();
    public function addChavePrimaria($chave);
}

?>