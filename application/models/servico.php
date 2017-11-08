<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';
class Servico implements Serializablee
{
    private $cd_servico, $nm_servico, $ds_servico, $vl_servico, $cargo;
    
    // Recebe um array contendo os dados
    public function __construct($cd_servico, $nm_servico, $ds_servico, $vl_servico, Cargo $cargo)
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
        $dados['cd_cargo'] = $this->cargo->cd_cargo;
        
        return $dados;
    }
    
    public static function getClassName()
    {
        return 'servico';
    }
    
    public static function getChavePrimaria()
    {
        return 'cd_servico';
    }
}

?>