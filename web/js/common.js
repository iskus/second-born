$(document).ready(function () {
    $('.shadow').on('click', function () {
        location.href = '/shadow';
    });
});
function checkEmail(email) {
    if (email) {
        var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
        if (pattern.test(email)) {
            //
        } else {
            //
        }
    } else {
        //
    }

}