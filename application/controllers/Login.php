<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();
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
        $condicoes = array('usuario.ds_email' => $email);
        $query = $this->querydao->selectWhere(Usuario::getClassName(), $condicoes, Usuario::getJoins()); // acessa a função buscaPorEmailSenha do modelo
		echo password_hash('PgBjpq9y048D5mXgJqKq123', PASSWORD_BCRYPT); die;
        if (isset($query) && !empty($query)){
        	// Verifica se batem login e senha
	        $verificacaoSenha = password_hash($query[0]['ds_salt'].$senha, PASSWORD_BCRYPT);
	        if (strcmp($verificacaoSenha, $query[0]['ds_hash']) == 0){
	        	echo 'oi';
	        	$usuario = new Usuario($query->ds_email, $query->ic_ativo, $query->cd_usuario);
	        	// Busca o funcionário
	        	$condicoesFuncionario = array($cd_usuario => $usuario->getChavePrimariaValor());
	        	$queryFuncionario = $this->querydao->selectWhere(Funcionario::getClassName, $condicoesFuncionario, 
	        														Funcionario::getJoins());
	        	
	        	if (isset($queryFuncionario) && !empty($queryFuncionario)){
	        		// Cria uma instância do cargo
	        		$cargo = new Cargo($queryFuncionario->nm_cargo, $queryFuncionario->cd_cargo);
	        		// Cria uma instância de funcionário
	        		$funcionario = new Funcionario($queryFuncionario->nm_funcionario, $queryFuncionario->vl_salario,
	        										$queryFuncionario->ds_email, $queryFuncionario->cd_telefone,
	        										$queryFuncionario->cd_celular, $queryFuncionario->dt_nascimento,
	        										$queryFuncionario->cd_rg, $queryFuncionario->cd_cpf, 
	        										$cargo, $queryFuncionario->cd_funcionario);
	        		print_r($funcrionario); die;
	        	}
	        }	
        }
        
        
        // if($usuario){
        //     $this->session->set_userdata("usuario_logado", $usuario);
        //     $dados['msg_logado'] = "Logado com sucesso!";
        //     redirect('painel', $dados);
        // }else{
        //     $dados['msg_erro'] = "Não foi possível fazer o Login!";
        //     redirect('login', $dados);
        // }
        
    }
    
    public function criaAdmin()
    {
    	$this->load->model('admin');
    	$this->admin->cria();
    }
}
