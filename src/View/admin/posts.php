<div class="mb-4 d-flex justify-content-between align-items-center">
  <h4 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Manage Posts</h4>
</div>

<div class="card p-4" style="background:var(--pin-card);border:1px solid var(--pin-border);border-radius:16px;">
  <?php if (count($data["memes"]) > 0): ?>
    <div class="table-responsive">
      <table class="table table-dark table-hover" style="color:var(--pin-white);background:transparent;">
        <thead>
          <tr>
            <th style="border-bottom:1px solid var(--pin-border);">User</th>
            <th style="border-bottom:1px solid var(--pin-border);">Content</th>
            <th style="border-bottom:1px solid var(--pin-border);">Date</th>
            <th style="border-bottom:1px solid var(--pin-border);">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data["memes"] as $meme): ?>
            <tr style="border-bottom:1px solid var(--pin-border);">
              <td style="vertical-align:middle;">
                <div class="d-flex align-items-center gap-2">
                  <div style="width:32px;height:32px;border-radius:50%;background:var(--pin-bg);border:1px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:14px;">
                    🙂
                  </div>
                  <div>
                    <div style="font-weight:600;font-size:14px;"><?= htmlspecialchars($meme["name"] ?? $meme["username"]) ?></div>
                    <div class="text-muted" style="font-size:12px;">@<?= htmlspecialchars($meme["username"]) ?></div>
                  </div>
                </div>
              </td>
              <td style="vertical-align:middle;max-width:300px;">
                <p class="mb-1 text-truncate"><?= htmlspecialchars($meme["caption"]) ?></p>
                <?php if (!empty($meme["image_url"])): ?>
                  <a href="<?= $meme["image_url"] ?>" target="_blank" class="text-decoration-none" style="color:var(--admin-primary);font-size:12px;">
                    <i class="bi bi-image me-1"></i> View Image
                  </a>
                <?php endif; ?>
              </td>
              <td style="vertical-align:middle;font-size:14px;" class="text-muted">
                <?= date('d M Y H:i', strtotime($meme["created_at"])) ?>
              </td>
              <td style="vertical-align:middle;">
                <a href="/meme/<?= $meme['meme_id'] ?>" target="_blank" class="btn btn-sm btn-outline-light me-2" style="border:1px solid var(--pin-border);" title="View Post">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="/admin/posts/takedown/<?= $meme['meme_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to take down this post? It will be permanently deleted.');" title="Takedown Post">
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
      <i class="bi bi-images fs-1 mb-3 d-block"></i>
      <p>No posts available.</p>
    </div>
  <?php endif; ?>
</div>
