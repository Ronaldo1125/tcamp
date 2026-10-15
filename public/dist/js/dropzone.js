$(document).ready(function () {
    // CRITICAL: Force the jQuery Validator package to check hidden interactive fields
    var validator = $('#add-form').data('validator');
    if (validator) {
        validator.settings.ignore = [];
    }
});

const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const fileBadge = document.getElementById('fileBadge');
const fileNameSpan = document.getElementById('fileName');

// Route file container clicks to hidden native input
dropzone.addEventListener('click', () => fileInput.click());

// Active visual dragging indicator states
dropzone.addEventListener('dragover', (e) => { 
    e.preventDefault(); 
    dropzone.classList.add('drag-over', 'border-primary'); 
});
dropzone.addEventListener('dragleave', () => { 
    dropzone.classList.remove('drag-over', 'border-primary'); 
});

// Handle dropped items directly
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('drag-over', 'border-primary');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        updateFileName(fileInput);
    }
});

// Expose chosen state context visually
function updateFileName(input) {
    if (input.files.length > 0) {
        fileNameSpan.textContent = input.files[0].name;
        fileBadge.classList.remove('d-none');

        // Trigger validator check as soon as file drops or changes programmatically
        $('#fileInput').valid();
    }
}