<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';
class Servico implements Serializablee
{
    private $cd_servico, $nm_servico, $ds_servico, $vl_servico, $cargo;
    
    // Recebe um array contendo os dados
    public function __construct($nm_servico, $ds_servico, $vl_servico, Cargo $cargo, $cd_servico = null)
    {
        $this->cd_servico = $cd_servico;
        $this->nm_servico = $nm_servico;
        $this->ds_servico = $ds_servico;
        $this->vl_servico = $vl_servico;
        $this->cargo = $cargo;
    }
    
    public function toArray()
    {
        $dados['cd_servico'] = $this->cd_servico;
        $dados['nm_servico'] = $this->nm_servico;
        $dados['ds_servico'] = $this->ds_servico;
        $dados['vl_servico'] = $this->vl_servico;
        $dados['cd_cargo'] = $this->cargo->getChavePrimariaValor();
        
        return $dados;
    }
    
    public function addChavePrimaria($cd_servico)
    {
        $this->cd_servico = $cd_servico;
    }
    
    public function getAll()
    {
        $dados['cd_servico'] = $this->cd_servico;
        $dados['nm_servico'] = $this->nm_servico;
        $dados['ds_servico'] = $this->ds_servico;
        $dados['vl_servico'] = $this->vl_servico;
        $dados['cd_cargo'] = $this->cargo->getChavePrimariaValor();
        $dados['nm_cargo'] = $this->cargo->getNomeCargo();
        
        return $dados;
    }
    
    public static function getJoins()
    {
        // Na chave 'on', concatena a chave o nome da tabela atual, o nome da classe do join e da foreign key
        $joins = array('tabela_nome' => Cargo::getClassName(),
                        'on' => 'servico.cd_cargo = '.Cargo::getClassName().'.'.Cargo::getChavePrimariaNome());
        return array($joins);
    }
    
    public function getNomeServico()
    {
        return $this->nm_servico;
    }
    
    public function getDescricaoServico()
    {
        return $this->ds_servico;
    }
    
    public function getChaveCargo()
    {
        return $this->cargo->getChavePrimariaValor();
    }
    
    public function getValorServico()
    {
        return $this->vl_servico;
    }
    
    public function getChavePrimariaValor()
    {
        return $this->cd_servico;
    }
    
    public static function getClassName()
    {
        return 'servico';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_servico';
    }
}

?>