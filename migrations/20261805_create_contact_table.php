<?php
Class CreateContactTable {
public static function up($pdo){
$sql ="
create table if not exists `contact` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` varchar(50) NOT NULL,
`email` varchar(100) NOT NULL,
`sujet` varchar(255) DEFAULT NULL,
`message` text DEFAULT NULL,
`phone` varchar(255) DEFAULT NULL,
`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP


)";

$pdo->exec($sql);
echo " Contact Ajoute avec succes";
}

public static function down ($pdo){
    $sql= "DROP TABLE contact ";
     $pdo->exec($sql);
     echo "Table contact deleted";

}
}
?>