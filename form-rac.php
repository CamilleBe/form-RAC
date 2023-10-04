<?php


try {
    $dbh = new PDO('mysql:host=localhost:3306; dbname=rac; charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Code derreur Camille : Erreur de connexion' . $e->getMessage());
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Codition Code postal
    if (!preg_match("~^\d{5}$~", $_POST['code_postal'])) {
        $errors['lenght_postal_code'] = "Le code postal n'est pas conforme";
    }

    //Codition email
    if (!preg_match("~^.+@.+\..+$~", $_POST['email'])) {
        $errors['preg_email'] = "l'e-mail est non conforme";
    }

    //Codition numéro de téléphone
    if (!preg_match("~^\d{10}$~", $_POST['telephone'])) {
        $errors['lenght_phone'] = "Le numéro renseigner n'existe pas";
    }

    //Condition naissance
    if (!preg_match("~^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[2-9][0-9]|200[0-3])$~", $_POST['date_naissance'])) {
        $errors['wrong_date'] = "Veuillez rentrer une date de naissance valide";
    }

    //Condition naissance co-emprunteur
    if (!preg_match("~^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[2-9][0-9]|200[0-3])$~", $_POST['date_naissance_co_emprunteur'])) {
        $errors['wrong_date_co_emprunteur'] = "Veuillez rentrer une date de naissance valide";
    }

    //Condition nombre enfants
    if (!preg_match("~^(10|[0-9])$~", $_POST['nombre_enfant'])) {
        $errors['wrong_enfants'] = "Veuillez rentrer un nombre valide";
    }

    var_dump($errors); // Affiche le contenu de la variable $errors


    if (empty($errors)) {

        try {

            // Affichez le contenu de $_POST pour le débogage
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            // Vérifiez si le statut est "non"
            if ($_POST['statut'] === 'non') {
                $_POST['mensualites_credits_immobiliers'] = "0.00";
                $_POST['total_restant_credits_immobiliers'] = "0.00";
                $_POST['valeur_patrimoine_immobilier'] = "0.00";
                // Ajoutez d'autres champs si nécessaire
            }

            if ($_POST['profession'] === 'sans_profession') {
                $_POST['contrat_de_travail'] = "0";
                $_POST['anciennete_travail_mois'] = "0.00";
                $_POST['anciennete_travail_annee'] = "0.00";
                $_POST['revenu_net_mensuel_avant_prelevement'] = "0.00";
                $_POST['frequence_revenus'] = "0";
            }

            if ( $_POST['emprunt'] === 'seul') {

                $_POST['genre_co_emprunteur'] = "0.00";
                $_POST['nom_co_emprunteur'] = "0.00";
                $_POST['prenom_co_emprunteur'] = "0.00";
                $_POST['date_naissance_co_emprunteur'] = "0.00";
                $_POST['ville_naissance_co_emprunteur'] = "0.00";
                $_POST['pays_naissance_co_emprunteur'] = "0.00";
                $_POST['nationalite_co_emprunteur'] = "0.00";

                $_POST['contrat_de_travail_co_emprunteur'] = "0";
                $_POST['anciennete_travail_mois_co_emprunteur'] = "0.00";
                $_POST['anciennete_travail_annee_co_emprunteur'] = "0.00";
                $_POST['revenu_net_mensuel_avant_prelevement_co_emprunteur'] = "0.00";
                $_POST['frequence_revenus_co_emprunteur'] = "0";
            }


            // Code de débogage pour vérifier si la condition est exécutée
            echo ($_POST['statut'] === 'non') ? "Condition is true" : "Condition is false";


            $query_params = array(
                ':statut' => $_POST['statut'],

                ':credit_immobilier' => $_POST['credit_immobilier'],
                /*':mensualites_credits_immobiliers' => ($_POST['statut'] == 'non') ? "0.00" : $_POST['statut'],*/
                ':mensualites_credits_immobiliers' => $_POST['mensualites_credits_immobiliers'],
                ':total_restant_credits_immobiliers' => $_POST['total_restant_credits_immobiliers'],
                ':valeur_patrimoine_immobilier' => $_POST['valeur_patrimoine_immobilier'],

                ':credit_consommation' => $_POST['credit_consommation'],
                ':mensualites_credits_consommations' => $_POST['mensualites_credits_consommations'],
                ':total_restant_credits_consommations' => $_POST['total_restant_credits_consommations'],

                ':autre_dette' => $_POST['autre_dette'],


                ':genre' => $_POST['genre'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':adresse' => $_POST['adresse'],
                ':ville' => $_POST['ville'],
                ':code_postal' => $_POST['code_postal'],
                ':telephone' => $_POST['telephone'],
                ':email' => $_POST['email'],
                ':date_naissance' => $_POST['date_naissance'],
                ':ville_naissance' => $_POST['ville_naissance'],
                ':pays_naissance' => $_POST['pays_naissance'],
                ':nationalite' => $_POST['nationalite'],
                ':objet_fichage' => $_POST['objet_fichage'],
                ':situation_logement' => $_POST['situation_logement'],
                ':situation_maritale' => $_POST['situation_maritale'],
                ':nombre_enfant' => $_POST['nombre_enfant'],

                ':profession' => $_POST['profession'],

                ':contrat_de_travail' => $_POST['contrat_de_travail'],
                ':anciennete_travail_mois' => $_POST['anciennete_travail_mois'],
                ':anciennete_travail_annee' => $_POST['anciennete_travail_annee'],
                ':revenu_net_mensuel_avant_prelevement' => $_POST['revenu_net_mensuel_avant_prelevement'],
                ':frequence_revenus' => $_POST['frequence_revenus'],

                ':emprunt' => $_POST['emprunt'],

                ':genre_co_emprunteur' => $_POST['genre_co_emprunteur'],
                ':nom_co_emprunteur' => $_POST['nom_co_emprunteur'],
                ':prenom_co_emprunteur' => $_POST['prenom_co_emprunteur'],
                ':date_naissance_co_emprunteur' => $_POST['date_naissance_co_emprunteur'],
                ':ville_naissance_co_emprunteur' => $_POST['ville_naissance_co_emprunteur'],
                ':pays_naissance_co_emprunteur' => $_POST['pays_naissance_co_emprunteur'],
                ':nationalite_co_emprunteur' => $_POST['nationalite_co_emprunteur'],

                ':contrat_de_travail_co_emprunteur' => $_POST['contrat_de_travail_co_emprunteur'],
                ':anciennete_travail_mois_co_emprunteur' => $_POST['anciennete_travail_mois_co_emprunteur'],
                ':anciennete_travail_annee_co_emprunteur' => $_POST['anciennete_travail_annee_co_emprunteur'],
                ':revenu_net_mensuel_avant_prelevement_co_emprunteur' => $_POST['revenu_net_mensuel_avant_prelevement_co_emprunteur'],
                ':frequence_revenus_co_emprunteur' => $_POST['frequence_revenus_co_emprunteur'],


                ':acceptations' => isset($_POST['acceptations']) ? 'accepté' : 0,

                ':date' => date('Y-m-d H:i:s'), // Enregistrement de la date d'envoi
                ':client_id' => $_POST['client_id']
            );

            $query = $dbh->prepare('INSERT INTO rac(
                                                        statut,
                                                        credit_immobilier,
                                                        mensualites_credits_immobiliers,
                                                        total_restant_credits_immobiliers,
                                                        valeur_patrimoine_immobilier,
                                                        credit_consommation,
                                                        mensualites_credits_consommations,
                                                        total_restant_credits_consommations,
                                                        autre_dette,
                                                        genre,
                                                        nom,
                                                        prenom,
                                                        adresse,
                                                        ville,
                                                        code_postal,
                                                        telephone,
                                                        email,
                                                        date_naissance,
                                                        ville_naissance,
                                                        pays_naissance,
                                                        nationalite,
                                                        objet_fichage,
                                                        situation_logement,
                                                        situation_maritale,
                                                        nombre_enfant,
                                                        profession,
                                                        contrat_de_travail,
                                                        anciennete_travail_mois,
                                                        anciennete_travail_annee,
                                                        revenu_net_mensuel_avant_prelevement,
                                                        frequence_revenus,
                                                        emprunt,
                                                        genre_co_emprunteur,
                                                        nom_co_emprunteur,
                                                        prenom_co_emprunteur,
                                                        date_naissance_co_emprunteur,
                                                        ville_naissance_co_emprunteur,
                                                        pays_naissance_co_emprunteur,
                                                        nationalite_co_emprunteur,
                                                        contrat_de_travail_co_emprunteur,
                                                        anciennete_travail_mois_co_emprunteur,
                                                        anciennete_travail_annee_co_emprunteur,
                                                        revenu_net_mensuel_avant_prelevement_co_emprunteur,
                                                        frequence_revenus_co_emprunteur,
                                                        acceptations,
                                                        date,
                                                        client_id
                                                    ) VALUES(
                                                        :statut,
                                                        :credit_immobilier,
                                                        :mensualites_credits_immobiliers,
                                                        :total_restant_credits_immobiliers,
                                                        :valeur_patrimoine_immobilier,
                                                        :credit_consommation,
                                                        :mensualites_credits_consommations,
                                                        :total_restant_credits_consommations,
                                                        :autre_dette,
                                                        :genre,
                                                        :nom,
                                                        :prenom,
                                                        :adresse,
                                                        :ville,
                                                        :code_postal,
                                                        :telephone,
                                                        :email,
                                                        :date_naissance,
                                                        :ville_naissance,
                                                        :pays_naissance,
                                                        :nationalite,
                                                        :objet_fichage,
                                                        :situation_logement,
                                                        :situation_maritale,
                                                        :nombre_enfant,
                                                        :profession,
                                                        :contrat_de_travail,
                                                        :anciennete_travail_mois,
                                                        :anciennete_travail_annee,
                                                        :revenu_net_mensuel_avant_prelevement,
                                                        :frequence_revenus,
                                                        :emprunt,
                                                        :genre_co_emprunteur,
                                                        :nom_co_emprunteur,
                                                        :prenom_co_emprunteur,
                                                        :date_naissance_co_emprunteur,
                                                        :ville_naissance_co_emprunteur,
                                                        :pays_naissance_co_emprunteur,
                                                        :nationalite_co_emprunteur,
                                                        :contrat_de_travail_co_emprunteur,
                                                        :anciennete_travail_mois_co_emprunteur,
                                                        :anciennete_travail_annee_co_emprunteur,
                                                        :revenu_net_mensuel_avant_prelevement_co_emprunteur,
                                                        :frequence_revenus_co_emprunteur,
                                                        :acceptations,
                                                        :date,
                                                        :client_id
                                                    )');
            $query->execute($query_params);
            echo "New record inserted successfully.";

            exit;

        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}

/* CREATE TABLE rac (
    statut VARCHAR(255),
    credit_immobilier VARCHAR(255),
    mensualites_credits_immobiliers DECIMAL(10, 2),
    total_restant_credits_immobiliers DECIMAL(10, 2),
    valeur_patrimoine_immobilier DECIMAL(10, 2),
    credit_consommation VARCHAR(50),
    mensualites_credits_consommations DECIMAL(10, 2),
    total_restant_credits_consommations DECIMAL(10, 2),
    autre_dette VARCHAR(50),
    genre VARCHAR(255),
    nom VARCHAR(255),
    prenom VARCHAR(255),
    adresse VARCHAR(255),
    ville VARCHAR(255),
    code_postal VARCHAR(255),
    telephone VARCHAR(255),
    email VARCHAR(255),
    date_naissance DATE,
    ville_naissance VARCHAR(255),
    pays_naissance VARCHAR(255),
    nationalite VARCHAR(255),
    objet_fichage VARCHAR(255),
    situation_logement VARCHAR(255),
    situation_maritale VARCHAR(255),
    nombre_enfant INT,
    profession VARCHAR(255),
    contrat_de_travail VARCHAR(255),
    anciennete_travail_mois INT,
    anciennete_travail_annee INT,
    revenu_net_mensuel_avant_prelevement DECIMAL(10, 2),
    frequence_revenus VARCHAR(255),
    emprunt VARCHAR(255),
    genre_co_emprunteur VARCHAR(255),
    nom_co_emprunteur VARCHAR(255),
    prenom_co_emprunteur VARCHAR(255),
    date_naissance_co_emprunteur DATE,
    ville_naissance_co_emprunteur VARCHAR(255),
    pays_naissance_co_emprunteur VARCHAR(255),
    nationalite_co_emprunteur VARCHAR(255),
    contrat_de_travail_co_emprunteur VARCHAR(255),
    anciennete_travail_mois_co_emprunteur INT,
    anciennete_travail_annee_co_emprunteur INT,
    revenu_net_mensuel_avant_prelevement_co_emprunteur DECIMAL(10, 2),
    frequence_revenus_co_emprunteur VARCHAR(255),
    acceptations VARCHAR(255),
    date DATETIME,
    client_id INT
);
*/

$genre = $_POST['genre'] ?? "";
$nom = $_POST['nom'] ?? "";
$prenom = $_POST['prenom'] ?? "";
$adresse = $_POST['adresse'] ?? "";
$ville = $_POST['ville'] ?? "";
$code_postal = $_POST['code_postal'] ?? "";
$telephone = $_POST['telephone'] ?? "";
$email = $_POST['email'] ?? "";


?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Rachat de crédits</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./style-form-rac.css">
    <script src="./form-logic.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script>
        // Récupérer le paramètre "client_id" depuis l'URL

        document.addEventListener("DOMContentLoaded", function () {
            //Récupérer le paramètre "client_id" depuis l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const clientIdFromURL = urlParams.get('client_id');

            // Stocker la valeur dans un champ caché du formulaire
            document.getElementById('clientIdInput').value = clientIdFromURL;
        });

    </script>

</head>
<body>
<header>
    <div>
        <h1>Rachat de crédits</h1>
    </div>

    <div>
        <p id="phrase-form">Recevez une propostion adaptée à vos besoins financiés</p>
        <form action="form-rac.php" method="POST">

            <input type="hidden" name="client_id" id="clientIdInput" value="">

            <div class="cadre" data-step="step1" id="display-style">
                <p>1. Vos crédits</p>
                <h2>Êtes vous propriétaire d'un bien ?</h2>

                <div class="container radio">
                    <input type="radio" id="proprietaire" name="statut" value="proprietaire" <?php if ($_POST['statut'] === 'proprietaire') { echo 'checked'; } ?>>
                    <label for="proprietaire" class="style-label">Oui</label>

                    <input type="radio" id="non" name="statut" value="non" <?php if ($_POST['statut'] === 'non') { echo 'checked'; } ?>>
                    <label for="non" class="style-label">Non</label>
                </div>
                <button class="grey-button">SUIVANT</button>
            </div>


            <div class="cadre questionsImmobilier" data-step="step2">
                <p>1. Vos crédits</p>
                <h2>Combien de crédits immobiliers avez vous ?</h2>

                <div class="container container-normal">
                    <label for="credit_immobilier">Nombre de crédits immobiliez</label>
                    <select id="credit_immobilier" name="credit_immobilier" required>
                        <option value=""></option>
                        <option value="aucun" <?php if($_POST['credit_immobilier'] === 'aucun') echo 'selected'; ?>>Aucun</option>
                        <option value="1" <?php if($_POST['credit_immobilier'] === '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if($_POST['credit_immobilier'] === '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if($_POST['credit_immobilier'] === '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if($_POST['credit_immobilier'] === '4') echo 'selected'; ?>>4</option>
                        <option value="5" <?php if($_POST['credit_immobilier'] === '5') echo 'selected'; ?>>5</option>
                        <option value="6" <?php if($_POST['credit_immobilier'] === '6') echo 'selected'; ?>>6</option>
                        <option value="7" <?php if($_POST['credit_immobilier'] === '7') echo 'selected'; ?>>7</option>
                        <option value="8" <?php if($_POST['credit_immobilier'] === '8') echo 'selected'; ?>>8</option>
                        <option value="9" <?php if($_POST['credit_immobilier'] === '9') echo 'selected'; ?>>9</option>
                        <option value="10" <?php if($_POST['credit_immobilier'] === '10') echo 'selected'; ?>>10</option>
                    </select>

                </div>
                <button class="grey-button">SUIVANT</button>

            </div>

            <div class="cadre questionsImmobilier" data-step="step3">

                <p>1. Vos crédits</p>
                <h2>Détails des crédits immobiliers</h2>

                <div class="container container-normal container-column container-input">

                    <div class="f2pl">
                        <div>
                            <label for="mensualites_credits_immobiliers">Montant des mensualités</label><br>
                            <input type="text" id="mensualites_credits_immobiliers" name="mensualites_credits_immobiliers" autocomplete="mensualites_credits_immobiliers" value="<?php echo $_POST['mensualites_credits_immobiliers'] ?? ''; ?>" required>
                        </div>


                        <div>
                            <label for="total_restant_credits_immobiliers">Montant total restant dû</label><br>
                            <input type="text" id="total_restant_credits_immobiliers" name="total_restant_credits_immobiliers" autocomplete="total_restant_credits_immobiliers" value="<?php echo $_POST['total_restant_credits_immobiliers'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="fl fl-top">
                        <label for="valeur_patrimoine_immobilier">Valeur approximative de votre patrimoine immobilier</label>
                        <input type="text" id="valeur_patrimoine_immobilier" name="valeur_patrimoine_immobilier" autocomplete="valeur_patrimoine_immobilier" value="<?php echo $_POST['valeur_patrimoine_immobilier'] ?? ''; ?>" required>
                    </div>

                </div>

                <button id="button-input" class="grey-button">SUIVANT</button>

            </div>

            <div class="cadre" data-step="step4">

                <p>1. Vos crédits</p>
                <h2>Combien de crédits à la consommation avez vous ?</h2>


                <div class="container container-normal">
                    <label for="credit_consommation">Nombre de crédits à la consommation</label>
                    <select id="credit_consommation" name="credit_consommation" required>
                        <option value=""></option>
                        <option value="aucun" <?php if($_POST['credit_consommation'] === 'aucun') echo 'selected'; ?>>Aucun</option>
                        <option value="1" <?php if($_POST['credit_consommation'] === '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if($_POST['credit_consommation'] === '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if($_POST['credit_consommation'] === '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if($_POST['credit_consommation'] === '4') echo 'selected'; ?>>4</option>
                        <option value="5" <?php if($_POST['credit_consommation'] === '5') echo 'selected'; ?>>5</option>
                        <option value="6" <?php if($_POST['credit_consommation'] === '6') echo 'selected'; ?>>6</option>
                        <option value="7" <?php if($_POST['credit_consommation'] === '7') echo 'selected'; ?>>7</option>
                        <option value="8" <?php if($_POST['credit_consommation'] === '8') echo 'selected'; ?>>8</option>
                        <option value="9" <?php if($_POST['credit_consommation'] === '9') echo 'selected'; ?>>9</option>
                        <option value="10" <?php if($_POST['credit_consommation'] === '10') echo 'selected'; ?>>10</option>
                    </select>

                </div>

                <button class="grey-button">SUIVANT</button>

            </div>

            <div class="cadre" data-step="step5">
                <p>1. Vos crédits</p>
                <h2>Détails des crédits à la consommation</h2>

                <div class="container container-normal container-column container-input">

                    <div class="f2pl">
                        <div>
                            <label for="mensualites_credits_consommations">Montant des mensualités</label>
                            <input type="text" id="mensualites_credits_consommations" name="mensualites_credits_consommations" autocomplete="mensualites_credits_consommations" value="<?php echo $_POST['mensualites_credits_consommations'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="total_restant_credits_consommations">Montant total restant dû</label>
                            <input type="text" id="total_restant_credits_consommations" name="total_restant_credits_consommations" autocomplete="total_restant_credits_consommations" value="<?php echo $_POST['total_restant_credits_consommations'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="fl fl-top">
                        <label for="autre_dette">Si autres dettes, total restant dû </label>
                        <input type="text" id="autre_dette" name="autre_dette" autocomplete="autre_dette" value="<?php echo $_POST['autre_dette'] ?? '' ; ?>" required>
                    </div>

                </div>

                <button id="button-input" class="grey-button">SUIVANT</button>
            </div>


            <div class="cadre" data-step="step6">
                <p>2. Votre profil</p>
                <h2>Détails de vos informations personnelles</h2>

                <div class="container container-normal container-column container-input">
                    <div>
                        <input type="radio" id="homme" name="genre" value="homme" <?php if ($_POST['genre'] === 'homme') { echo 'checked'; } ?>>
                        <label for="homme">Homme</label>

                        <input type="radio" id="femme" name="genre" value="femme" <?php if ($_POST['genre'] === 'femme') { echo 'checked'; } ?>>
                        <label for="femme">Femme</label>

                        <input type="radio" id="non-defini" name="genre" value="non-defini" <?php if ($_POST['genre'] === 'non-defini') { echo 'checked'; } ?>>
                        <label for="non-defini">Non défini</label>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="nom">Nom</label><br>
                            <input type="text" id="nom" name="nom" autocomplete="nom" value="<?php echo $nom ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="prenom">Prénom</label><br>
                            <input type="text" id="prenom" name="prenom" autocomplete="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>" required>
                        </div>

                    </div>

                    <div class="fl">
                        <label for="adresse">Adresse</label><br>
                        <input type="text" id="adresse" name="adresse" autocomplete="adresse" value="<?php echo $_POST['adresse'] ?? ''; ?>">
                    </div>
                </div>

                <button id="button-input" class="grey-button">SUIVANT</button>
            </div>
            <div class="cadre" data-step="step7">
                <p>2. Votre profil</p>
                <h2>Détails de vos informations personnelles</h2>

                <div class="container container-normal container-column container-input">

                    <div class="f2pl">
                        <div>
                            <label for="ville">Ville</label> <br>
                            <input type="text" id="ville" name="ville" autocomplete="ville" value="<?php echo $_POST['ville'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="code_postal">Code Postal</label><br>
                            <input type="text" id="code_postal" name="code_postal" autocomplete="codePostal" value="<?php echo $_POST['code_postal'] ?? ''; ?>" required>
                        </div>

                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="email">E-mail</label>
                            <input type="text" id="email" name="email" autocomplete="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="telephone">Téléphone</label>
                            <input type="text" id="telephone" name="telephone" autocomplete="phone" value="<?php echo $_POST['telephone'] ?? ''; ?>" required>
                        </div>
                    </div>

                </div>

                <button id="button-input" class="grey-button">SUIVANT</button>
            </div>


            <div class="cadre" data-step="step8">
                <p>2. Votre profil</p>
                <h2>Votre nationalité</h2>

                <div class="container container-normal container-column container-input">
                    <div class="f2pl">
                        <div>
                            <label for="date_naissance">Votre date de naissance</label>
                            <input type="text" id="date_naissance" name="date_naissance" autocomplete="date_naissance" value="<?php echo $_POST['date_naissance'] ?? ''; ?>" placeholder="JJ/MM/AAAA" required>

                            <div class="fl-error">
                                <?php if (isset($errors['wrong_date'])) { ?>
                                    <p id="error1"><?php echo $errors['wrong_date']; ?></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div>
                            <label for="ville_naissance">Ville de naissance</label>
                            <input type="text" id="ville_naissance" name="ville_naissance" autocomplete="ville_naissance" value="<?php echo $_POST['ville_naissance'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="pays_naissance">Votre pays de naissance</label>
                            <input type="text" id="pays_naissance" name="pays_naissance" autocomplete="pays_naissance" value="<?php echo $_POST['pays_naissance'] ?? ''; ?>" required>
                        </div>
                        <div>
                            <label for="nationalite">Votre nationalité</label>
                            <input type="text" id="nationalite" name="nationalite" autocomplete="nationalite" value="<?php echo $_POST['nationalite'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <button id="button-input" class="grey-button">SUIVANT</button>

                </div>
            </div>

            <div class="cadre" data-step="step9">
                <p>2. Votre profil</p>
                <h2>Votre situation familiale</h2>

                <div class="container container-normal container-column container-input">
                    <div class="f2pl">

                        <div>
                            <label for="objet_fichage">Faites-vous l'objet d'un fichage</label>
                            <select id="objet_fichage" name="objet_fichage" required>
                                <option value=""></option>
                                <option value="aucun" <?php if($_POST['objet_fichage'] === 'aucun') echo 'selected'; ?>>Aucun</option>
                                <option value="fichage_banque_france" <?php if($_POST['objet_fichage'] === 'fichage_banque_france') echo 'selected'; ?>>Fichage Banque de France</option>
                                <option value="ficp" <?php if($_POST['objet_fichage'] === 'ficp') echo 'selected'; ?>>Fichage FICP (crédit)</option>
                                <option value="plan_surendettement" <?php if($_POST['objet_fichage'] === 'plan_surendettement') echo 'selected'; ?>>Plan de surendettement</option>
                            </select>
                        </div>

                        <div>
                            <label for="situation_logement">Vous êtes</label>
                            <select id="situation_logement" name="situation_logement" required>
                                <option value=""></option>
                                <option value="proprietaire" <?php if($_POST['situation_logement'] === 'proprietaire') echo 'selected'; ?>>Propriétaire</option>
                                <option value="locataire" <?php if($_POST['situation_logement'] === 'locataire') echo 'selected'; ?>>Locataire</option>
                                <option value="heberger" <?php if($_POST['situation_logement'] === 'heberger') echo 'selected'; ?>>Hébergé par un tiers</option>
                            </select>
                        </div>


                    </div>

                    <div class="f2pl">

                        <div id="dimension-nb-enfant">
                            <label for="nombre_enfant">Nombre d'enfants à charge</label>
                            <input type="text" id="nombre_enfant" name="nombre_enfant" autocomplete="nombre_enfant" value="<?php echo $_POST['nombre_enfant'] ?? ''; ?>" required>
                        </div>

                        <div class="fl-error">
                            <?php if (isset($errors['wrong_enfants'])) { ?>
                                <p id="error3"><?php echo $errors['wrong_enfants']; ?></p>
                            <?php } ?>
                        </div>

                        <div id="dimension-maritale">
                            <label for="situation_maritale">Situation maritale</label>
                            <select id="situation_maritale" name="situation_maritale" required>
                                <option value=""></option>
                                <option value="celibataire" <?php if($_POST['situation_maritale'] === 'celibataire') echo 'selected'; ?>>Célibataire</option>
                                <option value="marie" <?php if($_POST['situation_maritale'] === 'marie') echo 'selected'; ?>>Marié</option>
                                <option value="pacse" <?php if($_POST['situation_maritale'] === 'pacse') echo 'selected'; ?>>Pacsé</option>
                                <option value="union_libre" <?php if($_POST['situation_maritale'] === 'union_libre') echo 'selected'; ?>>Union Libre</option>
                                <option value="divorce" <?php if($_POST['situation_maritale'] === 'divorce') echo 'selected'; ?>>Divorcé</option>
                                <option value="separe" <?php if($_POST['situation_maritale'] === 'separe') echo 'selected'; ?>>Séparé</option>
                                <option value="veuf" <?php if($_POST['situation_maritale'] === 'veuf') echo 'selected'; ?>>Veuf</option>
                            </select>
                        </div>

                    </div>
                    <button id="button-input" class="grey-button">SUIVANT</button>

                </div>
            </div>

            <div class="cadre" data-step="step10">
                <p>2.Votre profil</p>
                <h2>Votre situation professionelle</h2>

                <div class="container container-normal">
                    <label for="profession">Votre profession</label>
                    <select id="profession" name="profession" required>
                        <option value=""></option>
                        <option value="secteur_prive" <?php if($_POST['profession'] === 'secteur_prive') echo 'selected'; ?>>Secteur privé (salarié, ...)</option>
                        <option value="secteur_publique" <?php if($_POST['profession'] === 'secteur_publique') echo 'selected'; ?>>Secteur publique(fonctionnaire, ...)</option>
                        <option value="artisans_commercants" <?php if($_POST['profession'] === 'artisans_commercants') echo 'selected'; ?>>Artisans commerçants</option>
                        <option value="profession_liberale" <?php if($_POST['profession'] === 'profession_liberale') echo 'selected'; ?>>Profession libérale</option>
                        <option value="secteur_agricole" <?php if($_POST['profession'] === 'secteur_agricole') echo 'selected'; ?>>Secteur agricole</option>
                        <option value="etudiant" <?php if($_POST['profession'] === 'etudiant') echo 'selected'; ?>>Étudiant</option>
                        <option value="chomage" <?php if($_POST['profession'] === 'chomage') echo 'selected'; ?>>Chômage</option>
                        <option value="sans_profession" <?php if($_POST['profession'] === 'sans_profession') echo 'selected'; ?>>Sans profession</option>
                        <option value="retraite" <?php if($_POST['profession'] === 'retraite') echo 'selected'; ?>>Retraité</option>
                        <option value="autre" <?php if($_POST['profession'] === 'autre') echo 'selected'; ?>>Autre</option>
                    </select>
                </div>

                <button class="grey-button">SUIVANT</button>
            </div>

            <div class="cadre cadre-height-exeption" data-step="step11">

                <p>2.Votre profil</p>
                <h2>Votre situation professionelle</h2>
                <div class="container container-normal container-column container-input">

                    <div class="f2pl">
                        <div>
                            <label for="contrat_de_travail">Contrat de travail</label>
                            <select id="contrat_de_travail" name="contrat_de_travail" required>
                                <option value=""></option>
                                <option value="cdi" <?php if($_POST['contrat_de_travail'] === 'cdi') echo 'selected'; ?>>CDI</option>
                                <option value="cdd" <?php if($_POST['contrat_de_travail'] === 'cdd') echo 'selected'; ?>>CDD</option>
                                <option value="interim" <?php if($_POST['contrat_de_travail'] === 'interim') echo 'selected'; ?>>Interim</option>
                                <option value="cdi_essaie" <?php if($_POST['contrat_de_travail'] === 'cdi_essaie') echo 'selected'; ?>>CDI en période d'essaie</option>
                                <option value="autre" <?php if($_POST['contrat_de_travail'] === 'autre') echo 'selected'; ?>>Autre</option>
                                <option value="0" <?php if($_POST['contrat_de_travail'] === '0') echo 'selected'; ?> hidden >0</option>

                            </select>

                        </div>

                        <div>
                            <label for="anciennete_travail_mois">Ancienneté au travail (en mois) </label>
                            <input type="text" id="anciennete_travail_mois" name="anciennete_travail_mois" autocomplete="anciennete_travail_mois" value="<?php echo $_POST['anciennete_travail_mois'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="anciennete_travail_annee">Ancienneté au travail (en années) </label>
                            <input type="text" id="anciennete_travail_annee" name="anciennete_travail_annee" autocomplete="anciennete_travail_annee" value="<?php echo $_POST['anciennete_travail_annee'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="revenu_net_mensuel_avant_prelevement">Revenu Net mensuel (avant prélèvement impôt)</label>
                            <input type="text" id="revenu_net_mensuel_avant_prelevement" name="revenu_net_mensuel_avant_prelevement" autocomplete="revenu_net_mensuel_avant_prelevement" value="<?php echo $_POST['revenu_net_mensuel_avant_prelevement'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <label for="frequence_revenus">Fréquence des revenus</label>
                    <select id="frequence_revenus" name="frequence_revenus"required>
                        <option value=""></option>
                        <option value="12_mois" <?php if($_POST['frequence_revenus'] === '12_mois') echo 'selected'; ?>>12 mois</option>
                        <option value="13_mois" <?php if($_POST['frequence_revenus'] === '13_mois') echo 'selected'; ?>>13 mois</option>
                        <option value="14_mois" <?php if($_POST['frequence_revenus'] === '14_mois') echo 'selected'; ?>>14 mois</option>
                        <option value="15_mois" <?php if($_POST['frequence_revenus'] === '15_mois') echo 'selected'; ?>>15 mois</option>
                        <option value="16_mois" <?php if($_POST['frequence_revenus'] === '16_mois') echo 'selected'; ?>>16 mois</option>
                        <option value="0" <?php if($_POST['frequence_revenus'] === '0') echo 'selected'; ?> hidden>none</option>

                    </select>
                </div>

                <button id="button-input" class="grey-button">SUIVANT</button>

            </div>

            <div class="cadre" data-step="step12">
                <p>2.Votre profil</p>
                <h2>Empruntez-vous seul ou avec un co-emprunteur ?</h2>
                <div class="container container-normal container-column">
                    <label for="emprunt">Choisissez une option</label>
                    <select id="emprunt" name="emprunt"required>
                        <option value=""></option>
                        <option value="seul" <?php if($_POST['emprunt'] === 'seul') echo 'selected'; ?>>Seul</option>
                        <option value="avec_co_emprunteur" <?php if($_POST['emprunt'] === 'avec_co_emprunteur') echo 'selected'; ?>>Avec un co-emprunteur</option>
                    </select>
                </div>

                <button class="grey-button">SUIVANT</button>

            </div>

            <div class="cadre" data-step="step13">
                <p>3.Profil du co-emprunteur</p>
                <h2>Informations personlles du co-emprunteur</h2>

                <div class="container container-normal container-column container-input">
                    <div>
                        <input type="radio" id="homme_" name="genre_co_emprunteur" value="homme_" <?php if ($_POST['genre_co_emprunteur'] === 'homme_') { echo 'checked'; } ?>>
                        <label for="homme_">Homme</label>

                        <input type="radio" id="femme_" name="genre_co_emprunteur" value="femme_" <?php if ($_POST['genre_co_emprunteur'] === 'femme_') { echo 'checked'; } ?>>
                        <label for="femme_">Femme</label>

                        <input type="radio" id="non_defini" name="genre_co_emprunteur" value="non_defini" <?php if ($_POST['genre_co_emprunteur'] === 'non_defini') { echo 'checked'; } ?>>
                        <label for="non_defini" >Non défini</label>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="nom_co_emprunteur">Nom</label>
                            <input type="text" id="nom_co_emprunteur" name="nom_co_emprunteur" autocomplete="nom" value="<?php echo $nom ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="prenom_co_emprunteur">Prénom</label>
                            <input type="text" id="prenom_co_emprunteur" name="prenom_co_emprunteur" autocomplete="prenom" value="<?php echo $_POST['prenom_co_emprunteur'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <button class="grey-button">SUIVANT</button>

                </div>
            </div>


            <div class="cadre" data-step="step14">
                <p>3.Profil du co-emprunter</p>
                <h2>Nationalité du co-emprunteur</h2>
                <div class="container container-normal container-column container-input">
                    <div class="f2pl">
                        <div>
                            <label for="date_naissance_co_emprunteur">Date de naissance</label>
                            <input type="text" id="date_naissance_co_emprunteur" name="date_naissance_co_emprunteur" autocomplete="date_naissance_co_emprunteur" value="<?php echo $_POST['date_naissance_co_emprunteur'] ?? ''; ?>" placeholder="JJ/MM/AAAA" required>

                        </div>

                        <div>
                            <label for="ville_naissance_co_emprunteur">Ville de naissance</label>
                            <input type="text" id="ville_naissance_co_emprunteur" name="ville_naissance_co_emprunteur" autocomplete="ville_naissance_co_emprunteur" value="<?php echo $_POST['ville_naissance_co_emprunteur'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="pays_naissance_co_emprunteur">Pays de naissance</label>
                            <input type="text" id="pays_naissance_co_emprunteur" name="pays_naissance_co_emprunteur" autocomplete="pays_naissance_co_emprunteur" value="<?php echo $_POST['pays_naissance_co_emprunteur'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="nationalite_co_emprunteur">Nationalité</label>
                            <input type="text" id="nationalite_co_emprunteur" name="nationalite_co_emprunteur" autocomplete="nationalite_co_emprunteur" value="<?php echo $_POST['nationalite_co_emprunteur'] ?? ''; ?>" required>
                        </div>
                    </div>

                </div>

                <button class="grey-button">SUIVANT</button>

            </div>


            <div class="cadre cadre-height-exeption" data-step="step15">
                <p>3.Profil du co-emprunteur</p>
                <h3>Situation professionelle du co-emprunteur</h3>

                <div class="container container-normal container-column container-input">
                    <div class="f2pl">
                        <div>
                            <label for="contrat_de_travail_co_emprunteur">Contrat de travail</label>
                            <select id="contrat_de_travail_co_emprunteur" name="contrat_de_travail_co_emprunteur" required>
                                <option value=""></option>
                                <option value="cdi" <?php if($_POST['contrat_de_travail_co_emprunteur'] === 'cdi') echo 'selected'; ?>>CDI</option>
                                <option value="cdd" <?php if($_POST['contrat_de_travail_co_emprunteur'] === 'cdd') echo 'selected'; ?>>CDD</option>
                                <option value="interim" <?php if($_POST['contrat_de_travail_co_emprunteur'] === 'interim') echo 'selected'; ?>>Interim</option>
                                <option value="cdi_essaie" <?php if($_POST['contrat_de_travail_co_emprunteur'] === 'cdi_essaie') echo 'selected'; ?>>CDI en période d'essaie</option>
                                <option value="autre" <?php if($_POST['contrat_de_travail_co_emprunteur'] === 'autre') echo 'selected'; ?>>Autre</option
                            </select>
                            </select>
                        </div>

                        <div>
                            <label for="anciennete_travail_mois_co_emprunteur">Ancienneté au travail (en mois) </label>
                            <input type="text" id="anciennete_travail_mois_co_emprunteur" name="anciennete_travail_mois_co_emprunteur" autocomplete="anciennete_travail_mois_co_emprunteur" value="<?php echo $_POST['anciennete_travail_mois_co_emprunteur'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="f2pl">
                        <div>
                            <label for="anciennete_travail_annee_co_emprunteur">Ancienneté au travail (en années) </label>
                            <input type="text" id="anciennete_travail_annee_co_emprunteur" name="anciennete_travail_annee_co_emprunteur" autocomplete="anciennete_travail_annee_co_emprunteur" value="<?php echo $_POST['anciennete_travail_annee_co_emprunteur'] ?? ''; ?>" required>
                        </div>

                        <div>
                            <label for="revenu_net_mensuel_avant_prelevement_co_emprunteur">Revenu Net mensuel (avant prélèvement impôt)</label>
                            <input type="text" id="revenu_net_mensuel_avant_prelevement_co_emprunteur" name="revenu_net_mensuel_avant_prelevement_co_emprunteur" autocomplete="revenu_net_mensuel_avant_prelevement_co_emprunteur" value="<?php echo $_POST['revenu_net_mensuel_avant_prelevement_co_emprunteur'] ?? ''; ?>" required>
                        </div>

                    </div>

                    <label for="frequence_revenus_co_emprunteur">Fréquence des revenus</label>
                    <select id="frequence_revenus_co_emprunteur" name="frequence_revenus_co_emprunteur"required>
                        <option value=""></option>
                        <option value="12_mois" <?php if($_POST['frequence_revenus_co_emprunteur'] === '12_mois') echo 'selected'; ?>>12 mois</option>
                        <option value="13_mois" <?php if($_POST['frequence_revenus_co_emprunteur'] === '13_mois') echo 'selected'; ?>>13 mois</option>
                        <option value="14_mois" <?php if($_POST['frequence_revenus_co_emprunteur'] === '14_mois') echo 'selected'; ?>>14 mois</option>
                        <option value="15_mois" <?php if($_POST['frequence_revenus_co_emprunteur'] === '15_mois') echo 'selected'; ?>>15 mois</option>
                        <option value="16_mois" <?php if($_POST['frequence_revenus_co_emprunteur'] === '16_mois') echo 'selected'; ?>>16 mois</option>
                    </select>
                </div>
                <button class="grey-button">SUIVANT</button>

            </div>


            <div class="cadre" data-step="step16">
                <div id="fb">
                    <div class="exeption" id="acceptations">
                        <input type="checkbox" id="cgu" name="cgu" <?php if(isset($_POST['offre'])) echo "checked"; ?> required>
                        <label for="cgu">En validant ce formulaire, vous acceptez d’être rappelé par un conseiller. Les données recueillies sont nécessaires afin de traiter votre demande et, sauf opposition de votre part pourront être utilisées à des fins de prospection commerciale. Conformément au Règlement Général sur la Protection des Données (RGPD), de la loi Informatique et Libertés du 6 janvier 1978 modifiée, vous disposez de droits sur vos données. Reportez-vous à notre Politique de Protection des Données. *</label>
                        <br><br>
                    </div>

                    <input type="submit" value="ENVOYER" id="hbutton">
                </div>

            </div>
        </form>
    </div>

</header>
</body>
</html>