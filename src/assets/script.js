//input validation for search bar form
document.addEventListener("DOMContentLoaded", function() {
    searchForm = document.getElementById("searchForm");
    searchInput = document.getElementById("search");
    searchError = document.getElementById("searchError");

    if (searchForm) {  // Check if the form exists
        searchForm.onsubmit = function(event) {
            let searchValue = searchInput.value.trim();
            let errorMessage = "";  


            //input check
            if (searchValue === "") {
                errorMessage = "Per favore, inserisci un termine di ricerca.";
            } else if (searchValue.length < 3) {
                
                errorMessage = "Il termine di ricerca deve contenere almeno 3 caratteri.";
            } else if (/[;<>|]/.test(searchValue)) {
                
                errorMessage = "Il termine di ricerca contiene caratteri non validi: ; < > |";
            }

            //error message
            if (errorMessage) {
                searchError.textContent = errorMessage; 
                event.preventDefault(); 
            } else {
                searchError.textContent = ""; 
            }
        };
    }
});

// input validation sign up form
document.addEventListener("DOMContentLoaded", function() {
    const signUpForm = document.getElementById("signUpForm");
    const emailInput = document.getElementById("mail");
    const passwordInput = document.getElementById("pwd");
    const confirmPasswordInput = document.getElementById("confirmPwd");
    
    // Clear messages
    function clearErrors() {
        document.querySelectorAll(".error-message").forEach(el => el.textContent = '');
        document.querySelectorAll(".error-message").forEach(el => el.classList.remove('active'));
    }
    
    // Function to validate the form
    signUpForm.onsubmit = function(event) {
        //clearErrors(); // Clear previous errors

        let valid = true;

        // Email validation
        const email = emailInput.value.trim();
        if (email === '') {
            document.getElementById("emailError").textContent = "Email is required.";
            document.getElementById("emailError").classList.add('active');
            valid = false;
        } else if (!email.includes('@')) {
            document.getElementById("emailError").textContent = "Invalid email format.";
            document.getElementById("emailError").classList.add('active');
            valid = false;
        }

        // Password validation
        const password = passwordInput.value;
        if (password.length < 8) {
            document.getElementById("passwordError").textContent = "Password deve essere almeno di 8 caratter";
            document.getElementById("passwordError").classList.add('active');
            valid = false;
        } else if (password.length > 16) {
            document.getElementById("passwordError").textContent = "Password non puo' superare i 16 caratteri";
            document.getElementById("passwordError").classList.add('active');
            valid = false;
        }

        //confirm password validation
        const confirmPassword = confirmPasswordInput.value;
        if (confirmPassword !== password) {
            document.getElementById("confirmPasswordError").textContent = "Le password non corrispondono";
            document.getElementById("confirmPasswordError").classList.add('active');
            valid = false;
        }

        // Don't submit if invalid
        if (!valid) {
            event.preventDefault();
        }
    };
});

