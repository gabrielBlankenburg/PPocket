<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';
class Servico implements Serializablee
{
    private $id, $nome, $descricao, $preco, $cargo;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome, $descricao, $preco, Cargo $cargo)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->cargo = $cargo;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['nome'] = $this->nome;
        $dados['descricao'] = $this->descricao;
        $dados['preco'] = $this->preco;
        $dados['cargo'] = $this->cargo;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'servico';
    }
}