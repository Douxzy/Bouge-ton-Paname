function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');

    answer.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}