const Form = {
    form: null,

    init: function () {
        this.form = document.getElementById('main-form');

        this.initSubmitButton();
        this.initCancelButton();
        this.initAddBreakButtons();
    },

    initSubmitButton: function () {
        let submitBtn = document.getElementsByClassName('js-submitBtn').item(0);

        submitBtn.addEventListener('click', function () {
            Form.handleSubmitBtnClick();
        });
    },

    handleSubmitBtnClick: function (submitBtn) {
        Form.form.submit();
    },

    initCancelButton: function() {
        let cancelBtn = document.getElementsByClassName('js-cancelBtn').item(0);

        cancelBtn.addEventListener('click', function () {
            Form.handleCancelBtnClick();
        });
    },

    handleCancelBtnClick: function () {
        let breaksFieldset  = document.getElementById('breaks'),
            breakCountField = document.getElementById('break-count');

        Form.form.reset();
        breaksFieldset.innerHTML = '';
        breakCountField.value = '1';
    },

    initAddBreakButtons: function () {
        let collection = document.getElementsByClassName('js-addBreakBtn');

        for (let item of collection) {
            item.addEventListener('click', function (event) {
                Form.handleAddBreak(event.target);
            });
        }
    },

    handleAddBreak: function () {
        let breakContainer = document.getElementById('breaks'),
            breakCount     = document.getElementById('break-count').value,
            inputGroup, input, label, breakId;

        inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group');


        breakId = 'break-' + breakCount;

        label = document.createElement('label');
        label.setAttribute('for', breakId);
        label.innerHTML = breakCount + '. Pause:';

        input = document.createElement('input');
        input.setAttribute('type', 'time');
        input.setAttribute('id', breakId);
        input.setAttribute('name', breakId);

        inputGroup.appendChild(label);
        inputGroup.appendChild(input);

        breakContainer.classList.remove('invisible');
        breakContainer.appendChild(inputGroup);

        breakCount++
        document.getElementById('break-count').value = breakCount;
    }
};