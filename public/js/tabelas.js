$( document ).ready(function() {

    $('#tabela_contatos').bootstrapTable({
        pagination: true,
        search: true,
        sorting: true,
        columns: [{
            field: 'id',
            title: '#'
        }, {
            field: 'nome',
            title: 'Nome'
        }, {
            field: 'email',
            title: 'Email'
        }, {
            field: 'link_editar',
            title: ''
        }, {
            field: 'link_excluir',
            title: ''
        }]
    });

    $('#tabela_templates').bootstrapTable({
        pagination: true,
        search: true,
        sorting: true,
        columns: [{
            field: 'id',
            title: '#'
        }, {
            field: 'nome',
            title: 'Nome'
        }, {
            field: 'assunto',
            title: 'Assunto'
        }, {
            field: 'mensagem',
            title: 'Mensagem'
        }, {
            field: 'link_editar',
            title: ''
        }, {
            field: 'link_excluir',
            title: ''
        }]
    });

    $('#tabela_campanhas').bootstrapTable({
        pagination: true,
        search: true,
        sorting: true,
        columns: [{
            field: 'id',
            title: '#'
        }, {
            field: 'nome',
            title: 'Nome'
        }, {
            field: 'data_criacao',
            title: 'Data/Hora'
        }, {
            field: 'status_nome',
            title: 'Status'
        }, {
            field: 'link_editar',
            title: ''
        }, {
            field: 'link_excluir',
            title: ''
        }, {
            field: 'link_executar',
            title: ''
        }]
    });

});