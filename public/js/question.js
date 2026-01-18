document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.question-form');
    if (!form) return;

    const questionText = form.querySelector('#questionText');
    const answers = [form.querySelector('#answer_0'), form.querySelector('#answer_1'),
        form.querySelector('#answer_2'), form.querySelector('#answer_3')];
    const radios = [form.querySelector('#radio_0'), form.querySelector('#radio_1'),
        form.querySelector('#radio_2'), form.querySelector('#radio_3')];

    let indexChecked;
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            indexChecked = i;
            break;
        }
    }


    window.addEventListener('beforeunload', (e) => {
        if (e.target.activeElement.id === 'go-back') {
            return;
        }
        e.preventDefault();
    });
});