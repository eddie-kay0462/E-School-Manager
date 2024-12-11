// Function to show all error messages
function showAllErrors() {
    document.querySelectorAll('.text-danger').forEach(error => {
        error.style.display = 'block';
    });
}

// Show all errors on first interaction with any form element
let firstInteraction = true;
document.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('focus', function() {
        if (firstInteraction) {
            showAllErrors();
            firstInteraction = false;
        }
    });
});

// Validate first name
document.getElementById('firstName').addEventListener('input', function() {
    const firstNameError = document.getElementById('firstNameError');
    firstNameError.style.display = this.value.trim() !== '' ? 'none' : 'block';
});

// Validate last name
document.getElementById('lastName').addEventListener('input', function() {
    const lastNameError = document.getElementById('lastNameError');
    lastNameError.style.display = this.value.trim() !== '' ? 'none' : 'block';
});

// Validate email
document.getElementById('email').addEventListener('input', function() {
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailError.style.display = emailRegex.test(this.value) ? 'none' : 'block';
});

// Validate password
// document.getElementById('password').addEventListener('input', function() {
//     const password = this.value;
//     const requirements = [
//         { regex: /.{8,}/, element: 'minLength' },
//         { regex: /[A-Z]/, element: 'uppercase' },
//         { regex: /[a-z]/, element: 'lowercase' },
//         { regex: /[0-9]/, element: 'number' },
//         { regex: /[@$!%*?&]/, element: 'specialChar' }
//     ];

//     // Check each requirement individually
//     requirements.forEach(req => {
//         const element = document.getElementById(req.element);
//         if (element) {
//             element.style.display = req.regex.test(password) ? 'none' : 'block';
//         }
//     });

//     // Check confirm password match if it has a value
//     const confirmPassword = document.getElementById('confirmPassword');
//     if (confirmPassword.value) {
//         const confirmPasswordError = document.getElementById('confirmPasswordError');
//         confirmPasswordError.style.display = confirmPassword.value === password ? 'none' : 'block';
//     }
// });

// Validate password V2
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const requirements = [
        { regex: /.{8,}/, element: 'minLength' },
        { regex: /[A-Z]/, element: 'uppercase' },
        { regex: /[a-z]/, element: 'lowercase' },
        { regex: /[0-9]/, element: 'number' },
        { regex: /[@$!%*?&]/, element: 'specialChar' }
    ];

    // Check if ALL requirements are met
    const allRequirementsMet = requirements.every(req => 
        req.regex.test(password)
    );

    // If all requirements are met, hide the entire error section
    const passwordError = document.getElementById('passwordError');
    passwordError.style.display = allRequirementsMet ? 'none' : 'block';

    // Individually style each requirement line
    requirements.forEach(req => {
        const element = document.getElementById(req.element);
        if (element) {
            element.style.textDecoration = req.regex.test(password) 
                ? 'line-through' 
                : 'none';
        }
    });
    // ... rest of the code
    //     // Check confirm password match if it has a value
    const confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword.value) {
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        confirmPasswordError.style.display = confirmPassword.value === password ? 'none' : 'block';
    }
});

// Validate confirm password
document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    confirmPasswordError.style.display = this.value === password ? 'none' : 'block';
});

// Validate courses
document.querySelectorAll('input[name="courses[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const coursesError = document.getElementById('coursesError');
        const anyChecked = Array.from(document.querySelectorAll('input[name="courses[]"]'))
            .some(cb => cb.checked);
        coursesError.style.display = anyChecked ? 'none' : 'block';
    });
});

// Validate teaching classes
document.querySelectorAll('input[name="teaching_classes[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const teachingClassesError = document.getElementById('teachingClassesError');
        const anyChecked = Array.from(document.querySelectorAll('input[name="teaching_classes[]"]'))
            .some(cb => cb.checked);
        teachingClassesError.style.display = anyChecked ? 'none' : 'block';
    });
});

// Handle class teacher checkbox
document.getElementById('classTeacherCheck').addEventListener('change', function() {
    const classSelection = document.getElementById('classSelection');
    classSelection.style.display = this.checked ? 'block' : 'none';
    
    // Show/hide class error based on selection
    const classError = document.getElementById('classError');
    if (!this.checked) {
        classError.style.display = 'none';
    }
});

// Validate class selection
document.querySelectorAll('input[name="class"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const classError = document.getElementById('classError');
        classError.style.display = 'none';
    });
});

// Validate teacher ID selection
document.getElementById('teacher_id').addEventListener('change', function() {
    document.getElementById('teacherIdError').style.display = this.value ? 'none' : 'block';
});

// Form submission
document.getElementById('teacherRegistration').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate all fields
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const coursesChecked = Array.from(document.querySelectorAll('input[name="courses[]"]')).some(cb => cb.checked);
    const teachingClassesChecked = Array.from(document.querySelectorAll('input[name="teaching_classes[]"]')).some(cb => cb.checked);
    const isClassTeacher = document.getElementById('classTeacherCheck').checked;
    const classSelected = isClassTeacher ? document.querySelector('input[name="class"]:checked') : true;
    const teacherId = document.getElementById('teacher_id').value;

    // Show any validation errors
    showAllErrors();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRequirements = [
        /.{8,}/, /[A-Z]/, /[a-z]/, /[0-9]/, /[@$!%*?&]/
    ];

    const isValid = 
        firstName !== '' &&
        lastName !== '' &&
        emailRegex.test(email) &&
        passwordRequirements.every(regex => regex.test(password)) &&
        password === confirmPassword &&
        coursesChecked &&
        teachingClassesChecked &&
        teacherId &&
        (!isClassTeacher || (isClassTeacher && classSelected));

    if (isValid) {
        // Hide all error messages
        document.querySelectorAll('.text-danger').forEach(error => {
            error.style.display = 'none';
        });
        
        // Submit the form normally
        this.submit();
    }
});
