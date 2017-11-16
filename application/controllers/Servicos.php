<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller 
{
    public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/servico.php';
		$this->load->model('querydao');
	}
	
	public function index()
	{
	    $dados['titulo'] = 'Serviços';
		$dados['chave_primaria'] = Servico::getChavePrimariaNome();
		$dados['cargos'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['query'] = $this->querydao->selectAll(Servico::getClassName(), Servico::getJoins());
		$dados['url'] = base_url().'servicos/cadastra_servico_action';
		
		$this->load->view('template/header', $dados);
		$this->load->view('painel/servicos/servicos_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
    public function cadastra_servico_action()
	{
		$nm_servico = $this->input->post('nm_servico');
		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');
		$cd_cargo = $this->input->post('cd_cargo');
		
		// Verifica se existe um cargo com o cd_cargo informado
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		
		// Se não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$cd_cargo = $query[0]['cd_cargo'];
			$nm_cargo = $query[0]['nm_cargo'];
			$cargo = new Cargo($nm_cargo, $cd_cargo);
		} else{
			echo 'nao encontrado'; die;
		}
		$servico = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo);
		
		$insert = $this->querydao->insert($servico);
		if ($insert != false){
			$servico->addChavePrimaria($insert->cd_servico);
		}
		
		$retorno = $servico->getAll();
		echo json_encode($retorno);
	}
	
	public function edita_servico($cd_servico)
	{
		$dados['titulo'] = 'Serviços';
		$dados['chave_primaria'] = Servico::getChavePrimariaNome();
		$dados['urlEdit'] = base_url().'servicos/edita_servico_action';
		$dados['urlDel'] = base_url().'servicos/delete_servico_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
		$query = $this->querydao->selectWhere(Servico::getClassName(), $condicoes, Servico::getJoins());
		
		// Não tiver exatamente um match significa que deu algum erro
		
		if (count($query) == 1){
			$nm_cargo = $query[0]['nm_cargo'];
			$cd_cargo = $query[0]['cd_cargo'];
			$nm_servico = $query[0]['nm_servico'];
			$ds_servico = $query[0]['ds_servico'];
			$vl_servico = $query[0]['vl_servico'];
			$cargo = new Cargo($nm_cargo, $cd_cargo);
			$servico = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
			$cargos = $this->querydao->selectAll(Cargo::getClassName());
		} else{
			echo 'nao encontrado'; die;
		}
		$dados['servico'] = $servico;
		$dados['cargos'] = $cargos;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/servicos/servicos_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_servico_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$cd_servico = $this->input->post('cd_servico');
		$nm_servico = $this->input->post('nm_servico');
 		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');
		
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		// Se o número de colunas for igual a 1, cria uma instancia de cargo com o cargo modificado (ou não)
		if (count($query) == 1){
			$cargo = new Cargo($query[0]['nm_cargo'], $query[0]['cd_cargo']);
			
			$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
			$query = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
			
			$servico = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
		}
		
		$query = $this->querydao->updateAll($servico);
		echo json_encode($query);
	}
	
	public function delete_servico_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$cd_servico = $this->input->post('cd_servico');
		$nm_servico = $this->input->post('nm_servico');
 		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');		
		
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		// Se o número de colunas for igual a 1, cria uma instancia de cargo com o cargo modificado (ou não)
		if (count($query) == 1){
			$cargo = new Cargo($query[0]['nm_cargo'], $query[0]['cd_cargo']);
			
			$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
			$query = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
			
			$servico = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
		}
		
		$query = $this->querydao->remove($servico);
		if ($query){
			echo base_url().'servicos';
		} else{
			echo 'false';
		}
	}
}

?>