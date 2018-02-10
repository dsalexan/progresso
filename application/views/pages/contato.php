
    <div id="wrap-body" class="p-t-lg-30">
        <div class="container">
            <div class="wrap-body-inner">
                <section class="block-contact m-t-lg-30 m-t-xs-0 p-b-lg-50">
                    <div class="">
                        <div class="row" id="template-wise">
                            <div class="col-sm-6 col-md-6 col-lg-6 m-b-xs-30">
                                <div class="heading">
                                    <h3>Informações</h3>
                                </div>
                                <div class="contact-info p-lg-30 p-xs-15 bg-gray-fa bg1-gray-2">
                                    <div class="content">
                                        <p hidden>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod temp incidunt ut labore et dolore magna aliqua uat enim ad minim veniama quis nostrud ullamco lab oris nisi ut aliqu.</p>
                                        <ul class="list-default">
                                            <li><i class="fa fa-clock-o"></i>
                                            <?=$config['logradouro']?>, <?=$config['cidade']?> - <?=$config['uf']?>
                                            </li>
                                            <li><i class="fa fa-phone"></i><?=$config['telefone']?> / <?=$config['telefone2']?></li>
                                            <li><i class="fa fa-envelope-o"></i><?=$config['email']?></li>
                                            <li><i class="fa fa-globe"></i><a href="facebook.com/progressoveiculos">Facebook</a></li>
                                        </ul>
                                    </div>

                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3663.1533003360514!2d-47.85039904913594!3d-23.346459984715324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c5d92979cbcfc3%3A0x41f7be6d928a712!2sR.+Cap.+Lisboa%2C+600+-+Centro%2C+Tatu%C3%AD+-+SP%2C+18270-070!5e0!3m2!1spt-BR!2sbr!4v1518284141932" 
                                        width="480" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div>
                            </div>
                            <!-- Contact form -->
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="heading">
                                    <h3>Contato</h3>
                                </div>
                                <div class="contact-form p-lg-30 p-xs-15 bg-gray-fa bg1-gray-2">
                                    
                                    <div id="email-sent" class="field" hidden>
                                        <div class="ui positive message small">
                                            <p>Seu e-mail foi enviado com sucesso.</p>
                                        </div>
                                    </div>
                                    </br>
                                    <form class="ui form" id="contato" method="post" action="<?= base_url('mail')?>">
                                        <div class="form-group">
                                            <input type="text" name="nome" class="form-control form-item" placeholder="Nome">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-item" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="assunto" class="form-control form-item" placeholder="Assunto">
                                        </div>
                                        <textarea name="mensagem" class="form-control form-item h-200 m-b-lg-10" placeholder="Mensagem" rows="3"></textarea>
                                        <button type="submit" class="ht-btn ht-btn-default">Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>