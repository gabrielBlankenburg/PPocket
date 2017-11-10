<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionarios extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cargo.php';
		require_once APPPATH.'models/funcionario.php';
		$this->load->model('querydao');
		
	}
	
	public function index()
	{
		// Os dados pro view
		$dados['titulo'] = 'Funcioários';
		$dados['chave_primaria'] = Funcionario::getChavePrimariaNome();
		$dados['query'] = $this->querydao->selectJoins(Funcionario::getJoins());
		$dados['cargos'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['url'] = base_url().'funcionarios/cadastra_funcionario_action';
		
		// Carrega a view
		$this->load->view('template/header', $dados);
		$this->load->view('painel/funcionarios/funcionarios_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function cadastra_funcionario_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$nm_funcionario = $this->input->post('nm_funcionario');
        $cd_telefone = $this->input->post('cd_telefone');
        $cd_celular = $this->input->post('cd_celular');
        $ds_email = $this->input->post('ds_email');
        $data = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_nascimento'));
        $dt_nascimento = $data->format('Y-m-d');
        $vl_salario = $this->input->post('vl_salario');
		
		// Verifica se existe um cargo com o cd_cargo informado
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$nm_cargo = $query[0]['nm_cargo'];
			$cd_cargo = $query[0]['cd_cargo'];
			$cargo = new Cargo($nm_cargo, $cd_cargo);
		} else{
			echo 'nao encontrado'; die;
		}
		
		$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular, 
										$dt_nascimento, $cargo);
		
		$insert = $this->querydao->insert($funcionario);
		if ($insert != false){
			$funcionario->addChavePrimaria($insert->cd_funcionario);
		}
		
		$retorno = $funcionario->getAll();
		echo json_encode($retorno);
	}
	
	public function edita_cargo($cd_cargo)
	{
		$dados['titulo'] = 'Cargo';
		$dados['chave_primaria'] = Cargo::getChavePrimariaNome();
		$dados['urlEdit'] = base_url().'cargos/edita_cargo_action';
		$dados['urlDel'] = base_url().'cargos/delete_cargo_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$nm_cargo = $query[0]['nm_cargo'];
			$cargo = new Cargo($nm_cargo, $cd_cargo);
		} else{
			echo 'nao encontrado'; die;
		}
		$dados['cargo'] = $cargo;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/cargos/cargos_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_cargo_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$nm_cargo = $this->input->post('nm_cargo');
		
		$cargo = new Cargo($nm_cargo, $cd_cargo);
		
		$query = $this->querydao->updateAll($cargo);
		echo json_encode($query);
	}
	
	public function delete_cargo_action()
	{
		$nm_cargo = $this->input->post('nm_cargo');
		$cd_cargo = $this->input->post('cd_cargo');
		
		$cargo = new Cargo($nm_cargo, $cd_cargo);
		
		$query = $this->querydao->remove($cargo);
		if ($query){
			echo base_url().'cargos';
		} else{
			echo 'false';
		}
	}
}
