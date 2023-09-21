document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1; //Initialise létape actuelle à 1

    function nextStep(){
        // Masque le bloc de questions actuel en fonction de l'étape actuelle
        const currentQuestions = document.querySelector('[data-step="step' + currentStep + '"]');

        if(currentQuestions) {
            currentQuestions.style.display = 'none';

            //Incrémenter l'étaope actuelle
            currentStep++;

            //Affiche le bloc de question de la prochaine étape en fonction de l'étape actuelle
            const nextQuestion = document.querySelector('[data-step="step' + currentStep + '"]');

            if (nextQuestion) {
                nextQuestion.style.display = 'block';
            }
        }
    }

    // Associez cette fonction à l'événement click du bouton
    const button = document.querySelector(".grey-button");

    if (button) {
        button.addEventListener("click", nextStep);
    }

});




