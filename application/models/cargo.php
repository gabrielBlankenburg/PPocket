<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/funcionario.php';
class Cargo implements Serializablee
{
    private $cd_cargo, $nm_cargo;
    
    // Recebe um array contendo os dados
    public function __construct($nm_cargo, $cd_cargo = null)
    {
        $this->cd_cargo = $cd_cargo;
        $this->nm_cargo = $nm_cargo;
    }
    
    // Retorna todos os elementos num array
    public function getAll()
    {
        $dados['cd_cargo'] = $this->cd_cargo;
        $dados['nm_cargo'] = $this->nm_cargo;
        
        return $dados;
    }
    
    public function getNomeCargo()
    {
        return $this->nm_cargo;
    }
    
    // A chave primária foge do padrão porque chave primarias só podem ser adicionadas, nunca alteradas
    public function addChavePrimaria($cd_cargo)
    {
        $this->cd_cargo = $cd_cargo;
    }
    public function getChavePrimariaValor()
    {
        return $this->cd_cargo;
    }
    
    public function toArray()
    {
        $dados['cd_cargo'] = $this->cd_cargo;
        $dados['nm_cargo'] = $this->nm_cargo;
        
        return $dados;
    }
    
    public static function getClassName()
    {
        return 'cargo';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_cargo';
    }
}

?>