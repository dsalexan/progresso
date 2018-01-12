<?php
    class Admin extends CI_Controller{

        public function view($page = 'home')
        {
            $pageNames = array(
                "home" => "Home",
                "conteudos" => "Conteúdos",
                "empresa" => "Empresa",
                "usuarios" => "Usuários",
                "enquetes" => "Enquetes",
                "veiculos" => "Veículos",
                "estatisticas" => "Estatísticas",
                "configuracoes" => "Configurações"
            );

            //checa se a pagina existe
            if ( ! file_exists(APPPATH.'views/admin/'.$page.'.php'))
            {   
                show_404();
            }
            
            $data['title'] = $pageNames[$page];
    
            $this->load->view('templates/admin-header', $data);
            $this->load->view('admin/'.$page, $data);
            $this->load->view('templates/admin-footer', $data);
        }

        public function login(){
            $data['title'] = 'Login';
    
            $this->load->view('templates/admin-header', $data);
            $this->load->view('admin/login', $data);
            $this->load->view('templates/admin-footer', $data);
        }
    }