<div class="mb-4 d-flex justify-content-between align-items-center">
  <h4 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Manage Reports</h4>
</div>

<div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;">
  <?php if (count($data["reports"]) > 0): ?>
    <div class="table-responsive">
      <table class="table table-dark table-hover" style="color:var(--pin-white);background:transparent;">
        <thead>
          <tr>
            <th style="border-bottom:1px solid var(--pin-border);">Reporter</th>
            <th style="border-bottom:1px solid var(--pin-border);">Target Type</th>
            <th style="border-bottom:1px solid var(--pin-border);">Target User</th>
            <th style="border-bottom:1px solid var(--pin-border);">Reason</th>
            <th style="border-bottom:1px solid var(--pin-border);">Status</th>
            <th style="border-bottom:1px solid var(--pin-border);">Date</th>
            <th style="border-bottom:1px solid var(--pin-border);">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data["reports"] as $report): ?>
            <tr style="border-bottom:1px solid var(--pin-border);">
              <td style="vertical-align:middle;font-weight:600;font-size:14px;">
                <?= htmlspecialchars($report["reporter_username"] ?? "Unknown") ?>
              </td>
              <td style="vertical-align:middle;">
                <?php if (!empty($report["target_meme_id"])): ?>
                  <span class="badge" style="background:var(--pin-border);color:var(--pin-white);">Post</span>
                <?php else: ?>
                  <span class="badge" style="background:var(--pin-border);color:var(--pin-white);">User</span>
                <?php endif; ?>
              </td>
              <td style="vertical-align:middle;font-weight:600;font-size:14px;">
                <?= htmlspecialchars($report["target_username"] ?? "Unknown") ?>
              </td>
              <td style="vertical-align:middle;max-width:250px;">
                <p class="mb-0 text-truncate"><?= htmlspecialchars($report["reason"]) ?></p>
              </td>
              <td style="vertical-align:middle;">
                <?php
                  $statusColor = 'var(--admin-primary)';
                  if ($report["status"] === 'resolved') $statusColor = 'green';
                  if ($report["status"] === 'reviewed') $statusColor = 'blue';
                ?>
                <span style="color:<?= $statusColor ?>;font-weight:600;font-size:12px;text-transform:uppercase;">
                  <?= htmlspecialchars($report["status"]) ?>
                </span>
              </td>
              <td style="vertical-align:middle;font-size:14px;" class="text-muted">
                <?= date('d M Y', strtotime($report["created_at"])) ?>
              </td>
              <td style="vertical-align:middle;">
                <?php if (!empty($report["target_meme_id"])): ?>
                  <a href="/meme/<?= $report['target_meme_id'] ?>" target="_blank" class="btn btn-sm btn-outline-light me-2" style="border:1px solid var(--pin-border);" title="View Target Post">
                    <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                <?php endif; ?>
                <a href="/admin/reports/delete/<?= $report['report_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?');" title="Delete Report">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-flag fs-1 mb-3 d-block"></i>
      <p>No reports found.</p>
    </div>
  <?php endif; ?>
</div>
