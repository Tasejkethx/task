export default class ValidationErrors {
    static showErrors(error) {
        // clear error messages
        const errorMessages = document.querySelectorAll('.text-danger');
        /* eslint no-return-assign:0 */
        errorMessages.forEach((el) => el.textContent = '');

        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(
            (elem) => elem.classList.remove('border', 'border-danger'));

        // show error messages
        const errors = error.response.data.errors;
        Object.keys(errors).forEach((element) => {
            const firstItemDOM = document.getElementById(element);
            const firstErrorMessage = errors[element][0];

            const div = document.createElement('div');
            div.className = 'text-danger';
            div.id = firstItemDOM.id + '-error';
            div.innerHTML = '' + firstErrorMessage;

            firstItemDOM.insertAdjacentElement('afterend', div);
            firstItemDOM.classList.add('border', 'border-danger');
        });
    }

    static deleteErrorMessages(className) {
        const formControls = document.getElementById(className);
        if (formControls.classList.length > 1) {
            formControls.classList.forEach((element) => {
                if (element === 'border-danger') {
                    formControls.classList.remove('border', 'border-danger');
                }
            });
        }
        const errorMessages = document.getElementById(className + '-error');
        if (errorMessages) {
            errorMessages.textContent = '';
        }
    }
}
