//store placeholder val
$("input").each(function () {


    $(this).data('holder', $(this).attr('placeholder'));
    $(this).focusin(function () {
        $(this).attr('placeholder', '');
    });
    $(this).focusout(function () {
        $(this).attr('placeholder', $(this).data('holder'));
    });

});


// add astrisk to required fields
$('input').each(function () {
    if ($(this).attr('required') === 'required') {
        $(this).after('<span class="astrisk">*</span>');
    }
});

function success(){
    return swal({
        title: 'registed successfully',
        text: 'you will redirected to your profile after 5s',
        icon: 'success',
        timer: 5000,
        button: false,
    });
}


const signupButton = document.getElementById('sign-up');
const loginButton  = document.getElementById('LogIn');
const container    = document.getElementById('container');

signupButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

loginButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});
