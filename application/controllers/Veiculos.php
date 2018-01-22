<?php
    class Veiculos extends CI_Controller{

        public function show($tipo)
        {
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
            $data['veiculos'] = $this->veiculos_model->get_veiculos_destaque($id_tipo);

            echo '<pre>'; print_r($data['veiculos']); echo '</pre>';
    
            $this->load->view('templates/header', $data);
            $this->load->view('veiculos/show', $data);
            $this->load->view('templates/footer', $data);
        }

        public function page($id_tipo, $numero_pagina){
            $qtd_por_pagina = 4; //a quantidade de veiculos por pagina é alterada por meio de um post para [url_tipo]/page/[num_page/]
            if($this->input->post('qtd_por_pagina')) $qtd_por_pagina = $this->input->post('qtd_por_pagina');

            $data = $this->veiculos_model->get_veiculos_por_pagina($id_tipo, $qtd_por_pagina, $numero_pagina);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);

        }

        public function search(){
            $search = $this->input->get('q');
            $result = $this->veiculos_model->pesquisar_termo($search);

            echo $search.'</br></br></br>';
            echo '<pre>'; print_r($result); echo '</pre>';
        }

        public function info($id_tipo, $id_veiculo){
            if($this->veiculos_model->checar_status($id_veiculo)){
                $data = $this->veiculos_model->get_veiculo($id_veiculo);
                
                echo '<pre>'; echo print_r($data); echo '</pre>';
            }else{
                show_404();
            }
        }
    }