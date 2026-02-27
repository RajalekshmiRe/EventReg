// ============================================
//   EventReg - Main JavaScript 2026
// ============================================

// ---------- Registration Form Handler ----------
const regForm = document.getElementById('registrationForm');
if (regForm) {
    regForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form        = e.target;
        const submitBtn   = form.querySelector('button[type="submit"]');
        const messageDiv  = document.getElementById('message');

        // Disable button + show spinner
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';

        const formData = new FormData(form);

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                messageDiv.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;

                form.reset();
                form.classList.remove('was-validated');

                setTimeout(() => { window.location.href = data.redirect; }, 1500);

            } else {
                messageDiv.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;

                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i>Register Now';
            }

        } catch (error) {
            console.error('Error:', error);
            messageDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>An error occurred. Please try again later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;

            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i>Register Now';
        }
    });
}

// ---------- Bootstrap Native Validation ----------
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

// ---------- Scroll to Top Button ----------
(function() {
    const btn = document.createElement('button');
    btn.className = 'scroll-top';
    btn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    btn.title = 'Back to top';
    document.body.appendChild(btn);

    window.addEventListener('scroll', function() {
        btn.classList.toggle('show', window.scrollY > 400);
    });

    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

// ---------- Navbar Active Link Highlight ----------
(function() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href === currentPage) {
            link.classList.add('active');
        }
    });
})();

// ---------- Fade-in Animation on Scroll ----------
(function() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.info-card, .event-card, .stat-box').forEach(el => {
        observer.observe(el);
    });
})();

// ---------- Input: Allow Only Numbers for Phone ----------
document.querySelectorAll('input[type="tel"]').forEach(input => {
    input.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
});

// ---------- Auto-dismiss Alerts after 5 seconds ----------
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(alert => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        if (bsAlert) bsAlert.close();
    });
}, 5000);