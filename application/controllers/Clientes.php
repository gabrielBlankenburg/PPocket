<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cliente.php';
		$this->load->model('querydao');
		
	}
	
	public function index()
	{
		// Os dados pro view
		$data['titulo'] = 'Clientes';
		$data['pagina'] = 'painel/clientes';
		$data['chave_primaria'] = Cliente::getChavePrimaria();
		$data['query'] = $this->querydao->selectAll(Cliente::getClassName());
		
		// Carrega a view
		$this->load->view('base', $data);
	}
	
	public function cadastra_cliente_action()
	{
		$nm_cliente = $this->input->post('nm_cliente');
		$cd_cnpj = $this->input->post('cd_cnpj');
		$cd_cpf = $this->input->post('cd_cpf');
		$ds_email = $this->input->post('ds_email');
		$cd_telefone = $this->input->post('cd_telefone');
		$nm_responsavel = $this->input->post('nm_responsavel');
		$ds_responsavel_email = $this->input->post('ds_responsavel_email');
		$cd_responsavel_telefone = $this->input->post('cd_responsavel_telefone');
		
		$cliente = new Cliente($nm_cliente, $cd_cnpj, $cd_cpf, $ds_email, $cd_telefone, $nm_responsavel,
								$ds_responsavel_email, $cd_responsavel_telefone);
		
		$cd_cliente = $this->querydao->insert($cliente);
		if ($cd_cliente != false){
			$cliente->addChavePrimaria($cd_cliente);
		}
		echo json_encode(($cliente->toArray()));
	}
	
	public function edita_cliente($cd_cliente)
	{
		$data['titulo'] = 'Clientes';
		$data['pagina'] = 'painel/clientes_editar';
		$data['chave_primaria'] = Cliente::getChavePrimaria();
		
		$condicoes = array(Cliente::getChavePrimaria() => $cd_cliente);
		$query = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes);
		
		if (count($query) == 1){
			$nm_cliente = $query[0]['nm_cliente'];
			$cd_cnpj = $query[0]['cd_cnpj'];
			$cd_cpf = $query[0]['cd_cpf'];
			$ds_email = $query[0]['ds_email'];
			$cd_telefone = $query[0]['cd_telefone'];
			$nm_responsavel = $query[0]['nm_responsavel'];
			$ds_responsavel_email = $query[0]['ds_responsavel_email'];
			$cd_responsavel_telefone = $query[0]['cd_responsavel_telefone'];
			$cliente = new Cliente($nm_cliente, $cd_cnpj, $cd_cpf, $ds_email, $cd_telefone, $nm_responsavel, 
									$ds_responsavel_email, $cd_responsavel_telefone);
			$cliente->addChavePrimaria($cd_cliente);
		}
		$data['query'] = $cliente->toArray();
		$this->load->view('base', $data);
	}
}
