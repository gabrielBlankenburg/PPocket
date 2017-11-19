<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cliente.php';
require_once APPPATH.'models/servico.php';
require_once APPPATH.'models/tarefa.php';
require_once APPPATH.'models/MuitosParaMuitos.php';
class Projeto implements Serializablee, MuitosParaMuitos
{
    private $cd_projeto, $nm_projeto, $dt_inicio, $dt_termino, $ds_projeto, $cliente, $servicos;
    
    // Recebe um array contendo os dados
    public function __construct($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, Cliente $cliente, 
                                $servicos = null, $cd_projeto = null)
    {
        $this->cd_projeto = $cd_projeto;
        $this->cliente = $cliente;
        $this->nm_projeto = $nm_projeto;
        $this->dt_inicio = $dt_inicio;
        $this->dt_termino = $dt_termino;
        $this->ds_projeto = $ds_projeto;
        if (!isset($servicos)){
            $this->servicos = array();
        }
    }
    
    public function toArray()
    {
        $dados['nm_projeto'] = $this->nm_projeto;
        $dados['dt_inicio'] = $this->dt_inicio;
        $dados['dt_termino'] = $this->dt_termino;
        $dados['ds_projeto'] = $this->ds_projeto;
        $dados['cd_cliente'] = $this->cliente->getChavePrimariaValor();
        
        return $dados;
    }
    public static function getJoins()
    {
        // Na chave 'on', concatena a chave o nome da tabela atual, o nome da classe do join e da foreign key
        $joins = array('tabela_nome' => Cliente::getClassName(),
                        'on' => 'projeto.cd_cliente = '.Cliente::getClassName().'.'.Cliente::getChavePrimariaNome());
        return array($joins);
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
    
    public function addChavePrimaria($cd_projeto)
    {
        $this->cd_projeto = $cd_projeto;
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
    public function getChaveCliente()
    {
        return 'cd_cliente';
    }
    
    public function getAll()
    {
        $dados['cd_projeto'] = $this->cd_projeto;
        $dados['nm_projeto'] = $this->nm_projeto;
        $dados['dt_inicio'] = $this->dt_inicio;
        $dados['dt_termino'] = $this->dt_termino;
        $dados['ds_projeto'] = $this->ds_projeto;
        $dados['cd_cliente'] = $this->cliente->getChavePrimariaValor();
        $dados['nm_cliente'] = $this->cliente->getNomeCliente();
        
        return $dados;
    }
    
    // Muitos Para Muitos
    public static function getClassNparaN(){
        return 'projeto_servico';
    }
    
    public function insereChavesNparaN(){
        return array('cd_projeto' => $this->cd_projeto, Servico::getClassName() => $this->cd_servico);
    }
    
    public static function getChaveRelacionamentoNome(){
        return 'cd_projeto_servico';
    }
}

?>