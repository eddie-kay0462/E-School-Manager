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
    console.log(studentId, courseCode);
    fetch(`../actions/get_grades.php?student_id=${studentId}&course_code=${courseCode}`)
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
            console.log(data);
            // Populate the form with the fetched grades or set to 0 if not found
            document.getElementById('assignmentScore').value = data.assignment_score ?? 0;
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

    // Store current active tab info before submitting
    const activeTab = document.querySelector('.tab-content.active');
    const activeTabId = activeTab ? activeTab.id : null;

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
            
            // Get current active tab before reload
            const currentActiveTab = document.querySelector('.tab-content.active').id;
            
            // Store active tab in sessionStorage
            sessionStorage.setItem('activeTab', currentActiveTab);
            
            // Reload the page
            window.location.reload();
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
    document.getElementById('courseCode').value = courseCode;

    // Get the class ID from the current active tab
    const activeTab = document.querySelector('.tab-content.active');
    const classId = activeTab.id.split('-')[1];
    document.getElementById('classId').value = classId;
    
    // First check if grades already exist for this student/course
    fetch(`../actions/get_grades.php?student_id=${studentId}&course_code=${courseCode}`)
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                // If grades exist, populate the form with existing values
                document.getElementById('assignmentScore').value = data.assignment_score || 0;
                document.getElementById('testScore').value = data.test_score || 0;
                document.getElementById('midtermScore').value = data.mid_term_score || 0;
                document.getElementById('examScore').value = data.exam_score || 0;
            } else {
                // Set all scores to 0 for new grade entry
                document.getElementById('assignmentScore').value = 0;
                document.getElementById('testScore').value = 0;
                document.getElementById('midtermScore').value = 0;
                document.getElementById('examScore').value = 0;
            }
            
            // Show the modal
            modal.style.display = "block";
        })
        .catch(error => {
            console.error('Error fetching grades:', error);
            // Set default values to 0 in case of error
            document.getElementById('assignmentScore').value = 0;
            document.getElementById('testScore').value = 0;
            document.getElementById('midtermScore').value = 0;
            document.getElementById('examScore').value = 0;
            modal.style.display = "block";
        });
}

// Show first course tab by default or restore previous tab
document.addEventListener('DOMContentLoaded', () => {
    // First check sessionStorage for active tab from previous save
    const savedActiveTab = sessionStorage.getItem('activeTab');
    if (savedActiveTab) {
        const activeTab = document.getElementById(savedActiveTab);
        if (activeTab) {
            const courseCode = activeTab.id.split('-')[0];
            showCourseRecords(savedActiveTab, courseCode);
            // Clear the saved tab after restoring
            sessionStorage.removeItem('activeTab');
            return;
        }
    }

    // If no saved tab, check URL params
    const urlParams = new URLSearchParams(window.location.search);
    const activeTabId = urlParams.get('activeTab');

    if (activeTabId) {
        const activeTab = document.getElementById(activeTabId);
        if (activeTab) {
            const courseCode = activeTab.id.split('-')[0];
            showCourseRecords(activeTabId, courseCode);
            return;
        }
    }

    // Default behavior if no active tab in storage or URL
    const firstCourse = document.querySelector('.course-item');
    if (firstCourse) {
        const courseName = firstCourse.querySelector('span').textContent;
        const courseCode = firstCourse.parentElement.querySelector('.class-links').id.replace('classes-', '');
        showCourseRecords(courseName + '-JSS1', courseCode);
    }
});

//implement the delete function
function deleteGrade(studentId, courseCode) {
    // Show confirmation dialog before deleting
    if (confirm('Are you sure you want to delete this grade? This action cannot be undone.')) {
        //delete the grade from the database
        fetch(`../actions/delete_grades.php?student_id=${studentId}&course_code=${courseCode}`)
            .then(response => response.json())
            .then(data => {
                alert('Grade deleted successfully!');
                // Reload the page to show updated data
                location.reload();
            })
            .catch(error => {
                console.error('Error deleting grade:', error);
                alert('Error deleting grade. Please try again.');
            });
    }
}
