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
            $resp = $this->db->order_by($tabela::getChavePrimariaNome(), "desc")
    		->limit(1)
    		->get($tabela::getClassName())
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
    
    public function updateAll(Serializablee $tabela)
    {
        $this->db->set($tabela->toArray());
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->update($tabela::getClassName()); 
    }
    
    public function selectWhere($tabela_nome, $condicoes, $limit = null, $offset = null)
    {
        return $this->db->get_where($tabela_nome, $condicoes, $limit, $offset)->result_array();
    }
    
    public function remove(Serializablee $tabela)
    {
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->delete($tabela::getClassName());
    }
}


?>