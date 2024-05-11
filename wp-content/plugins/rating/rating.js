'use strict';

document.addEventListener('submit', async function (event) {
    if (!(event.target && event.target.id === 'rating-form')) return;

    event.preventDefault();

    const formData = new FormData(event.target);
    const serializedData = new URLSearchParams(formData).toString();

    try {
        const response = await fetch(rating_plugin.ajax_url, {
            method: 'POST',
            body: serializedData,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        document.querySelector('#rating-display').textContent = data.message;
        const labels = document.querySelectorAll('#rating-form label');
        labels.forEach((label, i) => {
            const star = label.querySelector('i');
            star.className = i < data.rating ? 'fas fa-star' : 'far fa-star';
        });
    } catch (error) {
        console.error('Error:', error);
    }
});