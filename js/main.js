const btnOpenUploadModal = document.querySelector('.open-upload-modal');
const btnCloseUploadModal = document.querySelector('.close-modal-btn');
const btnModalSubmit = document.querySelector('.uploader-modal button');
const fileInputModal = document.querySelector('.file-input');
const uploadModalWrapper = document.querySelector('.uploader-modal-wrapper');
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

fileInputModal.addEventListener('change', () => {
    btnModalSubmit.disabled = !fileInputModal.value;
})

btnOpenUploadModal.addEventListener('click', () => {
    uploadModalWrapper.style.display = 'block';
    body.style.overflow = 'hidden';
})

btnCloseUploadModal.addEventListener('click', () => {
    uploadModalWrapper.style.display = 'none';
    body.style.overflow = 'auto';
    fileInputModal.value = '';
    btnModalSubmit.disabled = true;
})