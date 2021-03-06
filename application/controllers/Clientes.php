<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cliente.php';
		$this->load->model('querydao');
		
		if (!$this->session->userdata('logado')){
			$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
										  <strong>Erro!</strong> Você deve estar logado para acessar essa página</div>');
			redirect('/login/', 'refresh');
		}
		if ($this->session->userdata('cd_permissao') == 1 || $this->session->userdata('cd_permissao') == 2){
			redirect('/tarefas/', 'refresh');
		} else if ($this->session->userdata('cd_permissao') == 4){
			redirect('/funcionarios/', 'refresh');
		}
	}
	
	public function index()
	{
		// Os dados pro view
		$dados['titulo'] = 'Clientes';
		$dados['pagina'] = 'painel/clientes_listar';
		$dados['query'] = $this->querydao->selectAll(Cliente::getClassName());
		$dados['url'] = base_url().'clientes/cadastra_cliente_action';
		
		// Carrega a view
		$this->load->view('template/header', $dados);
		$this->load->view('painel/clientes/clientes_listar', $dados);
		$this->load->view('template/footer', $dados);
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
		$dados['urlEdit'] = base_url().'clientes/edita_cliente_action';
		$dados['urlDel'] = base_url().'clientes/delete_cliente_action';
		
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
		} else{
			echo 'não encontrado'; die;
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
	
	public function delete_cliente_action()
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
		
		$query = $this->querydao->remove($cliente);
		if ($query){
			echo base_url().'clientes';
		} else{
			echo 'false';
		}
	}
}
