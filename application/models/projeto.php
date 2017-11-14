<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cliente.php';
require_once APPPATH.'models/servico.php';
require_once APPPATH.'models/tarefa.php';
class Projeto implements Serializablee
{
    private $cd_projeto, $nm_projeto, $dt_inicio, $dt_termino, $ds_projeto, $vl_total;
    private $cliente, $servicos, $tarefas;
    
    // Recebe um array contendo os dados
    public function __construct($cd_projeto, $nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $vl_total, Cliente $cliente)
    {
        $this->cd_projeto = $cd_projeto;
        $this->cliente = $cliente;
        $this->nm_projeto = $nm_projeto;
        $this->dt_inicio = $dt_inicio;
        $this->dt_termino = $dt_termino;
        $this->ds_projeto = $ds_projeto;
        $this->vl_total = $vl_total;
    }
    
    public function adicionaTarefa(Tarefa $tarefa)
    {
        $this->tarefas[] = $tarefa;
    }
    
    public function toArray()
    {
        $dados['cd_projeto'] = $this->cd_projeto;
        $dados['nm_projeto'] = $this->nm_projeto;
        $dados['dt_inicio'] = $this->dt_inicio;
        $dados['dt_termino'] = $this->dt_termino;
        $dados['ds_projeto'] = $this->ds_projeto;
        $dados['vl_total'] = $this->vl_total;
        $dados['cd_cliente'] = $this->cliente->cd_cliente;
        
        return $dados;
    }
    
    public function getChavePrimariaValor()
    {
        return $this->cd_projeto;
    }
    
    public static function getClassName()
    {
        return 'projeto';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_projeto';
    }
    
    public function getNomeProjeto()
    {
        return 'nm_projeto';
    }
    
    public function getDataInicio()
    {
        return 'dt_inicio';
    }
    
    public function getDataTermino()
    {
        return 'dt_termino';
    }
    
    public function getDescricao()
    {
        return 'ds_projeto';
    }
}

?>