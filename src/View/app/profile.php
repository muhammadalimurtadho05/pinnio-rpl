<!-- Main -->
<div class="main-content">
  <div class="d-flex">
    <div class="flex-grow-1">
      <!-- Page header -->
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center gap-3">
            <a href="home.html" class="btn-pin-ghost p-1"><i class="bi bi-arrow-left"></i></a>
            <div>
              <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:16px;">
                <?= $data["user"]["name"] ? $data["user"]["name"] : $data["user"]["username"] ?></div>
              <div style="color:var(--pin-muted);font-size:12px;"><?= isset($data["stats"]) ? number_format($data["stats"]["posts_count"]) : '0' ?> thread</div>
            </div>
          </div>
        </div>
      </div>

      <div class="feed-col">
        <!-- Banner -->
        <div class="profile-banner">
          <div class="banner-pattern"></div>
        </div>

        <!-- Profile info -->
        <div style="padding:0 4px;">
          <div class="d-flex align-items-flex-start justify-content-between">
            <div class="profile-avatar-wrap">
              <div class="profile-avatar">🙂</div>
              <div class="online-badge"></div>
            </div>
          </div>

          <div style="padding:16px 0 0;">
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:22px;">
              <?= $data["user"]["name"] ? $data["user"]["name"] : $data["user"]["username"] ?></div>
            <div style="color:var(--pin-muted);font-size:14px;margin-bottom:12px;">@<?= $data["user"]["username"] ?>
            </div>
            <?php if ($data["user"]["bio"]): ?>
              <p style="font-size:14px;line-height:1.65;max-width:480px;margin-bottom:12px;"><?= $data["user"]["bio"] ?>
              </p>
            <?php endif ?>
          </div>

          <div class="profile-stats">
            <div class="profile-stat" onclick="openModal('followersModal')">
              <span class="num"><?= isset($data["stats"]) ? number_format($data["stats"]["followers_count"]) : '0' ?></span>
              <span class="label">Pengikut</span>
            </div>
            <div class="profile-stat" onclick="openModal('followingModal')">
              <span class="num"><?= isset($data["stats"]) ? number_format($data["stats"]["following_count"]) : '0' ?></span>
              <span class="label">Mengikuti</span>
            </div>
            <div class="profile-stat">
              <span class="num"><?= isset($data["stats"]) ? number_format($data["stats"]["posts_count"]) : '0' ?></span>
              <span class="label">Postingan</span>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="pin-tabs">
          <button class="pin-tab active" onclick="window.location.href='/profile'">Postingan</button>
          <button class="pin-tab <?= isset($data['active_tab']) && $data['active_tab'] === 'bookmarks' ? 'active' : '' ?>" onclick="window.location.href='/profile/bookmarks'">Tersimpan</button>
        </div>

        <!-- Posts -->
        <?php if (!isset($data["memes"]) || empty($data["memes"])): ?>
          <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:260px;">
            <div style="font-size:48px;margin-bottom:16px;">📭</div>
            <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--pin-white);margin-bottom:8px;">Belum ada
              postingan</h6>
            <p style="color:var(--pin-muted);text-align:center;margin-bottom:24px;max-width:420px;">Kamu belum memiliki
              postingan. Mulai dengan membuat thread baru untuk berbagi cerita atau gambar.</p>
          </div>
        <?php else: ?>
          <?php foreach ($data["memes"] as $meme): ?>
            <article class="thread-item fade-up clickable-thread" data-href="/meme/<?= $meme['meme_id'] ?>" style="animation-delay:0.05s">
              <div class="d-flex gap-3">
                <div
                  style="width:44px;height:44px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                  🙂</div>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                      <a href="/u/<?= htmlspecialchars($meme['username']) ?>" style="color:inherit;text-decoration:none;"><span style="font-weight:700;font-size:14px;"><?= $data["user"]["name"] ? $data["user"]["name"] : $data["user"]["username"] ?></span></a>
                      <span style="color:var(--pin-muted);font-size:13px;">@<?= $data["user"]["username"] ?> ·
                        <?= $meme['created_at'] ?>
                      </span></div>
                    <div class="dropdown" onclick="event.stopPropagation()">
                      <button class="btn-pin-ghost p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="openReportModal(<?= $meme['meme_id'] ?>)"><i class="bi bi-flag me-2"></i>Report</a></li>
                      </ul>
                    </div>
                  </div>
                  <p style="font-size:15px;margin-bottom:12px;">
                    <?= $meme['caption'] ?>
                  </p>
                  <?php if (isset($meme['image_url']) && !empty($meme['image_url'])): ?>
                    <div style="border-radius:12px;overflow:hidden;margin-bottom:12px;">
                      <img src="<?= $meme['image_url'] ?>" alt="Meme image"
                        style="width:100%;height:auto;max-height:400px;object-fit:cover;display:block;" />
                    </div>
                  <?php endif ?>
                  <div class="thread-actions">
                    <button class="thread-action-btn <?= isset($meme['is_liked']) && $meme['is_liked'] ? 'liked' : '' ?>" data-action="like" data-meme-id="<?= $meme['meme_id'] ?>">
                      <i class="bi <?= isset($meme['is_liked']) && $meme['is_liked'] ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                      <span class="action-count"><?= $meme['likes_count'] ?? '0' ?></span>
                    </button>
                    <button class="thread-action-btn"><i class="bi bi-chat"></i><span class="action-count">
                        <?= $meme['comments_count'] ?? '0' ?>
                      </span></button>
                    <button class="thread-action-btn <?= isset($meme['is_bookmarked']) && $meme['is_bookmarked'] ? 'bookmarked' : '' ?>" data-action="bookmark" data-meme-id="<?= $meme['meme_id'] ?>">
                      <i class="bi <?= isset($meme['is_bookmarked']) && $meme['is_bookmarked'] ? 'bi-bookmark-fill' : 'bi-bookmark' ?>"></i>
                    </button>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>