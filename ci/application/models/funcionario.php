<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';
class Funcionario implements Serializablee
{
    private $id, $nome, $salario, $email, $telefone, $endereco, $cargo, $tarefas;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome, $salario, $email, $telefone, $endereco, Cargo $cargo)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->salario = $salario;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->cargo = $cargo;
    }
    
    public function adicionaTarefa(Tarefa $tarefa)
    {
        $this->tarefas[] = $tarefa;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['nome'] = $this->nome;
        $dados['salario'] = $this->salario;
        $dados['email'] = $this->email;
        $dados['telefone'] = $this->telefone;
        $dados['endereco'] = $this->endereco;
        $dados['cargo'] = $this->cargo;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'funcionario';
    }
}