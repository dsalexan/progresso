<?php
    if(!array_key_exists('action', $options)){
        $options['action'] = 'list';
    }
?>

<div class="tabs">
<div class="ui secondary pointing menu" >
  <a class="item <?php if($options['action']=='list') echo 'active'?>" data-tab="list">Listar Todos</a>
  <a class="item <?php if($options['action']=='insert') echo 'active'?>" data-tab="insert">Cadastrar</a>
  <a class="item <?php if($options['action']=='update') echo 'active'?>" data-tab="update" disabled>Modificar</a>
</div>
<div class="ui tab segment <?php if($options['action']=='list') echo 'active'?>" data-tab="list">

    <?php $this->load->view('admin/veiculos/table.php'); ?>
    
</div>

<div class="ui tab segment <?php if($options['action']=='insert') echo 'active';?>" data-tab="insert">
    
    <?php 
    $data = [
        'acao' => 'insert'
    ];
    $this->load->view('admin/veiculos/form.php', $data); ?>

</div>

<div class="ui tab segment <?php if($options['action']=='update') echo 'active';?>" data-tab="update">
    
    <?php 
    $data = [
        'acao' => 'update'
    ];
    $this->load->view('admin/veiculos/form.php', $data); ?>

</div>
</div>

<!-- FORMULARIOS SECUNDARIOS -->
<?php

    //tipo
    $objetos[0] = [
        'tabela' => [
            'nome' => 'tipo',
            'alt' => 'Tipo',
            'link' => 'type',
            'icone' => 'car'
        ],
        'acao' => 'insert',
        'campos' => [
            [
                'label' => 'Nome',
                'icone' => 'card',
                'nome' => 'nome',
                'placeholder' => 'Nome',
                'id' => false,
                'tipo' => 'text'
            ],[
                'label' => 'Nome (plural)',
                'icone' => 'card',
                'nome' => 'plural',
                'placeholder' => 'Nome (plural)',
                'id' => 'tipo_nome_plural',
                'tipo' => 'text'
            ],[
                'label' => 'Link',
                'icone' => 'world',
                'nome' => 'url',
                'placeholder' => 'Link',
                'id' => 'tipo_url',
                'tipo' => 'text'
            ]
        ]
    ];

    //marca
    $objetos[1] = [
        'tabela' => [
            'nome' => 'marca',
            'alt' => 'Marca',
            'link' => 'brand',
            'icone' => 'cubes'
        ],
        'acao' => 'insert',
        'campos' => [
            [
                'label' => 'Tipo',
                'icone' => 'car',
                'nome' => 'tipo',
                'placeholder' => 'Tipo',
                'id' => false,
                'tipo' => 'dropdown',
                'dados' => [
                    'origem' => $this->veiculos_model->get_tipos(1),
                    'valor' => 'id_tipo',
                    'texto' => 'nome'
                ],
                'edit' => 'non-edit'
            ],[
                'label' => 'Nome',
                'icone' => 'card',
                'nome' => 'nome',
                'placeholder' => 'Nome',
                'id' => false,
                'tipo' => 'text'
            ]
        ]
    ];

    //modelo
    $objetos[2] = [
        'tabela' => [
            'nome' => 'modelo',
            'alt' => 'Modelo',
            'link' => 'model',
            'icone' => 'cube'
        ],
        'acao' => 'insert',
        'campos' => [
            [
                'label' => 'Tipo',
                'icone' => 'car',
                'nome' => 'tipo',
                'placeholder' => 'Tipo',
                'id' => false,
                'tipo' => 'dropdown',
                'dados' => [
                    'origem' => $this->veiculos_model->get_tipos(1),
                    'valor' => 'id_tipo',
                    'texto' => 'nome'
                ],
                'edit' => 'non-edit',
                'group' => 2
            ],[
                'label' => 'Marca',
                'icone' => 'cubes',
                'nome' => 'marca',
                'placeholder' => 'Marca',
                'id' => false,
                'tipo' => 'dropdown',
                'dados' => [
                    'origem' => $this->veiculos_model->get_marcas_lista(1),
                    'valor' => 'id_marca',
                    'texto' => 'nome'
                ],
                'edit' => 'non-edit',
                'group' => 2
            ],[
                'label' => 'Nome',
                'icone' => 'card',
                'nome' => 'nome',
                'placeholder' => 'Nome',
                'id' => false,
                'tipo' => 'text'
            ]
        ]
    ];

    //opcional
    $objetos[3] = [
        'tabela' => [
            'nome' => 'opcional',
            'alt' => 'Opcional',
            'link' => 'optional',
            'icone' => 'check square'
        ],
        'acao' => 'insert',
        'campos' => [
            [
                'label' => 'Nome',
                'icone' => 'card',
                'nome' => 'nome',
                'placeholder' => 'Nome',
                'id' => false,
                'tipo' => 'text'
            ]
        ]
    ];

    //combustivel
    $objetos[4] = [
        'tabela' => [
            'nome' => 'combustivel',
            'alt' => 'Tipo de Combustível',
            'link' => 'fuel',
            'icone' => 'battery full'
        ],
        'acao' => 'insert',
        'campos' => [
            [
                'label' => 'Nome',
                'icone' => 'card',
                'nome' => 'nome',
                'placeholder' => 'Nome',
                'id' => false,
                'tipo' => 'text'
            ]
        ]
    ];

    foreach($objetos as $objeto)
        $this->load->view('admin/veiculos/secundarios/form.php', ['objeto' => $objeto]);

