
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
    
        // Check if fields are empty
        if (email === "" || password === "") {
            e.preventDefault();
            document.getElementById("error-msg").innerText = "Please fill in all fields.";
        }
    });
    

    document.querySelector('.signup-btn').addEventListener('click', function(event) {
        event.preventDefault();
        
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
    
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
        } else {
            // Submit the form or proceed with AJAX request
            alert('Signup successful!');
            // Here, you would typically submit the form via AJAX or to a backend PHP script
        }
    });
    
    
// <!-- javascript -->

/* <script type="text/javascript"> */

function search() {
let filter = document.getElementById('find').value.toUpperCase();    
let item = document.querySelectorAll('.food');
let l = document.getElementsByTagName('.recipes p');
for(var i = 0;i<=l.length;i++){
let a=item[i].getElementsByTagName('.recipes p')[0];    
let value=a.innerHTML || a.innerText || a.textContent;
if(value.toUpperCase().indexOf(filter) > -1) {
item[i].style.display="";    
}
else
{
item[i].style.display="none";    
}
 }
  }

document.getElementById("commentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent page refresh

    const username = document.getElementById("username").value;
    const comment = document.getElementById("comment").value;

    if (username && comment) {
        // Create new comment div
        const commentDiv = document.createElement("div");
        commentDiv.classList.add("comment");

        // Add username and comment text
        commentDiv.innerHTML = `<strong>${username}:</strong> <p>${comment}</p>`;

        // Append new comment to the comments section
        document.getElementById("comments").appendChild(commentDiv);

        // Clear form fields
        document.getElementById("username").value = "";
        document.getElementById("comment").value = "";
    }
});



