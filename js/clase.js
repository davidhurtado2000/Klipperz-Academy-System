function submitForm() {
    document.getElementById('hiddenForm').submit();
}

function submitFormClases() {
    document.getElementById('hiddenFormClases').submit();
}

function generateForm($valor,$idform) {
    // Create a form element
    var form = document.createElement('form');
    form.method = 'post';

    // # BOLETA
    var formGroup = document.createElement('div');
    formGroup.className = 'form-group';

    var inputLabel = document.createElement('label');
    inputLabel.textContent = '# Boleta: ';

    var inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.className = 'form-control';
    inputField.name = 'boletanum';
    inputField.id = 'boletanum';
    inputField.value = $valor;
    inputField.required = true;

    formGroup.appendChild(inputLabel);
    formGroup.appendChild(inputField);
    form.appendChild(formGroup);

    // PAGO
    var formGroup = document.createElement('div');
    formGroup.className = 'form-group';

    var inputLabel = document.createElement('label');
    inputLabel.textContent = 'Pago: ';

    var inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.className = 'form-control';
    inputField.name = 'pago';
    inputField.id = 'pago';
    inputField.value = $valor;
    inputField.required = true;

    formGroup.appendChild(inputLabel);
    formGroup.appendChild(inputField);
    form.appendChild(formGroup);

    // FECHA
    var formGroup = document.createElement('div');
    formGroup.className = 'form-group';

    var inputLabel = document.createElement('label');
    inputLabel.textContent = 'Fecha: ';

    var inputField = document.createElement('input');
    inputField.type = 'date';
    inputField.className = 'form-control';
    inputField.name = 'fechapago';
    inputField.id = 'fechapago';
    inputField.value = $valor;
    inputField.required = true;

    formGroup.appendChild(inputLabel);
    formGroup.appendChild(inputField);
    form.appendChild(formGroup);

  

    // Append the form to the container
    document.getElementById($idform).innerHTML = '';
    document.getElementById($idform).appendChild(form);
}
