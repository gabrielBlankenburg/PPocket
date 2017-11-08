<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/servico.php';
require_once APPPATH.'models/projeto.php';
require_once APPPATH.'models/funcionario.php';
class Tarefa implements Serializablee
{
    private $cd_tarefa, $nm_tarefa, $ds_tarefa, $ic_concluido, $projeto, $servico, $funcionario;
    
    // Recebe um array contendo os dados
    public function __construct($cd_tarefa, $nm_tarefa, $ds_tarefa, $ic_concluido, Servico $servico, 
                                Projeto $projeto, Funcionario $funcionario)
    {
        $this->cd_tarefa = $cd_tarefa;
        $this->nm_tarefa = $nm_tarefa;
        $this->ic_concluido = $ic_concluido;
        $this->ds_tarefa = $ds_tarefa;
        $this->projeto = $projeto;
        $this->funcionario = $funcionario;
        $this->servico = $servico;
    }
    
    public function toArray()
    {
        $dados['cd_tarefa'] = $this->cd_tarefa;
        $dados['nm_tarefa'] = $this->nm_tarefa;
        $dados['ic_concluido'] = $this->ic_concluido;
        $dados['cd_servico'] = $this->servico->cd_servico;
        $dados['cd_projeto'] = $this->projeto->cd_projeto;
        $dados['cd_funcionario'] = $this->funcionario->cd_funcionario;
        
        return $dados;
    }
    
    public static function getClassName()
    {
        return 'tarefa';
    }
    
    public static function getChavePrimaria()
    {
        return 'cd_tarefa';
    }
}

?>