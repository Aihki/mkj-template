'use strict';

const modalButtons = document.querySelectorAll('.open-modal');
const modal = document.querySelector('#single-post');
const closeButton = document.querySelector('#close');
const modalContent = document.querySelector('#modal-content');

modalButtons.forEach(button => {
    button.addEventListener('click', async (evt)  => {
        evt.preventDefault();
        const url = singlePost.ajax_url;
        const data = new URLSearchParams({
            post_id: button.dataset.id,
            action: 'single_post',
        });

        const options = {
            method: 'POST',
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        };

        const response = await fetch(url, options);
        const post = await response.json();
        console.log(post);
        modalContent.innerHTML = '';
        modalContent.insertAdjacentHTML('afterbegin', `<h2>${post.post_title}</h2>`);
        modalContent.insertAdjacentHTML('beforeend', post.post_content);
        modal.showModal();
    });
});

closeButton.addEventListener('click', () => {
    modal.close();
});