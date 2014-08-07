function despesaListaInit(e) {

    $('#despesa-lista .total').hide();
 
    app.showLoading();

    var ano = e.view.params.ano;
    var mes = e.view.params.mes;
    var orgao = e.view.params.orgao;

    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/despesa",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                type: "GET",
                timeout: TIMEOUT,
                data: {
                    ano: ano,
                    mes: mes,
                    entidade: $('#despesa-filtro-entidade').val(),
                    tipoEmpenho: $('#despesa-filtro-tipo-empenho').val(),
                    desc_forc: $('#despesa-filtro-fonte-recursos').val(),
                    numeroEmpenho: $('#despesa-filtro-empenho').val(),
                    fornecedor: $('#despesa-filtro-fornecedor').val(),
                    orgao: orgao
                }
            }
        },
        schema: {
            data: 'data',
            total: 'count'
        },
        requestEnd: function(e) {
            $('#despesa-lista .total').slideDown('fast');
            $('#despesa-lista .despesa-total').html(e.response.total);
            app.hideLoading();
        },
        serverPaging: true,
        pageSize: 100
    });
    dataSource.bind("error", dataSource_error);

    $("#despesa-lista-scroll").kendoMobileListView({
        dataSource: dataSource,
        template: kendo.template($("#despesa-lista-scroll-template").html())
    });

}

function despesaAnoInit() {
    var dataSource = new kendo.data.DataSource({
        data: getReceitaAno()
    });
    dataSource.bind("error", dataSource_error);

    $("#despesa-ano-scroll").kendoMobileListView({
        dataSource: dataSource,
        template: "<a href='\\#despesa-mes?ano=#: ano #'>#: ano #</a>"
    });
}

function despesaMesShow(e) {
    app.showLoading();
    var ano = e.view.params.ano;

    $.ajax({
        url: SERVERDATA + "/api/despesa/total",
        dataType: "jsonp",
        data: {
            ano: ano
        },
        timeout: TIMEOUT,
        success: function(response) {
            var dataSource = new kendo.data.DataSource({
                data: getListaMes(ano)
            });

            $("#despesa-mes-scroll").kendoMobileListView({
                dataSource: dataSource,
                template: "<a href='\\#despesa-orgao?ano=" + ano + "&mes=#=index#'>#=mes#</a>"
            });
            app.hideLoading();

            $('#despesa-mes .total').slideDown('fast');
            $('#despesa-mes .despesa-total').html(response.total);
        },
        error: dataSource_error
    });

}

function despesaOrgaoShow(e) {
    app.showLoading();
    var ano = e.view.params.ano;
    var mes = e.view.params.mes;

    $.ajax({
        url: SERVERDATA + "/api/despesa/total",
        dataType: "jsonp",
        data: {
            ano: ano,
            mes: mes
        },
        timeout: TIMEOUT,
        success: function(response) {
            var dataSource = new kendo.data.DataSource({
                dataType: "jsonp",
                transport: {
                    read: {
                        url: SERVERDATA + "/api/despesa/orgaos",
                        contentType: "application/json; charset=utf-8",
                        dataType: "jsonp",
                        type: "GET",
                        timeout: TIMEOUT
                    }
                },
                schema: {
                    data: 'orgaos'
                },
                requestEnd: function(e) {
                    $('#despesa-lista .total').slideDown('fast');
                    $('#despesa-lista .despesa-total').html(e.response.total);
                    app.hideLoading();
                },
            });
            dataSource.bind("error", dataSource_error);

            $("#despesa-orgao-scroll").kendoMobileListView({
                dataSource: dataSource,
                template: "<a href='\\#despesa-lista?ano=" + ano + "&mes=" + mes + "&orgao=#=orgao#'>#=orgao#</a>"
            });

            app.hideLoading();

            $('#despesa-orgao .total').slideDown('fast');
            $('#despesa-orgao .despesa-total').html(response.total);
        },
        error: dataSource_error
    });

}

