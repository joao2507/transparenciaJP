function receitaListaInit(e) {

    $('#receita-lista .total').hide();
    
    app.showLoading();

    var ano = e.view.params.ano;
    var mes = e.view.params.mes;

    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/receita",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                type: "GET",
                timeout: TIMEOUT,
                data: {
                    ano: ano,
                    mes: mes,
                    entidade: $('#entidade').val()
                }
            }
        },
        schema: {
            data: 'data',
            total: 'count'
        },
        requestEnd: function(e) {
            $('#receita-lista .total').slideDown('fast');
            $('#receita-lista .receita-total').html(e.response.total);
            app.hideLoading();
        },
        serverPaging: true,
        pageSize: 100
    });
    dataSource.bind("error", dataSource_error);

    $("#receita-lista-scroll").kendoMobileListView({
        dataSource: dataSource,
        template: kendo.template($("#receita-lista-scroll-template").html())
    });

}

function receitaAnoInit() {
    var dataSource = new kendo.data.DataSource({
        data: getReceitaAno()
    });
    dataSource.bind("error", dataSource_error);

    $("#receita-ano-scroll").kendoMobileListView({
        dataSource: dataSource,
        template: "<a href='\\#receita-mes?ano=#: ano #'>#: ano #</a>"
    });
}

function receitaMesShow(e) {
    app.showLoading();
    var ano = e.view.params.ano;

    $.ajax({
        url: SERVERDATA + "/api/receita/total",
        dataType: "jsonp",
        data: {
            ano: e.view.params.ano
        },
        timeout: TIMEOUT,
        success: function(response) {
            var dataSource = new kendo.data.DataSource({
                data: getListaMes(ano)
            });

            $("#receita-mes-scroll").kendoMobileListView({
                dataSource: dataSource,
                template: "<a href='\\#receita-lista?ano=" + ano + "&mes=#=index#'>#=mes#</a>"
            });
            app.hideLoading();
            
            $('#receita-mes .total').slideDown('fast');
            $('#receita-mes .receita-total').html(response.total);
        },
        error: dataSource_error
    });

}

function receitaDetalheShow(e) {
    app.showLoading();
    $.ajax({
        url: SERVERDATA + "/api/receita/detalhe",
        dataType: "jsonp",
        data: {
            ano: e.view.params.ano,
            mes: e.view.params.mes,
            entidade: e.view.params.entidade,
            cod_receita: e.view.params.cod_receita
        },
        timeout: TIMEOUT,
        success: function(response) {
            $('#receita-detalhe-titulo').html(response.data.desc_rece);
            $('#receita-detalhe-entidade').html(response.data.nome_enti);
            $('#receita-detalhe-data').html(response.data.mes_refe + '/' + response.data.ano_refe);
            $('#receita-detalhe-codigo-receita').html(response.data.codi_rece);
            $('#receita-detalhe-valor').html(response.data.valo_arre);
            app.hideLoading();
        },
        error: dataSource_error
    });

}

function receitaDetalheBeforeShow() {
    $('#receita-detalhe-titulo').html('');
    $('#receita-detalhe-entidade').html('');
    $('#receita-detalhe-data').html('');
    $('#receita-detalhe-codigo-receita').html('');
    $('#receita-detalhe-valor').html('');
}

function filtrarReceitaButton(e) {
    var receitaView = $('#receita-lista').data("kendoMobileView");
    
    app.showLoading();
    
    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/receita",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                type: "GET",
                timeout: TIMEOUT,
                data: {
                    ano: receitaView.params.ano,
                    mes: receitaView.params.mes,
                    entidade: $('#entidade').val()
                }
            }
        },
        schema: {
            data: 'data',
            total: 'count'
        },
        requestEnd: function(e) {
            $('#receita-lista .total').slideDown('fast');
            $('#receita-lista .receita-total').html(e.response.total);
            closeModalFiltroReceita();
            app.hideLoading();
        },
        serverPaging: true,
        pageSize: 40
    });
    dataSource.bind("error", dataSource_error);
    
    $("#receita-lista-scroll").data("kendoMobileListView").setDataSource(dataSource);
    
}

function filtroReceitaInit(e) {
    var view = $('#filtroReceita');
    app.showLoading();
    $.ajax({
        url: SERVERDATA + "/api/receita/filtro",
        dataType: "jsonp",
        timeout: TIMEOUT,
        success: function(response) {
            
            $.each( response.entidades, function( i, el ){
                $('#filtroReceita #entidade').append('<option value="'+el.codi_enti+'">'+el.desc_enti+'</option>');
            });
            //exibicao nativo documentdropdown nos celulares
            if(view.data('count') == '0'){
                initDropDown('#filtroReceita');
                view.data('count', '1');
            }
            app.hideLoading();
        },
        error: dataSource_error
    });
}