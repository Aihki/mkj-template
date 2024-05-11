'use strict';
jQuery(document).ready(function($) {
    $('#comment-form').on('submit', function(event) {
        event.preventDefault();

        var comment = $('#comment').val();
        var post_id = $('#post_id').val();
        var nonce = $('#submit-comment-nonce').val();

        $.ajax({
            url: comment_plugin.ajax_url,
            type: 'post',
            data: {
                action: 'submit_comment',
                comment: comment,
                post_id: post_id,
                nonce: nonce
            },
            success: function(response) {
                if (response.success) {
                    alert('Comment submitted successfully.');
                    $('#comment').val('');
                } else {
                    alert('Failed to submit comment: ' + response.data);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});