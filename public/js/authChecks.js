document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-register');
    if (!form) return;

    const username = form.querySelector('#username');
    const password = form.querySelector('#password');
    const passwordConfirm = form.querySelector('#password_confirm');
    const messageDiv = document.querySelector('#message');
    const submitBtn = form.querySelector('button[type="submit"]');

    function setMessage(text) {
        messageDiv.textContent = text || '';
    }

    function validateUsername() {
        const val = username.value.trim();
        if (val === '') {
            username.classList.remove('is-invalid');
            return { ok: false, msg: '' };
        }
        if (val.length < 3 || val.length > 12) {
            username.classList.add('is-invalid');
            return { ok: false, msg: 'Meno používateľa musí mať 3–12 znakov.' };
        }
        username.classList.remove('is-invalid');
        return { ok: true, msg: '' };
    }

    function validatePasswords() {
        const p = password.value;
        const p2 = passwordConfirm.value;

        if (p === '' && p2 === '') {
            password.classList.remove('is-invalid');
            passwordConfirm.classList.remove('is-invalid');
            return { ok: false, msg: '' };
        }

        if (p.length < 8) {
            password.classList.add('is-invalid');
            passwordConfirm.classList.add('is-invalid');
            return { ok: false, msg: 'Heslo musí mať aspoň 8 znakov.' };
        }

        if (p.length > 30) {
            password.classList.add('is-invalid');
            passwordConfirm.classList.add('is-invalid');
            return { ok: false, msg: 'Heslo musí mať maximálne 30 znakov.' };
        }

        if (!/\d/.test(p)) {
            password.classList.add('is-invalid');
            passwordConfirm.classList.add('is-invalid');
            return { ok: false, msg: 'Heslo musí obsahovať aspoň jednu číslicu.' };
        }

        if (p !== p2) {
            password.classList.add('is-invalid');
            passwordConfirm.classList.add('is-invalid');
            return { ok: false, msg: 'Heslá sa nezhodujú.' };
        }

        password.classList.remove('is-invalid');
        passwordConfirm.classList.remove('is-invalid');
        return { ok: true, msg: '' };
    }

    function validateAll() {
        const u = validateUsername();
        const p = validatePasswords();

        setMessage(u.msg || p.msg);
        submitBtn.disabled = !(u.ok && p.ok);
        return u.ok && p.ok;
    }

    username.addEventListener('input', validateAll);
    password.addEventListener('input', validateAll);
    passwordConfirm.addEventListener('input', validateAll);
});


document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-change-password');
    if (!form) return;

    const oldPassword = form.querySelector('#old_password');
    const newPassword = form.querySelector('#new_password');
    const messageDiv = document.querySelector('#message');
    const submitBtn = form.querySelector('button[type="submit"]');

    function validatePassword() {
        const oldP = oldPassword.value;
        const newP = newPassword.value;

        if (newP === '') {
            submitBtn.disabled = true;
            messageDiv.textContent = '';
            return false;
        }

        if (newP.length < 8 || newP.length > 30) {
            submitBtn.disabled = true;
            newPassword.classList.add('is-invalid');
            messageDiv.textContent = 'Nové heslo musí mať aspoň 8 a maximálne 30 znakov.';
            return false;
        }

        if (!/\d/.test(newP)) {
            submitBtn.disabled = true;
            newPassword.classList.add('is-invalid');
            messageDiv.textContent = 'Nové heslo musí obsahovať aspoň jednu číslicu.';
            return false;
        }

        newPassword.classList.remove('is-invalid');
        messageDiv.textContent = '';

        if (oldP === '') {
            submitBtn.disabled = true;
            return false;
        }

        submitBtn.disabled = false;
        return true;
    }

    newPassword.addEventListener('input', validatePassword);
    oldPassword.addEventListener('input', validatePassword);
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-signin');
    if (!form) return;

    const username = form.querySelector('#username');
    const password = form.querySelector('#password');
    const messageDiv = document.querySelector('#message');

    function emptyMessage() {
        messageDiv.textContent = '';
    }

    username.addEventListener('input', emptyMessage);
    password.addEventListener('input', emptyMessage);
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-delete-password');
    if (!form) return;

    const password = form.querySelector('#password');
    const messageDiv = document.querySelector('#message');

    function emptyMessage() {
        messageDiv.textContent = '';
    }

    password.addEventListener('input', emptyMessage);
});