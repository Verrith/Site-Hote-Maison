<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Champs obligatoires
    $required_fields = [
        "prenom", "nom", "date_naissance", "prenom_naissance",
        "genre_select", "adresse", "ville", "code_postal",
        "contact1_nom", "contact1_lien", "contact1_tel", "contact2_nom",
        "contact2_lien", "contact2_tel"

    ];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            die("Erreur : le champ '$field' est obligatoire.");
        }
    }

    // --- Infos personnelles ---
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $date_naissance = trim($_POST["date_naissance"]);
    $prenom_naissance = trim($_POST["prenom_naissance"]);

    // Pronoms
    $pronoms = '';
    if (!empty($_POST["pronoms"])) {
        $pronoms = implode(", ", $_POST["pronoms"]);
        if (in_array("Autre", $_POST["pronoms"]) && !empty($_POST["pronoms_autre"])) {
            $pronoms .= ": " . trim($_POST["pronoms_autre"]);
        }
    }

    // Genre
    $genre = $_POST["genre_select"];
    if ($genre === "Autre" && !empty($_POST["genre_autre"])) {
        $genre .= ": " . trim($_POST["genre_autre"]);
    }

    // --- Adresse ---
    $adresse = trim($_POST["adresse"]);
    $ville = trim($_POST["ville"]);
    $code_postal = trim($_POST["code_postal"]);

    $adresse2 = !empty($_POST["adresse2"]) ? trim($_POST["adresse2"]) : null;
    $ville2 = !empty($_POST["ville2"]) ? trim($_POST["ville2"]) : null;
    $code_postal2 = !empty($_POST["code_postal2"]) ? trim($_POST["code_postal2"]) : null;

    // Contact 1
    $contact1_nom = trim($_POST["contact1_nom"]);
    $contact1_lien = trim($_POST["contact1_lien"]);
    $contact1_tel = trim($_POST["contact1_tel"]);
    $contact1_autre_tel = !empty($_POST["contact1_autre_tel"]) ? trim($_POST["contact1_autre_tel"]) : null;

    // Contact 2
    $contact2_nom = trim($_POST["contact2_nom"]);
    $contact2_lien = trim($_POST["contact2_lien"]);
    $contact2_tel = trim($_POST["contact2_tel"]);
    $contact2_autre_tel = !empty($_POST["contact2_autre_tel"]) ? trim($_POST["contact2_autre_tel"]) : null;

    // Santé
    $sante = $_POST["sante"] ?? null;

    // numéro pour te rejoindre
    $numero_rejoindre = !empty($_POST["numero_rejoindre"]) ? trim($_POST["numero_rejoindre"]) : "";

    // Moyen de contact
    $moyen_contact = '';
    if (!empty($_POST["moyen_contact"])) {
        $moyen_contact = implode(", ", $_POST["moyen_contact"]);
        if (in_array("Autre", $_POST["moyen_contact"]) && !empty($_POST["moyen_autre"])) {
            $moyen_contact .= ": " . trim($_POST["moyen_autre"]);
        }
    }

    $pseudos = $_POST["pseudos"] ?? null;

    try {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("INSERT INTO utilisateurs_hote_maison (
        prenom_hash, nom_hash, date_naissance_hash, prenom_naissance_hash, pronoms, genre,
        adresse_hash, ville_hash, code_postal_hash, adresse2_hash, ville2_hash, code_postal2_hash,
        contact1_nom_hash, contact1_lien, contact1_tel_hash, contact1_autre_tel_hash,
        contact2_nom_hash, contact2_lien, contact2_tel_hash, contact2_autre_tel_hash,
        sante, numero_rejoindre_hash, moyen_contact, pseudos
    ) VALUES (
        :prenom, :nom, :date_naissance, :prenom_naissance, :pronoms, :genre,
        :adresse, :ville, :code_postal, :adresse2, :ville2, :code_postal2,
        :contact1_nom, :contact1_lien, :contact1_tel, :contact1_autre_tel,
        :contact2_nom, :contact2_lien, :contact2_tel, :contact2_autre_tel,
        :sante, :numero_rejoindre, :moyen_contact, :pseudos
    )");

    $stmt->execute([
        ":prenom" => $prenom,
        ":nom" => $nom,
        ":date_naissance" => $date_naissance,
        ":prenom_naissance" => $prenom_naissance,
        ":pronoms" => $pronoms,
        ":genre" => $genre,
        ":adresse" => $adresse,
        ":ville" => $ville,
        ":code_postal" => $code_postal,
        ":adresse2" => $adresse2,
        ":ville2" => $ville2,
        ":code_postal2" => $code_postal2,
        ":contact1_nom" => $contact1_nom,
        ":contact1_lien" => $contact1_lien,
        ":contact1_tel" => $contact1_tel,
        ":contact1_autre_tel" => $contact1_autre_tel,
        ":contact2_nom" => $contact2_nom,
        ":contact2_lien" => $contact2_lien,
        ":contact2_tel" => $contact2_tel,
        ":contact2_autre_tel" => $contact2_autre_tel,
        ":sante" => $sante,
        ":numero_rejoindre" => $numero_rejoindre,
        ":moyen_contact" => $moyen_contact,
        ":pseudos" => $pseudos
    ]);

    // Redirige avec paramètre succès
    header('Location: ../Vue/fiche_didentification.php?success=1');
    exit;

} catch (PDOException $e) {
    echo "❌ Erreur lors de l'insertion : " . $e->getMessage();
}

}
// LCC
?>
