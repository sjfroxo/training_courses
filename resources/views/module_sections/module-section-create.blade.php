<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Module Section</title>
    <style>
        .step-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .step-container label {
            display: block;
            margin: 5px 0;
        }
        .step-container input, .step-container textarea, .step-container select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .remove-step {
            color: red;
            cursor: pointer;
            margin-top: 5px;
            display: inline-block;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<form id="dynamicForm" action="{{ route('moduleSections.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Section Title:</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div id="formContainer">
    </div>
    <button type="button" id="addElement">Add Step</button>
    <button type="submit">Submit</button>
</form>

<script>
    const stepTypes = ['Theory', 'Video', 'Test', 'Results'];

    function createStepContainer(index) {
        const container = document.createElement('div');
        container.className = 'step-container';
        container.innerHTML = `
                <label for="step_type_${index}">Step Type:</label>
                <select name="steps[${index}][type]" id="step_type_${index}" required>
                    ${stepTypes.map(type => `<option value="${type.toLowerCase()}">${type}</option>`).join('')}
                </select>
                <label for="step_title_${index}">Step Title:</label>
                <input type="text" name="steps[${index}][title]" id="step_title_${index}" required>
                <label for="step_content_${index}">Content:</label>
                <textarea name="steps[${index}][content]" id="step_content_${index}" rows="4" required></textarea>
                <span class="remove-step" onclick="this.parentElement.remove()">Remove Step</span>
            `;
        return container;
    }

    let stepIndex = 0;

    document.getElementById('addElement').addEventListener('click', function() {
        const formContainer = document.getElementById('formContainer');
        const newStep = createStepContainer(stepIndex);
        formContainer.appendChild(newStep);
        stepIndex++;
    });

    document.getElementById('dynamicForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = this;
        const formData = new FormData(form);

        const steps = [];
        const stepElements = document.querySelectorAll('.step-container');
        stepElements.forEach((container, index) => {
            const type = container.querySelector(`select[name="steps[${index}][type]"]`).value;
            const title = container.querySelector(`input[name="steps[${index}][title]"]`).value;
            const content = container.querySelector(`textarea[name="steps[${index}][content]"]`).value;
            steps.push({ type, title, content });
        });

        console.log('Form Data:', {
            module_id: formData.get('module_id'),
            title: formData.get('title'),
            steps: steps
        });

        form.submit();
    });
</script>
</body>
</html>
