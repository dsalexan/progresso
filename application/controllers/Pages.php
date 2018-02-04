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
                
            $data['bootstrap'] = true;
            $data['semantic'] = [
                    'css' => [],
                    'js' => []
                ]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
            $data['assets'] = [
                'css' => [
                    'font-awesome.min.css', 'search.css'
                ],
                'js' => [
                    'tether.min.js',
                    'search.js'
                ]];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/common-header', $data);
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/common-footer', $data);
            $this->load->view('templates/footer', $data);
        }
    }