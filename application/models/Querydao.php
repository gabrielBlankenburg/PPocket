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
    
    public function selectAll($tabela_nome, $joins = null)
    {
        if (isset($joins)){
            foreach ($joins as $join) {
                $this->db->join($join['tabela_nome'], $join['on']);
            }
        }
        return $this->db->get($tabela_nome)->result_array();
    }
    
    public function updateAll(Serializablee $tabela)
    {
        $this->db->set($tabela->toArray());
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->update($tabela::getClassName()); 
    }
    
    public function selectWhere($tabela_nome, $condicoes, $joins = null, $limit = null, $offset = null)
    {
        if (isset($joins)){
            foreach ($joins as $join) {
                $this->db->join($join['tabela_nome'], $join['on']);
            }
        }
        return $this->db->get_where($tabela_nome, $condicoes, $limit, $offset)->result_array();
    }
    
    public function remove(Serializablee $tabela)
    {
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->delete($tabela::getClassName());
    }
    
    public function insertNparaN(MuitosParaMuitos $tabela){
        $insert = $this->db->insert($tabela->getClassName(), $tabela->toArray());
        // Se inseriu com sucesso retorna o ultimo registro
        if ($insert){
            $resp = $this->db->order_by($tabela::getChavePrimariaNome(), "desc")
    		->limit(1)
    		->get($tabela::getClassName())
    		->row();
    		
    		$nome_chave = $tabela->getChavePrimariaNome();
    		$tabela->addChavePrimaria($resp->{$nome_chave});
        } else{
            echo false;
            die;
        }
        foreach ($tabela->insereChavesNparaN() as $t) {
            $insertMuitos = $this->db->insert($tabela::getClassNparaN(), $t);
            if (!$insertMuitos){
                echo false;
                die;
            }
        }
        // Se inseriu com sucesso retorna o ultimo registro
        if ($insert){
            header('Content-Type: application/json');
            return $resp;
        } else{
            $resp = false;
        }
    }
    
    public function updateAllNparaN(MuitosParaMuitos $tabela)
    {
        $this->db->set($tabela->toArray());
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        if (!$this->db->update($tabela::getClassName())){
            return false;
        }
        
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        if (!$this->db->delete($tabela::getClassNparaN())){
            return false;
        }
        foreach ($tabela->toArrayRelacionamento() as $dado) {
            $insertMuitos = $this->db->insert($tabela::getClassNparaN(), $dado);
            if (!$insertMuitos){
                echo false;
                die;
            }
        }
        return true;
    }
    
    public function removeNparaN(MuitosParaMuitos $tabela)
    {
        foreach ($tabela->toArrayRelacionamento() as $dado) {
            $remove = $this->db->delete($tabela::getClassNparaN(), $dado);
            if (!$remove){
                echo false;
                die;
            }
        }
        
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->delete($tabela::getClassName());
        
        
        return true; 
    }
}

?>