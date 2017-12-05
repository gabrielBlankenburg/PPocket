<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cargo.php';
		$this->load->model('querydao');
		
		if (!$this->session->userdata('logado')){
			$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
										  <strong>Erro!</strong> Você deve estar logado para acessar essa página</div>');
			redirect('/login/', 'refresh');
		}
		if ($this->session->userdata('cd_permissao') == 1 || $this->session->userdata('cd_permissao') == 2){
			redirect('/tarefas/', 'refresh');
		} else if($this->session->userdata('cd_permissao') == 3){
			redirect('/projetos/', 'refresh');
		} else if ($this->session->userdata('cd_permissao') == 4){
			redirect('/funcionarios/', 'refresh');
		}
		
	}
	
	// A variável $dados passa as variáveis que vão para o view. Na posição query, ele seleciona todos os cargos
	// cadastrados para a view listar eles
	public function index()
	{
		$dados['titulo'] = 'Cargos';
		$dados['query'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['url'] = base_url().'cargos/cadastra_cargo_action';
		
		$this->load->view('template/header', $dados);
		$this->load->view('painel/cargos/cargos_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	// Quando enviar o formulário de cadastro, ele cria instancia o objeto cargo e insere no banco de dados, retornando
	// um json do metodo getAll de $cargo. Esse método retorna todos os dados do objeto
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
	
	// É acessado pelo cd_cargo, Ele busca a query com o cd_cargo especifico, se não encontrar retorna "não encontrado"
	// e depois manda para a view todas as infos de determinado cargo
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
	
	// Cria uma instancia de cargo com as infos mandadas pelo post, e então da update nela
	public function edita_cargo_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$nm_cargo = $this->input->post('nm_cargo');
		
		$cargo = new Cargo($nm_cargo, $cd_cargo);
		
		$query = $this->querydao->updateAll($cargo);
		echo json_encode($query);
	}
	
	// Cria uma instância de cargo e deleta ela
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
