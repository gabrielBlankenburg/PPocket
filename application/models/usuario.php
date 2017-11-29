<?php
    require_once APPPATH."models/login.php";
    abstract class Usuario implements Login{
        
        private $cd_usuario, $nm_usuario, $ds_email, $ic_ativo;
        
        public function __construct($cd_usuario, $nm_usuario, $ds_email, $ic_ativo)
        {
            $this->cd_usuario = $cd_usuario;
            $this->nm_usuario = $nm_usuario;
            $this->ds_email= $ds_email;
            $this->ic_ativo = $ic_ativo;
        }
        
        public function getAll()
        {
            $dados['cd_usuario'] = $this->cd_usuario;
            $dados['nm_usuario'] = $this->nm_usuario;
            $dados['ds_email'] = $this->ds_email;
            $dados['ic_ativo'] = $this->ic_ativo;
            
            return $dados;
        }
        
        public function getNomeUsuario()
        {
            return $this->nm_usuario;
        }
        
        public function getEmailUsuario()
        {
            return $this->ds_email;
        }
        
        public function getUsuarioAtivo()
        {
            return $this->ic_ativo;
        }
        
        // A chave primária foge do padrão porque chave primarias só podem ser adicionadas, nunca alteradas
        public function addChavePrimaria($cd_usuario)
        {
            $this->cd_usuario = $cd_usuario;
        }
        
        public function toArray()
        {
            $dados['cd_usuario'] = $this->cd_usuario;
            $dados['nm_usuario'] = $this->nm_usuario;
            $dados['ds_email'] = $this->ds_email;
            $dados['ic_ativo'] = $this->ic_ativo;
            return $dados;
        }
        
        public function getChavePrimariaValor()
        {
            return $this->cd_usuario;
        }
        
        public static function getClassName()
        {
            return 'usuario';
        }
        
        public static function getChavePrimariaNome()
        {
            return 'cd_usuario';
        }
        
        abstract public function auth();
            
    }
?>