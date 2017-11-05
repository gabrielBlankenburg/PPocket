<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/servico.php';
require_once APPPATH.'models/projeto.php';
require_once APPPATH.'models/cliente.php';
require_once APPPATH.'models/funcionario.php';
class Tarefa implements Serializablee
{
    private $id, $nome, $descricao, $servico, $projeto, $cliente, $funcionario;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome, $descricao, Servico $servico, Projeto $projeto, Cliente $cliente, Funcionario $funcionario)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->servico = $servico;
        $this->projeto = $projeto;
        $this->cliente = $cliente;
        $this->funcionario = $funcionario;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['nome'] = $this->nome;
        $dados['descricao'] = $this->descricao;
        $dados['servico'] = $this->servico;
        $dados['projeto'] = $this->projeto;
        $dados['cliente'] = $this->cliente;
        $dados['funcionario'] = $this->funcionario;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'tarefa';
    }
}