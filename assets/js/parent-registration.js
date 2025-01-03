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

// Validate parent ID
document.getElementById('parent_id').addEventListener('input', function() {
    const parentIdError = document.getElementById('parentIdError');
    const parentIdRegex = /^PRNT-\d{3}$/i; // Case insensitive match for PRNT-XXX where X is digit
    const isValid = parentIdRegex.test(this.value);
    parentIdError.style.display = isValid ? 'none' : 'block';

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
    const wardIdRegex = /^STU-\d{3}$/i; // Case insensitive match for STU-XXX where X is digit
    wardIdError.style.display = wardIdRegex.test(this.value) ? 'none' : 'block';
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
        this.submit(); // Actually submit the form
    }
});

function validateForm() {
    const parentId = document.getElementById('parent_id').value.trim();
    const parentName = document.getElementById('parentName').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const wardId = document.getElementById('wardId').value.trim();

    const parentIdRegex = /^PRNT-\d{3}$/i;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const wardIdRegex = /^STU-\d{3}$/i;
    const passwordRegex = {
        minLength: /.{8,}/,
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/,
        specialChar: /[@$!%*?&]/
    };

    return (
        parentIdRegex.test(parentId) &&
        parentName !== '' &&
        emailRegex.test(email) &&
        Object.values(passwordRegex).every(regex => regex.test(password)) &&
        password === confirmPassword &&
        wardIdRegex.test(wardId)
    );
}
