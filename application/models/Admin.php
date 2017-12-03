<?php

class Admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function cria()
    {
        $this->load->helper('salt_generator_helper');
        $senha = 123;
        $salt =  gera_salt(20);
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $this->db->insert('usuario', array('ds_email' => 'admin@empresa.com', 'ds_hash' => $hash, 'ds_salt' => $salt, 'ic_ativo' => 1));
    }
}