document.addEventListener('DOMContentLoaded', function () {
    const view = document.querySelector('.attempt-answer-view');
    if (!view) return;

    const questionLabel = view.querySelector('#question-label');

    const prevButton = view.querySelector('#prev-question');
    const nextButton = view.querySelector('#next-question');
    const gotoInput = view.querySelector('#goto-number');
    const gotoButton = view.querySelector('#goto-question');

    const questionText = view.querySelector('#question_text');
    const answerDivs = [view.querySelector('#answer_div_1'), view.querySelector('#answer_div_2'),
        view.querySelector('#answer_div_3'), view.querySelector('#answer_div_4')];
    const answerBorders = [view.querySelector('#answer_border_1'), view.querySelector('#answer_border_2'),
        view.querySelector('#answer_border_3'), view.querySelector('#answer_border_4')];
    const answerTexts = [view.querySelector('#answer_text_1'), view.querySelector('#answer_text_2'),
        view.querySelector('#answer_text_3'), view.querySelector('#answer_text_4')];
    const labelChosen = [view.querySelector('#label_chosen_1'), view.querySelector('#label_chosen_2'),
        view.querySelector('#label_chosen_3'), view.querySelector('#label_chosen_4')];
    const labelCorrect = [view.querySelector('#label_correct_1'), view.querySelector('#label_correct_2'),
        view.querySelector('#label_correct_3'), view.querySelector('#label_correct_4')];

    const attemptId = Number(view.querySelector('#attemptId').value);
    const questionCount = Number(view.querySelector('#questionCount').value);
    let questionNum = 1;

    function changeLabel() {
        questionLabel.textContent = `Question ${questionNum}/${questionCount}`;
    }

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

    async function load() {
        try {
            let response = await fetch("http://localhost/?c=attempt&a=answer",
                {
                    method: "POST",
                    body: JSON.stringify({
                        attemptId: attemptId,
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
                questionText.textContent = data.questionText;
                for (let i = 0; i < answerDivs.length; i++) {
                    for (const node of Array.from(answerTexts[i].childNodes)) {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.nodeValue = data.answers[i] + ' ';
                            break;
                        }
                    }
                    answerDivs[i].hidden = data.answers[i] === '';
                    labelChosen[i].hidden = data.chosen !== (i + 1);
                    labelCorrect[i].hidden = data.correct !== (i + 1);
                    if (data.correct === (i + 1)) {
                        answerBorders[i].classList.remove('border-primary', 'border-transparent');
                        answerBorders[i].classList.add('border-success');
                    } else if (data.chosen === (i + 1)) {
                        answerBorders[i].classList.remove('border-success', 'border-transparent');
                        answerBorders[i].classList.add('border-primary');
                    } else {
                        answerBorders[i].classList.remove('border-primary', 'border-success');
                        answerBorders[i].classList.add('border-transparent');
                    }
                }
                gotoInput.value = '';
            }
        } catch (ex) {
            console.error(ex);
        }
    }

    prevButton.addEventListener('click', async function () {
        if (questionNum <= 1) return;
        questionNum--;
        await load();
        checkButtons();
        changeLabel();
    });

    nextButton.addEventListener('click', async function () {
        if (questionNum >= questionCount) return;
        questionNum++;
        await load();
        checkButtons();
        changeLabel();
    });

    gotoButton.addEventListener('click', async function () {
        const gotoVal = Number(gotoInput.value);
        if (gotoVal < 1 || gotoVal > questionCount) return;
        questionNum = gotoVal;
        await load();
        checkButtons();
        changeLabel();
    });

    checkButtons();
});