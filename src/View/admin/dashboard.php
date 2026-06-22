<div class="mb-4 d-flex justify-content-between align-items-center">
  <h4 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Dashboard Overview</h4>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;">
      <h6 style="color:var(--pin-white);font-weight:600;margin-bottom:8px;">Total Users</h6>
      <h2 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;color:var(--admin-primary);"><?= $data['total_users'] ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;">
      <h6 style="color:var(--pin-white);font-weight:600;margin-bottom:8px;">Total Posts</h6>
      <h2 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;color:var(--admin-primary);"><?= $data['total_memes'] ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;">
      <h6 style="color:var(--pin-white);font-weight:600;margin-bottom:8px;">Total Reports</h6>
      <h2 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;color:var(--admin-primary);"><?= $data['total_reports'] ?></h2>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Recent Users -->
  <div class="col-md-6">
    <div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;height:100%;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 style="font-family:'Syne',sans-serif;font-weight:600;margin:0;">Recent Users</h6>
      </div>
      <?php if (!empty($data["recent_users"])): ?>
        <ul class="list-group list-group-flush" style="background:transparent;">
          <?php foreach ($data["recent_users"] as $r_user): ?>
            <li class="list-group-item d-flex align-items-center" style="background:transparent;border-color:var(--pin-border);padding:12px 0;">
              <div style="width:36px;height:36px;border-radius:50%;background:var(--pin-bg);border:1px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:14px;margin-right:12px;">
                🙂
              </div>
              <div class="flex-grow-1">
                <div style="font-weight:600;font-size:14px;color:var(--pin-white);"><?= htmlspecialchars($r_user["name"] ?? $r_user["username"]) ?></div>
                <div style="font-size:12px;color:var(--pin-white);opacity:0.8;">@<?= htmlspecialchars($r_user["username"]) ?></div>
              </div>
              <div style="font-size:12px;color:var(--pin-white);opacity:0.8;">
                <?= date('d M Y', strtotime($r_user["created_at"])) ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="mt-3" style="color:var(--pin-white);opacity:0.8;">No users found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Recent Reports -->
  <div class="col-md-6">
    <div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;height:100%;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 style="font-family:'Syne',sans-serif;font-weight:600;margin:0;">Recent Reports</h6>
        <a href="/admin/reports" style="font-size:12px;color:var(--admin-primary);text-decoration:none;">View All</a>
      </div>
      <?php if (!empty($data["recent_reports"])): ?>
        <ul class="list-group list-group-flush" style="background:transparent;">
          <?php foreach ($data["recent_reports"] as $r_report): ?>
            <li class="list-group-item" style="background:transparent;border-color:var(--pin-border);padding:12px 0;">
              <div class="d-flex justify-content-between align-items-start mb-1">
                <div style="font-weight:600;font-size:14px;color:var(--pin-white);">
                  Reported by <?= htmlspecialchars($r_report["reporter_username"] ?? "Unknown") ?>
                </div>
                <span style="font-size:10px;font-weight:600;text-transform:uppercase;color:<?= $r_report['status'] === 'pending' ? 'var(--admin-primary)' : 'var(--pin-white)' ?>;">
                  <?= $r_report["status"] ?>
                </span>
              </div>
              <p class="mb-0 text-truncate" style="font-size:12px;max-width:250px;color:var(--pin-white);opacity:0.8;"><?= htmlspecialchars($r_report["reason"]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="mt-3" style="color:var(--pin-white);opacity:0.8;">No recent reports.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
