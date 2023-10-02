document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1; //Initialise létape actuelle à 1

    function nextStep(){

        const currentQuestions = document.querySelector('[data-step="step' + currentStep + '"]');

        if(currentQuestions) {

            // Vérifiez si tous les champs requis du bloc actuel sont complétés
            const requiredFields = currentQuestions.querySelectorAll('[required]');

            let allFieldsCompleted = true;
            requiredFields.forEach(field => {
                if (!field.value) {
                    allFieldsCompleted = false;
                }
            });

            /*VERIFICATION*/
            //CONDITION CODE POSTAL
            const codePostalField = currentQuestions.querySelector("#code_postal");
            if (codePostalField && !/^\d{5}$/.test(codePostalField.value)) {
                alert("Le code postal n'est pas conforme");
                return;
            }

            //CONDITION EMAIL
            const emailField = currentQuestions.querySelector("#email");
            if (emailField && !/^.+@.+..+$/.test(emailField.value)) {
                alert("L'adresse email n'est pas conforme");
                return;
            }

            //CONDITION TELEPHONE
            const telephoneField = currentQuestions.querySelector("#telephone");
            if (telephoneField && !/^\d{10}$/.test(telephoneField.value)) {
                alert("Le numéro n'est pas conforme");
                return;
            }

            //CONDITION NAISSANCE
            const dateNaissanceField = currentQuestions.querySelector('#date_naissance');
            if (dateNaissanceField && !/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[2-9][0-9]|200[0-3])$/.test(dateNaissanceField.value)) {
                alert("Date de naissance non conforme");
                return;
            }

            //CONDITION NAISSANCE CO-EMPRUNTEUR
            const dateNaissanceCoemprunteurField = currentQuestions.querySelector('#date_naissance_co_emprunteur');
            if (dateNaissanceCoemprunteurField && !/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[2-9][0-9]|200[0-3])$/.test(dateNaissanceCoemprunteurField.value)) {
                alert("La date de naissance du co-emprunteur n'est pas valide");
                return;
            }

            //CONDITION NOMBRE ENFANTS
            const nombreEnfantField = currentQuestions.querySelector("#nombre_enfant");
            if (nombreEnfantField && !/^(10|[0-9])$/.test(nombreEnfantField.value)) {
                alert("Veuillez saisir un nombre correct d'enfants");
                return;
            }

            if (currentStep === 1) {
                const response_step1 = document.querySelector('input[name="statut"]:checked').value;

                if (response_step1 === "proprietaire") {
                    // Logique pour afficher step2 et cacher step1

                    if (allFieldsCompleted) {
                        // Masque le bloc de questions actuel en fonction de l'étape actuelle

                        currentQuestions.style.display = 'none';
                        console.log("le block " + currentQuestions.getAttribute("data-step") + " disparait");


                        //Incrémenter l'étape actuelle
                        currentStep++;

                        //Affiche le bloc de question de la prochaine étape en fonction de l'étape actuelle
                        const nextQuestion = document.querySelector('[data-step="step' + currentStep + '"]');

                        if (nextQuestion) {
                            nextQuestion.style.display = 'block';
                            console.log("le block " + nextQuestion.getAttribute("data-step") + " apparait");
                        } else {
                            console.log("Bloc de questions introuvable pour l'étape : " + currentStep);
                        }
                    }

                } else {
                    alert('Veuillez compléter tous les champs requis avant de continuer.');


                        // Masque le bloc de questions actuel en fonction de l'étape actuelle

                        currentQuestions.style.display = 'none';
                        console.log("le block " + currentQuestions.getAttribute("data-step") + " disparait");


                        //Incrémenter l'étape actuelle
                        currentStep = 4;

                        if (allFieldsCompleted) {
                            //Affiche le bloc de question de la prochaine étape en fonction de l'étape actuelle
                            const nextQuestion = document.querySelector('[data-step="step' + currentStep + '"]');

                            if (nextQuestion) {
                                nextQuestion.style.display = 'block';
                                console.log("le block " + nextQuestion.getAttribute("data-step") + " apparait");
                            } else {
                                console.log("Bloc de questions introuvable pour l'étape : " + currentStep);
                            }
                        }
                }


                } else {
                    // Logique pour cacher step1 et afficher directement step3

                }
                return; // Terminez la fonction ici car vous avez déjà géré la logique de navigation pour step1


            }
        }

    // Associez cette fonction à l'événement click du bouton
    const buttons = document.querySelectorAll(".grey-button");

    buttons.forEach(button => {
        button.addEventListener("click", nextStep);
    });
});