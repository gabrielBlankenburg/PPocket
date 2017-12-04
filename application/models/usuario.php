<?php
    require_once APPPATH."models/funcionario.php";
    require_once APPPATH."models/serializable.php";
    class Usuario implements serializablee
    {
        
        private $cd_usuario, $ds_email_corporacional, $ic_primeiro_acesso, $ds_hash, $cd_permissao;
        public function __construct($ds_email_corporacional, $ic_primeiro_acesso, $ds_hash, $cd_permissao, $cd_usuario = null)
        {
            $this->cd_usuario = $cd_usuario;
            $this->ds_email_corporacional = $ds_email_corporacional;
            $this->ds_hash = $ds_hash;
            $this->ic_primeiro_acesso = $ic_primeiro_acesso;
            $this->cd_permissao = $cd_permissao;
        }
        
        public function getAll()
        {
            $dados['cd_usuario'] = $this->cd_usuario;
            $dados['ds_email_corporacional'] = $this->ds_email_corporacional;
            $dados['ic_primeiro_acesso'] = $this->ic_primeiro_acesso;
            $dados['cd_permissao'] = $this->cd_permissao;
            
            return $dados;
        }
        
        public function getChavePrimariaValor()
        {
            return $this->cd_usuario;
        }
        
        public function getEmailUsuario()
        {
            return $this->ds_email_corporacional;
        }
        
        public function getPrimeiroAcesso()
        {
            return $this->ic_primeiro_acesso;
        }
        
        // A chave primária foge do padrão porque chave primarias só podem ser adicionadas, nunca alteradas
        public function addChavePrimariaPai($cd_usuario)
        {
            $this->cd_usuario = $cd_usuario;
        }
        
        public function toArray()
        {
            $dados['cd_usuario'] = $this->cd_usuario;
            $dados['ds_email_corporacional'] = $this->ds_email_corporacional;
            $dados['ds_hash'] = $this->ds_hash;
            $dados['ic_primeiro_acesso'] = $this->ic_primeiro_acesso;
            $dados['cd_permissao'] = $this->cd_permissao;
            return $dados;
        }
        
        public static function getClassName()
        {
            return 'usuario';
        }
        
        public static function getChavePrimariaNome()
        {
            return 'cd_usuario';
        }
        
        public function getHash()
        {
            return $this->ds_hash;
        }
        
        
        public static function getJoins()
        {
           $joins = array('tabela_nome' => Funcionario::getClassName(),
                        'on' => 'usuario.cd_usuario = '.Funcionario::getClassName().'.cd_usuario');
            return array($joins); 
        }
        
        public function getPermissao()
        {
            return $this->cd_permissao;
        }
            
    }
?>