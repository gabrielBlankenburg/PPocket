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
		$dados['query'] = $this->querydao->selectAll(Servico::getClassName());
		$dados['url'] = base_url().'servicos/cadastra_servico_action';
	}
	
    public function cadastra_servico_action()
	{
		$nm_servico = $this->input->post('nm_servico');
		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');
		$servico = new Servico($cd_servico, $nm_servico, $ds_servico, $vl_servico /*$cd_cargo*/);
		
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
		$query = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		
		if (count($query) == 1){
			$nm_servico = $query[0]['nm_servico'];
			$ds_servico = $query[0]['ds_servico'];
			$vl_servico = $query[0]['vl_servico'];
			$servico = new Servico($cd_servico, $nm_servico, $ds_servico, $vl_servico/*, $cd_cargo*/);
		} else{
			echo 'nao encontrado'; die;
		}
		$dados['servico'] = $servico;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/servicos/servicos_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_servico_action()
	{
		$cd_servico = $this->input->post('cd_servico');
		$nm_servico = $this->input->post('nm_servico');
 		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');
		
		$servico = new Servico($cd_servico, $nm_servico, $ds_servico, $vl_servico /*$cd_cargo*/);
		
		$query = $this->querydao->updateAll($servico);
		echo json_encode($query);
	}
	
	public function delete_servico_action()
	{
		$cd_servico = $this->input->post('cd_servico');
		$nm_servico = $this->input->post('nm_servico');
 		$ds_servico = $this->input->post('ds_servico');
		$vl_servico = $this->input->post('vl_servico');		
		
		$servico = new Servico($cd_servico, $nm_servico, $ds_servico, $vl_servico);
		
		$query = $this->querydao->remove($servico);
		if ($query){
			echo base_url().'servicos';
		} else{
			echo 'false';
		}
	}
}

?>