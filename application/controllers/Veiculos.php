<?php
    class Veiculos extends CI_Controller{

        public function show($tipo){
            $tipos = $this->veiculos_model->get_tipos_url();

            //checa se a pagina existe
            $_404 = TRUE;
            $id_tipo = 0;
            foreach($tipos as &$row){
                if($row['url'] == $tipo){
                    $id_tipo = $row['id_tipo'];
                    $nome_plural = $row['nome_plural'];
                    $_404 = FALSE;
                    break;
                }
            }

            if ($_404) show_404();
            
            $data['title'] = $nome_plural;
            $data['destaques'] = $this->veiculos_model->get_veiculos_destaque($id_tipo, 1);
            $data['veiculos'] = $this->veiculos_model->get_veiculos_destaque($id_tipo, 0);
                
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


            //echo '<pre>'; print_r($data['veiculos']); echo '</pre>';
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/common-header', $data);
            $this->load->view('veiculos/show', $data);
            $this->load->view('templates/common-footer', $data);
            $this->load->view('templates/footer', $data);
        }

        public function page($id_tipo, $numero_pagina){
            $qtd_por_pagina = 10; //a quantidade de veiculos por pagina é alterada por meio de um post para [url_tipo]/page/[num_page/]
            if($this->input->post('qtd_por_pagina')) $qtd_por_pagina = $this->input->post('qtd_por_pagina');

            $data = $this->veiculos_model->get_veiculos_por_pagina($id_tipo, $qtd_por_pagina, $numero_pagina);
            echo '<pre>'; echo json_encode($data, JSON_PRETTY_PRINT); echo '</pre>';

        }

        public function marca($id_tipo, $id_marca){
            $marca = $this->veiculos_model->get_marca($id_marca);

            if($marca == null) show_404();

            $ids = $this->veiculos_model->get_ids_veiculo_por_marca($id_tipo, $id_marca);
            if($ids == []) $this->session->set_flashdata('no_results', 'Essa marca não possui veículos registrados.');

            $veiculos = array();
            foreach($ids as $id_veiculo){
                $veiculos[] = $this->veiculos_model->get_veiculo_display($id_veiculo['id_veiculo']);
            }


            $data['title'] = "Marca";
            $data['query'] = $marca['nome'];
            $data['results'] = $veiculos;

            $this->view_veiculos_display($data);
        }

        public function search($mode=false){
            $search = $this->input->get('q');
            $type = $this->input->get('type');

            // PREPARAR FILTRO DE PESQUISA
            $id_marca = (null !== $this->input->get('marca')) ? $this->input->get('marca') : null;
            $id_modelo = (null !== $this->input->get('modelo')) ? $this->input->get('modelo') : null;
            $id_tipo = (null !== $this->input->get('tipo')) ? $this->input->get('tipo') : null;
            $min_valor = (null !== $this->input->get('min_valor')) ? $this->input->get('min_valor') : null;
            $max_valor = (null !== $this->input->get('max_valor')) ? $this->input->get('max_valor') : null;

            $filtro = [];
            if(isset($id_marca)) $filtro['id_marca'] = $id_marca;
            if(isset($id_modelo)) $filtro['id_modelo'] = $id_modelo;
            if(isset($id_tipo)) $filtro['id_tipo'] = $id_tipo;
            if(isset($min_valor) or isset($max_valor)){
                $filtro['valor'] = [null, null];
                if(isset($min_valor)) $filtro['valor'][0] = $min_valor;
                if(isset($max_valor)) $filtro['valor'][1] = $max_valor;
            }
            if($filtro == array()) $filtro = false;
            // $filtro = false;
            

            $result = '';

            if($mode == 'json'){
                if($type == 'c') {

                    $result = json_encode($this->veiculos_model->auto_complete($search), JSON_UNESCAPED_UNICODE);
                    // $result = json_encode($this->veiculos_model->$function($search), JSON_PRETTY_PRINT);
                }else{
                    $documents = $this->veiculos_model->pesquisar_termo($search);

                    $veiculos = [];
                    if($documents['searchfound'] > 0){
                        foreach($documents['ids'] as $id_veiculo){
                            if($this->veiculos_model->crosscheck_veiculo_filtro($id_veiculo['_id'], $filtro))
                                $veiculos[] = $this->veiculos_model->get_veiculo_display($id_veiculo['_id']);
                        }
                    }

                    $result = json_encode($veiculos, JSON_PRETTY_PRINT);
                    // $result = json_encode($this->veiculos_model->pesquisar_termo($search), JSON_PRETTY_PRINT);
                }

                // echo $result;
                echo '<pre>'; echo $result; echo '</pre>';
            }else{
                
                $documents = $this->veiculos_model->pesquisar_termo($search);
                $veiculos = [];
                if($documents['searchfound'] > 0){
                    foreach($documents['ids'] as $id_veiculo){
                        if($this->veiculos_model->crosscheck_veiculo_filtro($id_veiculo['_id'], $filtro))
                            $veiculos[] = $this->veiculos_model->get_veiculo_display($id_veiculo['_id']);
                    }
                }

                if($veiculos == []) $this->session->set_flashdata('no_results', 'Sua busca não retornou resultados.');
            
                $data['title'] = "Pesquisa";
                $data['query'] = $search;
                $data['results'] = $veiculos;

                $this->view_veiculos_display($data);
            }
        }

        public function info($id_veiculo){
            if($this->veiculos_model->checar_status($id_veiculo)){
                $data = $this->veiculos_model->get_veiculo($id_veiculo);
                
                echo '<pre>'; echo print_r($data); echo '</pre>';
            }else{
                show_404();
            }
        }

        public function node($action){
            if($action=="reset"){
                $this->veiculos_model->reset_node();
                echo 'Node reset complete';
            }
        }

        /* FUNCOES DE GENERALIZAÇÃO */

        function view_veiculos_display($data){            
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
                        'grid.min.css',
                        'icon.min.css',
                        'label.min.css',
                        'message.min.css'
                    ],
                    'js' => [
                        'site.min.js', 
                        'dimmer.min.js',
                    ]
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
            $this->load->view('veiculos/search', $data);
            $this->load->view('templates/common-footer', $data);
            $this->load->view('templates/footer', $data);
        }
    }