function despesaDetalheShow(e) {
    app.showLoading();
    $.ajax({
        url: SERVERDATA + "/api/despesa/detalhe",
        dataType: "jsonp",
        data: {
            ano: e.view.params.ano,
            mes: e.view.params.mes,
            empenho: e.view.params.empenho,
            entidade: e.view.params.entidade,
            cod_receita: e.view.params.cod_receita
        },
        timeout: TIMEOUT,
        success: function(response) {
            $('#despesa-detalhe-desc_tpde').html(response.data.desc_tpde);
            $('#despesa-detalhe-nume_empe').html(response.data.nume_empe);
            $('#despesa-detalhe-data').html(response.data.mes_refe + '/' + response.data.ano_refe);
            $('#despesa-detalhe-desc_forc').html(response.data.desc_forc);
            $('#despesa-detalhe-desc_tpem').html(response.data.desc_tpem);
            $('#despesa-detalhe-nome_forn').html(response.data.nome_forn);
            $('#despesa-detalhe-codi_elem').html(response.data.codi_elem);
            $('#despesa-detalhe-desc_orga').html(response.data.desc_orga);
            $('#despesa-detalhe-desc_desp').html(response.data.desc_desp);
            $('#despesa-detalhe-nume_proc').html(response.data.nume_proc);
            $('#despesa-detalhe-valo_empe').html(response.data.valo_empe);
            $('#despesa-detalhe-desc_itee').html(response.data.desc_itee);
            $('#despesa-detalhe-desc_tpli').html(response.data.desc_tpli);
            $('#despesa-detalhe-nume_lici').html(response.data.nume_lici);
            $('#despesa-detalhe-nome_enti').html(response.data.nome_enti);
            $('#despesa-detalhe-ano_empe').html(response.data.ano_empe);
            $('#despesa-detalhe-data_empe').html(response.data.data_empe);


            if ($('#link-despesa-detalhe').attr('href').indexOf('?') < 0) {
                var queryString = '?empenho=' + response.data.nume_empe +
                        '&ano=' + response.data.ano_refe +
                        '&mes=' + response.data.mes_refe;
                $('#link-despesa-detalhe').attr('href', $('#link-despesa-detalhe').attr('href') + queryString);
                $('#link-despesa-historico').attr('href', $('#link-despesa-historico').attr('href') + queryString);
            }

            app.hideLoading();
        },
        error: dataSource_error
    });

}

function despesaDetalheBeforeShow() {
    $('#despesa-detalhe-titulo').html('');
    $('#despesa-detalhe-nume_empe').html('');
    $('#despesa-detalhe-data').html('');
    $('#despesa-detalhe-desc_forc').html('');
    $('#despesa-detalhe-desc_tpem').html('');
    $('#despesa-detalhe-nome_forn').html('');
    $('#despesa-detalhe-codi_elem').html('');
    $('#despesa-detalhe-desc_orga').html('');
    $('#despesa-detalhe-desc_desp').html('');
    $('#despesa-detalhe-nume_proc').html('');
    $('#despesa-detalhe-valo_empe').html('');
    $('#despesa-detalhe-desc_itee').html('');
    $('#despesa-detalhe-desc_tpli').html('');
    $('#despesa-detalhe-nume_lici').html('');
}

function filtrarDespesaButton(e) {
    var despesaView = $('#despesa-lista').data("kendoMobileView");

    app.showLoading();

    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/despesa",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                type: "GET",
                timeout: TIMEOUT,
                data: {
                    ano: despesaView.params.ano,
                    mes: despesaView.params.mes,
                    entidade: $('#despesa-filtro-entidade').val(),
                    orgao: despesaView.params.orgao,
                    tipoEmpenho: $('#despesa-filtro-tipo-empenho').val(),
                    fonteRecursos: $('#despesa-filtro-fonte-recursos').val(),
                    numeroEmpenho: $('#despesa-filtro-empenho').val(),
                    fornecedor: $('#despesa-filtro-fornecedor').val()
                }
            }
        },
        schema: {
            data: 'data',
            total: 'count'
        },
        requestEnd: function(e) {
            $('#despesa-lista .total').slideDown('fast');
            $('#despesa-lista .despesa-total').html(e.response.total);
            closeModalFiltroDespesa();
            app.hideLoading();
        },
        serverPaging: true,
        pageSize: 40
    });
    dataSource.bind("error", dataSource_error);

    $("#despesa-lista-scroll").data("kendoMobileListView").setDataSource(dataSource);
}

