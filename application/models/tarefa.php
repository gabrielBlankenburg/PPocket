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
    public function __construct($nm_tarefa, $ds_tarefa, $ic_concluido, Servico $servico, 
                                Projeto $projeto, Funcionario $funcionario, $cd_tarefa = null)
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
        $dados['cd_servico'] = $this->servico->getChavePrimariaValor();
        $dados['cd_projeto'] = $this->projeto->getChavePrimariaValor();
        $dados['cd_funcionario'] = $this->funcionario->getChavePrimariaValor();
        
        return $dados;
    }
    
    public static function getJoins()
    {
        // Na chave 'on', concatena a chave o nome da tabela atual, o nome da classe do join e da foreign key
        $joins = array('tabela_nome' => Servico::getClassName(),
                        'on' => 'tarefa.cd_servico = '.Servico::getClassName().'.'.Servico::getChavePrimariaNome());
        return array($joins);
    } 
    
    public function addChavePrimaria($cd_tarefa)
    {
        $this->cd_tarefa = $cd_tarefa;
    }
    
    public function getAll()
    {
        $dados['cd_tarefa'] = $this->cd_tarefa;
        $dados['nm_tarefa'] = $this->nm_tarefa;
        $dados['ic_concluido'] = $this->ic_concluido;
        $dados['ds_tarefa'] = $this->ds_tarefa;
        $dados['nm_projeto'] = $this->projeto->getNomeProjeto();
        $dados['cd_projeto'] = $this->projeto->getChavePrimariaValor();
        $dados['nm_servico'] = $this->servico->getNomeServico();
        $dados['cd_servico'] = $this->servico->getChavePrimariaValor();
        $dados['nm_funcionario'] = $this->funcionario->getNomeFuncionario();
        $dados['cd_funcionario'] = $this->funcionario->getChavePrimariaValor();
        
        return $dados;
    }
    
    public function getChavePrimariaValor()
    {
        return $this->cd_tarefa;
    }
    
    public static function getClassName()
    {
        return 'tarefa';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_tarefa';
    }
}

?>