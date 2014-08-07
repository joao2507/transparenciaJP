//var SERVERDATA = 'http://fopaserver.com.br/apptransp/app/index.php';
var SERVERDATA = 'http://transparencia.joaopessoa.pb.gov.br/app/index.php';
var app = null;
var TIMEOUT = 10000;

app = new kendo.mobile.Application($(document.body), {
    skin: "flat"
});

app.showLoading();

function onLoad() {
    if (isPhoneGap()) {
        document.addEventListener("deviceready", onDeviceReady, false);
    } else {
        app.hideLoading();
        $('#botoes').slideDown();
    }
}

// device APIs are available
//
function onDeviceReady() {
    //adicionar o evento online
    document.addEventListener("online", onOnline, false);
    //adicionar o evento offline
    document.addEventListener("offline", onOffline, false);
    //monitorar o click no backbutton
    document.addEventListener("backbutton", function(e) {
        app.hideLoading();
        var page_id = app.view().id;
        if (page_id == '/') {
            navigator.notification.confirm(
                    'Você realmente deseja sair?',
                    exitFromApp,
                    'Sair',
                    'Não,Sim'
                    );

        } else {
            e.preventDefault();
            navigator.app.backHistory();
        }
    }
    , false);
    app.hideLoading();
    $('#botoes').slideDown();
}

function onOffline() {
    showAlert('Sem conexão a internet!');
}

function onOnline() {
    $("#modal-alert").data("kendoMobileModalView").close();
    app.hideLoading();
}

function exitFromApp(buttonIndex) {
    if (buttonIndex == 2) {
        if (navigator.app) {
            navigator.app.exitApp();
        } else if (navigator.device) {
            navigator.device.exitApp();
        }
    }
}

function telefonesInit(e) {

    app.showLoading();
    var dataSource = new kendo.data.DataSource({
        dataType: "jsonp",
        transport: {
            read: {
                url: SERVERDATA + "/api/telefones/uteis",
                contentType: "application/json; charset=utf-8",
                dataType: "jsonp",
                cache: true,
                timeout: TIMEOUT,
                type: "GET"
            }
        },
        group: 'letra',
        schema: {
            data: 'data'
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

    $("#telefones-uteis-listview").kendoMobileListView({
        dataSource: dataSource,
        template: kendo.template($("#telefones-uteis-template").html()),
        type: 'group',
        fixedHeaders: true
    });
}
