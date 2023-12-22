function submitForm() {
    document.getElementById('hiddenForm').submit();
}

function submitFormClases() {
    document.getElementById('hiddenFormClases').submit();
}

function submitRegistroClases() {
    document.getElementById('hiddenRegistroClases').submit();
}

function validateFileImg() {
    var fileInput = document.getElementById('fotosubida');
    var file = fileInput.files[0];

    if (file) {
        var fileName = file.name;
        var fileExt = fileName.split('.').pop().toLowerCase();

        if (fileExt == 'png' || fileExt == 'jpg') {
            return true;
        }
        else {
            alert('Porfavor ingresar una imagen PNG');
            return false;
        }
    } else {
        alert('Porfavor ingresar una imagen');
        return false;
    }

}