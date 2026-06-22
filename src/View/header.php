<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data["title"] ?></title>
  <link rel="stylesheet" href="/public/css/bootstrap.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="/public/css/style.css">
  <?php if (isset($data["style"])): ?>
    <link rel="stylesheet" href="/public/css/<?= $data["style"] ?>">
  <?php endif ?>
</head>

<body>