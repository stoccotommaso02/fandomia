
function showError(field, message) {
    let errorDiv = document.createElement('p');
    errorDiv.className = 'error';
    errorDiv.role = 'alert';
    errorDiv.innerText = message;
    errorDiv.role= 'alert';
    field.parentNode.insertBefore(errorDiv, field.nextSibling);
}

function checkDate(date) {
    const today = new Date().toISOString().split('T')[0];

    return today < date;
}

function allowedPwd(pwd) {
    return /^[a-zA-Z0-9]+$/.test(pwd);
}

function strongPwd(pwd){   
    if(!(/[A-Z]/.test(pwd)))
        return false;
    if(!(/[a-z]/.test(pwd)))
        return false;
    if(!(/\d/.test(pwd)))
        return false;

    return true;
}


function checkRequired(field) {
    if (field === '') {
        return false;
    }
    return true;
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function clearErrors() {
    document.querySelectorAll(".error").forEach(el => el.textContent = '');
    document.querySelectorAll(".error").forEach(el => el.classList.remove('active'));
}

function handleCancellation(event) {
    
    let cancel = false;
    if (confirm("Sei sicuro di voler cancellare la prenotazione? Questa azione non può essere annullata.")) {
        cancel = true;
    }

    return cancel;
}

document.addEventListener("DOMContentLoaded", function() {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("search");

    if (searchForm) {  
        searchForm.onsubmit = function(event) {
            let searchValue = searchInput.value.trim(); 
            let valid = true;
            clearErrors();

            if (searchValue === "") {
                showError(searchForm,"Per favore, inserisci un termine di ricerca.");
                valid = false;
            } else if (searchValue.length < 3) {
                showError(searchForm,"Il termine di ricerca deve contenere almeno 3 caratteri.");
                valid = false;
            } else if (/[;<>|]/.test(searchValue)) {
                showError(searchForm,"Il termine di ricerca contiene caratteri non validi: ; < > |");
                valid = false;
            }

            if(!valid) event.preventDefault();
        };
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const emailInput = document.getElementById("mail");
    const passwordInput = document.getElementById("pwd");

    if(loginForm){
        loginForm.onsubmit = function(event) {
            let valid = true;
            clearErrors();

            var elements = document.querySelectorAll('.formError');
            elements.forEach(function(element) {
                element.remove();
            });
            const email = emailInput.value.trim();
            if (!checkRequired(email)) {
                showError(emailInput,"il campo email non puo' essere vuoto.");
                valid = false;
            } else if (!validateEmail(email)) {
                showError(emailInput,"Formato email non valido.");
                valid = false;
            }

            const password = passwordInput.value;
            if (password.length < 8 || password === "") {
                showError(passwordInput,"La password deve essere almeno di 8 caratteri");
                valid = false;
            } else if (password.length > 16) {
                showError(passwordInput,"La password non può superare i 16 caratteri");
                valid = false;
            }
            if (!valid) {
                event.preventDefault();
            }
        };
    }
});

document.addEventListener("DOMContentLoaded", function() {

    const signUpForm = document.getElementById("signupForm");
    const emailInput = document.getElementById("mail");
    const passwordInput = document.getElementById("pwd");
    const confirmPasswordInput = document.getElementById("confirmPwd");
    if(signUpForm){
        
        signUpForm.onsubmit = function(event) {
        let valid = true;
        clearErrors();

        const email = emailInput.value.trim();
        if (!checkRequired(email)) {
            showError(emailInput,"il campo email non puo' essere vuoto.");
            valid = false;
        } else if (!validateEmail(email)) {
            showError(emailInput,"Formato email non valido.");
            valid = false;
        }

        const password = passwordInput.value;
        if (!allowedPwd(password)) {
            showError(passwordInput,"La password può contenere solo lettere minuscole, lettere maiuscole e cifre");
            valid = false;
        }
        else if (password.length < 8 || !checkRequired(password)) {
            showError(passwordInput,"La password deve essere almeno di 8 caratteri");
            valid = false;
        } else if (password.length > 16) {
            showError(passwordInput,"La password non può superare i 16 caratteri");
            valid = false;
        }
        else if(!strongPwd(password)) {
            showError(passwordInput, "La password deve contenere almeno: un numero, una lettera maiuscola e una maiuscola");
            valid = false;
        }

        const confirmPassword = confirmPasswordInput.value;
        if (confirmPassword !== password) {
            showError(confirmPasswordInput,"Le password non corrispondono");
            valid = false;
        }
        if (!valid) {
            event.preventDefault();
        }
    };
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const reservationForm = document.getElementById("reservationForm");
    const withdrawDate = document.getElementById("withdrawDate");
    const withdrawTime = document.getElementById("withdrawTime");

    if(reservationForm){
        reservationForm.onsubmit = function(event) {
            let valid = true;
            clearErrors();
            const date = withdrawDate.value;
            const time = withdrawTime.value;
            if(!checkRequired(date) || !checkRequired(time)){
                showError(reservationForm, "inserire sia la data che l'ora del ritiro");
                valid = false;
            }
            else if(!checkDate(date)){
                showError(reservationForm, "Puoi prenotare solo da domani in poi!");
                valid = false;
            }
            if(!valid){
                event.preventDefault();
            }
        }
    }

});

document.addEventListener("DOMContentLoaded", function() {
    const cancelReservationForm = document.getElementById("cancelReservation");
    if (cancelReservationForm) {
        cancelReservationForm.onsubmit = function(event){
            if(!handleCancellation(event)){
                event.preventDefault();
            }
        }
    }
});

function togglePassword() {
    var passwordField = document.getElementById("pwd");
    var showPassword = document.getElementById("showPassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}