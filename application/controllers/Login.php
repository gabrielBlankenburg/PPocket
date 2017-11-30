<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();
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
		
	    $login = $this->input->post("email");// pega via post o email do formulario
        $senha = $this->input->post("senha"); // pega via post a senha do formulario
        $usuario = $this->querydao->buscaPorEmailSenha($login,$senha); // acessa a função buscaPorEmailSenha do modelo
 
        if($usuario){
            $this->session->set_userdata("usuario_logado", $usuario);
            $dados['msg_logado'] = "Logado com sucesso!";
            redirect('painel', $dados);
        }else{
            $dados['msg_erro'] = "Não foi possível fazer o Login!";
            redirect('login', $dados);
        }
        
    }
}
