document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1; //Initialise létape actuelle à 1

    function nextStep(){
        // Masque le bloc de questions actuel en fonction de l'étape actuelle
        const currentQuestions = document.querySelector('[data-step="step' + currentStep + '"]');

        if(currentQuestions) {
            currentQuestions.style.display = 'none';
            console.log("le block " + currentQuestions.getAttribute("data-step") + " disparait");


            //Incrémenter l'étaope actuelle
            currentStep++;

            //Affiche le bloc de question de la prochaine étape en fonction de l'étape actuelle
            const nextQuestion = document.querySelector('[data-step="step' + currentStep + '"]');

            if (nextQuestion) {
                nextQuestion.style.display = 'block';
                console.log("le block " + nextQuestion.getAttribute("data-step") + " apparait");
            }
            else {
                console.log("Bloc de questions introuvable pour l'étape : " + currentStep);
            }
        }
    }

    // Associez cette fonction à l'événement click du bouton
    const button = document.querySelector(".grey-button");

    button.addEventListener("click", nextStep);

    /*if (button) {
        button.addEventListener("click", nextStep);
    }
    else {
        console.log("Bouton non trouvé.");
    }*/

});




