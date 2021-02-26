<?php
/**
 * 1. Le dossier SQL contient l'export de ma table user.
 * 2. Trouvez comment importer cette table dans une des bases de données que vous avez créées, si vous le souhaitez vous pouvez en créer une nouvelle pour cet exercice.
 * 3. Assurez vous que les données soient bien présentes dans la table.
 * 4. Créez votre objet de connexion à la base de données comme nous l'avons vu
 * 5. Insérez un nouvel utilisateur dans la base de données user
 * 6. Modifiez cet utilisateur directement après avoir envoyé les données ( on imagine que vous vous êtes trompé )
 */

// TODO Votre code ici.
try {
    $bd = new PDO("mysql:host=localhost;dbname=table_test_php", "root", "");
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dn = $bd->prepare("
        INSERT INTO user (nom, prenom, rue, numero, code_postal, ville, pays, mail)
        VALUES (?,?,?,?,?,?,?,?)
    ");

    $nom = "Jocaille";
    $prenom = "Amaury";
    $rue = "Rue blabla";
    $numero = "54";
    $codePostal = "6562";
    $ville = "Chimay";
    $pays = "France";
    $mail = "ezoiahfih@hotmail.com";

    $dn->bindParam(1, $nom);
    $dn->bindParam(2, $prenom);
    $dn->bindParam(3, $rue);
    $dn->bindParam(4, $numero);
    $dn->bindParam(5, $codePostal);
    $dn->bindParam(6, $ville);
    $dn->bindParam(7, $pays);
    $dn->bindParam(8, $mail);

    if($dn->execute()) {
        echo "Ajout effectué";
    }

    $id = $bd->lastInsertId();

    $rectif = $bd->prepare("
        UPDATE user SET pays = :pays WHERE id= :id
    ");

    $pays = "Belgique";

    $rectif->bindParam(':pays', $pays);
    $rectif->bindParam(':id', $id);

    $rectif->execute();

    if($rectif->rowCount()) {
        echo "La donnée a été modifié";
    }
    else {
        echo "Echec de la modification";
    }
}
catch(PDOException $exception) {
    echo "Erreur" . $exception->getMessage();
}



/**
 * Théorie
 * --------
 * Pour obtenir l'ID du dernier élément inséré en base de données, vous pouvez utiliser la méthode: $bdd->lastInsertId()
 *
 * $result = $bdd->execute();
 * if($result) {
 *     $id = $bdd->lastInsertId();
 * }
 */