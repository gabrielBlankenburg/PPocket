<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/funcionario.php';
class Cargo implements Serializablee
{
    private $id, $nome, $descricao, $funcionarios;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome, $descricao)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }
    
    public function adicionaFuncionario(Funcionario $funcionario)
    {
        $this->funcionarios[] = $funcionario;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['nome'] = $this->nome;
        $dados['descricao'] = $this->descricao;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'cargo';
    }
}