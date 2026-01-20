document.addEventListener('DOMContentLoaded', function () {
    const view = document.querySelector('#resultCard');
    if (!view) return;

    let liked = Boolean(Number(view.querySelector('#liked').value));
    const likeButton = view.querySelector('#like-button');
    const quizId = Number(view.querySelector('#quizId').value);


    async function like() {
        try {
            let response = await fetch("http://localhost/?c=attempt&a=like",
                {
                    method: "POST",
                    body: JSON.stringify({
                        quizId: quizId
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        "Accept": "application/json"
                    }
                });
            return response.ok;

        } catch (ex) {
            console.error(ex);
            return false;
        }
    }

    async function unlike() {
        try {
            await fetch("http://localhost/?c=attempt&a=unlike",
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        quizId: quizId
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

    likeButton.addEventListener('click', async () => {
        if (!liked) {
            if (await like()) {
                liked = true;
                likeButton.textContent = 'Unlike';
            }
        } else {
            if (await unlike()) {
                liked = false;
                likeButton.textContent = 'Like';
            }
        }
    });

    if (liked) {
        likeButton.textContent = 'Unlike';
    } else {
        likeButton.textContent = 'Like';
    }
});