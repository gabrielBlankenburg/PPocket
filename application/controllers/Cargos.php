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
		$dados['chave_primaria'] = Cargo::getChavePrimariaNome();
		$dados['query'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['url'] = base_url().'cargo/cadastra_cargo_action';
		
		// Carrega a view
		$this->load->view('template/header', $dados);
		$this->load->view('painel/cargo/cargos_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function cadastra_cargo_action()
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
		
		$insert = $this->querydao->insert($cliente);
		if ($insert != false){
			$cliente->addChavePrimaria($insert->cd_cliente);
		}
		
		$retorno = $cliente->getAll();
		echo json_encode($retorno);
	}
	
	public function edita_cliente($cd_cliente)
	{
		$dados['titulo'] = 'Clientes';
		$dados['pagina'] = 'painel/clientes/clientes_editar';
		$dados['chave_primaria'] = Cliente::getChavePrimariaNome();
		$dados['url'] = base_url().'clientes/edita_cliente_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Cliente::getChavePrimariaNome() => $cd_cliente);
		$query = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
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
									$ds_responsavel_email, $cd_responsavel_telefone, $cd_cliente);
		}
		$dados['cliente'] = $cliente;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/clientes/clientes_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_cliente_action()
	{
		$cd_cliente = $this->input->post('cd_cliente');
		$nm_cliente = $this->input->post('nm_cliente');
		$cd_cnpj = $this->input->post('cd_cnpj');
		$cd_cpf = $this->input->post('cd_cpf');
		$ds_email = $this->input->post('ds_email');
		$cd_telefone = $this->input->post('cd_telefone');
		$nm_responsavel = $this->input->post('nm_responsavel');
		$ds_responsavel_email = $this->input->post('ds_responsavel_email');
		$cd_responsavel_telefone = $this->input->post('cd_responsavel_telefone');
		
		$cliente = new Cliente($nm_cliente, $cd_cnpj, $cd_cpf, $ds_email, $cd_telefone, $nm_responsavel,
								$ds_responsavel_email, $cd_responsavel_telefone, $cd_cliente);
		
		$query = $this->querydao->updateAll($cliente);
		echo json_encode($query);
	}
}
