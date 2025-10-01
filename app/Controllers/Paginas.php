<?php
class Paginas extends Controllers{
    public function sobre(){
          $this->view('paginas/sobre');
    }//fim do método sobre

    public function index(){
        $this->view('paginas/home');
    }//fim da função index
    public function contato(){
        
    }
    public function postos() {
        $this->view('paginas/postos');
    }
    public function emergencia() {
        $this->view('paginas/emergencia');
    }
    public function suporte() {
        $this->view('paginas/suporte');
    }
    public function saude() {
        $this->view('paginas/saude');
    }
    public function perfil() {
        $this->view('paginas/perfil');
    }
    public function loginPrincipal() {
        $this->view('usuarios/loginPrincipal');
    }
}//fim da classe Paginas