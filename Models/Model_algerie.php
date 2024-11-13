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
        // Fonction pour faire des logs avec chaque fonction
        private function logMessage($message) {
            $logFile = __DIR__ . '/log.txt';
            file_put_contents($logFile, date("Y-m-d H:i:s") . " - " . $message . PHP_EOL, FILE_APPEND);
        }

        // Ajouter un utilisateur
        public function ajouterUtilisateur($nom, $prenom, $email, $tel, $nationalite, $mot_de_passe) {
            try {
                $sql = "INSERT INTO users (nom, prenom, email, tel, nationalite, mot_de_passe) VALUES (:nom, :prenom, :email, :tel, :nationalite, :mot_de_passe)";
                $stmt = $this->pdo->prepare($sql);
                $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':tel' => $tel,
                    ':nationalite' => $nationalite,
                    ':mot_de_passe' => $hashed_password
                ]);
                $this->logMessage("Utilisateur ajouté avec succès : $nom $prenom");
                return $this->pdo->lastInsertId(); // Retourne l'ID de l'utilisateur ajouté
            } catch (PDOException $e) {
                $this->logMessage("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
                return false; // Retourne false en cas d'erreur
            }
        }
        

        public function utilisateurExiste($nom, $prenom, $tel, $email) {
            try {
                $sql = "SELECT * FROM users WHERE nom = :nom OR prenom = :prenom OR tel = :tel OR email = :email";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':tel' => $tel,
                    ':email' => $email
                ]);
                $existe = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->logMessage("Vérification d'utilisateur pour doublons avec nom: $nom, prénom: $prenom, tel: $tel, email: $email");
                return $existe;
            } catch (PDOException $e) {
                $this->logMessage("Erreur lors de la vérification de l'existence de l'utilisateur : " . $e->getMessage());
                return false;
            }
        }
        

     // Vérifier si un email existe déjà
     public function emailExiste($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $exists = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->logMessage("Vérification de l'email effectuée pour : $email");
            return $exists;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la vérification de l'email : " . $e->getMessage());
            return false;
        }
    }

    // Authentifier un utilisateur
    public function authentifierUtilisateur($email, $mot_de_passe) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                $this->logMessage("Authentification réussie pour l'utilisateur : $email");
                return $user;
            } else {
                $this->logMessage("Échec de l'authentification pour l'utilisateur : $email");
                return false;
            }
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de l'authentification de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Créer une demande de visa
    public function creerDemandeVisa($user_id, $num_passeport, $date_creation, $date_validite, $nationalite_id) {
        try {
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
            $this->logMessage("Demande de visa créée pour l'utilisateur ID : $user_id");
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la création de la demande de visa : " . $e->getMessage());
            return false;
        }
    }

    // Vérifier si une demande de visa existe pour un utilisateur
    public function demandeVisaExiste($user_id) {
        try {
            $sql = "SELECT COUNT(*) FROM visa_requests WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            $exists = $stmt->fetchColumn() > 0;
            $this->logMessage("Vérification de demande de visa pour l'utilisateur ID : $user_id");
            return $exists;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la vérification de la demande de visa : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les demandes de visa pour un utilisateur
    public function getDemandesVisaParUtilisateur($user_id) {
        try {
            $sql = "SELECT vr.*, n.nationalite 
                    FROM visa_requests vr 
                    JOIN nationalities n ON vr.nationalite_id = n.id 
                    WHERE vr.user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->logMessage("Demandes de visa récupérées pour l'utilisateur ID : $user_id");
            return $demandes;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération des demandes de visa : " . $e->getMessage());
            return false;
        }
    }

    // Obtenir l'ID d'une nationalité par son nom
    public function getNationaliteId($nationalite) {
        try {
            $sql = "SELECT id FROM nationalities WHERE nationalite = :nationalite";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':nationalite' => $nationalite]);
            $id = $stmt->fetchColumn();
            $this->logMessage("Récupération de l'ID pour la nationalité : $nationalite");
            return $id;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération de l'ID de la nationalité : " . $e->getMessage());
            return false;
        }
    }

    // Obtenir toutes les nationalités
    public function getNationalites() {
        try {
            $sql = "SELECT * FROM nationalities";
            $stmt = $this->pdo->query($sql);
            $nationalites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->logMessage("Récupération de toutes les nationalités");
            return $nationalites;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération des nationalités : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les demandes de visa en attente
    public function getDemandesVisaEnAttente() {
        try {
            $sql = "SELECT vr.id, vr.nom, vr.prenom, vr.num_passeport, n.nationalite, vr.date_creation_passeport 
                    FROM visa_requests vr 
                    JOIN nationalities n ON vr.nationalite_id = n.id 
                    WHERE vr.status = 'En attente'";
            $stmt = $this->pdo->query($sql);
            $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->logMessage("Récupération des demandes de visa en attente");
            return $demandes;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération des demandes de visa en attente : " . $e->getMessage());
            return false;
        }
    }

        // Valider une demande de visa
    public function validerDemandeVisa($visa_id) {
        try {
            $sql = "UPDATE visa_requests SET statut = 'Validé' WHERE id = :visa_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':visa_id' => $visa_id]);
            $this->logMessage("Demande de visa validée avec succès pour l'ID de demande : $visa_id");
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la validation de la demande de visa : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer tous les utilisateurs sauf les Algériens
    public function getAllUserssansAlgerie() {
        try {
            $sql = "SELECT * FROM users WHERE nationalite != 'Algérienne'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->logMessage("Tous les utilisateurs non algériens ont été récupérés avec succès.");
            return $users;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
            return false;
        }
    }

    // Marquer un utilisateur comme gagnant
    public function marquerCommeGagnant($userId) {
        try {
            $sql = "UPDATE users SET gagnant = 1 WHERE id = :userId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $this->logMessage("Utilisateur marqué comme gagnant pour l'ID utilisateur : $userId");
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors du marquage du gagnant : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour la nationalité d'un utilisateur
    public function mettreAJourNationalite($userId, $nouvelleNationalite = 'Algérienne') {
        try {
            $sql = "UPDATE users SET nationalite = :nouvelleNationalite WHERE id = :userId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nouvelleNationalite' => $nouvelleNationalite,
                ':userId' => $userId
            ]);
            $this->logMessage("Nationalité mise à jour pour l'utilisateur ID : $userId en $nouvelleNationalite");
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la mise à jour de la nationalité : " . $e->getMessage());
            return false;
        }
    }

    // Tirer un gagnant
    public function tirerAuSortGagnant() {
        try {
            $sql = "SELECT id FROM users WHERE nationalite != 'Algérienne'";
            $stmt = $this->pdo->query($sql);
            $utilisateurs = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (!$utilisateurs) {
                $this->logMessage("Aucun utilisateur éligible trouvé pour le tirage au sort.");
                return null;
            }

            $gagnantId = $utilisateurs[array_rand($utilisateurs)];
            $this->marquerCommeGagnant($gagnantId);
            $this->mettreAJourNationalite($gagnantId, 'Algérienne');

            $sql = "SELECT * FROM users WHERE id = :gagnantId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':gagnantId' => $gagnantId]);
            $gagnant = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->logMessage("Utilisateur tiré au sort comme gagnant : ID $gagnantId");
            return $gagnant;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors du tirage au sort : " . $e->getMessage());
            return false;
        }
    }

    // Ajouter un feedback
    public function ajouterFeedback($user_id, $commentaire, $note) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO feedbacks (user_id, commentaire, note, date) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $commentaire, $note]);
            $this->logMessage("Feedback ajouté pour l'utilisateur ID : $user_id avec note $note");
            return true;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de l'ajout du feedback : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer tous les feedbacks
    public function getAllFeedbacks() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM feedbacks ORDER BY date DESC");
            $feedbacks = $stmt->fetchAll();
            $this->logMessage("Tous les feedbacks ont été récupérés.");
            return $feedbacks;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération des feedbacks : " . $e->getMessage());
            return false;
        }
    }

    // Calculer la moyenne des notes
    public function calculerMoyenneNotes() {
        try {
            $stmt = $this->pdo->query("SELECT AVG(note) as moyenne FROM feedbacks");
            $result = $stmt->fetch();
            $moyenne = $result ? $result['moyenne'] : 0;
            $this->logMessage("Moyenne des notes calculée : $moyenne");
            return $moyenne;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors du calcul de la moyenne des notes : " . $e->getMessage());
            return false;
        }
    }

    // Offrir un déjeuner gratuit
    public function offrirDejeuner($email, $prenom) {
        try {
            $sql = "UPDATE users SET dejeuner = 1 WHERE email = :email AND prenom = :prenom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':email' => $email,
                ':prenom' => $prenom
            ]);
            $offreReussie = $stmt->rowCount() > 0;
            $this->logMessage($offreReussie ? "Déjeuner offert pour $prenom ($email)" : "Échec de l'offre de déjeuner pour $prenom ($email)");
            return $offreReussie;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de l'offre de déjeuner : " . $e->getMessage());
            return false;
        }
    }

    // Vérifier les informations de l'utilisateur
    public function verifierUtilisateur($user_id, $nom, $prenom, $tel, $email) {
        try {
            $sql = "SELECT * FROM users WHERE id = :user_id AND nom = :nom AND prenom = :prenom AND tel = :tel AND email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':tel' => $tel,
                ':email' => $email
            ]);
            $utilisateurExiste = $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
            $this->logMessage("Vérification des informations de l'utilisateur ID : $user_id - Résultat : " . ($utilisateurExiste ? "valide" : "non valide"));
            return $utilisateurExiste;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la vérification de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Changer le mot de passe de l'utilisateur
    public function changerMotDePasse($user_id, $nouveauMdp) {
        try {
            $sql = "UPDATE users SET mot_de_passe = :mot_de_passe WHERE id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $hashed_password = password_hash($nouveauMdp, PASSWORD_DEFAULT);
            $stmt->execute([
                ':mot_de_passe' => $hashed_password,
                ':user_id' => $user_id
            ]);
            $this->logMessage("Mot de passe modifié pour l'utilisateur ID : $user_id");
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors du changement de mot de passe : " . $e->getMessage());
            return false;
        }
    }

    // Obtenir les informations de l'utilisateur par ID
    public function getUtilisateurById($user_id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->logMessage("Informations récupérées pour l'utilisateur ID : $user_id");
            return $utilisateur;
        } catch (PDOException $e) {
            $this->logMessage("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
}
