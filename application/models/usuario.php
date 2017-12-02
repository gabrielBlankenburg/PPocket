<?php
    require_once APPPATH."models/login.php";
    require_once APPPATH."models/funcionario.php";
    class Usuario extends SignIn{
        
        public function __construct($ds_email, $ic_ativo, $cd_usuario)
        {
            parent::__construct($ds_email, $ic_ativo, $cd_usuario);
        }
        
        public function getAll()
        {
            $dados['cd_usuario'] = $this->cd_usuario;
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
        
        
        public static function getJoins()
        {
           $joins = array('tabela_nome' => Funcionario::getClassName(),
                        'on' => 'usuario.cd_usuario = '.Funcionario::getClassName().'.cd_usuario');
            return array($joins); 
        }
        
        // Arrumar
        public function getAuth()
        {
            return true;
        }
            
    }
?>