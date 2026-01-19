document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.quiz-edit');
    if (!form) return;

    const btnFinish = form.querySelector('#finish');
    const btnQuestions = form.querySelector('#upravOtazky');

    const formType = document.querySelector('#formType');
    if (formType.textContent === "Vytvoriť kvíz") {
        btnFinish.classList.add('disabled');
        btnQuestions.classList.add('disabled');
    }

    const title = form.querySelector('#title');
    const desc = form.querySelector('#description');
    const topic = form.querySelector('#topic');
    const difficulty = form.querySelector('#difficulty');
    const quizId = form.querySelector('#quizId');

    let orTitle = title.value;
    let orDesc = desc.value;
    let orTopic = topic.value;
    let orDifficulty = difficulty.value;

    function checkChange() {
        if (title.value !== orTitle || desc.value !== orDesc || topic.value !== orTopic || difficulty.value !== orDifficulty) {
            btnFinish.classList.add('disabled');
            btnQuestions.classList.add('disabled');
        } else {
            btnFinish.classList.remove('disabled');
            btnQuestions.classList.remove('disabled');
        }
    }

    title.addEventListener('input', checkChange);
    desc.addEventListener('input', checkChange);
    topic.addEventListener('input', checkChange);
    difficulty.addEventListener('input', checkChange);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            let response = await fetch(form.action,
                {
                    method: "POST",
                    body: JSON.stringify({
                        quizId: quizId.value,
                        title: title.value,
                        description: desc.value,
                        topic: topic.value,
                        difficulty: difficulty.value
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        "Accept": "application/json"
                    }
                });

            const data = await response.json();
            if (response.ok) {
                orTitle = title.value;
                orDesc = desc.value;
                orTopic = topic.value;
                orDifficulty = difficulty.value;
                quizId.value = data.quizId;
                btnQuestions.href = `http://localhost/?c=Question&a=edit&id=${data.quizId}`;
                btnFinish.classList.remove('disabled');
                btnQuestions.classList.remove('disabled');
            }
        } catch (ex) {
            console.error(ex);
        }
    });
});