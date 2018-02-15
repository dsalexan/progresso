<?php
    class Pages extends CI_Controller{

        public function view($page = 'home'){
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

                $ids = $this->veiculos_model->get_destaques();
                $destaques = array();
                foreach($ids as $id_veiculo){
                    $destaques[] = $this->veiculos_model->get_veiculo_display($id_veiculo['id_veiculo']);
                }

    
                $ids = $this->veiculos_model->get_id_veiculo_por_pagina_sem_tipo($qtd_por_pagina, 1);
                if($ids == []) $this->session->set_flashdata('no_results', 'Não possuímos veículos desse tipo registrados.');
    
                $veiculos = array();
                foreach($ids as $id_veiculo){
                    $veiculos[] = $this->veiculos_model->get_veiculo_display($id_veiculo['id_veiculo']);
                }

                $data['query'] = "Destaques";
                $data['destaques'] = $destaques;
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
                        'statistic.min.css',
                        'transition.min.css',
                        'dropdown.min.css',
                        'input.min.css',
                        'menu.min.css',
                        'item.min.css',
                        'search.min.css',
                        'loader.min.css',
                        'header.min.css',
                        'label.min.css'
                    ],
                    'js' => [
                        'site.min.js', 
                        'dimmer.min.js',
                        'transition.min.js',
                        'dropdown.min.js'
                    ]
                    ]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
                $data['assets'] = [
                    'css' => [
                        'font-awesome.min.css', 
                        'search.css',
                        'display.css',
                        'home-templace.css'
                    ],
                    'js' => [
                        'tether.min.js',
                        'search.js',
                        'display.js',
                        
                    ]];

                $this->load->view('templates/header', $data);
                $this->load->view('templates/common-header', $data);
                $this->load->view('pages/home', $data);
                $this->load->view('templates/common-footer', $data);
                $this->load->view('templates/footer', $data);
            }else{
                $config = $this->config_model->get_config();
                
                $data['config'] = $config;
                    
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
                        'statistic.min.css',
                        'transition.min.css',
                        'dropdown.min.css',
                        'input.min.css',
                        'menu.min.css',
                        'item.min.css',
                        'search.min.css',
                        'loader.min.css',
                        'form.min.css',
                        'message.min.css',
                        'image.min.css'
                    ],
                    'js' => [
                        'site.min.js', 
                        'dimmer.min.js',
                        'transition.min.js',
                        'dropdown.min.js',
                        'form.min.js'
                    ]
                    ]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
                $data['assets'] = [
                    'css' => [
                        'font-awesome.min.css', 
                        'search.css',
                        'display.css',
                        'home-templace.css',
                        'contato.css'
                    ],
                    'js' => [
                        'tether.min.js',
                        'search.js',
                        'display.js',
                        'contato.js'
                    ]];

                $this->load->view('templates/header', $data);
                $this->load->view('templates/common-header', $data);
                $this->load->view('pages/contato', $data);
                $this->load->view('templates/common-footer', $data);
                $this->load->view('templates/footer', $data);
            }
        }

        public function mail(){
            // Carrega a library email
            $this->load->library('email');
            //Recupera os dados do formulário
            $email = $this->config_model->get_email();
            $dados = $this->input->post();
            
            //Inicia o processo de configuração para o envio do email
            $config['protocol'] = 'mail'; // define o protocolo utilizado
            $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
            $config['validate'] = TRUE; // define se haverá validação dos endereços de email
            
            /*
            * Se o usuário escolheu o envio com template, define o 'mailtype' para html, 
            * caso contrário usa text
            */
            $config['mailtype'] = 'text';
    
            // Inicializa a library Email, passando os parâmetros de configuração
            $this->email->initialize($config);
            
            // Define remetente e destinatário
            $this->email->from($dados['email'],$dados['nome']); // Remetente
            $this->email->to($email,'Progresso Veículos'); // Destinatário
    
            // Define o assunto do email
            $this->email->subject('[Contato] '.$dados['assunto']);
    
            /*
            * Se o usuário escolheu o envio com template, passa o conteúdo do template para a mensagem
            * caso contrário passa somente o conteúdo do campo 'mensagem'
            */
            $this->email->message($dados['mensagem']);
            
    
            /*
            * Se o envio foi feito com sucesso, define a mensagem de sucesso
            * caso contrário define a mensagem de erro, e carrega a view home
            */
            if($this->email->send())
            {
                echo "ok";
            }
            else
            {
                echo $this->email->print_debugger();
            }
        }

        public function test(){
            $result = $this->veiculos_model->get_marcas(false);
            echo '<pre>'; echo $result = json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
        }
    }