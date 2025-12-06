document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-edit');
    if (!form) return;

    const btnFinish = form.querySelector('button[name="finish"]');
    const btnQuestions = form.querySelector('#upravOtazky');

    const formType = document.querySelector('#formType');
    if (formType.textContent === "Vytvoriť kvíz") {
        btnFinish.disabled = true;
        btnQuestions.classList.add('disabled');
        return;
    }

    const title = form.querySelector('#title');
    const desc = form.querySelector('#description');
    const topic = form.querySelector('#topic');
    const difficulty = form.querySelector('#difficulty');

    const orTitle = title.value;
    const orDesc = desc.value;
    const orTopic = topic.value;
    const orDifficulty = difficulty.value;

    function checkChange() {
        if (title.value !== orTitle || desc.value !== orDesc || topic.value !== orTopic || difficulty.value !== orDifficulty) {
            btnFinish.disabled = true;
            btnQuestions.classList.add('disabled');
        } else {
            btnFinish.disabled = false;
            btnQuestions.classList.remove('disabled');
        }
    }

    title.addEventListener('input', checkChange);
    desc.addEventListener('input', checkChange);
    topic.addEventListener('input', checkChange);
    difficulty.addEventListener('input', checkChange);
});