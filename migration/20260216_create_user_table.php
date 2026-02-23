<?php

class CreateUserTable{


public static function up($pdo)
{
$sql =CREATE TABLE IF NOT EXISTS users (
id int(11) NOT NULL AUTO_INCREMENT,
username varchar(50) NOT NULL,
email varchar(100) NOT NULL,
reset_token varchar(255) DEFAULT NULL,
reset_expires_at datetime DEFAULT NULL,
password varchar(255) NOT NULL,
active tinyint(1) NOT NULL DEFAULT 0,
role enum('user','admin') NOT NULL DEFAULT 'user',
created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
date_of_birth date DEFAULT NULL,
adress varchar(255) DEFAULT NULL,
confirmation_token varchar(255) DEFAULT NULL,
otp_code varchar(6) DEFAULT NULL,
otp_expires_at datetime DEFAULT NULL,
session_token varchar(255) DEFAULT NULL,
remember_token varchar(255) DEFAULT NULL,
avatar varchar(255) NOT NULL,

PRIMARY KEY (id),

UNIQUE KEY users_username_uq (username),
UNIQUE KEY users_email_uq (email),

KEY users_reset_token_idx (reset_token),
KEY users_confirmation_token_idx (confirmation_token),
KEY users_session_token_idx (session_token),
KEY users_remember_token_idx (remember_token),
KEY users_otp_code_idx (otp_code)
)

$pdo->exec($sql);
echo " utilisateur Ajoute avec succes"
}





public static function down($pdo){
    $sql = "Drop Table user";
    $pdo->exec($sql);
 }


}