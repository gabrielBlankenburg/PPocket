<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cliente.php';
require_once APPPATH.'models/servico.php';
require_once APPPATH.'models/tarefa.php';
class Projeto implements Serializablee
{
    private $id, $cliente, $servicos, $preco, $dt_entrega, $descricao, $nome, $tarefas;
    
    // Recebe um array contendo os dados
    public function __construct($id, Cliente $cliente, $nome, $descricao,  $preco, $dt_entrega)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->preco = $preco;
        $this->dt_entrega = $dt_entrega;
        $this->descricao = $descricao;
        $this->nome = $nome;
    }
    
    public function adicionaTarefa(Tarefa $tarefa)
    {
        $this->tarefas[] = $tarefa;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['id_cliente'] = $this->cliente->id;
        $dados['preco'] = $this->preco;
        $dados['dt_entrega'] = $this->dt_entrega;
        $dados['descricao'] = $this->descricao;
        $dados['nome'] = $this->nome;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'projeto';
    }
}