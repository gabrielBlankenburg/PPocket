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
		
		if (!$this->session->userdata('logado')){
			$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
										  <strong>Erro!</strong> Você deve estar logado para acessar essa página</div>');
			redirect('/login/', 'refresh');
		}
		
		if($this->session->userdata('cd_permissao') == 3){
			redirect('/projetos/', 'refresh');
		} else if ($this->session->userdata('cd_permissao') == 4){
			redirect('/funcionarios/', 'refresh');
		}
	}
	
	public function index()
	{
	    $dados['titulo'] = 'Tarefas';
		if ($this->session->userdata('cd_permissao') != 1){
			$dados['query'] = $this->querydao->selectAll(Tarefa::getClassName(), Tarefa::getJoins(), array('ic_concluido', 'desc'));
		} else{
			$condicoes = array('tarefa.cd_funcionario' => $this->session->userdata('cd_funcionario'));
			$dados['query'] = $this->querydao->selectWhere(Tarefa::getClassName(), $condicoes, Tarefa::getJoins());
		}
		$dados['projetos'] = $this->querydao->selectAll(Projeto::getClassName());
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
		$condicoes = array('funcionario.cd_cargo' => $query_servico[0]['cd_cargo']);
		$resp = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes);
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
			
			$condicoes = array(Funcionario::getChavePrimariaNomeFilho() => $cd_funcionario);
			$query_funcionario = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes, Funcionario::getJoins());
			
			// Não tiver exatamente um match significa que deu algum erro
			if (count($query_funcionario) == 1){
				$nm_funcionario = $query_funcionario[0]['nm_funcionario'];
				$vl_salario = $query_funcionario[0]['vl_salario'];
				$ds_email = $query_funcionario[0]['ds_email'];
				$cd_telefone = $query_funcionario[0]['cd_telefone'];
				$cd_celular = $query_funcionario[0]['cd_celular'];
				$dt_nascimento = $query_funcionario[0]['dt_nascimento'];
				$cd_rg = $query_funcionario[0]['cd_rg'];
				$cd_cpf = $query_funcionario[0]['cd_cpf'];
				$cd_funcionario = $query_funcionario[0]['cd_funcionario'];
				
				$cd_usuario = $query_funcionario[0]['cd_usuario'];
				$ds_email_corporacional = $query_funcionario[0]['ds_email_corporacional'];
				$cd_permissao = $query_funcionario[0]['cd_permissao'];
				$ds_hash = $query_funcionario[0]['ds_hash'];
				$ic_primeiro_acesso = $query_funcionario[0]['ic_primeiro_acesso'];
				$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
												$dt_nascimento, $cd_rg, $cd_cpf, $ds_email_corporacional, $ic_primeiro_acesso,
												$ds_hash, $cd_permissao, $cargoEscolhido, $cd_funcionario, $cd_usuario);
				
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
	
	public function edita_tarefa($cd_tarefa)
	{
		$dados['titulo'] = 'Tarefas';
		$dados['chave_primaria'] = Tarefa::getChavePrimariaNome();
		$dados['urlEdit'] = base_url().'tarefas/edita_tarefa_action';
		$dados['urlDel'] = base_url().'tarefas/delete_tarefa_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Tarefa::getChavePrimariaNome() => $cd_tarefa);
		$query = $this->querydao->selectWhere(Tarefa::getClassName(), $condicoes);
		
		if (count($query) != 1){
			echo 'não encontrado';
			die;
		}
		
		$nm_tarefa = $query[0]['nm_tarefa'];
		$ds_tarefa = $query[0]['ds_tarefa'];
		$ic_concluido = $query[0]['ic_concluido'];
		$cd_projeto = $query[0]['cd_projeto'];
		$cd_servico_escolhido = $query[0]['cd_servico'];
		$cd_funcionario = $query[0]['cd_funcionario'];
		$servicoEscolhido;
		$cargoEscolhido;
		
		$condicoes_projeto = array(Projeto::getChavePrimariaNome() => $cd_projeto);
		$query_projeto = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes_projeto);
		
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
					if ($cd_servico_escolhido == $cd_servico){
						$servicoEscolhido = end($servicos);
						$cargoEscolhido = $cargo;
					}
				}
			}
			$projeto = new Projeto($nm_projeto, $ds_projeto, $dt_inicio, $dt_termino, $cliente, $servicos, $cd_projeto);
			
			$condicoes = array(Funcionario::getChavePrimariaNomeFilho() => $cd_funcionario);
			$query_funcionario = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes, Funcionario::getJoins());
			
			// Não tiver exatamente um match significa que deu algum erro
			if (count($query_funcionario) == 1){
				$nm_funcionario = $query_funcionario[0]['nm_funcionario'];
				$vl_salario = $query_funcionario[0]['vl_salario'];
				$ds_email = $query_funcionario[0]['ds_email'];
				$cd_telefone = $query_funcionario[0]['cd_telefone'];
				$cd_celular = $query_funcionario[0]['cd_celular'];
				$dt_nascimento = $query_funcionario[0]['dt_nascimento'];
				$cd_rg = $query_funcionario[0]['cd_rg'];
				$cd_cpf = $query_funcionario[0]['cd_cpf'];
				$cd_funcionario = $query_funcionario[0]['cd_funcionario'];
				
				$cd_usuario = $query_funcionario[0]['cd_usuario'];
				$ds_email_corporacional = $query_funcionario[0]['ds_email_corporacional'];
				$cd_permissao = $query_funcionario[0]['cd_permissao'];
				$ds_hash = $query_funcionario[0]['ds_hash'];
				$ic_primeiro_acesso = $query_funcionario[0]['ic_primeiro_acesso'];
				
				$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
												$dt_nascimento, $cd_rg, $cd_cpf, $ds_email_corporacional, $ic_primeiro_acesso,
												$ds_hash, $cd_permissao, $cargoEscolhido, $cd_funcionario, $cd_usuario);
				$cargos = $this->querydao->selectAll(Cargo::getClassName());
				
			} else{
				echo 'nao encontrado'; die;
			}
			
			$tarefa = new Tarefa($nm_tarefa, $ds_tarefa, $ic_concluido, $servicoEscolhido, $projeto, $funcionario, $cd_tarefa);
			$dados['tarefa'] = $tarefa;
		} else{
			echo 'nao encontrado'; die;
		}
		
		$dados['projetos'] = $this->querydao->selectAll(Projeto::getClassName());
		$condicoes_joins = array('projeto.'.Projeto::getChavePrimariaNome() => $cd_projeto);
		$servicos = $this->querydao->selectWhere(Projeto::getClassName(), $condicoes_joins, Projeto::getAllJoins());
		
		
		$dados['clientes'] = $this->querydao->selectAll(Cliente::getClassName());
		$dados['servicos'] = $this->querydao->selectAll(Servico::getClassName());
		$dados['funcionarios'] = $this->querydao->selectAll(Funcionario::getClassNameFilho());
		$this->load->view('template/header', $dados);
		$this->load->view('painel/tarefas/tarefas_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	public function edita_tarefa_action()
	{
		$nm_tarefa = $this->input->post('nm_tarefa');
        $ds_tarefa = $this->input->post('ds_tarefa');
        $ic_concluido = $this->input->post('ic_concluido');    
		$cd_projeto = $this->input->post('cd_projeto');
		$cd_tarefa = $this->input->post('cd_tarefa');
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
			
			$condicoes = array(Funcionario::getChavePrimariaNomeFilho() => $cd_funcionario);
			$query_funcionario = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes, Funcionario::getJoins());
			
			// Não tiver exatamente um match significa que deu algum erro
			if (count($query_funcionario) == 1){
				$nm_funcionario = $query_funcionario[0]['nm_funcionario'];
				$vl_salario = $query_funcionario[0]['vl_salario'];
				$ds_email = $query_funcionario[0]['ds_email'];
				$cd_telefone = $query_funcionario[0]['cd_telefone'];
				$cd_celular = $query_funcionario[0]['cd_celular'];
				$dt_nascimento = $query_funcionario[0]['dt_nascimento'];
				$cd_rg = $query_funcionario[0]['cd_rg'];
				$cd_cpf = $query_funcionario[0]['cd_cpf'];
				$cd_funcionario = $query_funcionario[0]['cd_funcionario'];
				
				$cd_permissao = $query_funcionario[0]['cd_permissao'];
				$ds_email_corporacional = $query_funcionario[0]['ds_email_corporacional'];
				$ds_hash = $query_funcionario[0]['ds_hash'];
				$ic_primeiro_acesso = $query_funcionario[0]['ic_primeiro_acesso'];
				$cd_usuario = $query_funcionario[0]['cd_usuario'];
				
				$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
											$dt_nascimento, $cd_rg, $cd_cpf,$ds_email_corporacional, 
											$ic_primeiro_acesso, $ds_hash, $cd_permissao, $cargo, $cd_funcionario, $cd_usuario);
				$cargos = $this->querydao->selectAll(Cargo::getClassName());
			} else{
				echo 'nao encontrado'; die;
			}
			
			$tarefa = new Tarefa($nm_tarefa, $ds_tarefa, $ic_concluido, $servicoEscolhido, $projeto, $funcionario, $cd_tarefa);
			
			
			$update = $this->querydao->updateAll($tarefa);
			if ($update){
				echo true;
			} else{
				echo false;
			}
		} else{
			echo 'nao encontrado'; die;
		}
	}
	
	public function delete_tarefa_action()
	{
		$nm_tarefa = $this->input->post('nm_tarefa');
        $ds_tarefa = $this->input->post('ds_tarefa');
        $ic_concluido = $this->input->post('ic_concluido');    
		$cd_projeto = $this->input->post('cd_projeto');
		$cd_tarefa = $this->input->post('cd_tarefa');
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
			
			$condicoes = array(Funcionario::getClassNameFilho().'.'.Funcionario::getChavePrimariaNomeFilho() => $cd_funcionario);
			$query_funcionario = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes, Funcionario::getJoins());
			
			// Não tiver exatamente um match significa que deu algum erro
			if (count($query_funcionario) == 1){
				$nm_funcionario = $query_funcionario[0]['nm_funcionario'];
				$vl_salario = $query_funcionario[0]['vl_salario'];
				$ds_email = $query_funcionario[0]['ds_email'];
				$cd_telefone = $query_funcionario[0]['cd_telefone'];
				$cd_celular = $query_funcionario[0]['cd_celular'];
				$dt_nascimento = $query_funcionario[0]['dt_nascimento'];
				$cd_rg = $query_funcionario[0]['cd_rg'];
				$cd_cpf = $query_funcionario[0]['cd_cpf'];
				$cd_funcionario = $query_funcionario[0]['cd_funcionario'];
				
				$cd_permissao = $query_funcionario[0]['cd_permissao'];
				$ds_email_corporacional = $query_funcionario[0]['ds_email_corporacional'];
				$ds_hash = $query_funcionario[0]['ds_hash'];
				$ic_primeiro_acesso = $query_funcionario[0]['ic_primeiro_acesso'];
				$cd_usuario = $query_funcionario[0]['cd_usuario'];
				
				$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
											$dt_nascimento, $cd_rg, $cd_cpf,$ds_email_corporacional, 
											$ic_primeiro_acesso, $ds_hash, $cd_permissao, $cargo, $cd_funcionario, $cd_usuario);
				$cargos = $this->querydao->selectAll(Cargo::getClassName());
			} else{
				echo 'nao encontrado'; die;
			}
			
			$tarefa = new Tarefa($nm_tarefa, $ds_tarefa, $ic_concluido, $servicoEscolhido, $projeto, $funcionario, $cd_tarefa);
			
		} else{
			echo 'false';
		}
		
		
		$query = $this->querydao->remove($tarefa);
		if ($query){
			echo base_url().'tarefas';
		} else{
			echo 'false';
		}
	}
}

?>