// Add this after the existing JavaScript code
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const form = document.getElementById('studentRegistrationForm');
    const studentId = document.getElementById('studentId');
    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const dob = document.getElementById('dob');
    const gender = document.getElementById('gender');
    const enrollmentDate = document.getElementById('enrollmentDate');
    const classInputs = document.getElementsByName('class');

    // Show all errors initially when form is interacted with
    form.addEventListener('click', function() {
        validateStudentId();
        validateName(firstName, 'firstNameError');
        validateName(lastName, 'lastNameError');
        validateDob();
        validateGender();
        validateEnrollmentDate();
        validateClass();
    });

    // Individual field validations
    studentId.addEventListener('input', validateStudentId);
    firstName.addEventListener('input', () => validateName(firstName, 'firstNameError'));
    lastName.addEventListener('input', () => validateName(lastName, 'lastNameError'));
    dob.addEventListener('change', validateDob);
    gender.addEventListener('change', validateGender);
    enrollmentDate.addEventListener('change', validateEnrollmentDate);
    classInputs.forEach(input => input.addEventListener('change', validateClass));

    function validateStudentId() {
        const regex = /^STU-\d{3}$/;
        const error = document.getElementById('studentIdError');
        if (!studentId.value || !regex.test(studentId.value)) {
            studentId.classList.add('is-invalid');
            error.style.display = 'block';
            return false;
        }
        studentId.classList.remove('is-invalid');
        error.style.display = 'none';
        return true;
    }
    
    function validateName(input, errorId) {
        const regex = /^[a-zA-Z\s]+$/;
        const error = document.getElementById(errorId);
        if (!regex.test(input.value)) {
            input.classList.add('is-invalid');
            error.style.display = 'block';
            return false;
        }
        input.classList.remove('is-invalid');
        error.style.display = 'none';
        return true;
    }

    function validateDob() {
        const error = document.getElementById('dobError');
        const birthDate = new Date(dob.value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        
        if (age < 10 || age > 28) {
            dob.classList.add('is-invalid');
            error.style.display = 'block';
            return false;
        }
        dob.classList.remove('is-invalid');
        error.style.display = 'none';
        return true;
    }

    function validateGender() {
        const error = document.getElementById('genderError');
        if (!gender.value) {
            gender.classList.add('is-invalid');
            error.style.display = 'block';
            return false;
        }
        gender.classList.remove('is-invalid');
        error.style.display = 'none';
        return true;
    }

    function validateEnrollmentDate() {
        const error = document.getElementById('enrollmentDateError');
        const enrollDate = new Date(enrollmentDate.value);
        const today = new Date();
        
        if (!enrollmentDate.value || enrollDate > today) {
            enrollmentDate.classList.add('is-invalid');
            error.style.display = 'block';
            return false;
        }
        enrollmentDate.classList.remove('is-invalid');
        error.style.display = 'none';
        return true;
    }

    function validateClass() {
        const error = document.getElementById('classError');
        let isSelected = false;
        classInputs.forEach(input => {
            if (input.checked) isSelected = true;
        });
        
        if (!isSelected) {
            error.style.display = 'block';
            return false;
        }
        error.style.display = 'none';
        return true;
    }

    // Form submission validation
    form.addEventListener('submit', function(event) {
        const isValid = 
            validateStudentId() &&
            validateName(firstName, 'firstNameError') &&
            validateName(lastName, 'lastNameError') &&
            validateDob() &&
            validateGender() &&
            validateEnrollmentDate() &&
            validateClass();

        if (!isValid) {
            event.preventDefault();
        }
    });
});



