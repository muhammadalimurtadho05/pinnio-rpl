<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">
    <!-- Feed -->
    <div class="flex-grow-1">
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;margin:0;"><?= htmlspecialchars($data['user']['name'] ?: $data['user']['username']) ?></h5>
          </div>
          <div class="pin-tabs">
            <button class="pin-tab active" onclick="window.location.href='/u/<?= htmlspecialchars($data['user']['username']) ?>'">Postingan</button>
          </div>
        </div>
      </div>

      <div class="feed-col pt-2">
        <div class="profile-header">
          <div class="d-flex align-items-center gap-4 mb-4">
            <div class="profile-avatar">
              <?php if (!empty($data["user"]["profile_picture"])): ?>
                <img src="<?= htmlspecialchars($data["user"]["profile_picture"]) ?>" alt="Profile picture" style="width:100%;height:100%;object-fit:cover;">
              <?php else: ?>
                <span>👤</span>
              <?php endif; ?>
            </div>
            <div class="flex-grow-1">
              <h4 style="font-family:'Syne',sans-serif;font-weight:800;margin:0;"><?= htmlspecialchars($data["user"]["name"] ?: $data["user"]["username"]) ?></h4>
              <p style="color:var(--pin-muted);margin:0;font-size:15px;">@<?= htmlspecialchars($data["user"]["username"]) ?></p>
            </div>
            <div class="d-flex gap-2">
              <?php if (isset($_SESSION['auth']['user_id'])): ?>
                <button class="btn <?= $data['is_following'] ? 'btn-outline-light' : 'btn-pin' ?> rounded-pill px-4 follow-btn" data-user-id="<?= $data['user']['user_id'] ?>" onclick="toggleFollow(this)">
                  <?= $data['is_following'] ? 'Following' : 'Follow' ?>
                </button>
                <a href="/chat/<?= htmlspecialchars($data['user']['username']) ?>" class="btn btn-outline-light rounded-pill px-4">
                  Message
                </a>
              <?php endif; ?>
            </div>
          </div>
          
          <p style="font-size:15px;margin-bottom:20px;white-space:pre-wrap;"><?= htmlspecialchars($data["user"]["bio"] ?? 'No bio yet.') ?></p>
          
          <div class="d-flex gap-4 profile-stats">
            <div class="stat-item">
              <span class="stat-value"><?= htmlspecialchars($data["stats"]["followers_count"]) ?></span> Pengikut
            </div>
            <div class="stat-item">
              <span class="stat-value"><?= htmlspecialchars($data["stats"]["following_count"]) ?></span> Mengikuti
            </div>
            <div class="stat-item">
              <span class="stat-value"><?= htmlspecialchars($data["stats"]["posts_count"]) ?></span> Postingan
            </div>
          </div>
        </div>

        <div id="feedContainer">
          <?php if (!isset($data["memes"]) || empty($data["memes"])): ?>
            <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:300px;">
              <div style="font-size:48px;margin-bottom:16px;">📭</div>
              <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--pin-white);margin-bottom:8px;">Belum ada postingan</h6>
              <p style="color:var(--pin-muted);text-align:center;">Pengguna ini belum memposting apapun.</p>
            </div>
          <?php else: ?>
            <?php foreach ($data["memes"] as $meme): ?>
              <article class="thread-item fade-up clickable-thread" data-href="/meme/<?= $meme["meme_id"] ?>" style="animation-delay:0.05s">
                <div class="d-flex gap-3">
                  <div class="d-flex flex-column align-items-center">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;overflow:hidden;">
                        <?php if (!empty($data["user"]["profile_picture"])): ?>
                            <img src="<?= htmlspecialchars($data["user"]["profile_picture"]) ?>" alt="Profile picture" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            😊
                        <?php endif; ?>
                    </div>
                    <div class="thread-connector flex-grow-1 mt-2" style="min-height:20px;"></div>
                  </div>
                  <div class="flex-grow-1 pb-2">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                      <div>
                        <a href="/u/<?= htmlspecialchars($meme['username']) ?>" style="color:inherit;text-decoration:none;"><span style="font-weight:700;font-size:14px;"><?= htmlspecialchars($meme['username']) ?></span></a>
                        <span style="color:var(--pin-muted);font-size:13px;margin-left:6px;"><?= $meme['created_at'] ?></span>
                      </div>
                      <div class="dropdown" onclick="event.stopPropagation()">
                        <button class="btn-pin-ghost p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                          <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="openReportModal(<?= $meme['meme_id'] ?>)"><i class="bi bi-flag me-2"></i>Report</a></li>
                        </ul>
                      </div>
                    </div>
                    <p style="font-size:15px;margin-bottom:12px;"><?= htmlspecialchars($meme['caption']) ?></p>
                    <?php if (!empty($meme['image_url'])): ?>
                      <div style="border-radius:12px;overflow:hidden;margin-bottom:12px;">
                        <img src="<?= htmlspecialchars($meme['image_url']) ?>" alt="Meme image" style="width:100%;height:auto;max-height:400px;object-fit:cover;display:block;" />
                      </div>
                    <?php endif ?>
                    <div class="thread-actions">
                      <button class="thread-action-btn <?= $meme['is_liked'] ? 'liked' : '' ?>" data-action="like" data-meme-id="<?= $meme['meme_id'] ?>">
                        <i class="bi <?= $meme['is_liked'] ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                        <span class="action-count"><?= $meme['likes_count'] ?></span>
                      </button>
                      <button class="thread-action-btn"><i class="bi bi-chat"></i><span class="action-count"><?= $meme['comments_count'] ?></span></button>
                      <button class="thread-action-btn <?= $meme['is_bookmarked'] ? 'bookmarked' : '' ?>" data-action="bookmark" data-meme-id="<?= $meme['meme_id'] ?>">
                        <i class="bi <?= $meme['is_bookmarked'] ? 'bi-bookmark-fill' : 'bi-bookmark' ?>"></i>
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
</div>
