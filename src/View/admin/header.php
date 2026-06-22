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
  <style>
    :root {
      --admin-primary: #f2c94c;
    }

    .admin-layout {
      display: flex;
      min-height: 100vh;
      background: var(--pin-bg);
      color: var(--pin-white);
    }

    .admin-sidebar {
      width: 260px;
      background: var(--pin-card);
      border-right: 1px solid var(--pin-border);
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
      z-index: 100;
    }

    .admin-logo {
      padding: 24px;
      font-size: 24px;
      font-weight: 800;
      font-family: 'Syne', sans-serif;
      color: var(--pin-white);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .admin-logo i {
      color: var(--admin-primary);
    }

    .admin-nav {
      list-style: none;
      padding: 0 16px;
      margin: 0;
      flex-grow: 1;
    }

    .admin-nav li {
      margin-bottom: 8px;
    }

    .admin-nav a {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      color: var(--pin-muted);
      text-decoration: none;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .admin-nav a:hover,
    .admin-nav a.active {
      background: rgba(255, 255, 255, 0.05);
      color: var(--pin-white);
    }

    .admin-nav a.active {
      background: rgba(242, 201, 76, 0.1);
      color: var(--admin-primary);
    }

    .admin-nav-icon {
      font-size: 20px;
      margin-right: 16px;
    }

    .admin-footer {
      padding: 24px;
      border-top: 1px solid var(--pin-border);
    }

    .admin-content-wrapper {
      flex-grow: 1;
      overflow-y: auto;
      height: 100vh;
    }

    .admin-topbar {
      padding: 16px 32px;
      background: var(--pin-card);
      border-bottom: 1px solid var(--pin-border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 99;
    }

    .admin-main {
      padding: 32px;
      max-width: 1200px;
      margin: 0 auto;
    }
  </style>
  <?php if (isset($data["style"])): ?>
    <link rel="stylesheet" href="/public/css/<?= $data["style"] ?>">
  <?php endif ?>
</head>

<body>
  <div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <a href="/admin" class="admin-logo">
        <i class="bi bi-shield-lock-fill"></i> Admin
      </a>
      <ul class="admin-nav">
        <?php foreach ($data["navigation"] as $nav): ?>
          <li>
            <a href="<?= $nav["path"] ?>" <?= ($_SERVER['REQUEST_URI'] === $nav["path"] || (strpos($_SERVER['REQUEST_URI'], $nav["path"]) === 0 && $nav["path"] !== '/admin')) ? 'class="active"' : '' ?>>
              <span class="admin-nav-icon"><i class="bi bi-<?= $nav["icon"] ?>"></i></span> <?= $nav["name"] ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
      <div class="admin-footer">
        <a href="/logout" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-box-arrow-right"></i> Log out
        </a>
      </div>
    </aside>

    <div class="admin-content-wrapper">
      <header class="admin-topbar">
        <h5 style="margin:0;font-weight:700;font-family:'Syne',sans-serif;">Admin Workspace</h5>
        <div class="d-flex align-items-center gap-3">
          <div style="text-align:right;">
            <div style="font-weight:600;font-size:14px;">
              <?= htmlspecialchars($data["user"]["name"] ?? $data["user"]["username"]) ?>
            </div>
            <div style="font-size:12px;color:var(--pin-white);opacity:0.8;">Administrator</div>
          </div>
          <div
            style="width:40px;height:40px;border-radius:50%;background:var(--admin-primary);display:flex;align-items:center;justify-content:center;color:#000;font-weight:700;font-size:18px;">
            <?= strtoupper(substr($data["user"]["username"], 0, 1)) ?>
          </div>
        </div>
      </header>

      <main class="admin-main">