<?php
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'vendor/autoload.php';

try {
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $link = mysqli_connect("localhost", "root", "", "shop");
  if (!$link) die('Ошибка соединения' . mysqli_error($link));
  $result = mysqli_query($link, "SELECT id_goods, name, price, quantity, path_img FROM goods");
  $goods = [];
  while ($row = mysqli_fetch_assoc($result)){
    $goods[] = $row;
  }
  if (empty($goods)) {
    throw new Exception("Error!");
  }
  $template = $twig->load('catalog.twig');
  $template->display([
    'title' => 'Товары',
    'goods' => $goods,
  ]);
  mysqli_close($link);
} catch (Exception $e) {
  die ('error: ' . $e->getMessage());
} catch (\Throwable $th) {
  //throw $th;
  echo "error . $th";
}