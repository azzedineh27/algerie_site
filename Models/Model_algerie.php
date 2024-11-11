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
    public function ajouterUtilisateur($nom, $prenom, $email, $tel, $nationalite, $mot_de_passe) {
        $sql = "INSERT INTO users (nom, prenom, email, tel, nationalite, mot_de_passe) VALUES (:nom, :prenom, :email, :tel, :nationalite, :mot_de_passe)";
        $stmt = $this->pdo->prepare($sql);
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':tel' => $tel,
            ':nationalite'=>$nationalite,
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
    public function demandeVisaExiste($user_id) {
        $sql = "SELECT COUNT(*) FROM visa_requests WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchColumn() > 0;
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

    // Récupérer toutes les nationalités depuis la base de données
    public function getNationalites() {
        $sql = "SELECT * FROM nationalities";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si une nationalité est interdite (Israélienne, Kosovo, Taïwan)
    public function estNationaliteInterdite($nationalite) {
        $nationalitesInterdites = ['Israélienne', 'Kosovo', 'Taïwan'];
        return in_array($nationalite, $nationalitesInterdites);
    }
    // Récupérer les demandes de visa en attente
    public function getDemandesVisaEnAttente() {
        $sql = "SELECT vr.id, vr.nom, vr.prenom, vr.num_passeport, n.nationalite, vr.date_creation_passeport 
                FROM visa_requests vr 
                JOIN nationalities n ON vr.nationalite_id = n.id 
                WHERE vr.status = 'En attente'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Valider une demande de visa
    public function validerDemandeVisa($visa_id) {
        $sql = "UPDATE visa_requests SET statut = 'Validé' WHERE id = :visa_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':visa_id' => $visa_id]);
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function marquerCommeGagnant($userId) {
        $sql = "UPDATE users SET gagnant = 1 WHERE id = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }
    

    public function tirerAuSortGagnant() {
        // Récupérer tous les utilisateurs
        $sql = "SELECT id FROM users";
        $stmt = $this->pdo->query($sql);
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        if (!$utilisateurs) {
            return null; // Aucun utilisateur trouvé
        }
    
        // Choisir un utilisateur aléatoire
        $gagnantId = $utilisateurs[array_rand($utilisateurs)];
    
        // Marquer l'utilisateur comme gagnant
        $this->marquerCommeGagnant($gagnantId);
    
        // Renvoyer les informations du gagnant
        $sql = "SELECT * FROM users WHERE id = :gagnantId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':gagnantId' => $gagnantId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function ajouterFeedback($user_id, $commentaire, $note) {
        $stmt = $this->pdo->prepare("INSERT INTO feedbacks (user_id, commentaire, note, date) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $commentaire, $note]);
    }
    
    public function getAllFeedbacks() {
        $stmt = $this->pdo->query("SELECT * FROM feedbacks ORDER BY date DESC");
        return $stmt->fetchAll();
    }
    
    public function calculerMoyenneNotes() {
        $stmt = $this->pdo->query("SELECT AVG(note) as moyenne FROM feedbacks");
        $result = $stmt->fetch();
        return $result ? $result['moyenne'] : 0;
    }
    
    

}
?>
