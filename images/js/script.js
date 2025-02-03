
// Select the toggle button
const darkModeBtn = document.getElementById('dark-mode-btn');

// Check saved preference and apply dark mode if enabled
if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
}

// Toggle dark mode on button click
darkModeBtn.addEventListener('click', () => {
    const body = document.body;
    if (body.classList.contains('dark-mode')) {
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
    } else {
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
    }
});

function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
}



// newsletter code
document.getElementById('newsletter-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const feedback = document.getElementById('newsletter-feedback');

    // Send email to PHP script
    fetch('php/newsletter_signup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${encodeURIComponent(email)}`,
    })
        .then((response) => response.text())
        .then((data) => {
            feedback.style.display = 'block';
            feedback.textContent = data;
            document.getElementById('email').value = ''; // Clear input
        })
        .catch((error) => {
            feedback.style.display = 'block';
            feedback.textContent = 'An error occurred. Please try again.';
            feedback.style.color = 'red';
        });
});


//   // Fetch journey data from backend
//   fetch('php/get_journey_data.php')
//   .then(response => response.json())
//   .then(data => {
//       const journeyContainer = document.getElementById('journey-container');

//       // Create user metric element
//       const userMetric = document.createElement('div');
//       userMetric.classList.add('journey-metric');
//       userMetric.innerHTML = `<h1>${data.total_users}+</h1><p>Users</p>`;

//       // Create rating metric element
//       const ratingMetric = document.createElement('div');
//       ratingMetric.classList.add('journey-metric');
//       ratingMetric.innerHTML = `<h1>${data.total_ratings}+</h1><p>Ratings</p>`;

//       // Append metrics to container
//       journeyContainer.appendChild(userMetric);
//       journeyContainer.appendChild(ratingMetric);
//   })
//   .catch(error => {
//       console.error('Error fetching journey data:', error);
//   });