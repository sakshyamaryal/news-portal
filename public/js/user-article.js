const generateUniqueId = () => `comment-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;

    // Helper to handle errors
    const handleError = async (response) => {
        if (!response.ok) {
            const error = await response.json();
            throw error.message || "Something went wrong!";
        }
        return response.json();
    };

    // Realtime Comment Actions
    const editComment = async (commentId) => {
        const commentItem = document.getElementById(`comment-${commentId}`);
        const commentContent = commentItem.querySelector('.comment-content');
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        // Create a textarea for editing
        const textarea = document.createElement('textarea');
        textarea.classList.add('form-control');
        textarea.rows = 4;
        textarea.textContent = commentContent.textContent.trim();

        commentContent.replaceWith(textarea);
        const editButton = commentItem.querySelector('.edit-btn');
        const saveButton = document.createElement('button');
        saveButton.classList.add('btn', 'btn-sm', 'btn-outline-success');
        saveButton.textContent = 'Save';
        commentItem.querySelector('.comment-body').appendChild(saveButton);

        editButton.style.display = 'none';

        saveButton.addEventListener('click', async () => {
            const newContent = textarea.value.trim();
            if (!newContent) return;

            try {
                const response = await fetch(`/api/comments/${commentId}`, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        content: newContent
                    }),
                });

                const data = await handleError(response);
                toastr.success(data.message);

                // Replace the textarea with the updated comment content
                const updatedComment = document.createElement('p');
                updatedComment.classList.add('comment-content', 'mb-2');
                updatedComment.textContent = data.comment.content;
                textarea.replaceWith(updatedComment);
                saveButton.remove();
                editButton.style.display = 'inline-block';

            } catch (err) {
                toastr.error(err);
            }
        });
    };

    const deleteComment = async (commentId) => {
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        const result = await Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/api/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json',
                    },
                });

                const data = await handleError(response);
                toastr.success(data.message);
                document.getElementById(`comment-${commentId}`).remove();
            } catch (err) {
                toastr.error(err);
            }
        }
    };

    document.querySelector('#comment-list').addEventListener('click', async function(e) {
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        if (editBtn) {
            const commentId = editBtn.dataset.id;
            editComment(commentId);
        }
        if (deleteBtn) {
            const commentId = deleteBtn.dataset.id;
            deleteComment(commentId);
        }
    });


    // Add Comment in Realtime
    document.getElementById('comment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': `Bearer ${bearerToken}`,
                },
            });

            const data = await handleError(response);

            toastr.success(data.message);
            form.reset();

            // Append the new comment without refreshing
            const uniqueId = generateUniqueId();
            const commentSection = document.querySelector('#comment-list');
            commentSection.insertAdjacentHTML(
                'afterbegin',
                `<div class="comment-item mb-4" id="comment-${data.comment.id}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="avatar">
                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #0056b3; color: white; font-weight: bold; font-size: 18px;">
                            ${data.username.charAt(0).toUpperCase()}
                        </div>

                        </div>
                        <div class="comment-body">
                            <div class="d-flex justify-content-between">
                                <strong>${data.username}</strong>
                                <span class="text-muted small">Just now</span>
                            </div>
                            <p class="comment-content mb-2">${data.comment.content}</p>
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-outline-secondary edit-btn" data-id="${data.comment.id}" title="Edit">
                                    <i class="fa fa-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${data.comment.id}" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>`
            );
        } catch (err) {
            toastr.error(err);
        }
    });