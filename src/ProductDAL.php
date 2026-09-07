<?php

class ProductDAL
{

    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT id, title, description, image, alt, price from product";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        // Retourne un tableau vide si aucune donnée
        return $statement->fetchAll();

    }

    
    public static function selectById(PDO $connexion, int $id): false|array {

        $sql = "SELECT id, title, description, image, alt, price from product where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        $statement->execute();

        // Retourne 'false' si aucune donnée
        return $statement->fetch();

    }
    
    public static function selectByTitle(PDO $connexion, string $search): array {

        $sql = "SELECT id, title, description, image, alt, price from product where lower(title) like :search";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('search', $search, PDO::PARAM_STR);
             
        $statement->execute();

        // Retourne un tableau vide si aucune donnée
        return $statement->fetchAll();

    }

    public static function insertOne(PDO $connexion, string $title, string $description, string $image, string $alt): bool {

        $sql = "insert into product (title, description, image, alt) values(:title, :description, :image, :alt)";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('title', $title, PDO::PARAM_STR);
        $statement->bindValue('description', $description, PDO::PARAM_STR);
        $statement->bindValue('image', $image, PDO::PARAM_STR);
        $statement->bindValue('alt', $alt, PDO::PARAM_STR);
             
        return $statement->execute();

    }

    public static function updateById(PDO $connexion, int $id, string $title, string $description, string $image, string $alt): bool {

        $sql = "update product set title = :title, description = :description, image = :image, alt = :alt where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('title', $title, PDO::PARAM_STR);
        $statement->bindValue('description', $description, PDO::PARAM_STR);
        $statement->bindValue('image', $image, PDO::PARAM_STR);
        $statement->bindValue('alt', $alt, PDO::PARAM_STR);
        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        return $statement->execute();

    }

    public static function deleteById(PDO $connexion, int $id): bool {

        $sql = "delete from product where id = :id";

        $statement = $connexion->prepare($sql); 

        $statement->bindValue('id', $id, PDO::PARAM_INT);
             
        return $statement->execute();

    }

    
}





