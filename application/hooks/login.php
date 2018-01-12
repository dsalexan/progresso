<?php 

function is_logged() {
    $ci = & get_instance();//Instância do CodeIgniter
    $controller = $ci->router->fetch_class();
    $method = $ci->router->fetch_class().'/'.$ci->router->fetch_method();//Método atual

    $protegidos = ['admin'];//metodos ou controles protegidos
    $livres = ['admin/login']; // metodos ou controles específicos que não precisam ser protegidos

    $usuario_logado = $ci->session->userdata('logged_user');//Array gerado pelo seu algotitmo de "login" e gravado na SESSION

    if(!in_array($method, $livres) and !in_array($controller, $livres)){
        if (in_array($method, $protegidos) or in_array($controller, $protegidos)) {//Verificando se o método ou controle é protegido
            if(!isset($usuario_logado)){
                $ci->session->set_flashdata('forbidden_access', 'Somente usuários autenticados podem acessar essa seção. Por favor, entre com suas credenciais:');
                redirect(base_url('admin/login'));
            }
        }
    }
}
