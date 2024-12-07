// Hide error messages initially
document.querySelectorAll('.text-danger').forEach(element => element.style.display = 'none');

document.getElementById('studentRegistrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;

    // Validate Student ID
    const studentId = document.getElementById('studentId').value;
    if (!studentId || !/^STU-\d{3}$/.test(studentId)) {
        document.getElementById('studentIdError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('studentIdError').style.display = 'none';
    }

    // Validate First Name
    const firstName = document.getElementById('firstName').value.trim();
    if (!firstName) {
        document.getElementById('firstNameError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('firstNameError').style.display = 'none';
    }

    // Validate Last Name 
    const lastName = document.getElementById('lastName').value.trim();
    if (!lastName) {
        document.getElementById('lastNameError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('lastNameError').style.display = 'none';
    }

    // Validate Date of Birth
    const dob = document.getElementById('dob').value;
    const dobDate = new Date(dob);
    const today = new Date();
    const minAge = 10; // Minimum age for student
    const maxAge = 20; // Maximum age for student
    
    if (!dob || dobDate >= today || 
        (today.getFullYear() - dobDate.getFullYear() < minAge) ||
        (today.getFullYear() - dobDate.getFullYear() > maxAge)) {
        document.getElementById('dobError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('dobError').style.display = 'none';
    }

    // Validate Gender
    const gender = document.getElementById('gender').value;
    if (!gender) {
        document.getElementById('genderError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('genderError').style.display = 'none';
    }

    // Validate Class
    const classSelected = document.querySelector('input[name="class"]:checked');
    if (!classSelected) {
        document.getElementById('classError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('classError').style.display = 'none';
    }

    // Validate Enrollment Date
    const enrollmentDate = document.getElementById('enrollmentDate').value;
    const enrollmentDateObj = new Date(enrollmentDate);
    if (!enrollmentDate || enrollmentDateObj > today || 
        enrollmentDateObj < new Date(today.getFullYear() - 1, today.getMonth())) {
        document.getElementById('enrollmentDateError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('enrollmentDateError').style.display = 'none';
    }

    if (isValid) {
        // If all validations pass, submit the form
        if (e.submitter && e.submitter.type === 'submit') {
            this.submit();
        }
    }
});

// Add input event listeners to validate in real-time but prevent submission
const inputs = ['studentId', 'firstName', 'lastName', 'dob', 'gender', 'enrollmentDate'];
inputs.forEach(inputId => {
    document.getElementById(inputId).addEventListener('input', function() {
        // Create a mock submit event that won't actually submit
        const mockEvent = new Event('submit', {
            bubbles: true,
            cancelable: true
        });
        // Add a fake submitter to indicate this wasn't from the submit button
        mockEvent.submitter = { type: 'input' };
        document.getElementById('studentRegistrationForm').dispatchEvent(mockEvent);
    });
});

// Add change event listener for radio buttons
document.querySelectorAll('input[name="class"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('classError').style.display = 'none';
    });
});
