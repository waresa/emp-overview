function toggleForm() {
    const form = document.querySelector('.form-disp');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    const viewc = document.querySelector('.viewc');
    viewc.style.display = viewc.style.display === 'none' ? 'block' : 'none';
    const hours = document.querySelector('.hours');
    hours.style.display = hours.style.display === 'none' ? 'block' : 'none';
    const hours2 = document.querySelector('.hours2');
    hours2.style.display = hours2.style.display === 'none' ? 'block' : 'none';
}

const toggleButton = document.querySelector('.toggle-form');
toggleButton.addEventListener('click', toggleForm);