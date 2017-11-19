<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos extends CI_Controller 
{
    public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cliente.php';
		require_once APPPATH.'models/projeto.php';
		require_once APPPATH.'models/servico.php';
		$this->load->model('querydao');
	}
	
	public function index()
	{
	    $dados['titulo'] = 'Projetos';
		$dados['chave_primaria'] = Projeto::getChavePrimariaNome();
		$dados['query'] = $this->querydao->selectAll(Projeto::getClassName(), Projeto::getJoins());
		$dados['clientes'] = $this->querydao->selectAll(Cliente::getClassName());
		$dados['servicos'] = $this->querydao->selectAll(Servico::getClassName());
		$dados['url'] = base_url().'projetos/cadastra_projeto_action';
		
		$this->load->view('template/header', $dados);
		$this->load->view('painel/projetos/projetos_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
    public function cadastra_projeto_action()
	{
		$nm_projeto = $this->input->post('nm_projeto');
		$data_inicio = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_inicio'));
        $dt_inicio = $data_inicio->format('Y-m-d');
		$data_termino = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_termino'));
        $dt_termino = $data_termino->format('Y-m-d');       
		$ds_projeto = $this->input->post('ds_projeto');
		$cd_cliente = $this->input->post('cd_cliente');
		$servicos = array();
		
		$conditions = array(Cliente::getChavePrimariaNome() => $cd_cliente);
		$query_cliente = $this->querydao->selectWhere(Cliente::getClassName(), $conditions);
		
		// Cria um array de instancias de serviços
		foreach ($this->input->post('cd_servico') as $servico){
			$query_servico = $this->querydao->selectAll(Servico::getClassName());
			if (isset($query) && !empty($query)){
				$nm_servico = $query_servico->nm_servico;
				$ds_servico = $query_servico->ds_servico;
				$vl_servico = $query_servico->vl_servico;
				$cd_cargo = $query_servico->cd_cargo;
				$cd_servico = $query_servico->cd_servico;
				// Cria um cargo do serviço
				$conditions = array(Cargo::getChavePrimariaNome() => $cd_cargo);
				$query_cargo = $this->querydao->selectWhere(Cargo::getClassName(), $conditions);
				
				if (count($query_cargo) == 1){
					$cd_cargo = $query_cargo[0]['cd_cargo'];
					$nm_cargo = $query_cargo[0]['nm_cargo'];
					$cargo = new Cargo($nm_cargo, $cd_cargo);
				}
				
				$servicos[] = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo);
			}
		}
		$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $vl_total, $cliente, $servicos);
		
		print_r($projeto); die;
		
		$insert = $this->querydao->insert($projeto);
		if ($insert != false){
			$projeto->addChavePrimaria($insert->cd_projeto);
		}
		
		$retorno = $projeto->getAll();
		echo json_encode($retorno);
	}
	
	public function edita_projeto($cd_projeto)
	{
		$dados['titulo'] = 'Projetos';
		$dados['chave_primaria'] = Projeto::getChavePrimariaNome();
		$dados['urlEdit'] = base_url().'projetos/edita_projeto_action';
		$dados['urlDel'] = base_url().'projetos/delete_projeto_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Projeto::getChavePrimariaNome() => $cd_projeto);
		$query = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$nm_projeto = $query[0]['nm_projeto'];
			$dt_inicio = $query[0]['dt_inicio']; 
			$dt_termino = $query[0]['dt_termino']; 
			$ds_projeto = $query[0]['ds_projeto'];
			$projeto = new Projeto($cd_projeto, $nm_projeto, $dt_inicio, $dt_termino, $ds_projeto/*, $cd_cliente*/);
		} else{
			echo 'nao encontrado'; die;
		}
		$dados['projeto'] = $projeto;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/projetos/projetos_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_projeto_action()
	{
		$cd_projeto = $this->input->post('cd_projeto');
		$nm_projeto = $this->input->post('nm_projeto');
		$dt_inicio = $this->input->post('dt_inicio');
		$dt_termino=  $this->input->post('dt_termino');		
 		$ds_projeto = $this->input->post('ds_projeto');
		
		$projeto = new Projeto($cd_projeto, $nm_projeto, $dt_inicio, $dt_termino, $ds_projeto/*, $cd_cliente*/);
		
		$query = $this->querydao->updateAll($projeto);
		echo json_encode($query);
	}
	
	public function delete_projeto_action()
	{
		$cd_projeto = $this->input->post('cd_projeto');
		$nm_projeto = $this->input->post('nm_projeto');
		$dt_inicio = $this->input->post('dt_inicio');
		$dt_termino=  $this->input->post('dt_termino');
 		$ds_projeto = $this->input->post('ds_projeto');	
		
		$projeto = new Projeto($cd_projeto, $nm_projeto, $dt_inicio, $dt_termino, $ds_projeto/*, $cd_cliente*/);
		
		$query = $this->querydao->remove($projeto);
		if ($query){
			echo base_url().'projetos';
		} else{
			echo 'false';
		}
	}
}

?>