function toggleClassLinks(courseCode) {
    const classLinks = document.getElementById(`classes-${courseCode}`);
    if (classLinks.style.display === 'block') {
        classLinks.style.display = 'none';
    } else {
        // Hide all other class links first
        document.querySelectorAll('.class-links').forEach(el => {
            el.style.display = 'none';
        });
        classLinks.style.display = 'block';
    }
}

function showCourseRecords(courseName, courseCode) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show selected course tab
    document.getElementById(courseName).classList.add('active');

    // Update course info card
    const courseRecords = document.getElementById('courseRecords');
    const courseTitle = document.getElementById('courseTitle');
    const courseMessage = document.getElementById('courseMessage');

    courseTitle.textContent = courseName;
    courseMessage.textContent = `Viewing records for ${courseName}`;
    courseRecords.classList.remove('d-none');
}

function openEditModal(studentId, courseCode, studentName) {
    // Get the modal
    const modal = document.getElementById('editGradesModal');
    
    // Set student name and ID in the modal
    document.getElementById('studentNameInModal').textContent = studentName;
    document.getElementById('studentId').value = studentId;
    document.getElementById('courseCode').value = courseCode; // Set courseCode
    // Fetch grades from the server
    fetch(`../actions/get_grades.php?studentId=${studentId}&courseCode=${courseCode}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Check if data exists
            if (!data) {
                console.error('No data received wai');
                return;
            }
            // alert the studentid in script tag
            console.log('Student ID:', studentId);
            // Populate the form with the fetched grades
            document.getElementById('assignmentScore').value = data.assignment_score || 0;
            document.getElementById('testScore').value = data.test_score ?? 0;
            document.getElementById('midtermScore').value = data.mid_term_score ?? 0;
            document.getElementById('examScore').value = data.exam_score ?? 0;
        })
        .catch(error => {
            console.error('Error fetching grades:', error);
            // Set default values to 0 if there's an error
            document.getElementById('assignmentScore').value = 0;
            document.getElementById('testScore').value = 0;
            document.getElementById('midtermScore').value = 0;
            document.getElementById('examScore').value = 0;
        });

    // Show the modal
    modal.style.display = "block";
}

function closeEditModal() {
    const modal = document.getElementById('editGradesModal');
    modal.style.display = 'none';
}

document.getElementById('editGradesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        studentId: document.getElementById('studentId').value,
        courseCode: document.getElementById('courseCode').value,
        assignmentScore: document.getElementById('assignmentScore').value,
        testScore: document.getElementById('testScore').value,
        midtermScore: document.getElementById('midtermScore').value,
        examScore: document.getElementById('examScore').value,
        classId: document.getElementById('classId').value // Include classId
    };

    fetch('../actions/save_grades.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Grades saved successfully!');
            closeEditModal();
            location.reload();
        } else {
            alert('Error saving grades: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving grades');
    });
});

function openAddModal(studentId, courseCode, studentName) {
    // Get the modal
    const modal = document.getElementById('editGradesModal');
    
    // Set student name and ID in the modal
    document.getElementById('studentNameInModal').textContent = studentName;
    document.getElementById('studentId').value = studentId;
    
    // Set all scores to 0 for new grade entry
    document.getElementById('assignmentScore').value = 0;
    document.getElementById('testScore').value = 0;
    document.getElementById('midtermScore').value = 0;
    document.getElementById('examScore').value = 0;

    // Show the modal
    modal.style.display = "block";
}

// Show first course tab by default
document.addEventListener('DOMContentLoaded', () => {
    const firstCourse = document.querySelector('.course-item');
    if (firstCourse) {
        const courseName = firstCourse.querySelector('span').textContent;
        const courseCode = firstCourse.parentElement.querySelector('.class-links').id.replace('classes-', '');
        showCourseRecords(courseName + '-JSS1', courseCode);
    }
});
