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
                "configuracoes" => "Configurações",
                "login" => "Login"
            );

            //checa se a pagina existe
            if ( ! file_exists(APPPATH.'views/admin/'.$page.'.php'))
            {   
                show_404();
            }
            
            $options = [];
            if (null !== $this->input->get('a')) $options['action'] = $this->input->get('a');
            if (null !== $this->input->get('id_usuario')) $options['id_usuario'] = $this->input->get('id_usuario');
            if (null !== $this->input->get('id_veiculo')) $options['id_veiculo'] = $this->input->get('id_veiculo');

            $data['options'] = $options;


            $data['fileupload'] = true;
            $data['bootstrap_dashboard'] = true;
            $data['kingtable'] = ['css' => ['kingtable.core.css'],
                                'js' => [
                                    'kingtable.js'     
                                    ]];
            $data['semantic'] = [
                    'css' => [
                        'site.min.css', 
                        'reset.min.css', 
                        'container.min.css', 
                        'dimmer.min.css', 
                        'segment.min.css', 
                        'loader.min.css',
                        'input.min.css',
                        'icon.min.css',
                        'transition.min.css',
                        'popup.min.css',
                        'table.min.css',
                        'calendar.min.css',
                        'button.min.css',
                        'modal.min.css', // admin header
                        'grid.min.css',
                        'search.min.css', // admin header,
                        'tab.min.css',
                        'menu.min.css',
                        'item.min.css',
                        'form.min.css',
                        'button.min.css',
                        'label.min.css',
                        'divider.min.css',
                        'checkbox.min.css',
                        'popup.min.css',
                        'message.min.css',
                        'dropdown.min.css',
                        'image.min.css'
                    ],'js' => [
                        'site.min.js',  
                        'dimmer.min.js',
                        'transition.min.js',
                        'popup.min.js',
                        'calendar.min.js',
                        'modal.min.js', // admin header
                        'search.min.js', // admin header
                        'api.min.js', // admin header,
                        'tab.min.js',
                        'form.min.js',
                        'checkbox.min.js',
                        'popup.min.js',
                        'dropdown.min.js'
                    ]]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
            $data['assets'] = ['css' => ['dashboard.css', 'range.css', 'admin.css', $page.'.css', 'bootstrap-table.css'],
                                'js' => [     
                                    'moment-with-locales.js',
                                    'Chart.min.js',
                                    'admin.js',
                                    'range.js',
                                    $page.'.js',
                                    'bootstrap-table.js',
                                    'popper.min.js',
                                    'bootstrap-table-toolbar.js',]];
            $data['title'] = $pageNames[$page];
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin-header', $data);
            $this->load->view('admin/'.$page, $data);
            $this->load->view('templates/admin-footer', $data);
            $this->load->view('templates/footer', $data);
        }

        public function login(){
            $usuario_logado = $this->session->userdata('logged_user');//Array gerado pelo seu algotitmo de "login" e gravado na SESSION
            if(isset($usuario_logado)){
                redirect('admin');
            }


            //$data['bootstrap'] = true;
            $data['semantic'] = ['css' => ['site.min.css', 'reset.min.css', 'container.min.css', 'icon.min.css', 'message.min.css', 'input.min.css', 'form.min.css', 'button.min.css'],
                                  'js' => ['site.min.js', 'form.min.js', ]]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
            $data['assets'] = ['css' => ['login.css'],
                                'js' => ['login.js']];
            $data['title'] = 'Login';
    
            $this->load->view('templates/header', $data);
            $this->load->view('admin/login', $data);
            $this->load->view('templates/footer', $data);
        }

        public function validate(){
            $username = $this->security->xss_clean($this->input->post('username_login'));
            $password = $this->security->xss_clean($this->input->post('password_login'));
            $passwordMD5 = md5($password);

            $result = $this->usuarios_model->validate($username, $passwordMD5);

            if($result != false){
                $this->session->set_userdata('logged_user', $result);
                redirect('admin');
            }else{
                $this->session->set_flashdata('invalid_credentials', 'O nome de usuário e/ou senha informados são inválidos.');
                redirect('admin/login');
            }
        }

        public function logout(){
            $usuario_logado = $this->session->userdata('logged_user');//Array gerado pelo seu algotitmo de "login" e gravado na SESSION
            if(!isset($usuario_logado)){
                redirect('admin');
            }

            $this->session->unset_userdata('logged_user');
            $this->session->set_flashdata('logout_successful', 'Você encerrou sua sessão.');
            redirect('admin/login');

        }

        public function google(){
            $data['title'] = 'google-oauth';

            $this->load->view('admin/google-api/oauth', $data);
        }

        public function analytics($table){
            $result = array();

            if($table == "acesso_semanal"){
                $period = $this->input->post('period');
                 
                $result[$table] = $this->analytics_model->get_acesso_semanal($period[0], $period[1]);
            }elseif($table == "fontes_trafego"){
                $result[$table] = $this->analytics_model->get_fontes_trafego();
                // $cached_result = '{"fontes_trafego":{"attempts":1,"sessions":["42","3","1","72","2"],"dimensions":["(direct)","bing","br.yhs4.search.yahoo.com","google","lm.facebook.com"]}}';
                // $result = json_decode($cached_result);
            }

            echo $out_json = json_encode($result);
        }

        public function user($action='list',$id_usuario=false){

            $result = ['ok'];

            if($action == 'list' or $action == 'list-all'){
                $status = ($action == 'list-all') ? false    : 1 ;

                $result = $this->usuarios_model->get_usuarios_lista($status);
            }elseif($action == 'select'){
                $result = $this->usuarios_model->get_usuario($id_usuario);
            }elseif ($action == 'insert'){
                $usuario = [
                    'nome' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'senha' => $this->input->post('password'),
                    'nivel' => $this->input->post('nivel'),
                    'permissoes' => implode(",", $this->input->post('permissions')),
                    'status' => 1,
                ];
                
                $this->usuarios_model->insert_usuario($usuario);
            }elseif($action == 'update'){
                $usuario = [
                    'id_usuario' => $this->input->post('id'),
                    'nome' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'senha' => $this->input->post('password'),
                    'nivel' => $this->input->post('nivel'),
                    'permissoes' => implode(",", $this->input->post('permissions')),
                    'status' => 1,
                ];

                $this->usuarios_model->update_usuario($usuario);
            }elseif($action == 'remove'){
                if($id_usuario != false)
                    $this->usuarios_model->remove_usuario($id_usuario);
                else{
                    $usuarios = $this->input->post('ids');
                    foreach($usuarios as $id_usuario){
                        $this->usuarios_model->remove_usuario($id_usuario);
                    }
                }
            }

            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        
        public function vehicle($action='list',$id_veiculo=false){

            $result = ['ok'];

            if($action == 'list' or $action == 'list-all'){
                $status = ($action == 'list-all') ? false    : 1 ;

                $result = $this->veiculos_model->get_veiculos_lista($status);
            }elseif($action == 'select'){
                $result = $this->veiculos_model->get_veiculo($id_veiculo);
            }elseif ($action == 'insert'){
                $agora = new DateTime();
                $veiculo = [
                    'id_tipo' => $this->input->post('tipo'),
                    'id_marca' => $this->input->post('marca'),
                    'id_modelo' => $this->input->post('modelo'),
                    'estado' => $this->input->post('estado'),
                    'cor' => $this->input->post('cor'),
                    'ano' => $this->input->post('ano'),
                    'observacoes' => $this->input->post('observacoes'),
                    'venda_valor' => $this->input->post('valor'),
                    'destaque' => (null == $this->input->post('destaque')) ? 0 : $this->input->post('destaque'),
                    'data_registro' => $agora->format('Y-m-d H:i:s'),
                    'visitas' => 0,
                    'status' => 1,
                ];
                
                $id_veiculo = $this->veiculos_model->insert_veiculo($veiculo);
                $veiculo['id_veiculo'] = $id_veiculo;

                $opcionais = $this->input->post('opcionais');
                if($opcionais == '') $opcionais = [];
                if(!is_array($opcionais)) $opcionais = [$opcionais];
                foreach($opcionais as $id_opcional){
                    $this->veiculos_model->insert_opcional_veiculo($id_veiculo, $id_opcional);
                }

                $combustiveis = $this->input->post('combustivel');
                if($combustiveis == '') $combustiveis = [];
                if(!is_array($combustiveis)) $combustiveis = [$combustiveis];
                foreach($combustiveis as $id_combustivel){
                    $this->veiculos_model->insert_combustivel_veiculo($id_veiculo, $id_combustivel);
                }

                $imagens = [];
                for($i=0; $i < 7; $i++){
                    $files = $_FILES['image'.$i];
                    if($files['error'] == "0"){

                        $now = new DateTime();
                        $ext_file = '.'.explode('/',$files['type'])[1];
                        $nome_imagem =  $now->format('Ymd_His').'_'.microtime(true).$ext_file;
                        

                        $path = FCPATH . '/assets/img/veiculos/';
                        $configuracao = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'gif|jpg|png',
                            'file_name' => $nome_imagem
                        );      
                        $this->upload->initialize($configuracao);
                        
                        if ($this->upload->do_upload('image'.$i))
                            $imagens[] = ['url' => $nome_imagem, 'nome' => null];
                        else{
                            $imagens[] = $this->upload->display_errors(). '    ('.$path.')';
                        }
                    }
                }
                foreach($imagens as $data_imagem){
                    $imagem = [
                        'url_imagem' => $data_imagem['url'],
                        'nome' => $data_imagem['nome']
                    ];

                    $imagem['id_imagem'] = $this->veiculos_model->insert_imagem($imagem);
                    $this->veiculos_model->insert_imagem_veiculo($id_veiculo, $imagem['id_imagem']);
                }

                $result = $veiculo;
                $result['opcionais'] = $opcionais;
                $result['combustiveis'] = $combustiveis;
                $result['imagens'] = $imagens;
                

            }elseif($action == 'update'){
                $veiculo = [
                    'id_veiculo' => $this->input->post('id'),
                    'id_tipo' => $this->input->post('tipo'),
                    'id_marca' => $this->input->post('marca'),
                    'id_modelo' => $this->input->post('modelo'),
                    'estado' => $this->input->post('estado'),
                    'cor' => $this->input->post('cor'),
                    'ano' => $this->input->post('ano'),
                    'observacoes' => $this->input->post('observacoes'),
                    'venda_valor' => $this->input->post('valor'),
                    'destaque' => (null == $this->input->post('destaque')) ? 0 : $this->input->post('destaque'),
                    'status' => 1,
                ];

                $this->veiculos_model->update_veiculo($veiculo);
                $id_veiculo = $veiculo['id_veiculo'];

                $opcionais = $this->input->post('opcionais');
                if($opcionais == '') $opcionais = [];
                if(!is_array($opcionais)) $opcionais = [$opcionais];
                $opcionais_banco = $this->veiculos_model->get_opcionais($id_veiculo, true);
                foreach($opcionais as $id_opcional){ // INSERIR NOVOS
                    if(!in_array($id_opcional, $opcionais_banco)){
                        // $this->veiculos_model->insert_opcional_veiculo($id_veiculo, $id_opcional);
                    }
                }
                foreach($opcionais_banco as $id_opcional){ // REMOVER VELHOS
                    if(!in_array($id_opcional, $opcionais)){
                        // $this->veiculos_model->remove_opcional_veiculo($id_veiculo, $id_opcional);
                    }
                }

                $combustiveis = $this->input->post('combustivel');
                if($combustiveis == '') $combustiveis = [];
                if(!is_array($combustiveis)) $combustiveis = [$combustiveis];
                $combustiveis_banco = $this->veiculos_model->get_combustiveis($id_veiculo, true);
                foreach($combustiveis as $id_combustivel){ // INSERINDO NOVOS
                    if(!in_array($id_combustivel, $combustiveis_banco)){
                       // $this->veiculos_model->insert_combustivel_veiculo($id_veiculo, $id_combustivel);
                    }
                }
                foreach($combustiveis_banco as $id_combustivel){ // REMOVER VELHOS
                    if(!in_array($id_combustivel, $combustiveis)){
                        // $this->veiculos_model->remove_combustivel_veiculo($id_veiculo, $id_combustivel);
                    }
                }

                $imagens = [];
                for($i=0; $i < 7; $i++){
                    $files = $_FILES['image'.$i];
                    if($files['error'] == "0"){

                        $now = new DateTime();
                        $ext_file = '.'.explode('/',$files['type'])[1];
                        $nome_imagem =  $now->format('Ymd_His').'_'.microtime(true).$ext_file;
                        

                        $path = FCPATH . '/assets/img/veiculos/';
                        $configuracao = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'gif|jpg|png',
                            'file_name' => $nome_imagem
                        );      
                        $this->upload->initialize($configuracao);
                        
                        if ($this->upload->do_upload('image'.$i))
                            $imagens[] = ['id' => -1, 'url' => $nome_imagem, 'nome' => null];
                        else{
                            $imagens[] = $this->upload->display_errors(). '    ('.$path.')';
                        }
                    }
                }
                $imagens_banco = $this->input->get_imagens($id_veiculo, true);
                $ids = [];
                foreach($imagens as $data_imagem){ // INSERINDO NOVAS
                    
                    $id_imagem = $data_imagem['id']; // -1 se a img n estier no banco ainda
                    $imagem = [
                        'url_imagem' => $data_imagem['url'],
                        'nome' => $data_imagem['nome']
                    ];

                    if($id_imagem == -1){
                        // $imagem['id_imagem'] = $this->veiculos_model->insert_imagem($imagem);
                        // $this->veiculos_model->insert_imagem_veiculo($id_veiculo, $imagem['id_imagem']);
                    }else{
                        $ids[] = $id_imagem;
                    }
                }
                foreach($imagens_banco as $id_imagem){ // REMOVER VELHOS
                    if(!in_array($id_imagem, $ids)){
                        // $this->veiculos_model->remove_imagem_veiculo($id_veiculo, $id_imagem);
                    }
                }

                $result = $veiculo;
                $result['opcionais'] = $opcionais;
                $result['combustiveis'] = $combustiveis;
                $result['imagens'] = $imagens;

            }elseif($action == 'remove'){
                if($id_veiculo != false){
                    $this->veiculos_model->remove_veiculo($id_veiculo);
                }else{
                    $veiculos = $this->input->post('ids');
                    foreach($veiculos as $id_veiculo){
                        $this->veiculos_model->remove_veiculo($id_veiculo);
                    }

                    $result = $veiculos;
                }
            }elseif($action == 'image'){
                $images = $_FILES;
                $result = $images;
            }

            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function type($action='insert'){
            $result = ['ok'];

            if($action == 'insert'){
                $tipo = [
                    'nome' => $this->input->post('nome'),
                    'nome_plural' => $this->input->post('plural'),
                    'url' => $this->input->post('url')
                ];

                $id_tipo = $this->veiculos_model->insert_tipo($tipo);
                $tipo['id_tipo'] = $id_tipo;

                $result = $tipo;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function brand($action='insert'){
            $result = ['ok'];

            if($action == 'insert'){
                $marca = [
                    'id_tipo' => $this->input->post('tipo'),
                    'nome' => $this->input->post('nome')
                ];

                $id_marca = $this->veiculos_model->insert_marca($marca);
                $marca['id_marca'] = $id_marca;

                $result = $marca;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function model($action='insert'){
            $result = ['ok'];

            if($action == 'insert'){
                $modelo = [
                    'id_tipo' => $this->input->post('tipo'),
                    'id_marca' => $this->input->post('marca'),
                    'nome' => $this->input->post('nome'),
                ];

                $id_modelo = $this->veiculos_model->insert_modelo($modelo);
                $modelo['id_modelo'] = $id_modelo;

                $result = $modelo;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function optional($action='insert'){
            $result = ['ok'];

            if($action == 'insert'){
                $opcional = [
                    'nome' => $this->input->post('nome')
                ];

                $id_opcional = $this->veiculos_model->insert_opcional($opcional);
                $opcional['id_opcional'] = $id_opcional;

                $result = $opcional;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function fuel($action='insert'){
            $result = ['ok'];

            if($action == 'insert'){
                $combustivel = [
                    'nome' => $this->input->post('nome')
                ];

                $id_combustivel = $this->veiculos_model->insert_combustivel($combustivel);
                $combustivel['id_combustivel'] = $id_combustivel;

                $result = $combustivel;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function config($action='list'){
            $result = ['ok'];

            if($action == 'list'){

                $result = $this->config_model->get_config();
            }elseif($action == 'update'){
                $config = [
                    'id_config' => $this->input->post('id'),
                    'titulo_site' => $this->input->post('titulo'),
                    'url_site' => $this->input->post('url'),
                    'logradouro' => $this->input->post('logradouro'),
                    'cidade' => $this->input->post('cidade'),
                    'uf' => $this->input->post('uf'),
                    'telefone' => $this->input->post('telefone'),
                    'telefone2' => $this->input->post('telefone2'),
                    'email' => $this->input->post('email')
                ];

                $this->config_model->update_config($config);

                $result = $config;
            }

            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        

        public function test(){
            echo FCPATH;
            
            // echo '<pre>'; echo json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
        }
    }