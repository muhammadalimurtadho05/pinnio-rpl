<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">
    <!-- Feed -->
    <div class="flex-grow-1">
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;margin:0;">Notifikasi</h5>
          </div>
        </div>
      </div>

      <div class="feed-col pt-2">
        <div class="list-group list-group-flush bg-transparent">
          <?php if (empty($data['notifications'])): ?>
            <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:300px;">
              <div style="font-size:48px;margin-bottom:16px;">🔔</div>
              <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--pin-white);margin-bottom:8px;">Belum ada notifikasi</h6>
              <p style="color:var(--pin-muted);text-align:center;margin-bottom:24px;">Notifikasi tentang postingan dan pesan akan muncul di sini.</p>
            </div>
          <?php else: ?>
            <?php foreach ($data['notifications'] as $notif): ?>
              <?php 
                $link = '#';
                $message = '';
                $icon = '';
                $iconColor = '';
                
                if ($notif['type'] === 'like') {
                    $link = '/meme/' . $notif['reference_id'];
                    $message = 'menyukai postingan Anda.';
                    $icon = 'heart-fill';
                    $iconColor = '#ff4d6d';
                } elseif ($notif['type'] === 'message') {
                    $link = '/chat/' . $notif['actor_username'];
                    $message = 'mengirimi Anda pesan.';
                    $icon = 'chat-dots-fill';
                    $iconColor = 'var(--pin-yellow)';
                }
              ?>
              
              <a href="<?= $link ?>" class="list-group-item list-group-item-action bg-transparent d-flex align-items-center gap-3 py-3 <?= $notif['is_read'] ? '' : 'bg-dark' ?>" style="border-bottom: 1px solid var(--pin-border);">
                <div style="position:relative;">
                  <div style="width:48px;height:48px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:24px;overflow:hidden;flex-shrink:0;">
                    <?php if (!empty($notif['actor_profile_picture'])): ?>
                      <img src="<?= htmlspecialchars($notif['actor_profile_picture']) ?>" alt="Profile picture" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                      😊
                    <?php endif; ?>
                  </div>
                  <div style="position:absolute;bottom:-4px;right:-4px;background:var(--pin-card);border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:10px;color:<?= $iconColor ?>;">
                    <i class="bi bi-<?= $icon ?>"></i>
                  </div>
                </div>
                
                <div class="flex-grow-1 min-width-0">
                  <p class="mb-0" style="color:var(--pin-white);font-size:15px;">
                    <span style="font-weight:700;"><?= htmlspecialchars($notif['actor_name'] ?: $notif['actor_username']) ?></span> <?= $message ?>
                  </p>
                  <small style="color:var(--pin-muted);font-size:12px;"><?= date('d M Y, H:i', strtotime($notif['created_at'])) ?></small>
                </div>
                
                <?php if (!$notif['is_read']): ?>
                  <div style="width:10px;height:10px;border-radius:50%;background:var(--pin-yellow);flex-shrink:0;"></div>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
