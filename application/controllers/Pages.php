<?php
    class Pages extends CI_Controller{

        public function view($page = 'home')
        {
            $pageNames = array(
                "home" => "Home",
                "quem-somos" => "Quem Somos",
                "contato" => "Contato"
            );

            //checa se a pagina existe
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {   
                show_404();
            }
            
            $data['title'] = $pageNames[$page];
    
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
    }