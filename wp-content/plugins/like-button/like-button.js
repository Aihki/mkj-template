'use strict';

// Use event delegation with async/await and vanilla JavaScript
document.addEventListener('submit', async function (event) {
    // Exit early if the event target does not match the like-form
    if (!(event.target && event.target.id === 'like-form')) return;

    // Prevent the default form submission
    event.preventDefault();

    // Serialize the form data
    const formData = new FormData(event.target);
    const serializedData = new URLSearchParams(formData).toString();
    console.log(serializedData);

    try {
        // Send an AJAX request
        const response = await fetch(like_button.ajax_url, {
            method: 'POST',
            body: serializedData,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        // Parse the JSON response
        const data = await response.json();
        console.log(data);

        // Update the like count and icon based on the response
        document.querySelector('#like-count').textContent = data.likes;
        document.querySelectorAll('ion-icon').forEach(icon => {
            icon.setAttribute('name', data.liked ? 'heart-dislike' : 'heart');
        });
    } catch (error) {
        console.error('Error:', error);
    }
});