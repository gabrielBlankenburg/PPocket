<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'models/serializable.php';
require_once APPPATH.'models/cargo.php';
require_once APPPATH.'models/usuario.php';

class Funcionario extends Usuario
{
    private $cd_funcionario, $nm_funcionario, $cd_telefone, $cd_celular, $ds_email, $dt_nascimento, $vl_salario, $cd_rg, $cd_cpf, $cargo, $cd_permissao;
    
    // Recebe um array contendo os dados
    public function __construct($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular, $dt_nascimento, 
                                    $cd_rg, $cd_cpf, $ds_email_corporacional, $ic_primeiro_acesso, $ds_hash,
                                    $cd_permissao, Cargo $cargo, $cd_funcionario = null)
    {
        parent::__construct($ds_email_corporacional, $ic_primeiro_acesso, $ds_hash, $cd_permissao, $cd_funcionario);
        $this->cd_funcionario = $cd_funcionario;
        $this->nm_funcionario = $nm_funcionario;
        $this->cd_telefone = $cd_telefone;
        $this->cd_celular = $cd_celular;
        $this->ds_email = $ds_email;
        $this->dt_nascimento = $dt_nascimento;
        $this->vl_salario = $vl_salario;
        $this->cd_rg = $cd_rg;
        $this->cd_cpf = $cd_cpf;
        $this->cargo = $cargo;
    }
    
    // Retorna todos os elementos num array
    public function getAll()
    {
        $dados['cd_funcionario'] = $this->cd_funcionario;
        $dados['nm_funcionario'] = $this->nm_funcionario;
        $dados['cd_telefone'] = $this->cd_telefone;
        $dados['cd_celular'] = $this->cd_celular;
        $dados['ds_email'] = $this->ds_email;
        $dados['dt_nascimento'] = date('d/m/Y', strtotime($this->dt_nascimento));
        $dados['vl_salario'] = $this->vl_salario;
        $dados['cd_cargo'] = $this->cargo->getChavePrimariaValor();
        $dados['cd_rg'] = $this->cd_rg;
        $dados['cd_cpf'] = $this->cd_cpf;
        $dados['nm_cargo'] = $this->cargo->getNomeCargo();
        
        return $dados;
    }
    
    public function getChaveCargo()
    {
        return $this->cargo->getChavePrimariaValor();
    }
    
    public function getNomeFuncionario()
    {
        return $this->nm_funcionario;
    }
    
    public function getTelefoneFuncionario()
    {
        return $this->cd_telefone;
    }
    
    public function getCelularFuncionario()
    {
        return $this->cd_celular;
    }
    
    public function getEmailFuncionario()
    {
        return $this->ds_email;
    }
    
    public function getNascimentoFuncionario()
    {
        return date('d/m/Y', strtotime($this->dt_nascimento));
    }
    
    public function getSalarioFuncionario()
    {
        return $this->vl_salario;
    }
    
    public function getRgFuncionario()
    {
        return $this->cd_rg;
    }
    
    public function getCpfFuncionario()
    {
        return $this->cd_cpf;
    }
    
    // Retorna um array contendo o nome da tabela que deverá ser feito um join e os campos que devem ser comparados
    public static function getJoins()
    {
        // Na chave 'on', concatena a chave o nome da tabela atual, o nome da classe do join e da foreign key
        $joins = array('tabela_nome' => Cargo::getClassName(),
                        'on' => 'funcionario.cd_cargo = '.Cargo::getClassName().'.'.Cargo::getChavePrimariaNome());
        return array($joins);
    }
    
    // A chave primária foge do padrão porque chave primarias só podem ser adicionadas, nunca alteradas
    public function addChavePrimaria($cd_funcionario)
    {
        $this->cd_funcionario = $cd_funcionario;
    }
    
    public function toArrayFilho()
    {
        $dados['cd_funcionario'] = $this->cd_funcionario;
        $dados['nm_funcionario'] = $this->nm_funcionario;
        $dados['cd_telefone'] = $this->cd_telefone;
        $dados['cd_celular'] = $this->cd_celular;
        $dados['ds_email'] = $this->ds_email;
        $dados['dt_nascimento'] = $this->dt_nascimento;
        $dados['vl_salario'] = $this->vl_salario;
        $dados['cd_rg'] = $this->cd_rg;
        $dados['cd_cpf'] = $this->cd_cpf;
        $dados['cd_cargo'] = $this->cargo->getChavePrimariaValor();
        
        return $dados;
    }
    
    public function getChavePrimariaValor()
    {
        return $this->cd_funcionario;
    }
    
    public static function getClassNameFilho()
    {
        return 'funcionario';
    }
    
    public static function getChavePrimariaNome()
    {
        return 'cd_funcionario';
    }
}

?>