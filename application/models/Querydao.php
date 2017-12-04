<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/serializable.php';

class Querydao extends CI_Model
{
    // Insere os dados de uma tabela, e se for inserido com sucesso, faz um select no ultimo dado e retorna em formato
    // JSON o mesmo
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
        if (method_exists($tabela, 'toArrayFilho')){
            $insert = $this->db->insert($tabela->getClassNameFilho(), $tabela->toArrayFilho());
            // Se inseriu com sucesso retorna o ultimo registro
            if ($insert){
                $resp = $this->db->order_by($tabela::getChavePrimariaNomeFilho(), "desc")
        		->limit(1)
        		->get($tabela::getClassNameFilho())
        		->row();
            } else{
                $resp = false;
            }
        }
        
        header('Content-Type: application/json');
        return $resp;
    }
    
    // Busca todos os resultados da tabela específicada. se tiver joins, ele percorre todos e o aplica
    public function selectAll($tabela_nome, $joins = null)
    {
        if (isset($joins)){
            foreach ($joins as $join) {
                $this->db->join($join['tabela_nome'], $join['on']);
            }
        }
        return $this->db->get($tabela_nome)->result_array();
    }
    
    // Pega os valores de uma tabela (que é informado pelo método toArray()), seleciona a chave primária e da update
    public function updateAll(Serializablee $tabela)
    {
        if (method_exists($tabela, 'toArrayFilho')){
            $this->db->set($tabela->toArrayFilho());
            $this->db->where($tabela::getChavePrimariaNomeFilho(), $tabela->getChavePrimariaValorFilho());
            return $this->db->update($tabela::getClassNameFilho());
        } else{
            $this->db->set($tabela->toArray());
            $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
            return $this->db->update($tabela::getClassName()); 
        }
        
    }
    
    // Seleciona dados específicos, o parâmetro condições é um array de condições, que segue a regra do CodeIgniter
    public function selectWhere($tabela_nome, $condicoes, $joins = null, $limit = null, $offset = null)
    {
        if (isset($joins)){
            foreach ($joins as $join) {
                $this->db->join($join['tabela_nome'], $join['on']);
            }
        }
        return $this->db->get_where($tabela_nome, $condicoes, $limit, $offset)->result_array();
    }
    
    // Pega a chave primaria e o valor dela, e remove esse dado
    public function remove(Serializablee $tabela)
    {
        if (method_exists($tabela, 'toArrayFilho')){
            $this->db->where($tabela::getChavePrimariaNomeFilho(), $tabela->getChavePrimariaValorFilho());
            return $this->db->delete($tabela::getClassNameFilho());
        }
        $this->db->where($tabela::getChavePrimariaNome(), $tabela->getChavePrimariaValor());
        return $this->db->delete($tabela::getClassName());
    }
    
    // Primeiro insere na tabela (passada por parâmetro), depois na tabela de relacionamento (percorrendo o valor das
    // chaves), e finalmente retorna em json a inserção da tabela
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
    
    // Primeiro atualiza a tabela, depois apaga tudo relacionado a essa tabela na tabela de relacionamento, enfim é
    // adicionado tudo relacionado a essa tabela na tabela de relacionamento. Retorna true ou false dependendo se 
    // o update foi feito com sucesso ou não
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
    
    // Remove tudo da tabela, e depois da tabela de relacionamento, retornando true em sucesso ou false em falha
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
    
    // Função temporária de login
    public function buscaPorEmailSenha($login, $senha, $tabela){
        $this->db->where("nm_usuario", $login);
        $this->db->where("ds_hash", $senha);
        $usuario = $this->db->get($tabela)->row_array();
        return $usuario;
    }
}

?>