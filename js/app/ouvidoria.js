function ouvidoriaInit() {
    var listviews = this.element.find("ul.km-listview");

    $("#ouvidoria-formato").kendoMobileButtonGroup({
        select: function() {
            listviews.hide()
                     .eq(this.selectedIndex)
                     .show();
        },
        index: 0
    });
    
    initDropDown('#ouvidoria');
}

function ouvidoriaEnviar(e) {
    var buttongroup = $("#ouvidoria-formato").data('kendoMobileButtonGroup');
    
    var params = {};
    //Com identificacao
    if(buttongroup.selectedIndex == 0){
        params.tipo = 0;
        params.nome = $('#ouvidoria-normal-nome').val();
        params.email = $('#ouvidoria-normal-email').val();
        params.genero = $('#ouvidoria-normal-genero :checked').val();
        params.orientacao = $('#ouvidoria-normal-orientacao-sexual :checked').val();
        params.etnia = $('#ouvidoria-normal-etnia :checked').val();
        params.idade = $('#ouvidoria-normal-idade').val();
        params.endereco = $('#ouvidoria-normal-endereco').val();
        params.telefoneResidencial = $('#ouvidoria-normal-telefone-residencial').val();
        params.telefoneComercial = $('#ouvidoria-normal-telefone-comercial').val();
        params.telefoneCelular = $('#ouvidoria-normal-telefone-celular').val();
        params.mensagem = $('#ouvidoria-normal-mensagem').val();
    }else if(buttongroup.selectedIndex == 1){ //Anonimo
        params.tipo = 1;
        params.mensagem = $('#ouvidoria-anonimo-mensagem').val();
    }
    
    app.showLoading();
    $.ajax({
        url: SERVERDATA + "/api/ouvidoria/enviar",
        dataType: "jsonp",
        data: params,
        timeout: TIMEOUT,
        success: function(response) {
            if(!response.erro)
                showAlertComTitulo('Mensagem enviada!', response.mensagem);
            else
                showAlert(response.mensagem);
            app.hideLoading();
        },
        error: dataSource_error
    });
}