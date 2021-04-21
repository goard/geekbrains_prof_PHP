<?php
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'vendor/autoload.php';
include_once 'db.php';

try {
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $sql = "SELECT COUNT(*) as counter FROM goods";
  $sth = $pdo->query($sql);
  $row = $sth->fetch(PDO::FETCH_ASSOC);
  $totalPages = ceil($row['counter']/ROWS_NUM);

  // if (empty($goods)) {
  //   throw new Exception("Error!");
  // }

  $template = $twig->load('catalog.twig');
  $template->display([
    'title' => 'Товары',
    'total_pages' => $totalPages,
  ]);
} catch (Exception $e) {
  die ('error: ' . $e->getMessage());
} catch (\Throwable $th) {
  //throw $th;
  echo "error . $th";
}