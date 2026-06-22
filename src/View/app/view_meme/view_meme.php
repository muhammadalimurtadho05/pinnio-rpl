<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">

    <!-- Thread Detail Feed -->
    <div class="flex-grow-1">
      <!-- Page Header -->
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center gap-3">
            <a href="home.html" class="btn-pin-ghost p-1"><i class="bi bi-arrow-left"></i></a>
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:18px;margin:0;">Thread</h5>
          </div>
        </div>
      </div>

      <div class="feed-col pt-3 pb-5">

        <!-- ===== ORIGINAL POST ===== -->
        <div style="padding: 0 0 4px;">
          <!-- Author row -->
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-3">
              <div
                style="width:48px;height:48px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">
                ☕</div>
              <div>
                <div style="font-weight:700;font-size:15px;">
                  <a href="/u/<?= htmlspecialchars($data['meme']['username']) ?>" style="color:inherit;text-decoration:none;">
                    <?= $data["meme"]["name"] ? $data["meme"]["name"] : $data["meme"]["username"] ?>
                  </a>
                </div>
                <div style="color:var(--pin-muted);font-size:13px;">@<?= $data["meme"]["username"] ?></div>
              </div>
            </div>
            <!-- Dropdown menu for own post -->
            <?php if ($data["meme"]["user_id"] === $_SESSION['auth']['user_id']): ?>
              <?php require __DIR__ . "/dropdown_user.php"; ?>
            <?php else: ?>
              <?php require __DIR__ . "/dropdown.php"; ?>
            <?php endif ?>
          </div>

          <!-- Post content -->
          <p class="original-post-content"><?= $data["meme"]["caption"] ?></p>

          <!-- Image -->
          <?php if (isset($data["meme"]["image_url"])): ?>
            <div class="post-image-wrap">
              <img src="<?= $data["meme"]['image_url'] ?>" alt="Meme image"
                style="width:100%;height:auto;max-height:400px;object-fit:cover;display:block;" />
            </div>
          <?php endif ?>

          <!-- Actions row -->
          <div class="thread-actions pb-3" style="border-bottom:1px solid var(--pin-border);">
            <button class="thread-action-btn <?= isset($data['meme']['is_liked']) && $data['meme']['is_liked'] ? 'liked' : '' ?>" data-action="like" data-meme-id="<?= $data['meme']['meme_id'] ?>" style="font-size:20px; padding:8px 14px;">
              <i class="bi <?= isset($data['meme']['is_liked']) && $data['meme']['is_liked'] ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
              <span class="action-count"><?= $data["meme"]['likes_count'] ?></span>
            </button>
            <button class="thread-action-btn" style="font-size:20px; padding:8px 14px;" onclick="focusCommentBox()">
              <i class="bi bi-chat"></i> <?= $data["meme"]['comments_count'] ?>
            </button>
            <button class="thread-action-btn ms-auto" style="font-size:20px; padding:8px 14px;">
              <i class="bi bi-bookmark"></i>
            </button>
          </div>
        </div>

        <!-- ===== ADD COMMENT ===== -->
        <form action="/comment/<?= $data["meme"]["meme_id"] ?>" method="POST" class="comment-compose"
          id="commentSection">
          <div class="d-flex gap-3 align-items-start">
            <div
              style="width:40px;height:40px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
              🙂</div>
            <div class="flex-grow-1">
              <textarea class="pin-input mb-2" name="content" id="content" placeholder="Tulis komentar kamu..."
                rows="2"></textarea>
              <button type="submit" class="btn btn-pin btn-sm">Kirim</button>
            </div>
          </div>
        </form>

        <!-- ===== COMMENTS LIST ===== -->
        <div id="commentsContainer" class="mt-3">
          <span>Comments <?= $data["meme"]["comments_count"] ?></span>
          <?php if (empty($data["meme"]["comments_count"]) || $data["meme"]["comments_count"] == 0): ?>
            <div role="alert"
              style="margin-top:16px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--pin-border);border-radius:16px;color:var(--pin-muted);background:transparent;">
              <span style="font-size:18px;line-height:1;">💬</span>
              <span style="font-size:14px;">Belum ada komentar untuk postingan ini.</span>
            </div>
          <?php else: ?>
            <?php foreach ($data["comments"] as $comment): ?>
              <div class="comment-item fade-up" style="animation-delay:0.05s">
                <div class="d-flex gap-3">
                  <div class="d-flex flex-column align-items-center">
                    <div
                      style="width:40px;height:40px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                      🚀</div>
                    <div class="comment-thread-line flex-grow-1 mt-2" style="min-height:16px;"></div>
                  </div>
                  <div class="flex-grow-1 pb-2">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                      <span style="color:var(--pin-muted);font-size:12px;">@<?= $comment["username"] ?> ·
                        <?= $comment["created_at"] ?></span>
                      <div class="action-menu-wrap">
                        <button class="btn-pin-ghost p-1" onclick="toggleDropdown('commentDrop1')">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <div class="dropdown-menu-pin" id="commentDrop1">
                          <div style="height:1px;background:var(--pin-border);margin:4px 0;"></div>
                          <button class="dropdown-item-pin danger"
                            onclick="closeDropdown('commentDrop1'); openModal('deleteCommentModal')">
                            <i class="bi bi-trash3"></i> Hapus komentar
                          </button>
                        </div>
                      </div>
                    </div>
                    <p style="font-size:14px;margin-bottom:10px;"><?= $comment["content"] ?></p>
                  </div>
                </div>
              </div><!-- end commentsContainer -->
            <?php endforeach ?>
          <?php endif ?>
        </div><!-- end feed-col -->
      </div><!-- end flex-grow-1 -->
    </div>
  </div>