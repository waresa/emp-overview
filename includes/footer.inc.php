</body>
<script>
    function toggleForm() {
        const form = document.querySelector('.form-disp');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        const viewc = document.querySelector('.viewc');
        viewc.style.display = viewc.style.display === 'none' ? 'block' : 'none';
    }
    const toggleButton = document.querySelector('.toggle-form');
    toggleButton.addEventListener('click', toggleForm);
</script>

</html>