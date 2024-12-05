function toggleClassSelect() {
    const classSelection = document.getElementById('classSelection');
    const isClassTeacher = document.querySelector('input[name="isClassTeacher"]:checked').value;
    classSelection.style.display = isClassTeacher === 'yes' ? 'block' : 'none';
}

document.getElementById('teacherRegistration').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your form submission logic here
   //get the first name, last name, email, password, class, and isClassTeacher
   const firstName = document.getElementById('firstName').value;
   const lastName = document.getElementById('lastName').value;
   const email = document.getElementById('email').value;
   const password = document.getElementById('password').value;
   const classResponsible = document.getElementById('class').value;
   const isClassTeacher = document.querySelector('input[name="isClassTeacher"]:checked').value;

   //validate the form
   if(firstName === '' || lastName === '' || email === '' || password === '' || classResponsible === '' || isClassTeacher === ''){
    alert('Please fill in all fields');
    return;
   }

});