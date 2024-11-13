<?php
require 'vendor/autoload.php';
use Faker\Factory;

// Connexion à la base de données
$host = 'localhost';
$db = 'ecommerce';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

//générateur Faker
$faker = Factory::create();

//table users
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO users (username, mail, password, cell_number) VALUES (:username, :mail, :password, :cell_number)");
    $stmt->execute([
        ':username' => $faker->userName,
        ':mail' => $faker->email,
        ':password' => password_hash($faker->password, PASSWORD_BCRYPT),
        ':cell_number' => $faker->phoneNumber,
    ]);
}

//table address
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO address (street, city, country, user_id) VALUES (:street, :city, :country, :user_id)");
    $stmt->execute([
        ':street' => $faker->streetAddress,
        ':city' => $faker->city,
        ':country' => $faker->country,
        ':user_id' => $faker->numberBetween(1, 20),
    ]);
}

//table product
for ($i = 0; $i < 50; $i++) {
    $stmt = $pdo->prepare("INSERT INTO product (name, type, description, price, stock) VALUES (:name, :type, :description, :price, :stock)");
    $stmt->execute([
        ':name' => $faker->word,
        ':type' => $faker->word,
        ':description' => $faker->sentence,
        ':price' => $faker->randomFloat(2, 5, 500),
        ':stock' => $faker->numberBetween(0, 100),
    ]);
}

//table payment
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO payment (IBAN, card_number, expiration_date, cryptogram, user_id) VALUES (:IBAN, :card_number, :expiration_date, :cryptogram, :user_id)");
    $stmt->execute([
        ':IBAN' => base64_encode($faker->iban),
        ':card_number' => base64_encode($faker->creditCardNumber),
        ':expiration_date' => $faker->creditCardExpirationDateString,
        ':cryptogram' => $faker->numberBetween(100, 999),
        ':user_id' => $faker->numberBetween(1, 20),
    ]);
}

//table cart
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
    $stmt->execute([
        ':user_id' => $faker->numberBetween(1, 20),
    ]);
}

//table cart_product
for ($i = 0; $i < 50; $i++) {
    $stmt = $pdo->prepare("INSERT INTO cart_product (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
    $stmt->execute([
        ':cart_id' => $faker->numberBetween(1, 20),
        ':product_id' => $faker->numberBetween(1, 50),
        ':quantity' => $faker->numberBetween(1, 5),
    ]);
}

//table command
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO command (command_date, delivered, user_id, cart_id, address_id, payment_id) VALUES (:command_date, :delivered, :user_id, :cart_id, :address_id, :payment_id)");
    $stmt->execute([
        ':command_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ':delivered' => $faker->boolean,
        ':user_id' => $faker->numberBetween(1, 20),
        ':cart_id' => $faker->numberBetween(1, 20),
        ':address_id' => $faker->numberBetween(1, 20),
        ':payment_id' => $faker->numberBetween(1, 20),
    ]);
}

//table invoices
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO invoices (command_date, delivered_date, command_id, user_id, address_id) VALUES (:command_date, :delivered_date, :command_id, :user_id, :address_id)");
    $stmt->execute([
        ':command_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ':delivered_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ':command_id' => $faker->numberBetween(1, 20),
        ':user_id' => $faker->numberBetween(1, 20),
        ':address_id' => $faker->numberBetween(1, 20),
    ]);
}

echo "Les données fictives ont été insérées avec succès dans toutes les tables (except tables photos) !";
?>
