<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/serializable.php';
// A interface utilizada quando se tem relacionamento de N para N no banco
interface MuitosParaMuitos extends Serializablee
{
    public static function getClassNparaN();
    public function insereChavesNparaN();
    public static function getChaveRelacionamentoNome();
    public function addChavePrimaria($chave);
}

?>