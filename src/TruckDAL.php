<?php

class TruckDAL
{

    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT id, maker, model, image from truck";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        // Retourne un tableau vide si aucune donnée
        return $statement->fetchAll();

    }

    
    public static function selectById(PDO $connexion, int $id): false|array {

        $sql = "SELECT id, maker, model, image from truck where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        $statement->execute();

        // Retourne 'false' si aucune donnée
        return $statement->fetch();

    }
    
    public static function selectByTitle(PDO $connexion, string $search): array {

        $sql = "SELECT id, maker, model, image from truck where lower(title) like :search";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('search', $search, PDO::PARAM_STR);
             
        $statement->execute();

        // Retourne un tableau vide si aucune donnée
        return $statement->fetchAll();

    }

    public static function insertOne(PDO $connexion, string $maker, string $model, string $image): bool {

        $sql = "insert into truck (maker, model, image) values(:maker, :model, :image)";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('maker', $maker, PDO::PARAM_STR);
        $statement->bindValue('model', $model, PDO::PARAM_STR);
        $statement->bindValue('image', $image, PDO::PARAM_STR);
             
        return $statement->execute();

    }

    public static function updateById(PDO $connexion, int $id, string $maker, string $model, string $image): bool {

        $sql = "update truck set maker = :maker, model = :model, image = :image where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('maker', $maker, PDO::PARAM_STR);
        $statement->bindValue('model', $model, PDO::PARAM_STR);
        $statement->bindValue('image', $image, PDO::PARAM_STR);
        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        return $statement->execute();

    }

    public static function deleteById(PDO $connexion, int $id): bool {

        $sql = "delete from truck where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        return $statement->execute();

    }

    
}





