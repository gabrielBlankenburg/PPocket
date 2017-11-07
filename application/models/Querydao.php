<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/serializable.php';

class Querydao extends CI_Model
{
    public function insert(Serializablee $tabela)
    {
        $insert = $this->db->insert($tabela->getClassName(), $tabela->toArray());
        // Se inseriu com sucesso retorna o ultimo registro
        if ($insert){
            $resp = $this->db->order_by($tabela->getPrimaryKey(),"desc")
    		->limit(1)
    		->get($tabela->getClassName())
    		->row();
        } else{
            $resp = false;
        }
        header('Content-Type: application/json');
        return $resp;
    }
    
    public function selectAll($tabela_nome)
    {
        return $this->db->get($tabela_nome)->result_array();
    }
}