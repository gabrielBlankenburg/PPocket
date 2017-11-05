<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		require_once APPPATH.'models/projeto.php';
		require_once APPPATH.'models/cliente.php';
		require_once APPPATH.'models/cargo.php';
		require_once APPPATH.'models/funcionario.php';
		require_once APPPATH.'models/servico.php';
		require_once APPPATH.'models/tarefa.php';
		$this->load->model('insertdao');
		
	}
	
	public function teste()
	{
		$cliente = new Cliente(1, 'teste empresa', '1234', 'teste nome', 'responsavel@teste.com', '1234555', 'empresa@teste.com', '3333333');
		$cargo = new Cargo(1, 'back end', 'programador back end');
		$funcionario = new Funcionario(1, 'teste', 300, 'funcionario@email.com', '333333', 'endereco teste', $cargo);
		$servico = new Servico(1, 'loja virtual', 'criação e manutenção de uma loja virtual', 3000, $cargo);
		$projeto = new Projeto(1, $cliente, 'loja', 'loja virtual teste', 3000, '19-02-2018');
		$tarefa = new Tarefa(1, 'precos', 'preco da lojinha', $servico, $projeto, $cliente, $funcionario);
		
		$projeto->adicionaTarefa($tarefa);
		print_r($projeto); die;
		
		
	}
	
	public function projetos()
	{
		// Os dados pro view
		$data['titulo'] = 'Projetos';
		$data['pagina'] = 'painel/projetos';
		
		
		$array = array(array('nome' => 'gabriel'), array('nome' => 'ale'));
		
		$dado['id'] = 0;
		$dado['id_cliente'] = 1;
		$dado['preco'] = 430;
        $dado['dt_entrega'] = '12-02-2009';
        $dado['descricao'] = 'apenas teste';
        $dado['nome'] = 'teste';
        $dado['servicos'] = $array;
		
		$cliente = new Projeto((object) $dado);
		$this->load->model('insertdao');
		$this->insertdao->insert($cliente);
		
		// Carrega a view
		$this->load->view('base', $data);
	}
	
	public function clientes()
	{
		// Os dados pro view
		$data['titulo'] = 'Clientes';
		$data['pagina'] = 'painel/clientes';
		
		$dado['id'] = 0;
		$dado['nome_fantasma'] = 'Teste SA';
		$dado['cnpj'] = '333.333.333.333';
        $dado['nome_responsavel'] = 'responsavel teste';
        $dado['email_responsavel'] = 'responsavel@email.com';
        $dado['telefone_responsavel'] = 333333333;
        $dado['email_empresa'] = 'empresa@email.com';
        $dado['telefone_empresa'] = 222222222;
		
		$cliente = new Cliente((object) $dado);
		$this->load->model('insertdao');
		$this->insertdao->insert($cliente);
		
		// Carrega a view
		$this->load->view('base', $data);
	}
	
	public function serviços()
	{
		// Os dados pro view
		$data['titulo'] = 'Serviços';
		$data['pagina'] = 'painel/serviços';
		
		// Carrega a view
		$this->load->view('base', $data);
	}
}
