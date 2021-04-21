<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
  die("Error! " . $err->getMessage());
} catch (\Throwable $th) {
  //throw $th;
}

const ROWS_NUM = 4;