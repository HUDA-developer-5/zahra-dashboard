$('.validate-form button').each(function(){
    if(!$(this).hasClass('btn-cancel')){
        $(this).click (function(e) {
            e.preventDefault();
            validateInputs(e);
        });
    }
})
/*=============error================*/
const setError = (element, message) => {
    const inputControl = element.closest('.validate-input');
    const errorDisplay = inputControl.find('.error-note');

    errorDisplay.text(message);
    inputControl.addClass('error');
    inputControl.removeClass('success')
}
/*=============setSuccess================*/
const setSuccess = element => {
    const inputControl = element.closest('.validate-input');
    const errorDisplay = inputControl.find('.error-note');

    errorDisplay.text('');
    inputControl.addClass('success');
    inputControl.removeClass('error');
};
/*=============Valid E-mail================*/
const isValidEmail = email => {
    const re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    return re.test(String(email).toLowerCase());
}
/*=============valid input filelds================*/
const validateInputs = (e) => {
    const form = $(e.currentTarget).closest('.validate-form');
    const username = form.find('.username');
    const email = form.find('.email');
    const phone = form.find('.phone');
    const password = form.find('.password');
    const password2 = form.find('.password2');
    const password3 = form.find('.password3');
    const checkInput = form.find('.checkInput');
    const requiredInput = form.find('.requiredInput');
    const onlyText = form.find('.only-text');
    const onlyNumber = form.find('.only-number');

    const usernameValue = username.val();
    const emailValue = email.val();
    const passwordValue = password.val();
    const password2Value = password2.val();
    const password3Value = password3.val();
    const phoneValue = phone.val();
    var regex = /[!@#$%^&*()+\=\[\]{};':"\\|,.<>\/?]/;
    var letters = /[a-zA-Z]/;

    if( requiredInput.length != 0 ) {
        $(requiredInput).each(function(){
            if($(this).prop('required') == true && $(this).val() == '') {
                setError($(this), 'This is felid required');
            } else {
                setSuccess($(this));
            }
        })
    }

    if( onlyNumber.length != 0 ) {
        $(onlyNumber).each(function(){
            if (letters.test($(this).val())) {
                setError($(this), 'this must not contain letters.')
            } else if (regex.test($(this).val()) ) {
                setError(($(this)), 'this must not contain special characters.')
            } else {
                if($(this).prop('required') == true && $(this).val() == '') {
                    setError($(this), 'This is felid required');
                } else {
                    setSuccess($(this));
                }
            }
        })
    }

    if( onlyText.length != 0 ) {
        $(onlyText).each(function(){
            if (!letters.test($(this).val()) && $(this).val() != '') {
                setError($(this), 'this should be letters.')
            } else if (regex.test($(this).val()) && $(this).val() != '') {
                setError(($(this)), 'this must not contain special characters.')
            } else {
                if($(this).prop('required') == true && $(this).val() == '') {
                    setError($(this), 'This is felid required');
                } else {
                    setSuccess($(this));
                }
            }
        })
    }
    
    if( username.length != 0 ) {
        if(username.prop('required') == true && usernameValue == '') {
            setError(username, 'Username is required');
        } else if (usernameValue.length > 50 ) {
            setError(username, 'Username must be maximum 20 character.')
        } else if (regex.test(usernameValue) ) {
            setError(username, 'Username must not contain special characters.')
        } else {
            setSuccess(username);
        }
    }
/*=============email================*/
    if( email.length != 0 ) {
        if(email.prop('required') == true && emailValue == '') {
            setError(email, 'Email is required');
        } else if (!isValidEmail(emailValue) && emailValue != '') {
            setError(email, 'Provide a valid email address');
        } else {
            setSuccess(email);
        }
    }
/*=============password================*/
    if( password.length != 0 ) {
        if(password.prop('required') == true && passwordValue == '') {
            setError(password, 'Password is required');
        } else if (passwordValue.length < 8 ) {
            setError(password, 'Password must be at least 8 character.')
        } else if (passwordValue.length > 20 ) {
            setError(password, 'Password must be maximum 20 character.')
        } else {
            setSuccess(password);
        }
    }

    if( password2.length != 0 ) {
        if(password2.prop('required') == true && password2Value == '') {
            setError(password2, 'Please confirm your password');
        } else if (password2Value !== passwordValue) {
            setError(password2, "Passwords doesn't match");
        } else {
            setSuccess(password2);
        }
    }
    if( password3.length != 0 ) {
        if(password3.prop('required') == true && password3Value == '') {
            setError(password3, 'Please confirm your password');
        } else if (password3Value !== password2Value) {
            setError(password3, "Passwords doesn't match");
        } else {
            setSuccess(password3);
        }
    }

/*=============phone================*/
    if( phone.length != 0 ) {
        if(phone.prop('required') == true  && phoneValue == '') {
            setError(phone, 'Phone is required');
        } else if (phoneValue.length > 16 ) {
            setError(phone, 'phone must be maximum 16 character.')
        } else if (regex.test(phoneValue) ) {
            setError(phone, 'phone must not contain special characters.')
        } else if (letters.test(phoneValue) ) {
            setError(phone, 'phone must not contain letters.')
        } else {
            setSuccess(phone);
        }
    }
/*=============check Input================*/
    if( checkInput.length != 0 ) {
        $(checkInput).each(function(){
            if($(this).prop('required') == true  && $(this).prop('checked') == false) {
                setError($(this), 'This is required');
            } else {
                setSuccess($(this));
            }
        })

        
    }

};
