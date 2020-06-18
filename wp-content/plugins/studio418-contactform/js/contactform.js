// Contact form zelf
const form = document.querySelector('.contact-form');
// Submit knopje
const button = document.querySelector('.contactform-submit');
// Verplichte velden
const rq = document.querySelectorAll('.rq');

// Zet button op disabled via javascript zodat het formulier blijft werken mocht javascript uit staan
button.disabled = true;

// Als iemand een toets indruk op het toetsenbord in het formulier voer de code uit
form.addEventListener('keyup', function () {

    // variable of te checken of alle velden zijn ingevuld. Deze wordt false als dat niet het geval is
    let compleet = true;

    // Loop door alle verplichte velden na
    for(let i = 0; i < rq.length; i++) {

        // Check of verplicht veld leeg is en is het een email veld of het een geldige email is
        if(rq[i].value.trim() === '' && rq[i].type !== 'email' || rq[i].type === 'email' && !checkEmail(rq[i].value.trim())) {

            button.disabled = true;
            // Als een verlicht veld leeg is of geen geldige email is zetten we compleet op false
            compleet = false;
        }
    }

    // Zet verzendknopje weer aan
    if(compleet) {
        button.disabled = false;
    }

});

// Check op geldige email
function checkEmail (email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
}