<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';

class Funcionario implements Serializablee
{
    private $cd_funcionario, $nm_funcionario, $cd_telefone, $cd_celular, $ds_email, $dt_nascimento, $vl_salario;
    private $cargo, $tarefas;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome, $salario, $email, $telefone, $endereco, $vl_salario, Cargo $cargo)
    {
        $this->cd_funcionario = $cd_funcionario;
        $this->nm_funcionario = $nm_funcionario;
        $this->cd_telefone = $cd_telefone;
        $this->cd_celular = $cd_celular;
        $this->ds_email = $ds_email;
        $this->dt_nascimento = $dt_nascimento;
        $this->vl_salario = $vl_salario;
        $this->cargo = $cargo;
    }
    
    public function adicionaTarefa(Tarefa $tarefa)
    {
        $this->tarefas[] = $tarefa;
    }
    
    public function toArray()
    {
        $dados['cd_funcionario'] = $this->cd_funcionario;
        $dados['nm_funcionario'] = $this->nm_funcionario;
        $dados['cd_telefone'] = $this->cd_telefone;
        $dados['cd_celular'] = $this->cd_celular;
        $dados['ds_email'] = $this->ds_email;
        $dados['dt_nascimento'] = $this->dt_nascimento;
        $dados['vl_salario'] = $this->vl_salario;
        $dados['cd_cargo'] = $this->cargo->cd_cargo;
        
        return $dados;
    }
    
    public static function getClassName()
    {
        return 'funcionario';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_funcionario';
    }
}

?>