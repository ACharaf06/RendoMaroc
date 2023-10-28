//gérer le comportement des étoiles
let labels = Array.from(document.querySelectorAll('.rating-stars label'));
let inputs = Array.from(document.querySelectorAll('.rating-stars input'));

let currentRating = 0;

labels.forEach((label, index) => {
    // Mouse enter
    label.addEventListener('mouseenter', () => {
        for (let i = 0; i <= index; i++) {
            labels[i].style.color = 'gold';
        }
    });

    // Mouse leave
    label.addEventListener('mouseleave', () => {
        labels.forEach((label, i) => {
            label.style.color = i < currentRating ? 'gold' : 'lightgray';
        });
    });
});

inputs.forEach((input, index) => {
    // On click
    input.addEventListener('click', () => {
        currentRating = index + 1;
        labels.forEach((label, i) => {
            label.style.color = i < currentRating ? 'gold' : 'lightgray';
        });
    });
});

//pour gérer le trie des rendonées
document.addEventListener('DOMContentLoaded', function() {
    var sortBy = document.getElementById('sort-by');
    sortBy.addEventListener('change', function() {
        document.getElementById('sort-form').submit();
    });
});