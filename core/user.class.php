<?php

    class User {
        
        private int $id;
        private string $pseudo;
        private string $email;
        private string $password;
        private string $token;
        private ?string $avatar;
        private ?string $prenom;
        private ?string $nom;
        private Datetime $dateInscription;

        public function __construct() {
            $this->id = 0;
            $this->pseudo = "";
            $this->email = "";
            $this->password = "";
            $this->token = "";
            $this->avatar = "";
            $this->prenom = "";
            $this->nom = "";
            $this->dateInscription = new Datetime();
        }

        /************************************************  MAGIC SETTER  *****************************************************/
        
        public function __set($property, $value) {

            if ($property == "date_inscription") {
                $this->dateInscription = new Datetime($value);

            } else {
               $this->$property = $value; 
            }  

        }

        /************************************************  MAGIC GETTER  *****************************************************/

        public function __get($property) {

            if ($property == "date_inscription") {

                return $this->dateInscription;

            } else {

              return $this->$property; 

            } 

        }

        /*************************************************  CONNEXION  ******************************************************/
        /**
        * @param string Email de l'utilisateur souhaitant se connecter
        * @param string Mot de passe en clair de l'utilisateur souhaitant se connecter
        * 
        * @return User l'utilisateur enregistré qui correspond aux critères
        */

        public function getPassword() {
            return $this->password;
        }

        public static function login(string $email, string $password) : User {

            try {

                $connexion = new PDO('mysql:host=localhost;dbname=exophp;charset=utf8', 'root', 'A12z09eR');
                $connexion-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // On regarde si l'utilisateur est inscrit dans la table utilisateurs
                //$check = $connexion->prepare('SELECT * FROM utilisateurs WHERE email = :email AND actif = 1;');
                $check = $connexion->prepare('SELECT * FROM utilisateurs WHERE email = :email;');
                $check->bindParam(':email', $email, PDO::PARAM_STR);
                $check->execute();

                $data = $check->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User");

                if ($check->rowCount()) {

                    $user = $data[0];

                    if(password_verify($password, $user->getPassword())) {

                        return $user;

                    } else {

                        return new User();

                    }
                   
                } else {

                    return new User();

                }
            
            } catch(Exception $e) {

            return new User();

            }

        }

        /*************************************************  REGISTER  ****************************************************/ 

        /**
        * @param void Rien à passer en paramètre !
        * @return bool TRUE in case of success or FALSE in case of failure
        */

        public function creerCompte() : bool {

            $email = $this->email;
            $password = $this-> password;
            $pseudo = $this-> pseudo;
    
            // Requête 
            $sql = "INSERT INTO utilisateurs (email, password, pseudo) VALUES (:email, :password, :pseudo);";
                
            try {  

                // Connexion à la base de données
                $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");
    
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $requete = $connexion->prepare($sql);
                $requete-> bindParam(":email", $email, PDO::PARAM_STR);
                $requete-> bindParam(":password", $password, PDO::PARAM_STR);
                $requete-> bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    
                return $requete-> execute();

            } catch (Exception $exc) {

                // echo $exc-> getMessage();
                return false;

            }

        }

        /***********************************  Change profile picture  *******************************/ 


        public static function changeAvatar() {

            $tailleMax = 2097152; // initialisation de la taille max autorisée
            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png'); // les formats d'images valides
            $id = $_SESSION['user-id']; // initialisation de la variable id dans laquelle on stocke l'id de l'utilisateur connecté

            if ($_FILES['avatar']['size'] <= $tailleMax) { // Si avatar ne retourne pas d'erreur et si sa taille est inferieure ou égale à $tailleMax


                $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1)); // Initialise la variable qui servira à ajouter l'extension

                if (in_array($extensionUpload, $extensionsValides)) {

                    $chemin = "./membres/avatars/".$_SESSION['user-id'].".".$extensionUpload; // Préparation du chemin de stockage de l'image en fonction de l'id de l'utilisateur et de $extensionUpload
                    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin); // // On déplace les fichiers uploadés dans $chemin et on stocke le tout dans une variable $resultat

                    if($resultat) { // Si on obtient un resultat

                        // On se connecte à la bdd
                        $db_obj = new Database();
                        $db_connection = $db_obj->dbConnection();

                        $updateAvatar = $db_connection->prepare('UPDATE utilisateurs SET avatar = :avatar WHERE id = :id'); // requete sql update avatar en fonction de l'id de l'utilisateur
                        $updateAvatar->execute(array( // Exécution de la requête sql et création d'un tableau
                            "avatar" => $_SESSION['user-id'].".".$extensionUpload, // Equivalent bindParam (lie)
                            "id" => $_SESSION['user-id'] // Equivalent bindParam (lie)
                        ));
                        
                        header('Location: profile.php?id='.$id); // On redirige à la page profile de l'utilisateur connecté 
                    
                    } else {

                        echo "<p class='err'>Erreur durant l'importation de la photo de profil.";
                    
                    }

                } else {

                    echo "<p class='red'>Pas le bon format d'image.</p>";
                
                }

            } else {

                echo "<p class='err'>Votre photo de profil n'est pas valide.</p>";
            
            }

        }

        /***********************************  Change pseudo  ****************************************/ 

        public static function changePseudo() {

            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();
            
            $id = $_SESSION['user-id'];

            $newpseudo = htmlspecialchars($_POST['newpseudo']);
            $pseudolength = strlen($newpseudo); 
            
            if ($pseudolength <= 255) {
            
                $reqpseudo = $db_connection->prepare("SELECT * FROM utilisateurs WHERE pseudo = ? AND id != ?");
                $reqpseudo->execute(array($newpseudo, $id));

                $pseudoexist = $reqpseudo->rowCount();


                if ($pseudoexist == 1) {

                    header('Location: profile.php?err=pseudo');

                } else {

                    $insertpseudo = $db_connection->prepare('UPDATE utilisateurs SET pseudo = ? WHERE id = ?');
                    $insertpseudo->execute(array($newpseudo, $id));
                    
                    header('Location: profile.php?id=' . $id);

                }

            } else {

                header('Location: profile.php?err=pseudo');

            }

        }

        /***********************************  Change email  ****************************************/ 

        public static function changeMail() {

            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $id = $_SESSION['user-id'];

            $newmail = htmlspecialchars($_POST['newmail']);
            $newmail = strtolower($newmail);

            if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
                
                $reqmail = $db_connection->prepare("SELECT * FROM utilisateurs WHERE email = ? AND id!= ?");
                $reqmail->execute(array($newmail, $id));

                $mailexist = $reqmail->rowCount();

                if ($mailexist == 0) {

                    $insertmail = $db_connection->prepare('UPDATE utilisateurs SET email = ? WHERE id = ?');
                    $insertmail->execute(array($newmail, $id));
                    
                    header('Location: profile.php?id=' . $id);
                
                } else {

                    header('Location: profile.php?err=email');
                
                }
        
            } else {
            
                header('Location: profile.php?err=email');
            
            }
    
        }

        /***********************************  Change firstname  ****************************************/ 

        public static function changeFirstName() {
            
            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $id = $_SESSION['user-id'];

            $firstName = htmlspecialchars($_POST['firstname']);
            $firstNameLength = strlen($firstName); 

            if ($firstNameLength <= 200) {
                
                $insertFirstName = $db_connection->prepare('UPDATE utilisateurs SET prenom = ? WHERE id = ?');
                $insertFirstName->execute(array($firstName, $id));
                
                header('Location: profile.php?id=' . $id);

            } else {

                $msg = "Votre prénom ne peut pas dépasser 200 caractères.";
        
            }
        }

        /***********************************  Change lastname  ****************************************/ 

        public static function changeLastName() {

            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $id = $_SESSION['user-id'];

            $lastName = htmlspecialchars($_POST['lastname']);
            $lastNameLength = strlen($lastName); 

            if ($lastNameLength <= 200) {
    
                $insertLastName = $db_connection->prepare('UPDATE utilisateurs SET nom = ? WHERE id = ?');
                $insertLastName->execute(array($lastName, $id));
                
                header('Location: profile.php?id=' . $id);
            
            } else {
                
                $msg = "Votre nom ne peut pas dépasser 200 caractères.";
            
            }

        }

        /***********************************  Change password  *************************************/ 

        public static function changePassword() {

            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $id = $_SESSION['user-id'];

            $mdp1 = ($_POST['newmdp1']);
            $mdp2 = ($_POST['newmdp2']);
            $cost = ['cost' => 12];

            if($mdp1 == $mdp2) {

                $mdp1 = password_hash($mdp1, PASSWORD_BCRYPT, $cost);
                $insertmdp = $db_connection->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $insertmdp->execute(array($mdp1, $id));
                
                header('Location: profile.php?id='.$id);
            
            } else {
            
                header('Location: profile.php?err=confirmation');
            
            }

        }

        /***********************************  Suppression du compte  *******************************/  
        
        public static function deleteAccount() {

            // On se connecte à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            // Vérifier si la session est active et si l'utilisateur est connecté
            if(isset($_SESSION['user-id'])) {
            
                $id = $_SESSION['user-id'];
            
                // Supprimer le compte de la base de données
                $delete = $db_connection->prepare("DELETE FROM utilisateurs WHERE id = ?");
                $delete->execute(array($id));

                // Rediriger vers une page de confirmation ou déconnexion
                header('Location: logout.php');
                exit;
            
            } else {
            
                // Erreur ou message d'alerte si l'utilisateur n'est pas connecté
                $msg = "Une erreur s'est produite. Veuillez réessayer.";
            
            }

        }

        /*************************************************  RECHERCHE  *********************************************************************************/  

        /**
        * @param string $email Email de l'utilisateur souhaitant se connecter
        * 
        * @return bool TRUE si un compte portant cet email existe déjà, FALSE sinon
        */

        public static function exists(string $email): bool {

            // Requête SQL à executer
            $sql = "SELECT * FROM utilisateurs WHERE email LIKE :email;";

            try {

                // connexion à la base de données
                $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");
    
                $requete = $connexion-> prepare($sql);
                $requete-> bindParam(":email", $email, PDO::PARAM_STR);
    
                $requete-> execute();

                $resultats = $requete-> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");

                if (count($resultats) > 0) {

                    return true;

                } else {

                   return false;

                }

            } catch (Exception $exc) {

                // echo $exc-> getMessage();
                // Par sécurité et empêcher toute création de compte en cas de problème
                return true;
            }

        }

        /*************************************************  USER QUERY  *****************************************************************************/

        public static function queryUser(string $q): array {
            
            $q = "%$q%";
            $sql = "SELECT * FROM utilisateurs WHERE email LIKE :q OR pseudo LIKE :q OR prenom LIKE :q OR nom LIKE :q OR CONCAT(prenom, ' ', nom) LIKE :q;";

            try { 

                $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");

                $requete = $connexion->prepare($sql);
                $requete->bindParam(":q", $q, PDO::PARAM_STR);

                $requete-> execute();

                $resultats = $requete-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User"); 

                return $resultats;

            } catch (Exception $exc) {

                // echo $exc-> getMessage();
                return array();

            }

        }

        /******************************************************  FIND BY ID   ****************************************************************************/

        /**
        * @param int $id Identifiant de l'utilisateur à retrouver
        * 
        * @return User L'utilisateur qui possède l'identifiant fourni en argument
        */

        public static function findByiD(int $id): User {

            // Requête SQL à executer
            $sql = "SELECT * FROM utilisateurs WHERE id = :id;";

            try {

                // connexion à la base de données
                $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");
    
                $requete = $connexion-> prepare($sql);
                $requete-> bindParam(":id", $id, PDO::PARAM_INT);
    
                $requete-> execute();

                $resultats = $requete-> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");

                if (count($resultats) > 0) {

                    return $resultats[0];

                } else {

                   return new User();

                }

            } catch (Exception $exc) {

                //   echo $exc-> getMessage();
                return new User();
            }

        }

        /**************************************************  FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID  *********************************************/

        function all_users($id){

            $sql = "SELECT id, pseudo, avatar FROM utilisateurs WHERE id != ?";

            try{

                $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");

                $requete = $connexion->prepare($sql);
                $requete-> bindParam(":id", $id, PDO::PARAM_INT);
                $requete-> execute([$id]);

                if($requete->rowCount() > 0){

                    return $requete->fetchAll(PDO::FETCH_OBJ);
                
                } else {

                    return false;

                }

            } catch (PDOException $e) {

                die($e->getMessage());

            }

        }

    /*********************************************************** IMAGE EXISTS **********************************************************************/

    public static function check_image_exists($url, $default = 'default.jpg') {

        $url = trim($url);
        $info = @getimagesize($url);

        if ((bool) $info) {

            return $url;

        } else {

            return $default;

        }

    }

}

    
    