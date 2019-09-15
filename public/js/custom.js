function loadData(url, elm) {
    if (elm == undefined) elm = 'main-list'

    $.get(encodeURI(url)).done(function (content) {
        $('#' + elm).html(content);
    });
}