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
            
            $data['bootstrap'] = true;
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
                        'checkbox.min.css'
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
                        'checkbox.min.js'
                    ]]; // setar a variavel para o template HEADER identificar que deve puxar certos arquivos pro cabeçalho
            $data['assets'] = ['css' => ['dashboard.css', 'range.css', 'admin.css', $page.'.css'],
                                'js' => [     
                                    'moment-with-locales.js',
                                    'Chart.min.js',
                                    'admin.js',
                                    'range.js',
                                    $page.'.js']];
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
            $username = $this->security->xss_clean($this->input->post('username'));
            $password = $this->security->xss_clean($this->input->post('password'));
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
                //$result[$table] = $this->analytics_model->get_fontes_trafego();
                $cached_result = '{"fontes_trafego":{"attempts":1,"sessions":["42","3","1","72","2"],"dimensions":["(direct)","bing","br.yhs4.search.yahoo.com","google","lm.facebook.com"]}}';
                $result = json_decode($cached_result);
            }

            echo $out_json = json_encode($result);
            

        }
    }