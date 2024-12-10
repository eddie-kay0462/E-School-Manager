// // Hide error messages initially
// document.querySelectorAll('.text-danger').forEach(element => element.style.display = 'none');

// document.getElementById('studentRegistrationForm').addEventListener('submit', function(e) {
//     e.preventDefault();
//     let isValid = true;

//     // Validate Student ID
//     const studentId = document.getElementById('studentId').value;
//     if (!studentId || !/^STU-\d{3}$/.test(studentId)) {
//         document.getElementById('studentIdError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('studentIdError').style.display = 'none';
//     }

//     // Validate First Name
//     const firstName = document.getElementById('firstName').value.trim();
//     if (!firstName) {
//         document.getElementById('firstNameError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('firstNameError').style.display = 'none';
//     }

//     // Validate Last Name 
//     const lastName = document.getElementById('lastName').value.trim();
//     if (!lastName) {
//         document.getElementById('lastNameError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('lastNameError').style.display = 'none';
//     }

//     // Validate Date of Birth
//     const dob = document.getElementById('dob').value;
//     const dobDate = new Date(dob);
//     const today = new Date();
//     const minAge = 10; // Minimum age for student
//     const maxAge = 20; // Maximum age for student
    
//     if (!dob || dobDate >= today || 
//         (today.getFullYear() - dobDate.getFullYear() < minAge) ||
//         (today.getFullYear() - dobDate.getFullYear() > maxAge)) {
//         document.getElementById('dobError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('dobError').style.display = 'none';
//     }

//     // Validate Gender
//     const gender = document.getElementById('gender').value;
//     if (!gender) {
//         document.getElementById('genderError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('genderError').style.display = 'none';
//     }

//     // Validate Class
//     const classSelected = document.querySelector('input[name="class"]:checked');
//     if (!classSelected) {
//         document.getElementById('classError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('classError').style.display = 'none';
//     }

//     // Validate Enrollment Date
//     const enrollmentDate = document.getElementById('enrollmentDate').value;
//     const enrollmentDateObj = new Date(enrollmentDate);
//     if (!enrollmentDate || enrollmentDateObj > today || 
//         enrollmentDateObj < new Date(today.getFullYear() - 1, today.getMonth())) {
//         document.getElementById('enrollmentDateError').style.display = 'block';
//         isValid = false;
//     } else {
//         document.getElementById('enrollmentDateError').style.display = 'none';
//     }

//     if (isValid) {
//         // If all validations pass, submit the form
//         if (e.submitter && e.submitter.type === 'submit') {
//             this.submit();
//         }
//     }
// });

// // Add input event listeners to validate in real-time but prevent submission
// const inputs = ['studentId', 'firstName', 'lastName', 'dob', 'gender', 'enrollmentDate'];
// inputs.forEach(inputId => {
//     document.getElementById(inputId).addEventListener('input', function() {
//         // Create a mock submit event that won't actually submit
//         const mockEvent = new Event('submit', {
//             bubbles: true,
//             cancelable: true
//         });
//         // Add a fake submitter to indicate this wasn't from the submit button
//         mockEvent.submitter = { type: 'input' };
//         document.getElementById('studentRegistrationForm').dispatchEvent(mockEvent);
//     });
// });

// // Add change event listener for radio buttons
// document.querySelectorAll('input[name="class"]').forEach(radio => {
//     radio.addEventListener('change', function() {
//         document.getElementById('classError').style.display = 'none';
//     });
// });


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


