document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.question-form');
    if (!form) return;

    const questionLabel = form.querySelector('#question-label');

    const prevButton = form.querySelector('#prev-question');
    const nextButton = form.querySelector('#next-question');
    const gotoInput = form.querySelector('#goto-number');
    const gotoButton = form.querySelector('#goto-question');
    const newQuestionButton = form.querySelector('#new-question');
    const goBackButton = form.querySelector('#go-back');
    const deleteButton = form.querySelector('#delete-question');


    const questionText = form.querySelector('#question_text');
    const answers = [form.querySelector('#answer_0'), form.querySelector('#answer_1'),
        form.querySelector('#answer_2'), form.querySelector('#answer_3')];
    const radios = [form.querySelector('#radio_0'), form.querySelector('#radio_1'),
        form.querySelector('#radio_2'), form.querySelector('#radio_3')];
    const quizId = Number(form.querySelector('#quizId').value);
    let questionNum = 1;
    let questionCount = Number(form.querySelector('#questionCount').value);

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

    async function saveQuestion() {
        try {
            const answerTexts = [answers[0].value, answers[1].value, answers[2].value, answers[3].value];
            const indexChecked = radios.findIndex(radio => radio.checked);
            await fetch("http://localhost/?c=Quiz&a=saveQuestion",
                {
                    method: "POST",
                    body: JSON.stringify({
                        quizId: quizId,
                        number: questionNum,
                        questionText: questionText.value,
                        answers: answerTexts,
                        correct: indexChecked + 1
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
            let response = await fetch("http://localhost/?c=Quiz&a=question",
                {
                    method: "POST",
                    body: JSON.stringify({
                        quizId: quizId,
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
                for (let i = 0; i < answers.length; i++) {
                    answers[i].value = data.answers[i];
                    radios[i].checked = (data.correct - 1) === i;
                }
                radios[data.correct - 1].checked = true;
                gotoInput.value = '';
            }
        } catch (ex) {
            console.error(ex);
        }
    }

    async function deleteQuestion() {
        try {
            let response = await fetch("http://localhost/?c=Quiz&a=deleteQuestion",
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        quizId: quizId,
                        number: questionNum
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

    function changeLabel() {
        questionLabel.textContent = `Question ${questionNum}/${questionCount}`;
    }


    prevButton.addEventListener('click', async (e) => {
        if (questionNum <= 1) return;
        if (await saveQuestion()) {
            questionNum--;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    nextButton.addEventListener('click', async (e) => {
        if (questionNum >= questionCount) return;
        if (await saveQuestion()) {
            questionNum++;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    gotoButton.addEventListener('click', async (e) => {
        const gotoVal = Number(gotoInput.value);
        if (gotoVal < 1 || gotoVal > questionCount) return;
        if (await saveQuestion()) {
            questionNum = gotoVal;
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    newQuestionButton.addEventListener('click', async (e) => {
        if (await saveQuestion()) {
            questionNum = questionCount + 1;
            questionCount++;
            questionText.value = '';
            for (let i = 0; i < answers.length; i++) {
                answers[i].value = '';
                radios[i].checked = i === 0;
            }
            radios[0].checked = true;
            checkButtons();
            changeLabel();
        }
    });

    goBackButton.addEventListener('click', async (e) => {
        if (await saveQuestion()) {
           window.location.href = form.action;
       }
    });

    deleteButton.addEventListener('click', async (e) => {
        if (questionCount === 1) {
            alert("Cannot delete the only question in the quiz.");
            return;
        }
        if (await deleteQuestion()) {
            questionCount--;
            if (questionNum > questionCount) {
                questionNum = questionCount;
            }
            await loadQuestion();
            checkButtons();
            changeLabel();
        }
    });

    window.addEventListener('beforeunload', (e) => {
        if (e.target.activeElement.id === 'go-back') {
            return;
        }
        e.preventDefault();
    });

    checkButtons();
});