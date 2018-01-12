<?php
    class Veiculos extends CI_Controller{

        public function show($tipo = 'carros')
        {
            //checa se a pagina existe
            if ($tipo != 'carros' and $tipo != 'motos')
            {   
                show_404();
            }
            
            $data['title'] = ucfirst($tipo);
    
            $this->load->view('templates/header', $data);
            $this->load->view('veiculos/show', $data);
            $this->load->view('templates/footer', $data);
        }
    }