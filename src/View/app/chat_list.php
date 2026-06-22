<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">
    <!-- Feed -->
    <div class="flex-grow-1">
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;margin:0;">Messages</h5>
          </div>
        </div>
      </div>

      <div class="feed-col pt-2">
        <div class="list-group list-group-flush bg-transparent">
          <?php if (empty($data['conversations'])): ?>
            <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:300px;">
              <div style="font-size:48px;margin-bottom:16px;">💬</div>
              <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--pin-white);margin-bottom:8px;">Belum ada percakapan</h6>
              <p style="color:var(--pin-muted);text-align:center;margin-bottom:24px;">Mulai obrolan dengan pengguna lain dari profil mereka!</p>
            </div>
          <?php else: ?>
            <?php foreach ($data['conversations'] as $conv): ?>
              <a href="/chat/<?= htmlspecialchars($conv['username']) ?>" class="list-group-item list-group-item-action bg-transparent d-flex align-items-center gap-3 py-3" style="border-bottom: 1px solid var(--pin-border);">
                <div style="width:48px;height:48px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:24px;overflow:hidden;flex-shrink:0;">
                  <?php if (!empty($conv['profile_picture'])): ?>
                    <img src="<?= htmlspecialchars($conv['profile_picture']) ?>" alt="Profile picture" style="width:100%;height:100%;object-fit:cover;">
                  <?php else: ?>
                    😊
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-width-0">
                  <div class="d-flex justify-content-between align-items-baseline mb-1">
                    <h6 class="mb-0 text-truncate" style="font-weight:700;color:var(--pin-white);"><?= htmlspecialchars($conv['name'] ?: $conv['username']) ?></h6>
                    <small style="color:var(--pin-muted);font-size:12px;white-space:nowrap;"><?= date('H:i', strtotime($conv['last_message_time'])) ?></small>
                  </div>
                  <p class="mb-0 text-truncate" style="color:var(--pin-muted);font-size:14px;">
                    <?= htmlspecialchars($conv['last_message']) ?>
                  </p>
                </div>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
