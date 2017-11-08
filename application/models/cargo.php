<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/funcionario.php';
class Cargo implements Serializablee
{
    private $cd_cargo, $nm_cargo, $funcionarios;
    
    // Recebe um array contendo os dados
    public function __construct($cd_cargo, $nm_cargo)
    {
        $this->cd_cargo = $nm_cargo;
        $this->nm_cargo = $nm_cargo;
    }
    
    public function adicionaFuncionario(Funcionario $funcionario)
    {
        $this->funcionarios[] = $funcionario;
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
    
    public static function getChavePrimaria()
    {
        return 'cd_cargo';
    }
}

?>