function despesaHistoricoShow(e) {
    app.showLoading();

    var queryString = '?empenho=' + e.view.params.empenho +
            '&ano=' + e.view.params.ano +
            '&mes=' + e.view.params.mes;
    $('#link-despesa-detalhe').attr('href', $('#link-despesa-detalhe').attr('href') + queryString);
    $('#link-despesa-historico').attr('href', $('#link-despesa-historico').attr('href') + queryString);

    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/despesa/detalhe",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                type: "GET",
                timeout: TIMEOUT,
                data: {
                    ano: e.view.params.ano,
                    mes: e.view.params.mes,
                    empenho: e.view.params.empenho,
                    entidade: e.view.params.entidade,
                    cod_receita: e.view.params.cod_receita
                }
            }
        },
        group: {field: "data_movi", dir: "desc"},
        schema: {
            data: function(response) {
                return response.historico;
            }
        },
        requestEnd: function() {
            app.hideLoading();
        },
        error: function() {
            app.hideLoading();
            showAlert('Não foi possível conectar ao servidor, por favor, tente novamente mais tarde.');
        }
    });
    dataSource.bind("error", dataSource_error);

    $("#despesa-historico-listview").kendoMobileListView({
        dataSource: dataSource,
        type: 'group',
        template: $('#template-despesa-historico').html(),
        fixedHeaders: true
    });

}

function filtroDespesaInit(e) {
    var view = $('#filtroDespesa');
    app.showLoading();
    $.ajax({
        url: SERVERDATA + "/api/despesa/filtro",
        dataType: "jsonp",
        cache: true,
        timeout: TIMEOUT,
        success: function(response) {
            $.each(response.entidades, function(i, el) {
                $('#filtroDespesa #despesa-filtro-entidade').append('<option value="' + el.codi_enti + '">' + el.desc_enti + '</option>');
            });
            $.each(response.tipoEmpenhos, function(i, el) {
                $('#filtroDespesa #despesa-filtro-tipo-empenho').append('<option value="' + el.tipo + '">' + el.tipo + '</option>');
            });
            $.each(response.fonteRecursos, function(i, el) {
                $('#filtroDespesa #despesa-filtro-fonte-recursos').append('<option value="' + el.fonte + '">' + el.fonte + '</option>');
            });

            //exibicao nativo documentdropdown nos celulares
            if (view.data('count') == '0') {
                initDropDown('#filtroDespesa');
                view.data('count', '1');
            }

            app.hideLoading();
        },
        error: dataSource_error
    });
}

$('#link-despesa-compartilhar').on('click',
        function() {
            var view = $('#despesa-detalhe').data("kendoMobileView");
            var ano = view.params.ano;
            var mes = view.params.mes;
            var empenho = view.params.empenho;
            var url = 'http://transparencia.joaopessoa.pb.gov.br/sicoda/sicoda_despesa_lei131_ed2.php?sicoda_db=lei131&sicoda_db_table=despesa_lei131&' +
                    'ano=' + ano + '&mes=' + mes + '&numEmpenho=' + empenho;
            var texto = 'Informações detalhadas de despesa da Prefeitura Municipal de João Pessoa - Empenho ' + empenho + ' - Ano ' + ano;
            window.plugins.socialsharing.share(texto, null, null, url);
            return false;
        });
