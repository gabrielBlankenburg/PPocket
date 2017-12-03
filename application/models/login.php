<?php
    require_once APPPATH.'models/serializable.php';
    abstract class SignIn implements Serializablee{
        private $cd_usuario, $ds_email, $ic_ativo;
        
        public function __construct($ds_email, $ic_ativo, $cd_usuario = null)
        {
            $this->cd_usuario = $cd_usuario;
            $this->ds_email = $ds_email;
            $this->ic_ativo = $ic_ativo;
        }
        
        public function getChavePrimariaValor()
        {
            return $this->cd_usuario;
        }
        
        public abstract function getAuth();
    }
?>