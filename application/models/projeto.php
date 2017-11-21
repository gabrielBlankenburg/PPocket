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
        $this->servicos = array();
        if (isset($servicos)){
            foreach ($servicos as $servico) {
                $this->servicos[] = $servico;
            }
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
        return $this->nm_projeto;
    }
    
    public function getDataInicio()
    {
        return $this->dt_inicio;
    }
    
    public function getDataTermino()
    {
        return $this->dt_termino;
    }
    
    public function getDescricaoProjeto()
    {
        return $this->ds_projeto;
    }
    public function getChaveCliente()
    {
        return $this->cliente->getChavePrimariaValor();
    }
    
    public function getServicos()
    {
        return $this->servicos;
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
    
    // MUITOS PARA MUITOS
    
    // Retorna o nome da tabela de relacionamento
    public static function getClassNparaN()
    {
        return 'projeto_servico';
    }
    
    // Retorna um array, que contém outros arrays, estes possuem a primeira chave o nome do campo do id do projeto,
    // e o primeiro valor como o valor do id do projeto, a segunda chave é o nome do id do serviço atual e o segundo 
    // valor é o valor do id do serviço atual
    public function insereChavesNparaN()
    {
        $tabelas = array();
        foreach ($this->servicos as $servico) {
            $tabelas[] = array('cd_projeto' => $this->cd_projeto, 
                                Servico::getChavePrimariaNome() => $servico->getChavePrimariaValor());
        }
        return $tabelas;
    }
    
    // Retorna os join necessários para a tabela de relacionamento. 
    public static function getNparaNJoins()
    {
        $joins = array();
        // Na chave 'on', concatena a chave o nome da tabela atual, o nome da classe do join e da foreign key
        $joins[] = array('tabela_nome' => Cliente::getClassName(),
                        'on' => 'projeto.cd_cliente = '.Cliente::getClassName().'.'.Cliente::getChavePrimariaNome());
        $joins[] = array('tabela_nome' => 'projeto_servico',
                        'on' => 'projeto.cd_projeto = projeto_servico.cd_projeto');
        $joins[] = array('tabela_nome' => Servico::getClassName(),
                        'on' => 'projeto_servico.cd_servico = '.Servico::getClassName()
                        .'.'.Servico::getChavePrimariaNome());
        return $joins;
    }   
    
    public static function getChaveRelacionamentoNome()
    {
        return 'cd_projeto_servico';
    }
    
    // Retorna os dados dos campos da tabela de relacionamento (exceto o proprio id da tabela)
    public function toArrayRelacionamento()
    {
        $dados = array();
        foreach ($this->servicos as $servico) {
            $dados[] = array('cd_projeto' => $this->cd_projeto, 
                                'cd_servico' => $servico->getChavePrimariaValor());
        }
        return $dados;
    }
    
}

?>