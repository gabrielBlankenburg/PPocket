<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/projeto.php';
class Cliente implements Serializablee
{
    private $id, $nome_fantasma, $cnpj, $nome_responsavel, $email_responsavel;
    private $telefone_responsavel, $email_empresa, $telefone_empresa, $projetos;
    
    // Recebe um array contendo os dados
    public function __construct($id, $nome_fantasma, $cnpj, $nome_responsavel, $email_responsavel, $telefone_responsavel, $email_empresa, $telefone_empresa)
    {
        $this->id = $id;
        $this->nome_fantasma = $nome_fantasma;
        $this->cnpj = $cnpj;
        $this->nome_responsavel = $nome_responsavel;
        $this->email_responsavel = $email_responsavel;
        $this->telefone_responsavel = $telefone_responsavel;
        $this->email_empresa = $email_empresa;
        $this->telefone_empresa = $telefone_empresa;
    }
    
    public function adicionaProjeto(Projeto $projeto)
    {
        $this->projetos[] = $projeto;
    }
    
    public function toArray()
    {
        $dados['id'] = $this->id;
        $dados['nome_fantasma'] = $this->nome_fantasma;
        $dados['cnpj'] = $this->cnpj;
        $dados['nome_responsavel'] = $this->nome_responsavel;
        $dados['email_responsavel'] = $this->email_responsavel;
        $dados['telefone_responsavel'] = $this->telefone_responsavel;
        $dados['email_empresa'] = $this->email_empresa;
        $dados['telefone_empresa'] = $this->telefone_empresa;
        
        return $dados;
    }
    
    public function getClassName()
    {
        return 'cliente';
    }
}