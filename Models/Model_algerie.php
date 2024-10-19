<?php
class Model_algerie {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Ajouter un utilisateur
    public function ajouterUtilisateur($nom, $prenom, $email, $tel, $mot_de_passe) {
        $sql = "INSERT INTO users (nom, prenom, email, tel, mot_de_passe) VALUES (:nom, :prenom, :email, :tel, :mot_de_passe)";
        $stmt = $this->pdo->prepare($sql);
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':tel' => $tel,
            ':mot_de_passe' => $hashed_password
        ]);
        return $this->pdo->lastInsertId();
    }

    // Vérifier si un email existe déjà (pour l'inscription)
    public function emailExiste($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Authentifier un utilisateur (connexion)
    public function authentifierUtilisateur($email, $mot_de_passe) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            return $user; // Authentification réussie
        } else {
            return false; // Échec de l'authentification
        }
    }

    // Créer une demande de visa
    public function creerDemandeVisa($user_id, $num_passeport, $date_creation, $date_validite, $nationalite_id) {
        $sql = "INSERT INTO visa_requests (user_id, num_passeport, date_creation_passeport, date_validite_passeport, nationalite_id) 
                VALUES (:user_id, :num_passeport, :date_creation, :date_validite, :nationalite_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':num_passeport' => $num_passeport,
            ':date_creation' => $date_creation,
            ':date_validite' => $date_validite,
            ':nationalite_id' => $nationalite_id
        ]);
        return $this->pdo->lastInsertId();
    }

    // Ajouter un document pour une demande de visa
    public function ajouterDocument($visa_request_id, $nom_document, $chemin_fichier) {
        $sql = "INSERT INTO documents (visa_request_id, nom_document, chemin_fichier) 
                VALUES (:visa_request_id, :nom_document, :chemin_fichier)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':visa_request_id' => $visa_request_id,
            ':nom_document' => $nom_document,
            ':chemin_fichier' => $chemin_fichier
        ]);
    }

    // Récupérer une demande de visa par utilisateur
    public function getDemandesVisaParUtilisateur($user_id) {
        $sql = "SELECT vr.*, n.nationalite 
                FROM visa_requests vr 
                JOIN nationalities n ON vr.nationalite_id = n.id 
                WHERE vr.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNationaliteId($nationalite) {
        $sql = "SELECT id FROM nationalities WHERE nationalite = :nationalite";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nationalite' => $nationalite]);
        return $stmt->fetchColumn();
    }
    
}
?>
