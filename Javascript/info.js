const moyenCheckboxes = document.querySelectorAll('input[name="moyen_contact[]"]');
const moyenAutreCheckbox = document.getElementById('moyen_autre_checkbox');
const moyenAutreInput = document.getElementById('moyen_autre');

function updateMoyenAutreRequirement() {
    const otherSelected = moyenAutreCheckbox.checked;
    const normalSelected = Array.from(moyenCheckboxes).some(cb => cb.checked && cb !== moyenAutreCheckbox);

    // Si "Autre" est coché et AUCUN autre moyen n'est sélectionné → input requis
    if (otherSelected && !normalSelected) {
        moyenAutreInput.style.display = 'inline-block';
        moyenAutreInput.required = true;
    } else {
        moyenAutreInput.style.display = otherSelected ? 'inline-block' : 'none';
        moyenAutreInput.required = false;

        if (!otherSelected) {
            moyenAutreInput.value = "";
        }
    }
}

// Sur chaque checkbox
moyenCheckboxes.forEach(cb => {
    cb.addEventListener('change', updateMoyenAutreRequirement);
});

// Initialisation
document.addEventListener('DOMContentLoaded', updateMoyenAutreRequirement);

const pronomsCheckboxes = document.querySelectorAll('input[name="pronoms[]"]');
const pronomsAutreCheckbox = document.getElementById('pronoms_autre_checkbox');
const pronomsAutreInput = document.getElementById('pronoms_autre');

function updatePronomsAutreRequirement() {
    const checkedPronoms = Array.from(pronomsCheckboxes).filter(cb => cb.checked && cb !== pronomsAutreCheckbox);
    const autreChecked = pronomsAutreCheckbox.checked;

    if (autreChecked && checkedPronoms.length === 0) {
        pronomsAutreInput.style.display = 'inline-block';
        pronomsAutreInput.required = true;
    } else {
        pronomsAutreInput.style.display = autreChecked ? 'inline-block' : 'none';
        pronomsAutreInput.required = false;
        if (!autreChecked) {
            pronomsAutreInput.value = '';
        }
    }
}

// Appliquer à chaque checkbox
pronomsCheckboxes.forEach(cb => {
    cb.addEventListener('change', updatePronomsAutreRequirement);
});

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', updatePronomsAutreRequirement);

    // Genre : champ texte si "Autre" choisi
    const genreSelect = document.getElementById('genre');
    const genreAutre = document.getElementById('genre_autre');

    genreSelect.addEventListener('change', function() {
        if (genreSelect.value === 'Autre') {
            genreAutre.style.display = 'block';
            genreAutre.required = true;
        } else {
            genreAutre.style.display = 'none';
            genreAutre.required = false;
        }
    });
    
// LCC
