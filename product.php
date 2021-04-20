<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'vendor/autoload.php';

try {
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $idProduct = (int)$_GET['id_product'];
  $link = mysqli_connect("localhost", "root", "", "shop");
  if (!$link) die('Ошибка соединения' . mysqli_error($link));
  mysqli_query($link, "INSERT INTO goods_counter (id_goods, counter) VALUE ($idProduct, 1) ON DUPLICATE KEY UPDATE counter = counter + 1");
  $result = mysqli_query($link, "SELECT * FROM goods INNER JOIN goods_counter ON goods.id_goods=goods_counter.id_goods WHERE goods.id_goods=$idProduct");
  $row = mysqli_fetch_assoc($result);
  mysqli_close($link);
  if (empty($row)) {
    throw new Exception("Error!");
  }
  $template = $twig->load('product.twig');
  $template->display([
    'title' => 'Продукт',
    'id' => $idProduct,
    'good' => $row,
  ]);
} catch (\Throwable $th) {
  //throw $th;
}
