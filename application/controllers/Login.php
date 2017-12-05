<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();
		require_once APPPATH.'models/funcionario.php';
		require_once APPPATH.'models/usuario.php';
		$this->load->model('querydao');
	}
	
	public function index()
	{
		$dados['titulo'] = 'Login | PPocket';
		$dados['descricao'] = 'lorem ipsum';
		$dados['url'] = base_url().'login/';
	
		if(isset($this->session->userdata['usuario_logado'])) {
			redirect('painel', $dados);
		} else {
			$this->load->view('painel/login', $dados);
			$this->load->view('template/footer', $dados);
		}
	}
	
	public function autenticar(){
	    $email = $this->input->post("email");// pega via post o email do formulario
        $senha = $this->input->post("senha"); // pega via post a senha do formulario
        $condicoes = array('usuario.ds_email_corporacional' => $email);
        $query = $this->querydao->selectWhere(Usuario::getClassName(), $condicoes); // acessa a função buscaPorEmailSenha do modelo
		
        if (isset($query) && !empty($query)){
        	// Verifica se batem login e senha
	        if (password_verify($senha, $query[0]['ds_hash'])){
	        	$usuario = new Usuario($query[0]['ds_email_corporacional'], $query[0]['ic_primeiro_acesso'], $query[0]['ds_hash'],
	        	$query[0]['cd_permissao'], $query[0]['cd_usuario']);
	        	// Busca o funcionário
	        	$condicoesFuncionario = array('usuario.cd_usuario' => $usuario->getChavePrimariaValor());
	        	$queryFuncionario = $this->querydao->selectWhere(Funcionario::getClassNameFilho(), $condicoesFuncionario, 
	        														Funcionario::getJoins());
	        	
	        	if (isset($queryFuncionario) && !empty($queryFuncionario)){
	        		// Cria uma instância do cargo
	        		$cargo = new Cargo($queryFuncionario[0]['nm_cargo'], $queryFuncionario[0]['cd_cargo']);
	        		// Cria uma instância de funcionário
	        		$funcionario = new Funcionario($queryFuncionario[0]['nm_funcionario'], $queryFuncionario[0]['vl_salario'],
	        										$queryFuncionario[0]['ds_email'], $queryFuncionario[0]['cd_telefone'],
	        										$queryFuncionario[0]['cd_celular'], $queryFuncionario[0]['dt_nascimento'],
	        										$queryFuncionario[0]['cd_rg'], $queryFuncionario[0]['cd_cpf'], 
	        										$query[0]['ds_email_corporacional'], $query[0]['ic_primeiro_acesso'],
	        										$query[0]['ds_hash'], $query[0]['cd_permissao'], $cargo, 
	        										$queryFuncionario[0]['cd_funcionario'], $query[0]['cd_usuario']);
	        		if (isset($funcionario)){
	        			// Cria uma session com o usuario e funcionário
	        			$session_data = array(
	        				'cd_funcionario' => $funcionario->getChavePrimariaValorFilho(),
	        				'cd_permissao' => $funcionario->getPermissao(),
	        				'nm_funcionario' => $funcionario->getNomeFuncionario(),
	        				'logado' => true);
	        			$this->session->set_userdata($session_data);
	        			if ($funcionario->getPermissao() == 1 || $funcionario->getPermissao() == 2){
	        				redirect('/tarefas/', 'refresh');
	        			} else if ($funcionario->getPermissao() == 3 || $funcionario->getPermissao() == 5){
	        				redirect('/projetos/', 'refresh');
	        			} else if ($funcionario->getPermissao() == 5){
	        				redirect('/funcionarios/', 'refresh');
	        			} else{
	        				$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
												  <strong>Erro!</strong> Ocorreu um erro no sistema, 
												  tente novamente mais tarde</div>');
	        				redirect('/login/', 'refresh');
	        			}
	        			
	        		} else{
	        			$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
												  <strong>Erro!</strong> Ocorreu um erro no sistema, 
												  tente novamente mais tarde</div>');
	        			redirect('/login/', 'refresh');
	        		} 
	        		
	        	} else{
	        		$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
												  <strong>Erro!</strong> Ocorreu um erro no sistema, 
												  tente novamente mais tarde</div>');
        			redirect('/login/', 'refresh');
        		}
	        } else{
	        	$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
												  <strong>Falha!</strong> Usuario ou senha inválido. </div>');
    			redirect('/login/', 'refresh');
    		}	
        } else{
        	$this->session->set_flashdata('autenticacao', '<div class="alert alert-danger">
												  <strong>Falha!</strong> Usuario ou senha inválido. </div>');
        	redirect('/login/', 'refresh');
        }
        
    }
    
    public function criaAdmin()
    {
    	$this->load->model('admin');
    	$this->admin->cria();
    }
}
