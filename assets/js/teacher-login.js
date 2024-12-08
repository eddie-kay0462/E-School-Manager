// Function to show error messages selectively
function showError(errorElement, show) {
    if (errorElement) {
        errorElement.style.display = show ? 'block' : 'none';
    }
}

// Validate teacher ID
document.getElementById('teacherId').addEventListener('input', function() {
    const teacherIdError = document.getElementById('teacherIdError');
    const teacherIdRegex = /^TEACH-\d{3}$/i;
    const isValid = teacherIdRegex.test(this.value);
    showError(teacherIdError, !isValid);
});

// Validate email
document.getElementById('email').addEventListener('input', function() {
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(this.value);
    showError(emailError, !isValid);
});

// Validate password
document.getElementById('password').addEventListener('input', function() {
    const passwordError = document.getElementById('passwordError');
    const isValid = this.value.length > 0;
    showError(passwordError, !isValid);
});

// Form submission
document.getElementById('teacherLogin').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const teacherId = document.getElementById('teacherId').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validation rules
    const teacherIdRegex = /^TEACH-\d{3}$/i;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validate each field and show/hide errors
    const teacherIdValid = teacherIdRegex.test(teacherId);
    const emailValid = emailRegex.test(email);
    const passwordValid = password.length > 0;

    showError(document.getElementById('teacherIdError'), !teacherIdValid);
    showError(document.getElementById('emailError'), !emailValid);
    showError(document.getElementById('passwordError'), !passwordValid);

    // Submit if all valid
    if (teacherIdValid && emailValid && passwordValid) {
        this.submit();
    }

    else {
        alert('Invalid teacher ID, email, or password');
    }
});
