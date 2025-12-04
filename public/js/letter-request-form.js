document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const formSteps = document.querySelectorAll('.form-step');
    const stepperItems = document.querySelectorAll('.stepper-item');
    const nextBtn = document.getElementById('nextBtn');
    const backBtn = document.getElementById('backBtn');
    const submitBtn = document.getElementById('submitBtn');
    const letterTypeSelect = document.getElementById('letter_type_id');

    function updateStepper() {
        stepperItems.forEach((item, index) => {
            const step = index + 1;
            if (step < currentStep) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else if (step === currentStep) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else {
                item.classList.remove('active', 'completed');
            }
        });
    }

    function showStep(step) {
        formSteps.forEach(s => {
            if (parseInt(s.dataset.step) === step) {
                s.style.display = 'block';
                s.classList.add('fade-in');
            } else {
                s.style.display = 'none';
                s.classList.remove('fade-in');
            }
        });

        updateStepper();

        if (step === 1) {
            backBtn.style.display = 'none';
            nextBtn.style.display = 'inline-flex';
            submitBtn.style.display = 'none';
        } else if (step === formSteps.length) {
            backBtn.style.display = 'inline-flex';
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-flex';
        } else {
            backBtn.style.display = 'inline-flex';
            nextBtn.style.display = 'inline-flex';
            submitBtn.style.display = 'none';
        }
    }

    nextBtn.addEventListener('click', function() {
        if (currentStep < formSteps.length) {
            currentStep++;
            showStep(currentStep);
        }
    });

    backBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    letterTypeSelect.addEventListener('change', function() {
        const container = document.getElementById('dynamicFields');
        const selectedOption = letterTypeSelect.options[letterTypeSelect.selectedIndex];

        container.innerHTML = '';

        if (!selectedOption.value) {
            return;
        }

        const fields = JSON.parse(selectedOption.dataset.fields || '{}');

        Object.entries(fields).forEach(([fieldName, fieldType]) => {
            const fieldCol = document.createElement('div');
            fieldCol.className = 'col-md-6';

            const label = document.createElement('label');
            label.className = 'form-label';
            label.textContent = formatFieldName(fieldName);
            label.setAttribute('for', `form_data_${fieldName}`);

            let input;
            switch (fieldType) {
                case 'textarea':
                    input = document.createElement('textarea');
                    input.rows = 3;
                    input.className = 'form-control';
                    break;
                case 'select':
                    input = document.createElement('select');
                    input.className = 'form-select';
                    const optionsDiv = document.querySelector(`#field-options [data-field="${fieldName}"]`);
                    if (optionsDiv) {
                        input.innerHTML = optionsDiv.innerHTML;
                    } else {
                        input.innerHTML = '<option value="">-- Pilih --</option>';
                    }
                    break;
                default:
                    input = document.createElement('input');
                    input.type = fieldType;
                    input.className = 'form-control';
            }

            input.name = `form_data[${fieldName}]`;
            input.id = `form_data_${fieldName}`;
            input.required = true;
            input.placeholder = `Masukkan ${formatFieldName(fieldName).toLowerCase()}`;

            fieldCol.appendChild(label);
            fieldCol.appendChild(input);
            container.appendChild(fieldCol);
        });
    });

    function formatFieldName(fieldName) {
        return fieldName.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    const familyRadio = document.getElementById('subject_family');
    const selfRadio = document.getElementById('subject_self');
    const familySelection = document.getElementById('family_member_selection');

    function toggleFamilySelection() {
        if (familyRadio && familyRadio.checked) {
            familySelection.style.display = 'block';
        } else {
            if (familySelection) {
                familySelection.style.display = 'none';
            }
        }
    }

    if (familyRadio) {
        familyRadio.addEventListener('change', toggleFamilySelection);
    }
    if (selfRadio) {
        selfRadio.addEventListener('change', toggleFamilySelection);
    }

    // Initial setup
    showStep(currentStep);
    toggleFamilySelection();
});
