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

// Validate parent name
document.getElementById('parentName').addEventListener('input', function() {
    const nameError = document.getElementById('nameError');
    nameError.style.display = this.value.trim() !== '' ? 'none' : 'block';
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

// Validate ward ID
document.getElementById('wardId').addEventListener('input', function() {
    const wardIdError = document.getElementById('wardIdError');
    // Assuming ward ID should be a non-empty string
    // You might want to add more specific validation rules for ward ID format
    wardIdError.style.display = this.value.trim() !== '' ? 'none' : 'block';
});

// Form submission
document.getElementById('parentRegistration').addEventListener('submit', function(e) {
    e.preventDefault();
    showAllErrors(); // Show all errors on submit attempt
    
    // Validate all fields here
    const isValid = validateForm();
    
    if (isValid) {
        // Process form submission
        console.log('Form is valid, processing submission...');
    }
});

function validateForm() {
    const parentName = document.getElementById('parentName').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const wardId = document.getElementById('wardId').value.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = {
        minLength: /.{8,}/,
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/,
        specialChar: /[@$!%*?&]/
    };

    return (
        parentName !== '' &&
        emailRegex.test(email) &&
        Object.values(passwordRegex).every(regex => regex.test(password)) &&
        password === confirmPassword &&
        wardId !== ''
    );
}
