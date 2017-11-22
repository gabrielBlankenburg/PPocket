<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Faz as mesmas coisas que os outros controllers, porém é maior pois depende de mais instancias
class Tarefas extends CI_Controller 
{
    public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cliente.php';
		require_once APPPATH.'models/projeto.php';
		require_once APPPATH.'models/servico.php';
		require_once APPPATH.'models/tarefa.php';
		require_once APPPATH.'models/funcionario.php';
		$this->load->model('querydao');
	}
	
	public function index()
	{
	    $dados['titulo'] = 'Tarefas';
		$dados['query'] = $this->querydao->selectAll(Tarefa::getClassName(), Tarefa::getJoins());
		$dados['funcionarios'] = $this->querydao->selectAll(Funcionario::getClassName());
		$dados['projetos'] = $this->querydao->selectAll(Projeto::getClassName());
		$dados['servico'] = $this->querydao->selectAll(Servico::getClassName());
		$dados['url'] = base_url().'tarefas/cadastra_tarefa_action';
		
		
		$this->load->view('template/header', $dados);
		$this->load->view('painel/tarefas/tarefas_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	// As funções que têm api de prefixo farão uma busca na tabela indicada
	public function apiGetServicos()
	{
		$cd_projeto = $this->input->get('cd_projeto');
		$condicoes = array('projeto.'.Projeto::getChavePrimariaNome() => $cd_projeto);
		$resp = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes, Projeto::getAllJoins());
		header('Content-Type: application/json');
		echo json_encode($resp);
	}
	public function apiGetFuncionarios()
	{
		$cd_servico = $this->input->get('cd_servico');
		$condicoes = array(Servico::getChavePrimariaNome() => $cd_servico);
		$query_servico = $this->querydao->selectWhere(Servico::getClassName(), $condicoes);
		$condicoes = array('cd_cargo' => $query_servico[0]['cd_cargo']);
		$resp = $this->querydao->selectWhere(Funcionario::getClassName(), $condicoes);
		header('Content-Type: application/json');
		echo json_encode($resp);
	}
	
    public function cadastra_tarefa_action()
	{
		$nm_tarefa = $this->input->post('nm_tarefa');
        $ds_tarefa = $this->input->post('ds_tarefa');
        $ic_concluido = 0;    
		$cd_projeto = $this->input->post('cd_projeto');
		// $cd_servico = $this->input->post('cd_servico');
		
		// Serviço escolhido
		$servicoEscolhido;
		$cargoEscolhido;
		$funcionario;
		$cd_funcionario = $this->input->post('cd_funcionario');
		$servicos = array();
		
		$condicoes = array(Projeto::getChavePrimariaNome() => $cd_projeto);
		$query_projeto = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query_projeto) == 1){
			$nm_projeto = $query_projeto[0]['nm_projeto'];
			$dt_inicio = $query_projeto[0]['dt_inicio']; 
			$dt_termino = $query_projeto[0]['dt_termino']; 
			$ds_projeto = $query_projeto[0]['ds_projeto'];
			$cd_cliente = $query_projeto[0]['cd_cliente'];
			
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
					if ($this->input->post('cd_servico') == $cd_servico){
						$servicoEscolhido = end($servicos);
						$cargoEscolhido = $cargo;
					}
						
				}
			}
			$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos, $cd_projeto);
			
			$condicoes = array(Funcionario::getChavePrimariaNome() => $cd_funcionario);
			$query_funcionario = $this->querydao->selectWhere(Funcionario::getClassName(), $condicoes, Funcionario::getJoins());
			
			// Não tiver exatamente um match significa que deu algum erro
			if (count($query_funcionario) == 1){
				$nm_funcionario = $query_funcionario[0]['nm_funcionario'];
				$vl_salario = $query_funcionario[0]['vl_salario'];
				$ds_email = $query_funcionario[0]['ds_email'];
				$cd_telefone = $query_funcionario[0]['cd_telefone'];
				$cd_celular = $query_funcionario[0]['cd_celular'];
				$dt_nascimento = $query_funcionario[0]['dt_nascimento'];
				$cd_funcionario = $query_funcionario[0]['cd_funcionario'];
				
				$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
												$dt_nascimento, $cargoEscolhido, $cd_funcionario);
				$cargos = $this->querydao->selectAll(Cargo::getClassName());
			} else{
				echo 'nao encontrado'; die;
			}
			
			$tarefa = new Tarefa($nm_tarefa, $ds_tarefa, $ic_concluido, $servicoEscolhido, $projeto, $funcionario);
			
			
			$insert = $this->querydao->insert($tarefa);
			if ($insert != false){
				$tarefa->addChavePrimaria($insert->cd_tarefa);
			}
			
			$retorno = $tarefa->getAll();
			echo json_encode($retorno);
		} else{
			echo 'nao encontrado'; die;
		}
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
			print_r($projeto); die;
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