?>

<!-- TABELAS SECUNDARIAS -->
<?php

    //tipo
    $tabelas[0] = [
        'tabela' => [
            'nome' => 'tipo',
            'alt' => 'Tipos',
            'link' => 'type',
            'icone' => 'car'
        ],
        'campos' => [
            [
                'label' => 'ID',
                'nome' => 'id_tipo',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome',
                'nome' => 'nome',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome (plural)',
                'nome' => 'nome_plural',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Link',
                'nome' => 'url',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Status',
                'nome' => 'status',
                'sortable' => true,
                'visible' => true
            ],
        ]
    ];

    //marca
    $tabelas[1] = [
        'tabela' => [
            'nome' => 'marca',
            'alt' => 'Marcas',
            'link' => 'brand',
            'icone' => 'cubes'
        ],
        'campos' => [
            [
                'label' => 'ID',
                'nome' => 'id_marca',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Tipo',
                'nome' => 'tipo',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome',
                'nome' => 'nome',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Imagem',
                'nome' => 'imagem',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Status',
                'nome' => 'status',
                'sortable' => true,
                'visible' => true
            ],
        ]
    ];

    //modelo
    $tabelas[2] = [
        'tabela' => [
            'nome' => 'modelo',
            'alt' => 'Modelos',
            'link' => 'model',
            'icone' => 'cube'
        ],
        'campos' => [
            [
                'label' => 'ID',
                'nome' => 'id_modelo',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Tipo',
                'nome' => 'tipo',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Marca',
                'nome' => 'marca',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome',
                'nome' => 'nome',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Status',
                'nome' => 'status',
                'sortable' => true,
                'visible' => true
            ],
        ]
    ];

    //opcional
    $tabelas[3] = [
        'tabela' => [
            'nome' => 'opcional',
            'alt' => 'Opcionais',
            'link' => 'optional',
            'icone' => 'check square'
        ],
        'campos' => [
            [
                'label' => 'ID',
                'nome' => 'id_opcional',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome',
                'nome' => 'nome',
                'sortable' => true,
                'visible' => true
            ],
        ]
    ];

    //combustivel
    $tabelas[4] = [
        'tabela' => [
            'nome' => 'combustivel',
            'alt' => 'Tipos de Combustível',
            'link' => 'fuel',
            'icone' => 'battery full'
        ],
        'campos' => [
            [
                'label' => 'ID',
                'nome' => 'id_combustivel',
                'sortable' => true,
                'visible' => true
            ],[
                'label' => 'Nome',
                'nome' => 'nome',
                'sortable' => true,
                'visible' => true
            ],
        ]
    ];

    foreach($tabelas as $objeto)
        $this->load->view('admin/veiculos/secundarios/table.php', ['objeto' => $objeto]);

?>

<div id="remove-confirmation" class="ui modal mini" style="bottom: auto">
  <div class="header">Confirmação</div>
  <div class="content">
    <p>Tem certeza que deseja excluir esses itens?</p>
    <p class="items"></p>
  </div>
  <div class="actions">
    <div class="ui negative button">Não</div>
    <div class="ui positive button">Sim</div>
  </div>
</div>

<script>
    var options = {
        <?php foreach($options as $key => $value){ ?>
            "<?=$key?>": "<?=$value?>",
        <?php } ?>
    };
</script>
