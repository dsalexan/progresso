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
                
            if($page == 'home'){
                $qtd_por_pagina = 50; //a quantidade de veiculos por pagina é alterada por meio de um post para [url_tipo]/page/[num_page/]
                if($this->input->post('qtd_por_pagina')) $qtd_por_pagina = $this->input->post('qtd_por_pagina');
    
                $ids = $this->veiculos_model->get_id_veiculo_por_pagina_sem_tipo($qtd_por_pagina, 1);
                if($ids == []) $this->session->set_flashdata('no_results', 'Não possuímos veículos desse tipo registrados.');
    
                $veiculos = array();
                foreach($ids as $id_veiculo){
                    $veiculos[] = $this->veiculos_model->get_veiculo_display($id_veiculo['id_veiculo']);
                }

                $data['query'] = "Destaques";
                $data['results'] = $veiculos;
                    
                $data['bootstrap'] = true;
                $data['semantic'] = [
                    'css' => [
                        'site.min.css', 
                        'reset.min.css', 
                        'container.min.css', 
                        'dimmer.min.css', 
                        'card.min.css',
                        'image.min.css',
                        'reveal.min.css',
                        'icon.min.css',
                        'label.min.css',
                        'message.min.css',
                        'button.min.css',
                        'segment.min.css',
                        'divider.min.css',
                        'grid.min.css',
                        'statistic.min.css'
                    ],
                    'js' => [
                        'site.min.js', 
                        'dimmer.min.js',
                    ]
                    ]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
                $data['assets'] = [
                    'css' => [
                        'font-awesome.min.css', 
                        'search.css',
                        'display.css'
                    ],
                    'js' => [
                        'tether.min.js',
                        'search.js',
                        'display.js'
                    ]];

                $this->load->view('templates/header', $data);
                $this->load->view('templates/common-header', $data);
                $this->load->view('veiculos/show', $data);
                $this->load->view('templates/common-footer', $data);
                $this->load->view('templates/footer', $data);
            }else{

            }
        }
    }