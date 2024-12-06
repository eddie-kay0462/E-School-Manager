// Function to show all error messages
function showAllErrors() {
document.querySelectorAll('.text-danger').forEach(error => {
    error.style.display = 'block';
});
}




const classSelection = document.getElementById('classSelection');
const isClassTeacher = document.querySelector('input[name="isClassTeacher"]:checked')?.value;
classSelection.style.display = isClassTeacher === 'yes' ? 'block' : 'none';



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
else{
    passwordError.innerHTML = 'Passwords do not match';
    passwordError.style.display = 'block';
}
});

// Validate confirm password
document.getElementById('confirmPassword').addEventListener('input', function() {
const password = document.getElementById('password').value;
const confirmPasswordError = document.getElementById('confirmPasswordError');
confirmPasswordError.style.display = this.value === password ? 'none' : 'block';
// print the password and confirm password
});

// Validate courses
document.querySelectorAll('input[name="courses"]').forEach(checkbox => {
checkbox.addEventListener('change', function() {
    const coursesError = document.getElementById('coursesError');
    const anyChecked = Array.from(document.querySelectorAll('input[name="courses"]'))
        .some(cb => cb.checked);
    coursesError.style.display = anyChecked ? 'none' : 'block';
});
});

// Validate class teacher selection
document.querySelectorAll('input[name="isClassTeacher"]').forEach(radio => {
radio.addEventListener('change', function() {
    const classTeacherError = document.getElementById('classTeacherError');
    classTeacherError.style.display = 'none';

    const classError = document.getElementById('classError');
    if (this.value === 'yes') {
        classError.style.display = 'block';
    } else {
        classError.style.display = 'none';
    }
});
});

// Add this event listener for teacher ID radio buttons
document.querySelectorAll('input[name="teacher_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Hide error message when a selection is made
        document.getElementById('teacherIdError').style.display = 'none';
    });
});


// Handle class selection
document.getElementById('class').addEventListener('change', function() {
const classError = document.getElementById('classError');
classError.style.display = this.value ? 'none' : 'block';
});

function toggleClassSelect() {
const classSelection = document.getElementById('classSelection');
const isClassTeacher = document.querySelector('input[name="isClassTeacher"]:checked');

if (isClassTeacher) {
    classSelection.style.display = isClassTeacher.value === 'yes' ? 'block' : 'none';
}
}

// Form submission
document.getElementById('teacherRegistration').addEventListener('submit', function(e) {
e.preventDefault();
showAllErrors(); // Show all errors on submit attempt

// Validate all fields
const firstName = document.getElementById('firstName').value.trim();
const lastName = document.getElementById('lastName').value.trim();
const email = document.getElementById('email').value;
const password = document.getElementById('password').value;
const confirmPassword = document.getElementById('confirmPassword').value;
const coursesChecked = Array.from(document.querySelectorAll('input[name="courses"]')).some(cb => cb.checked);
const isClassTeacher = document.querySelector('input[name="isClassTeacher"]:checked');
const classSelected = document.getElementById('class').value;
const teacherId = document.querySelector('input[name="teacher_id"]:checked').value;

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
    isClassTeacher &&
    (isClassTeacher.value === 'no' || (isClassTeacher.value === 'yes' && classSelected));

if (isValid) {
    // Hide all error messages on successful validation
    document.querySelectorAll('.text-danger').forEach(error => {
        error.style.display = 'none';
    });
    
    alert('Registration successful! Welcome to our teaching team.');
    // Process form submission
    console.log('Form is valid, processing submission...');
}

// submit the form TO THE PHP FILE
document.getElementById('teacherRegistration').submit();
 });

