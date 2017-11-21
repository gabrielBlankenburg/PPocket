<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cargo.php';
		$this->load->model('querydao');
		
	}
	
	
	public function index()
	{
		// Os dados pro view
		$dados['titulo'] = 'Cargos';
		$dados['query'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['url'] = base_url().'cargos/cadastra_cargo_action';
		
		// Carrega a view
		$this->load->view('template/header', $dados);
		$this->load->view('painel/cargos/cargos_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function cadastra_cargo_action()
	{
		$nm_cargo = $this->input->post('nm_cargo');
		
		$cargo = new Cargo($nm_cargo);
		
		$insert = $this->querydao->insert($cargo);
		if ($insert != false){
			$cargo->addChavePrimaria($insert->cd_cargo);
		}
		
		$retorno = $cargo->getAll();
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
