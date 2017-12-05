<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use Mailgun\Mailgun;
$mailgun = new Mailgun('api_key', new \Http\Adapter\Guzzle6\Client());

class Funcionarios extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/cargo.php';
		require_once APPPATH.'models/funcionario.php';
		require_once APPPATH.'models/usuario.php';
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
		}
		
	}
	
	// Para a view, carrega também a lista de todos os cargos para poder mostrar na tag <select>
	public function index()
	{
		// Os dados pro view
		$dados['titulo'] = 'Funcionários';
		$dados['query'] = $this->querydao->selectAll(Funcionario::getClassNameFilho(), Funcionario::getJoins());
		$dados['cargos'] = $this->querydao->selectAll(Cargo::getClassName());
		$dados['url'] = base_url().'funcionarios/cadastra_funcionario_action';
		
		// Carrega a view
		$this->load->view('template/header', $dados);
		$this->load->view('painel/funcionarios/funcionarios_listar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	// Para cadastrar um funcionário, é necessário um cargo, então é feito um select no cargo específico, criado uma
	// instância de cargo, depois insere essa instância no construtor de funcionário junto com os outros parâmetros
	public function cadastra_funcionario_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$nm_funcionario = $this->input->post('nm_funcionario');
        $cd_telefone = $this->input->post('cd_telefone');
        $cd_celular = $this->input->post('cd_celular');
        $ds_email = $this->input->post('ds_email');
        $data = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_nascimento'));
        $dt_nascimento = $data->format('Y-m-d');
        $vl_salario = $this->input->post('vl_salario');
        $cd_rg = $this->input->post('cd_rg');
        $cd_cpf = $this->input->post('cd_cpf');
        
        $ds_email_corporacional = $this->input->post('ds_email_corporacional');
        $cd_permissao = $this->input->post('cd_permissao');
        
        // Carrega o gerador de string para gerar a senha aleatória
        $this->load->helper('gerador_senha');
        $senha = gera_senha(30);
        // $senha = '123';
        $ds_hash = password_hash($senha, PASSWORD_BCRYPT);
        
        $mgClient = new Mailgun($this->config->item('key_mail'));
		$domain = $this->config->item('domain_mail');
        
		
		// Verifica se existe um cargo com o cd_cargo informado
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$nm_cargo = $query[0]['nm_cargo'];
			$cd_cargo = $query[0]['cd_cargo'];
			$cargo = new Cargo($nm_cargo, $cd_cargo);
		} else{
			echo 'nao encontrado'; die;
		}
		//Dúvida - Se não existir, é criado automaticamente?
		$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular, 
										$dt_nascimento, $cd_rg, $cd_cpf, $ds_email_corporacional, 1,
										$ds_hash, $cd_permissao, $cargo);
		
		$insert = $this->querydao->insert($funcionario);
		if ($insert != false){
			$funcionario->addChavePrimaria($insert->cd_funcionario);
		} else{
			echo false;
		}
		$html = '<h1>Olá '.$funcionario->getNomeFuncionario().'</h1>';
		$html .= '<br><br> Para logar no <strong>PPocket</strong> basta entrar com seu email'.
					$funcionario->getEmailUsuario().' e a senha temporária: '.$senha.' .';
		$html .= '<br> <strong>Lembre-se de trocar a senha assim que logar.</strong>';
		$html .= '<br><br> Equipe PPocket.';
		$result = $mgClient->sendMessage("$domain",
		array('from'    => $this->config->item('from_mail'),
		    'to'      => 'gabriel <gabriel.blankenburg.p.silva@gmail.com>',
		    'subject' => 'Hello gabriel',
		    'html'    => $html));
		$retorno = $funcionario->getAll();
		echo json_encode($retorno, JSON_UNESCAPED_SLASHES);
	}
	
	public function edita_funcionario($cd_funcionario)
	{
		$dados['titulo'] = 'Funcionario';
		$dados['urlEdit'] = base_url().'funcionarios/edita_funcionario_action';
		$dados['urlDel'] = base_url().'funcionarios/delete_funcionario_action';
		
		// Cria uma condição para pegar a chave primaria igual ao do parametro passado
		$condicoes = array(Funcionario::getChavePrimariaNomeFilho() => $cd_funcionario);
		$query = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoes, Funcionario::getJoins());
		
		// Não tiver exatamente um match significa que deu algum erro
		if (count($query) == 1){
			$cargo = new Cargo($query[0]['nm_cargo'], $query[0]['cd_cargo']);
			$nm_funcionario = $query[0]['nm_funcionario'];
			$vl_salario = $query[0]['vl_salario'];
			$ds_email = $query[0]['ds_email'];
			$cd_telefone = $query[0]['cd_telefone'];
			$cd_celular = $query[0]['cd_celular'];
			$dt_nascimento = $query[0]['dt_nascimento'];
			$cd_rg = $query[0]['cd_rg'];
			$cd_cpf = $query[0]['cd_cpf'];
			$cd_funcionario = $query[0]['cd_funcionario'];
			$cd_permissao = $query[0]['cd_permissao'];
			$ds_email_corporacional = $query[0]['ds_email_corporacional'];
			$ds_hash = $query[0]['ds_hash'];
			$ic_primeiro_acesso = $query[0]['ic_primeiro_acesso'];
			$cd_usuario = $query[0]['cd_usuario'];
			
			$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular,
											$dt_nascimento, $cd_rg, $cd_cpf,$ds_email_corporacional, 
											$ic_primeiro_acesso, $ds_hash, $cd_permissao, $cargo, $cd_funcionario, $cd_usuario);
			$cargos = $this->querydao->selectAll(Cargo::getClassName());
			
			
		} else{
			echo 'nao encontrado'; die;
		}
		$dados['cargos'] = $cargos;
		$dados['funcionario'] = $funcionario;
		$this->load->view('template/header', $dados);
		$this->load->view('painel/funcionarios/funcionarios_editar', $dados);
		$this->load->view('template/footer', $dados);
	}
	
	// Quando vai editar um funcionário, cria primeiro uma instância de cargo, e depois uma instância de funcionário
	// e então é atualizado o funcionário
	public function edita_funcionario_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$cd_funcionario = $this->input->post('cd_funcionario');
		$nm_funcionario = $this->input->post('nm_funcionario');
        $cd_telefone = $this->input->post('cd_telefone');
        $cd_celular = $this->input->post('cd_celular');
        $ds_email = $this->input->post('ds_email');
        $data = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_nascimento'));
        $dt_nascimento = $data->format('Y-m-d');
        $vl_salario = $this->input->post('vl_salario');
        $cd_rg = $this->input->post('cd_rg');
        $cd_cpf = $this->input->post('cd_cpf');
        
        $cd_usuario = $this->input->post('cd_usuario');
        $ds_email_corporacional = $this->input->post('ds_email_corporacional');
        $cd_permissao = $this->input->post('cd_permissao');
        $ic_primeiro_acesso = $this->input->post('ic_primeiro_acesso');
        $ds_hash = $this->input->post('ds_hash');
        
		
		// Busca o cargo
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		// Se o número de colunas for igual a 1, cria uma instancia de cargo com o cargo modificado (ou não)
		if (count($query) == 1){
			$cargo = new Cargo($query[0]['nm_cargo'], $query[0]['cd_cargo']);
			
			$condicoes = array(Funcionario::getChavePrimariaNome() => $cd_funcionario);
			$query = $this->querydao->selectWhere(Funcionario::getClassName(), $condicoes);
			
			$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular, 
										$dt_nascimento, $cd_rg, $cd_cpf, $ds_email_corporacional, $ic_primeiro_acesso, 
										$ds_hash, $cd_permissao, $cargo, $cd_funcionario, $cd_usuario);
		}
		
		
		$query = $this->querydao->updateAll($funcionario);
		echo json_encode($query);
	}
	
	// Cria uma instância de cargo, depois uma instância de funcionário passando a instancia de cargo como parametro, 
	// e a partir disso deleta o funcionário
	public function delete_funcionario_action()
	{
		$cd_cargo = $this->input->post('cd_cargo');
		$cd_funcionario = $this->input->post('cd_funcionario');
		$nm_funcionario = $this->input->post('nm_funcionario');
        $cd_telefone = $this->input->post('cd_telefone');
        $cd_celular = $this->input->post('cd_celular');
        $ds_email = $this->input->post('ds_email');
        $data = DateTime::createFromFormat('d/m/Y', $this->input->post('dt_nascimento'));
        $dt_nascimento = $data->format('Y-m-d');
        $vl_salario = $this->input->post('vl_salario');
        $cd_rg = $this->input->post('cd_rg');
        $cd_cpf = $this->input->post('cd_cpf');
        
        $cd_usuario = $this->input->post('cd_usuario');
        $ds_email_corporacional = $this->input->post('ds_email_corporacional');
        $cd_permissao = $this->input->post('cd_permissao');
        $ic_primeiro_acesso = $this->input->post('ic_primeiro_acesso');
        $ds_hash = $this->input->post('ds_hash');
		
		$condicoes = array(Cargo::getChavePrimariaNome() => $cd_cargo);
		$query = $this->querydao->selectWhere(Cargo::getClassName(), $condicoes);
		
		$cargo = new Cargo($query[0]['nm_cargo'], $query[0]['cd_cargo']);
		
		$funcionario = new Funcionario($nm_funcionario, $vl_salario, $ds_email, $cd_telefone, $cd_celular, 
										$dt_nascimento, $cd_rg, $cd_cpf, $ds_email_corporacional, $ic_primeiro_acesso, 
										$ds_hash, $cd_permissao, $cargo, $cd_funcionario, $cd_usuario);
		
		$query = $this->querydao->remove($funcionario);
		if ($query){
			echo base_url().'funcionarios';
		} else{
			echo 'false';
		}
	}
}
