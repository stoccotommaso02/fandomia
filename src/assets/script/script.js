
function showError(field, message) {
    // Create a new div element to hold the error message
    let errorDiv = document.createElement('p');
    // Add a class name to the error div for styling
    errorDiv.className = 'error';
    errorDiv.role = 'alert';
    // Set the error message text
    errorDiv.innerText = message;
    errorDiv.role= 'alert';
    // Insert the error message after the field
    field.parentNode.insertBefore(errorDiv, field.nextSibling);
}

function checkDate(date) {
    const today = new Date().toISOString().split('T')[0];

    return today < date;
}

function strongPwd(pwd){    //password must contain at least one special character
    var valid = true;
    var format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    
    if(format.test(pwd)) valid = false;
    if(pwd !== pwd.toLowerCase()) valid = false;
    if( (/\d/.test(pwd))) valid = true;

    return valid;
}


function checkRequired(field) {
    if (field === '') {
        return false; // Field is empty
    }
    return true;
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Clear messages
function clearErrors() {
    document.querySelectorAll(".error").forEach(el => el.textContent = '');
    document.querySelectorAll(".error").forEach(el => el.classList.remove('active'));
}

//ask for confirmation before deleteing a reservation
function handleCancellation(event) {
    
    let cancel = false;
    if (confirm("Sei sicuro di voler cancellare la prenotazione? Questa azione non può essere annullata.")) {
        cancel = true;
    }

    return cancel;
}

//input validation for search bar form
document.addEventListener("DOMContentLoaded", function() {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("search");

    if (searchForm) {  // Check if the form exists
        searchForm.onsubmit = function(event) {
            let searchValue = searchInput.value.trim(); 
            let valid = true;
            clearErrors();

            //input check
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

    // Function to validate the form
    if(loginForm){
        loginForm.onsubmit = function(event) {
            let valid = true;
            clearErrors();
            // Email validation
            const email = emailInput.value.trim();
            if (!checkRequired(email)) {
                showError(emailInput,"il campo email non puo' essere vuoto.");
                valid = false;
            } else if (!validateEmail(email)) {
                showError(emailInput,"Formato email non valido.");
                valid = false;
            }

            // Password validation
            const password = passwordInput.value;
            if (password.length < 8 || password === "") {
                showError(passwordInput,"La password deve essere almeno di 8 caratteri");
                valid = false;
            } else if (password.length > 16) {
                showError(passwordInput,"La password non può superare i 16 caratteri");
                valid = false;
            }
            // Don't submit if invalid
            if (!valid) {
                event.preventDefault();
            }
        };
    }
});

// input validation sign up form
document.addEventListener("DOMContentLoaded", function() {

    const signUpForm = document.getElementById("signupForm");
    const emailInput = document.getElementById("mail");
    const passwordInput = document.getElementById("pwd");
    const confirmPasswordInput = document.getElementById("confirmPwd");
    // Function to validate the form
    if(signUpForm){
        
        signUpForm.onsubmit = function(event) {
        let valid = true;
        clearErrors();

        // Email validation
        const email = emailInput.value.trim();
        if (!checkRequired(email)) {
            showError(emailInput,"il campo email non puo' essere vuoto.");
            valid = false;
        } else if (!validateEmail(email)) {
            showError(emailInput,"Formato email non valido.");
            valid = false;
        }

        // Password validation
        const password = passwordInput.value;
        if (password.length < 8 || !checkRequired(password)) {
            showError(passwordInput,"La password deve essere almeno di 8 caratteri");
            valid = false;
        } else if (password.length > 16) {
            showError(passwordInput,"La password non puo' superare i 16 caratteri");
            valid = false;
        }
        else if(!strongPwd(password)) {
            showError(passwordInput, "L password deve contenere almeno: un numero, un carattere speciale e una maiuscola");
            valid = false;
        }

        //confirm password validation
        const confirmPassword = confirmPasswordInput.value;
        if (confirmPassword !== password) {
            showError(confirmPasswordInput,"Le password non corrispondono");
            valid = false;
        }
        // Don't submit if invalid
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


/* HAMBURGER MENU */
const openButton = document.getElementById('openmenu');
const closeButton = document.getElementById('closemenu');
const media = window.matchMedia('(width < 760px');
const collapsable = document.getElementById('collapsable');
const menuList = document.getElementById('menuList');

function setupMenu(e) {
    if(e.matches) {
        collapsable.setAttribute('inert', '');
        menuList.style.transition = 'none';
    } else {
        collapsable.removeAttribute('inert', '');
    }
}

function openMenu() {
    openButton.setAttribute('aria-expanded', 'true');
    collapsable.removeAttribute('inert');
    menuList.removeAttribute('style');
}

function closeMenu() {
    openButton.setAttribute('aria-expanded', 'false');
    collapsable.setAttribute('inert', '');

    setTimeout(() => {
        menuList.style.transition = 'none';
    }, 500);
}

setupMenu(media);
media.addEventListener('change',function(e) {
    setupMenu(e);
})
openButton.addEventListener('click', openMenu);
closeButton.addEventListener('click', closeMenu);