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


    if (empty($errors)) {
        try {

            $query_params = array(
                ':status' => $_POST['status'],

                ':credit_immobilier' => $_POST['credit_immobilier'],
                ':mensualites_credits_immobiliers' => $_POST['mensualites_credits_immobiliers'],
                ':total_restant_credits_immobiliers' => $_POST['total_restant_credits_immobiliers'],
                ':valeur_patrimoine_immobilier' => $_POST['valeur_patrimoine_immobilier'],

                ':credit_consommation' => $_POST['credit_consommation'],


                ':genre' => $_POST['genre'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':adresse' => $_POST['adresse'],
                ':ville' => $_POST['ville'],
                ':code_postal' => $_POST['code_postal'],
                ':telephone' => $_POST['telephone'],
                ':email' => $_POST['email'],
                ':acceptations' => isset($_POST['acceptations']) ? 'accepté' : 0,

                ':date' => date('Y-m-d H:i:s'), // Enregistrement de la date d'envoi
                ':client_id' => $_POST['client_id']
            );

            $query = $dbh->prepare('INSERT INTO rac(status, credit_immobilier, mensualites_credits_immobiliers, total_restant_credits_immobiliers, valeur_patrimoine_immobilier, credit_consommation, genre, nom, prenom, adresse, ville, code_postal, telephone, email, acceptations, date, client_id) VALUES(:status, :credit_immobilier, :mensualites_credits_immobiliers, :total_restant_credits_immobiliers, :valeur_patrimoine_immobilier, :credit_consommation, :genre, :nom, :prenom, :adresse, :ville, :code_postal, :telephone, :email, :acceptations, :date, :client_id)');
            $query->execute($query_params);
            echo "New record inserted successfully.";

            exit;

        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}

/*CREATE TABLE energie_solaire (
  id INT NOT NULL AUTO_INCREMENT,
  status VARCHAR(255),
  logement_type VARCHAR(255),
  facture_energie VARCHAR(255),
  genre VARCHAR(255),
  nom VARCHAR(255),
  prenom VARCHAR(255),
  adresse VARCHAR(255),
  code_postal VARCHAR(5),
  ville VARCHAR(255),
  telephone VARCHAR(10),
  email VARCHAR(255),
  acceptations BOOLEAN,
  offre BOOLEAN,
  PRIMARY KEY (id)
);*/

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
<html lang="fr">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TTKG7XR');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YJVDX1493G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YJVDX1493G');
</script>

    <meta charset="UTF-8">
    <title>Rachat de crédits</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style-form-rac.css">

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
            <p>Recevez une propostion adaptée à vos besoins financiés</p>
            <form action="form-rac.php" method="POST">

                <input type="hidden" name="client_id" id="clientIdInput" value="">

                <div class="f2pl">
                        <label for="statut">Êtes vous propriétaire d'un bien ?</label required>
                        <input type="radio" id="oui" name="statut" value="propriétaire" <?php if ($_POST['statut'] === 'homme') { echo 'checked'; } ?>>
                        <label for="propriétaire">Oui</label>

                        <input type="radio" id="" name="statut" value="non" <?php if ($_POST['statut'] === 'non') { echo 'checked'; } ?>>
                        <label for="non">Non</label>
                </div>


                <div class="fl">
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

                <div>
                    <label for="mensualites_credits_immobiliers">Montant des mensualités de vos crédits immobiliers</label>
                    <input type="text" id="mensualites_credits_immobiliers" name="mensualites_credits_immobiliers" autocomplete="mensualites_credits_immobiliers" value="<?php echo $mensualites_credits_immobiliers ?? ''; ?>" required>

                    <label for="total_restant_credits_immobiliers">Montant total restant dû de vos crédits immobiliers</label>
                    <input type="text" id="total_restant_credits_immobiliers" name="total_restant_credits_immobiliers" autocomplete="total_restant_credits_immobiliers" value="<?php echo $total_restant_credits_immobiliers ?? ''; ?>" required>

                    <label for="valeur_patrimoine_immobilier">Valeur approximative de votre patrimoine immobilier</label>
                    <input type="text" id="valeur_patrimoine_immobilier" name="valeur_patrimoine_immobilier" autocomplete="valeur_patrimoine_immobilier" value="<?php echo $valeur_patrimoine_immobilier ?? ''; ?>" required>
                </div>

                <div class="fl">
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








                <div class="f2pl">
                        <label for="statut">Êtes vous propriétaire d'un bien ?</label required>
                        <input type="radio" id="oui" name="statut" value="propriétaire" <?php if ($_POST['statut'] === 'homme') { echo 'checked'; } ?>>
                        <label for="propriétaire">Oui</label>

                        <input type="radio" id="" name="statut" value="non" <?php if ($_POST['statut'] === 'non') { echo 'checked'; } ?>>
                        <label for="non">Non</label>

                    <select id="facture_energie" name="facture_energie" required>
                        <option value="">Le montant de votre facture énergétique... <sup>*</sup></option>
                        <option value="-1000" <?php if($_POST['facture_energie'] === '-1000') echo 'selected'; ?>>- 1 000€</option>
                        <option value="1000" <?php if($_POST['facture_energie'] === '1000') echo 'selected'; ?>>1 000€</option>
                        <option value="1500" <?php if($_POST['facture_energie'] === '1500') echo 'selected'; ?>>1 500€</option>
                        <option value="2000" <?php if($_POST['facture_energie'] === '2000') echo 'selected'; ?>>2 000€</option>
                        <option value="2500" <?php if($_POST['facture_energie'] === '2500') echo 'selected'; ?>>2 500€</option>
                        <option value="3000" <?php if($_POST['facture_energie'] === '3000') echo 'selected'; ?>>3 000€</option>
                        <option value="3500" <?php if($_POST['facture_energie'] === '3500') echo 'selected'; ?>>3 500€</option>
                        <option value="+3500" <?php if($_POST['facture_energie'] === '+3500') echo 'selected'; ?>>+3 500€</option>
                    </select>
                </div>







                <div class="fl exeption">
                    <label for="genre">Genre : </label required>
                    <input type="radio" id="homme" name="genre" value="homme" <?php if ($_POST['genre'] === 'homme') { echo 'checked'; } ?>>
                    <label for="homme">Homme</label>

                    <input type="radio" id="femme" name="genre" value="femme" <?php if ($_POST['genre'] === 'femme') { echo 'checked'; } ?>>
                    <label for="femme">Femme</label>

                    <input type="radio" id="non-defini" name="genre" value="non-defini" <?php if ($_POST['genre'] === 'non-defini') { echo 'checked'; } ?>>
                    <label for="non-defini">Non défini</label>
                </div>

                <div class="f2pl">
                    <input type="text" id="nom" name="nom" placeholder="Nom *" autocomplete="nom" value="<?php echo $nom; ?>" required>

                    <input type="text" id="prenom" name="prenom" placeholder="→Prénom *" autocomplete="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>" required>
                </div>

                <div class="fl">
                    <input type="text" id="adresse" name="adresse" placeholder="Adresse" autocomplete="adresse" value="<?php echo $_POST['adresse'] ?? ''; ?>">
                </div>

                <div class="f2pl">
                    <input type="text" id="ville" name="ville" placeholder="Ville" autocomplete="ville" value="<?php echo $_POST['ville'] ?? ''; ?>">

                    <input type="text" id="code_postal" name="code_postal" placeholder="Code Postal *" autocomplete="codePostal" value="<?php echo $_POST['code_postal'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['lenght_postal_code'])) { ?>
                        <p id="error1"><?php echo $errors['lenght_postal_code']; ?></p>
                    <?php } ?>
                </div>


                <div class="fl">
                    <label for="email"></label>
                    <input type="text" id="email" name="email" placeholder="Adresse e-mail *" autocomplete="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['preg_email'])) { ?>
                        <p id="error2"><?php echo $errors['preg_email']; ?></p>
                    <?php } ?>
                </div>

                <div class="fl">
                    <label for="telephone"></label>
                    <input type="text" id="telephone" name="telephone" placeholder="Numéro de téléphone *" autocomplete="phone" value="<?php echo $_POST['telephone'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['lenght_phone'])) { ?>
                        <p id="error3"><?php echo $errors['lenght_phone']; ?></p>
                    <?php } ?>
                </div>

                <div id="fb">
                    <div class="exeption" id="acceptations">
                        <input type="checkbox" id="cgu" name="cgu" <?php if(isset($_POST['offre'])) echo "checked"; ?> required>
                        <label for="cgu">En validant ce formulaire, vous acceptez d’être rappelé par un conseiller. Les données recueillies sont nécessaires afin de traiter votre demande et, sauf opposition de votre part pourront être utilisées à des fins de prospection commerciale. Conformément au Règlement Général sur la Protection des Données (RGPD), de la loi Informatique et Libertés du 6 janvier 1978 modifiée, vous disposez de droits sur vos données. Reportez-vous à notre Politique de Protection des Données. *</label>
                        <br><br>
                    </div>

                    <input type="submit" value="ENVOYER" id="hbutton">
                </div>
            </form>
        </div>
</header>
