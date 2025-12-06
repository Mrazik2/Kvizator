document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-register');
    if (!form) return;

    const username = form.querySelector('#username');
    const password = form.querySelector('#password');
    const passwordConfirm = form.querySelector('#password_confirm');
    const messageDiv = document.querySelector('#message');
    const submitBtn = form.querySelector('button[type="submit"]');

    function setMessage(text) {
        if (messageDiv) messageDiv.textContent = text || '';
    }

    function validateUsername() {
        if (!username) return { ok: true, msg: '' };
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
        // if either password field is missing, skip password validation
        if (!password || !passwordConfirm) return { ok: true, msg: '' };

        const p = password.value;
        const p2 = passwordConfirm.value;

        if (p === '' && p2 === '') {
            password.classList.remove('is-invalid');
            passwordConfirm.classList.remove('is-invalid');
            return { ok: false, msg: '' };
        }

        // minimum length
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

        // at least one digit
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
        // show first error message (username first)
        setMessage(u.msg || p.msg);
        if (submitBtn) submitBtn.disabled = !(u.ok && p.ok);
        return u.ok && p.ok;
    }

    if (username) username.addEventListener('input', validateAll);
    if (password) password.addEventListener('input', validateAll);
    if (passwordConfirm) passwordConfirm.addEventListener('input', validateAll);

    form.addEventListener('submit', function (e) {
        if (!validateAll()) e.preventDefault();
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-change-password');
    if (!form) return;
    const oldPassword = form.querySelector('#old_password');
    const newPassword = form.querySelector('#new_password');
    const messageDiv = document.querySelector('#message');
    const submitBtn = form.querySelector('button[type="submit"]');

    function validatePassword() {
        let val = newPassword.value || '';
        let lengthOk = val.length >= 8 && val.length <= 30;
        let digitOk = /\d/.test(val);

        if (oldPassword.value === '' && val.length === 0) {
            submitBtn.disabled = true;
            messageDiv.textContent = '';
            return false;
        }

        if (val.length === 0) {
            submitBtn.disabled = true;
            messageDiv.textContent = '';
            return false;
        }

        if (!lengthOk) {
            submitBtn.disabled = true;
            newPassword.classList.add('is-invalid');
            messageDiv.textContent = 'Nové heslo musí mať aspoň 8 a maximálne 30 znakov.';
            return false;
        }

        if (!digitOk) {
            submitBtn.disabled = true;
            newPassword.classList.add('is-invalid');
            messageDiv.textContent = 'Nové heslo musí obsahovať aspoň jednu číslicu.';
            return false;
        }

        newPassword.classList.remove('is-invalid');
        messageDiv.textContent = '';
        if (oldPassword.value === '') {
            submitBtn.disabled = true;
            return false;
        }

        submitBtn.disabled = false;
        return true;
    }

    newPassword.addEventListener('input', validatePassword);
    oldPassword.addEventListener('input', validatePassword);

    form.addEventListener('submit', function (e) {
        if (!validatePassword()) {
            e.preventDefault();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-signin');
    if (!form) return;
    const messageDiv = document.querySelector('#message');
    const username = form.querySelector('#username');
    const password = form.querySelector('#password');

    function emptyMessage() {
        messageDiv.textContent = '';
    }

    username.addEventListener('input', emptyMessage);
    password.addEventListener('input', emptyMessage);
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-delete-password');
    if (!form) return;
    const messageDiv = document.querySelector('#message');
    const password = form.querySelector('#password');

    function emptyMessage() {
        messageDiv.textContent = '';
    }

    password.addEventListener('input', emptyMessage);
});