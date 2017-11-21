<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Faz as mesmas coisas que os outros controllers, porém é maior pois depende de mais instancias
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
        $dt_inicio = $this->input->post('dt_inicio');
        $dt_termino = $this->input->post('dt_termino');       
		$ds_projeto = $this->input->post('ds_projeto');
		$cd_cliente = $this->input->post('cd_cliente');
		$servicos = array();
		
		$condicoes = array(Cliente::getChavePrimariaNome() => $cd_cliente);
		$query_cliente = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes);
		
		if (count($query_cliente) == 1){
			$cliente = new Cliente($query_cliente[0]['nm_cliente'], $query_cliente[0]['cd_cnpj'], 
									$query_cliente[0]['cd_cpf'], $query_cliente[0]['ds_email'], 
									$query_cliente[0]['cd_telefone'], $query_cliente[0]['nm_responsavel'],
									$query_cliente[0]['ds_responsavel_email'], $query_cliente[0]['cd_responsavel_telefone'], 
									$query_cliente[0]['cd_cliente']);
		} else{
			echo false;
			die;
		}
		// Cria um array de instancias de serviços
		foreach ($this->input->post('cd_servico') as $cd_servico){
			$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
			$query_servico = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
			if (isset($query_servico) && !empty($query_servico)){
				$nm_servico = $query_servico[0]['nm_servico'];
				$ds_servico = $query_servico[0]['ds_servico'];
				$vl_servico = $query_servico[0]['vl_servico'];
				$cd_cargo = $query_servico[0]['cd_cargo'];
				$cd_servico = $query_servico[0]['cd_servico'];
				// Cria um cargo do serviço
				$conditions = array(Cargo::getChavePrimariaNome() => $cd_cargo);
				$query_cargo = $this->querydao->selectWhere(Cargo::getClassName(), $conditions);
				
				if (count($query_cargo) == 1){
					$cd_cargo = $query_cargo[0]['cd_cargo'];
					$nm_cargo = $query_cargo[0]['nm_cargo'];
					$cargo = new Cargo($nm_cargo, $cd_cargo);
				}
				
				$servicos[] = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
			}
		}
		$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos);
		
		$insert = $this->querydao->insertNparaN($projeto);
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
			$cd_cliente = $query[0]['cd_cliente'];
			
			$condicoes_cliente = array(Cliente::getChavePrimariaNome() => $cd_cliente);
			$query_cliente = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes_cliente);
			if (count($query_cliente) == 1){
				$cliente = new Cliente($query_cliente[0]['nm_cliente'], $query_cliente[0]['cd_cnpj'], 
										$query_cliente[0]['cd_cpf'], $query_cliente[0]['ds_email'], 
										$query_cliente[0]['cd_telefone'], $query_cliente[0]['nm_responsavel'],
										$query_cliente[0]['ds_responsavel_email'], $query_cliente[0]['cd_responsavel_telefone'], 
										$query_cliente[0]['cd_cliente']);
			} else{
				echo 'não encontrado';
				die;
			}
			$condicoes = array(Projeto::getClassName().'.'.Projeto::getChavePrimariaNome() => $cd_projeto);
			$query_all = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes, Projeto::getNparaNJoins());
			$servicos = array();
			if (isset($query_all) && !empty($query_all)){
				foreach ($query_all as $q) {
					$nm_servico = $q['nm_servico'];
					$ds_servico = $q['ds_servico'];
					$vl_servico = $q['vl_servico'];
					$cd_servico = $q['cd_servico'];
					$cd_cargo = $q['cd_cargo'];
					
					$condicoes_cargo = array(Cargo::getChavePrimariaNome() => $cd_cargo);
					$query_cargo = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes_cargo);
					
					if (count($query_cargo) == 1){
						$cd_cargo = $query_cargo[0]['cd_cargo'];
						$nm_cargo = $query_cargo[0]['nm_cargo'];
						$cargo = new Cargo($nm_cargo, $cd_cargo);
					} else{
						echo 'não encontrado';
						die;
					}
					
					$servicos[] = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
				}
			}
			$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos, $cd_projeto);
			
		} else{
			echo 'nao encontrado'; die;
		}
		
		$clientes = $this->querydao->selectAll(Cliente::getClassName());
		$dados['servicos'] = $this->querydao->selectAll(Servico::getClassName());
		$dados['projeto'] = $projeto;
		$dados['clientes'] = $clientes;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/projetos/projetos_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_projeto_action()
	{
		$nm_projeto = $this->input->post('nm_projeto');
        $dt_inicio = $this->input->post('dt_inicio');
        $dt_termino = $this->input->post('dt_termino');       
		$ds_projeto = $this->input->post('ds_projeto');
		$cd_cliente = $this->input->post('cd_cliente');
		$cd_projeto = $this->input->post('cd_projeto');
		$servicos = array();
		
		$condicoes = array(Cliente::getChavePrimariaNome() => $cd_cliente);
		$query_cliente = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes);
		
		if (count($query_cliente) == 1){
			$cliente = new Cliente($query_cliente[0]['nm_cliente'], $query_cliente[0]['cd_cnpj'], 
									$query_cliente[0]['cd_cpf'], $query_cliente[0]['ds_email'], 
									$query_cliente[0]['cd_telefone'], $query_cliente[0]['nm_responsavel'],
									$query_cliente[0]['ds_responsavel_email'], $query_cliente[0]['cd_responsavel_telefone'], 
									$query_cliente[0]['cd_cliente']);
		} else{
			echo false;
			die;
		}
		// Cria um array de instancias de serviços
		foreach ($this->input->post('cd_servico') as $cd_servico){
			$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
			$query_servico = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
			if (isset($query_servico) && !empty($query_servico)){
				$nm_servico = $query_servico[0]['nm_servico'];
				$ds_servico = $query_servico[0]['ds_servico'];
				$vl_servico = $query_servico[0]['vl_servico'];
				$cd_cargo = $query_servico[0]['cd_cargo'];
				$cd_servico = $query_servico[0]['cd_servico'];
				// Cria um cargo do serviço
				$conditions = array(Cargo::getChavePrimariaNome() => $cd_cargo);
				$query_cargo = $this->querydao->selectWhere(Cargo::getClassName(), $conditions);
				
				if (count($query_cargo) == 1){
					$cd_cargo = $query_cargo[0]['cd_cargo'];
					$nm_cargo = $query_cargo[0]['nm_cargo'];
					$cargo = new Cargo($nm_cargo, $cd_cargo);
				}
				
				$servicos[] = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
			}
		}
		$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos, $cd_projeto);
		
		$insert = $this->querydao->updateAllNparaN($projeto);
		if ($insert){
			echo true;
		} else{
			false;
		}
	}
	
	public function delete_projeto_action()
	{
		$nm_projeto = $this->input->post('nm_projeto');
        $dt_inicio = $this->input->post('dt_inicio');
        $dt_termino = $this->input->post('dt_termino');       
		$ds_projeto = $this->input->post('ds_projeto');
		$cd_cliente = $this->input->post('cd_cliente');
		$cd_projeto = $this->input->post('cd_projeto');
		$servicos = array();
		
		$condicoes = array(Cliente::getChavePrimariaNome() => $cd_cliente);
		$query_cliente = $this->querydao->selectWhere(Cliente::getClassName(), $condicoes);
		
		if (count($query_cliente) == 1){
			$cliente = new Cliente($query_cliente[0]['nm_cliente'], $query_cliente[0]['cd_cnpj'], 
									$query_cliente[0]['cd_cpf'], $query_cliente[0]['ds_email'], 
									$query_cliente[0]['cd_telefone'], $query_cliente[0]['nm_responsavel'],
									$query_cliente[0]['ds_responsavel_email'], $query_cliente[0]['cd_responsavel_telefone'], 
									$query_cliente[0]['cd_cliente']);
		} else{
			echo false;
			die;
		}
		// Cria um array de instancias de serviços
		foreach ($this->input->post('cd_servico') as $cd_servico){
			$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
			$query_servico = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
			if (isset($query_servico) && !empty($query_servico)){
				$nm_servico = $query_servico[0]['nm_servico'];
				$ds_servico = $query_servico[0]['ds_servico'];
				$vl_servico = $query_servico[0]['vl_servico'];
				$cd_cargo = $query_servico[0]['cd_cargo'];
				$cd_servico = $query_servico[0]['cd_servico'];
				// Cria um cargo do serviço
				$conditions = array(Cargo::getChavePrimariaNome() => $cd_cargo);
				$query_cargo = $this->querydao->selectWhere(Cargo::getClassName(), $conditions);
				
				if (count($query_cargo) == 1){
					$cd_cargo = $query_cargo[0]['cd_cargo'];
					$nm_cargo = $query_cargo[0]['nm_cargo'];
					$cargo = new Cargo($nm_cargo, $cd_cargo);
				}
				
				$servicos[] = new Servico($nm_servico, $ds_servico, $vl_servico, $cargo, $cd_servico);
			}
		}
		$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos, $cd_projeto);
		
		
		
		$query = $this->querydao->removeNparaN($projeto);
		if ($query){
			echo base_url().'projetos';
		} else{
			echo 'false';
		}
	}
}

?>