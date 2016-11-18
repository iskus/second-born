$(function() {
    $('<div/>').addClass('welcome').css({
        //'position': 'fixed',
        //'top': '50%',
        //'left': '50%',
        //'width': '600px',
        //'height': '200px',
        //'margin': '-100px 0px 0px -300px',
        //'border': '1px solid white'
        //'display': 'none'
    }).text('WELCOME TO IFW')
        .appendTo($('body')).animate({display: 'block'}, 1500, function() {$(this).show();});
});