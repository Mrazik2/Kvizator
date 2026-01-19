document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.attempt-question-form');
    if (!form) return;

    const questionLabel = form.querySelector('#question-label');

    const prevButton = form.querySelector('#prev-question');
    const nextButton = form.querySelector('#next-question');
    const gotoInput = form.querySelector('#goto-number');
    const gotoButton = form.querySelector('#goto-question');
    const submitButton = form.querySelector('#submit-attempt');
    const abandonButton = form.querySelector('#abandon-attempt');

    const questionText = form.querySelector('#question_text');
    const answerDivs = [form.querySelector('#answer_div_1'), form.querySelector('#answer_div_2'),
        form.querySelector('#answer_div_3'), form.querySelector('#answer_div_4')];
    const answerTexts = [form.querySelector('#answer_text_1'), form.querySelector('#answer_text_2'),
        form.querySelector('#answer_text_3'), form.querySelector('#answer_text_4')];
    const answerRadios = [form.querySelector('#answer_radio_1'), form.querySelector('#answer_radio_2'),
        form.querySelector('#answer_radio_3'), form.querySelector('#answer_radio_4')];

    const attemptId = Number(form.querySelector('#attemptId').value);
    const questionCount = Number(form.querySelector('#questionCount').value);
    let questionNum = 1;

    function checkButtons() {
        if (questionNum === questionCount) {
            nextButton.classList.add('preserve-hidden');
        } else {
            nextButton.classList.remove('preserve-hidden');
        }
        if (questionNum === 1) {
            prevButton.classList.add('preserve-hidden');
        } else {
            prevButton.classList.remove('preserve-hidden');
        }
    }

    function changeLabel() {
        questionLabel.textContent = `Question ${questionNum}/${questionCount}`;
    }

    function refreshChosen() {
        answerRadios.forEach((radio) => {
            radio.checked = false;
        });
    }

    async function saveAnswer() {
        try {
            let chosen = 0;
            for (let i = 0; i < answerRadios.length; i++) {
                if (answerRadios[i].checked) {
                    chosen = i + 1;
                }
            }
            await fetch("http://localhost/?c=attempt&a=save",
                {
                    method: "PUT",
                    body: JSON.stringify({
                        quizId: attemptId,
                        number: questionNum,
                        chosen: chosen
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        "Accept": "application/json"
                    }
                });
            return true;
        } catch (ex) {
            console.error(ex);
            return false;
        }
    }

    async function loadQuestion() {
        try {
            let response = await fetch("http://localhost/?c=attempt&a=question",
                {
                    method: "POST",
                    body: JSON.stringify({
                        quizId: attemptId,
                        number: questionNum
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        "Accept": "application/json"
                    }
                });
            const data = await response.json();
            if (response.ok) {
                questionText.value = data.questionText;
                for (let i = 0; i < answerDivs.length; i++) {
                    answerTexts[i].value = data.answerTexts[i];
                    answerRadios[i].checked = (data.chosen - 1) === i;
                    answerDivs[i].hidden = data.answerTexts[i] === '';
                }
                gotoInput.value = '';
            }
        } catch (ex) {
            console.error(ex);
        }
    }

    async function deleteAttempt() {
        try {
            await fetch("http://localhost/?c=attempt&a=delete",
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        quizId: attemptId
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        "Accept": "application/json"
                    }
                });
            return true;
        } catch (ex) {
            console.error(ex);
            return false;
        }
    }

    prevButton.addEventListener('input', async () => {
        if (questionNum <= 1) return;
        if (await saveAnswer()) {
            questionNum--;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    nextButton.addEventListener('input', async () => {
        if (questionNum >= questionCount) return;
        if (await saveAnswer()) {
            questionNum++;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    gotoButton.addEventListener('input', async () => {
        const gotoVal = Number(gotoInput.value);
        if (gotoVal < 1 || gotoVal > questionCount) return;
        if (await saveAnswer()) {
            questionNum = gotoVal;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    submitButton.addEventListener('input', async () => {
        if (await saveAnswer()) {
            window.location.href = `http://localhost/?c=attempt&a=results&attemptId=${attemptId}`;
        }
    });

    abandonButton.addEventListener('input', async () => {
        window.location.href = "http://localhost/?c=home&a=index";
    });

    window.addEventListener('beforeunload', (e) => {
        if (e.target.activeElement.id === 'submit-attempt') {
            return;
        }
        deleteAttempt();
    });

    checkButtons();
});
