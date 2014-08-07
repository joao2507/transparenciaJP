function initDropDown(container) {
    // if (kendo.ui.DropDownList) {
    //   $(container+" .dropdown").kendoDropDownList();
    //}
}

function closeDropDown(container) {
    //if (kendo.ui.DropDownList) {
    //  $(container+" .dropdown").data("kendoDropDownList").close();
    //}
}

function showAlert(texto) {
    if (isPhoneGap()) {
        navigator.notification.alert(
                texto,
                null,
                'Alerta',
                'OK'
                );
    } else {
        alert(texto);
    }
}

function showAlertComTitulo(titulo, texto) {
    if (isPhoneGap()) {
        navigator.notification.alert(
                texto,
                null,
                titulo,
                'OK'
                );
    } else {
        alert(texto);
    }
}

function closeModalFiltroReceita() {
    $("#filtroReceita").data("kendoMobileModalView").close();
    app.hideLoading();
}
function closeModalFiltroDespesa() {
    $("#filtroDespesa").data("kendoMobileModalView").close();
    app.hideLoading();
}

function getReceitaAno() {
    var data = [];
    var date = new Date();
    var anoAgora = date.getFullYear();
    for (var i = anoAgora; i >= 2009; i--) {
        data.push({
            ano: i
        });
    }
    return data;
}

function getListaMes(ano) {
    var data = [];
    var date = new Date();
    var anoAgora = date.getFullYear();
    var mesIndex = date.getMonth() + 1;

    if (ano == anoAgora) {
        var nomeMeses = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        for (var i = 1; i <= mesIndex; i++) {
            data.push({
                index: i, mes: nomeMeses[i]
            });
        }
    } else {
        var data = [
            {index: 1, mes: 'Janeiro'},
            {index: 2, mes: 'Fevereiro'},
            {index: 3, mes: 'Março'},
            {index: 4, mes: 'Abril'},
            {index: 5, mes: 'Maio'},
            {index: 6, mes: 'Junho'},
            {index: 7, mes: 'Julho'},
            {index: 8, mes: 'Agosto'},
            {index: 9, mes: 'Setembro'},
            {index: 10, mes: 'Outubro'},
            {index: 11, mes: 'Novembro'},
            {index: 12, mes: 'Dezembro'}
        ];
    }
    return data;
}

function dataSource_error(e) {
    app.hideLoading();
    
    if (isPhoneGap())
        navigator.app.backHistory();
    else
        history.go(-1);
    showAlert('Não foi possível conectar ao servidor, por favor, tente novamente.');
}

function isPhoneGap() {
    return window.PhoneGap;
}