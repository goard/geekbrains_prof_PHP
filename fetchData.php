<?php
require_once 'vendor/autoload.php';
include_once 'db.php';

try {
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $pageNum = isset($_POST['page']) ? ((int) $_POST['page'] ? (int) $_POST['page'] : 1) : 1;
  $start = ($pageNum-1) * ROWS_NUM;

  $result = $pdo->prepare("SELECT * from goods ORDER BY id_goods LIMIT $start, " . ROWS_NUM);
  $result->execute();

  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $goods[] = $row;
  }

  $template = $twig->load('showProducts.twig');
  $template->display([
    'goods' => $goods
  ]);
} catch (Exception $e) {
  die ('error: ' . $e->getMessage());
} catch (\Throwable $th) {
  throw $th;
}

// if(isset($_POST['page']))
// {
//     $get = $_POST['page'];
//     echo $get;
// }
