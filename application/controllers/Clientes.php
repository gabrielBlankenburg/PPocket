<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		require_once APPPATH.'models/cliente.php';
		$this->load->model('querydao');
		
	}
	
	public function index()
	{
		// Os dados pro view
		$data['titulo'] = 'Clientes';
		$data['pagina'] = 'painel/clientes';
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
		echo json_encode(($this->querydao->insert($cliente)));
	}
}
