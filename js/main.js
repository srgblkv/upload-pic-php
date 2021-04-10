const btnOpenUploadModal = document.querySelector('.open-upload-modal');
const btnCloseUploadModal = document.querySelector('.close-modal-btn');
const btnModalSubmit = document.querySelector('.uploader-modal button');
const uploadModalWrapper = document.querySelector('.uploader-modal-wrapper');
const fileInput = document.querySelector('#file-field')
const progressBar = document.querySelector('#progress-bar');

const statusMessage = document.querySelector('#status-message');

const body = document.querySelector('body');
const picCheckers = document.querySelectorAll('.picture-checker');
const btnRemove = document.querySelector('.btn-remove');

let checkedArray = [];

for (const check of picCheckers) {
    addEventListener('change', () => {
        if (check.checked) {
            if (!checkedArray.includes(check.name)) {
                checkedArray.push(check.name);
            }
        } else {
            if (checkedArray.includes(check.name)) {
                const index = checkedArray.indexOf(check.name);
                checkedArray = checkedArray.slice(0, index)
                    .concat(checkedArray.slice(index + 1, checkedArray.length));
            }
        }

        btnRemove.disabled = !checkedArray.length;
    })
}

btnRemove.addEventListener('click', (e) => {
    e.preventDefault();
    const formData = new FormData();
    const xhr = new XMLHttpRequest();

    for (const checkedFile of checkedArray) {
        formData.append('files[]', checkedFile);
    }

    xhr.open('post', 'delete.php');
    xhr.send(formData);
    xhr.onload = () => {
        viewStatus(xhr.responseText);
    };
});


fileInput.addEventListener('change', () => {
    btnModalSubmit.disabled = !fileInput.files;
});

btnOpenUploadModal.addEventListener('click', () => {
    uploadModalWrapper.style.display = 'block';
    body.style.overflow = 'hidden';
});

btnCloseUploadModal.addEventListener('click', () => {
    uploadModalWrapper.style.display = 'none';
    body.style.overflow = 'auto';
    fileInput.value = '';
    btnModalSubmit.disabled = true;
});

btnModalSubmit.addEventListener('click', (e) => {
    e.preventDefault();
    fileInput.style.display = 'none';
    progressBar.style.display = 'block';
    uploadFiles();
});

function uploadFiles() {
    const formData = new FormData();
    const xhr = new XMLHttpRequest();

    for (const file of fileInput.files) {
        formData.append('files[]', file);
    }

    xhr.upload.addEventListener('progress', progressHandler, false);
    xhr.addEventListener('load', completeHandler, false);
    xhr.open('post', 'upload.php');
    xhr.send(formData);
}

function progressHandler(e) {
    progressBar.value = Math.round((e.loaded / e.total) * 100);
}

function completeHandler(e) {
    viewStatus(e.target.responseText);
    defaultValues();
}

function viewStatus(resMsg) {
    statusMessage.style.display = 'block';
    statusMessage.innerText = resMsg;
    setTimeout(() => {
        statusMessage.style.display = 'none';
    }, 3000);
}

function defaultValues() {
    progressBar.value = 0;
    fileInput.value = '';
    fileInput.style.display = 'block';
    progressBar.style.display = 'none';
}
