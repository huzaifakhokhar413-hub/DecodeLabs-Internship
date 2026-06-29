const mobileBtn = document.querySelector('.mobile-menu-btn');
const navMenu = document.querySelector('.nav-menu');
const contactForm = document.getElementById('contactForm');
const catLinks = document.querySelectorAll('.cat-link');

mobileBtn.addEventListener('click', () => {
    if (navMenu.style.display === 'flex') {
        navMenu.style.display = 'none';
    } else {
        navMenu.style.display = 'flex';
        navMenu.style.flexDirection = 'column';
        navMenu.style.position = 'absolute';
        navMenu.style.top = '70px';
        navMenu.style.right = '5%';
        navMenu.style.backgroundColor = '#FFFFFF';
        navMenu.style.padding = '20px';
        navMenu.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        navMenu.style.width = '200px';
    }
});

catLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        alert('Category selected: ' + link.innerText);
    });
});

if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;

        if (!email.includes('@') || !email.includes('.')) {
            alert('Please enter a valid email address.');
            return;
        }

        alert('Success! Thank you ' + name + '. Your message has been received.');
        contactForm.reset();
    });
}