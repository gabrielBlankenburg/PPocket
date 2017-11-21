<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/projeto.php';
class Cliente implements Serializablee
{
    private $cd_cliente, $nm_cliente, $cd_cnpj, $cd_cpf, $ds_email, $cd_telefone, $nm_responsavel;
    private $ds_responsavel_email, $cd_responsavel_telefone;
    
    // Recebe um array contendo os dados
    public function __construct($nm_cliente, $cd_cnpj, $cd_cpf, $ds_email, $cd_telefone, $nm_responsavel, 
                                $ds_responsavel_email, $cd_responsavel_telefone, $cd_cliente = null)
    {
        $this->cd_cliente = $cd_cliente;
        $this->nm_cliente = $nm_cliente;
        $this->cd_cnpj = $cd_cnpj;
        $this->cd_cpf = $cd_cpf;
        $this->ds_email = $ds_email;
        $this->cd_telefone = $cd_telefone;
        $this->nm_responsavel = $nm_responsavel;
        $this->ds_responsavel_email = $ds_responsavel_email;
        $this->cd_responsavel_telefone = $cd_responsavel_telefone;
    }
    
    // A chave primária foge do padrão porque chave primarias só podem ser adicionadas, nunca alteradas
    public function addChavePrimaria($cd_cliente)
    {
        $this->cd_cliente = $cd_cliente;
    }
    public function getChavePrimariaValor()
    {
        return $this->cd_cliente;
    }
    
    public function getNomeCliente()
    {
        return $this->nm_cliente;
    }
    
    public function getCpf()
    {
        return $this->cd_cpf;
    }
    
    public function getCnpj()
    {
        return $this->cd_cnpj;
    }
    
    public function getEmail()
    {
        return $this->ds_email;
    }
    
    public function getTelefone()
    {
        return $this->cd_telefone;
    }
    
    public function setTelefone($valor)
    {
        $this->cd_telefone = $valor;
    }
    
    public function getNomeResponsavel()
    {
        return $this->nm_responsavel;
    }
    
    public function getEmailResponsavel()
    {
        return $this->ds_responsavel_email;
    }
    
    public function getTelefoneResponsavel()
    {
        return $this->cd_responsavel_telefone;
    }
    
    // Retorna todos os elementos num array
    public function getAll()
    {
        $dados['cd_cliente'] = $this->cd_cliente;
        $dados['nm_cliente'] = $this->nm_cliente;
        $dados['cd_cnpj'] = $this->cd_cnpj;
        $dados['cd_cpf'] = $this->cd_cpf;
        $dados['ds_email'] = $this->ds_email;
        $dados['cd_telefone'] = $this->cd_telefone;
        $dados['nm_responsavel'] = $this->nm_responsavel;
        $dados['ds_responsavel_email'] = $this->ds_responsavel_email;
        $dados['cd_responsavel_telefone'] = $this->cd_responsavel_telefone;
        
        return $dados;
    }
    
    // METODOS SERIALAZIBLEE
    
    // retorna os dados dos elementos necessários para um update
    public function toArray()
    {
        $dados['nm_cliente'] = $this->nm_cliente;
        $dados['cd_cnpj'] = $this->cd_cnpj;
        $dados['cd_cpf'] = $this->cd_cpf;
        $dados['ds_email'] = $this->ds_email;
        $dados['cd_telefone'] = $this->cd_telefone;
        $dados['nm_responsavel'] = $this->nm_responsavel;
        $dados['ds_responsavel_email'] = $this->ds_responsavel_email;
        $dados['cd_responsavel_telefone'] = $this->cd_responsavel_telefone;
        
        return $dados;
    }
    
    public static function getClassName()
    {
        return 'cliente';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_cliente';
    }
}

?>