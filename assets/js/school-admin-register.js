// Function to show all error messages
function showAllErrors() {
    document.querySelectorAll('.text-danger').forEach(error => {
        error.style.display = 'block';
    });
}

// Show all errors on first interaction with any form element
let firstInteraction = true;
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', function() {
        if (firstInteraction) {
            showAllErrors();
            firstInteraction = false;
        }
    });
});
document.getElementById('adminId').addEventListener('input', function() {
    const adminIdError = document.getElementById('adminIdError');
    adminIdError.style.display = this.value.trim().match(/^ADMIN-\d{3}$/) ? 'none' : 'block';
});
// Validate first name
document.getElementById('firstName').addEventListener('input', function() {
    const firstNameError = document.getElementById('firstNameError');
    firstNameError.style.display = this.value.trim().length >= 2 ? 'none' : 'block';
});

// Validate last name
document.getElementById('lastName').addEventListener('input', function() {
    const lastNameError = document.getElementById('lastNameError');
    lastNameError.style.display = this.value.trim().length >= 2 ? 'none' : 'block';
});

// Validate email
document.getElementById('email').addEventListener('input', function() {
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailError.style.display = emailRegex.test(this.value) ? 'none' : 'block';
});

// Validate password
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const requirements = [
        { regex: /.{8,}/, element: 'minLength' },
        { regex: /[A-Z]/, element: 'uppercase' },
        { regex: /[a-z]/, element: 'lowercase' },
        { regex: /[0-9]/, element: 'number' },
        { regex: /[@$!%*?&]/, element: 'specialChar' }
    ];

    requirements.forEach(req => {
        const element = document.getElementById(req.element);
        if (element) {
            element.style.display = req.regex.test(password) ? 'none' : 'block';
        }
    });

    // Hide the main password error only if all requirements are met
    const passwordError = document.getElementById('passwordError');
    const allRequirementsMet = requirements.every(req => req.regex.test(password));
    if (allRequirementsMet) {
        passwordError.style.display = 'none';
    }
});

// Validate confirm password
document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    confirmPasswordError.style.display = this.value === password ? 'none' : 'block';
});

// Form submission
document.getElementById('adminRegistration').addEventListener('submit', function(e) {
    e.preventDefault();
    showAllErrors(); // Show all errors on submit attempt
    
    // Validate all fields here
    const isValid = validateForm();
    
    if (isValid) {
        // Process form submission
        console.log('Form is valid, processing submission...');
        this.submit(); // Actually submit the form
    }
});

function validateForm() {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = {
        minLength: /.{8,}/,
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/,
        specialChar: /[@$!%*?&]/
    };

    return (
        firstName.length >= 2 &&
        lastName.length >= 2 &&
        emailRegex.test(email) &&
        Object.values(passwordRegex).every(regex => regex.test(password)) &&
        password === confirmPassword
    );
}
