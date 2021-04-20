const btnOpenUploadModal = document.querySelector('.open-upload-modal');
const btnCloseUploadModal = document.querySelector('.close-modal-btn');
const btnModalSubmit = document.querySelector('.uploader-modal button');
const uploadModalWrapper = document.querySelector('.uploader-modal-wrapper');
const fileInput = document.querySelector('#file-field')
const progressBar = document.querySelector('#progress-bar');
const statusMessage = document.querySelector('#status-message');
const body = document.querySelector('body');
const btnRemove = document.querySelector('.btn-remove');
const imgViewContainer = document.querySelector('.pictures-view-items');

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
    xhr.open('post', 'include/upload.php');
    xhr.send(formData);
}

function progressHandler(e) {
    progressBar.value = Math.round((e.loaded / e.total) * 100);
}

function completeHandler(e) {
    viewStatus(e.target.responseText);
    defaultValues();
    renderImgList();
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

function renderImgList() {
    const xhr = new XMLHttpRequest();
    xhr.open('get', 'include/load.php')
    xhr.send()

    xhr.onloadend = () => {
        imgViewContainer.innerHTML = '';
        btnRemove.disabled = true;

        for (const file of JSON.parse(xhr.response).sort((a, b) => a.name.toLowerCase() > b.name.toLowerCase() ? -1 : 1)) {
            const picItem = `
                    <div class="picture-item">
                        <div class="picture-img">
                            <a href="${file.src}"><img src="${file.src}" alt="${file.name}"/></a>
                        </div>
                        <div class="picture-info">
                            <ul>
                                <li>Название: <b>${file.name}</b></li>
                                <li>Размер файла: <b>${file.size}</b></li>
                                <li>Дата загрузки: <b>${file.uploadDate}</b></li>
                                <li>
                                    <label>
                                        Выбрать:
                                        <input
                                            class="picture-checker"
                                            name="${file.name}"
                                            type="checkbox"
                                        />
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                `;
            imgViewContainer.insertAdjacentHTML('afterbegin', picItem);
        }

        const picCheckers = document.querySelectorAll('.picture-checker');

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

            xhr.open('post', 'include/delete.php');
            xhr.send(formData);
            xhr.onloadend = () => {
                viewStatus(xhr.responseText);
                renderImgList();
            };
        });
    }
}

renderImgList()
