<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">
    <!-- Feed -->
    <div class="flex-grow-1">
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;margin:0;">Home</h5>
          </div>
          <div class="pin-tabs">
            <button class="pin-tab active" onclick="switchTab(this, 'forYou')">Untuk Kamu</button>
            <button class="pin-tab" onclick="switchTab(this, 'following')">Mengikuti</button>
          </div>
        </div>
      </div>

      <div class="feed-col pt-2">
        <!-- Feed Items -->
        <div id="feedContainer">
          <?php if (!isset($data["memes"]) || empty($data["memes"])): ?>
            <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:300px;">
              <div style="font-size:48px;margin-bottom:16px;">📭</div>
              <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--pin-white);margin-bottom:8px;">Belum ada thread</h6>
              <p style="color:var(--pin-muted);text-align:center;margin-bottom:24px;">Jadilah yang pertama memposting thread menarik!</p>
              <button class="btn btn-pin" onclick="openModal('composeModal')">
                <i class="bi bi-pen me-2"></i>Buat Thread Pertama
              </button>
            </div>
          <?php else: ?>
            <?php foreach ($data["memes"] as $meme): ?>
              <article class="thread-item fade-up clickable-thread" data-href="/meme/<?= $meme["meme_id"] ?>" style="animation-delay:0.05s">
                <div class="d-flex gap-3">
                  <div class="d-flex flex-column align-items-center">
                    <div
                      style="width:44px;height:44px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                      😊</div>
                    <div class="thread-connector flex-grow-1 mt-2" style="min-height:20px;"></div>
                  </div>
                  <div class="flex-grow-1 pb-2">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                      <div>
                        <span style="font-weight:700;font-size:14px;"><?= $meme['username'] ?></span>
                        <span style="color:var(--pin-muted);font-size:13px;margin-left:6px;"><?= $meme['created_at'] ?></span>
                      </div>
                      <button class="btn-pin-ghost p-1" onclick="event.stopPropagation()"><i
                          class="bi bi-three-dots"></i></button>
                    </div>
                    <p style="font-size:15px;margin-bottom:12px;"><?= $meme['caption'] ?></p>
                    <?php if (isset($meme['image_url']) && !empty($meme['image_url'])): ?>
                      <div style="border-radius:12px;overflow:hidden;margin-bottom:12px;">
                        <img src="<?= $meme['image_url'] ?>" alt="Meme image" style="width:100%;height:auto;max-height:400px;object-fit:cover;display:block;" />
                      </div>
                    <?php endif ?>
                    <div class="thread-actions" onclick="event.stopPropagation()">
                      <button class="thread-action-btn <?= isset($meme['is_liked']) && $meme['is_liked'] ? 'liked' : '' ?>" data-action="like" data-meme-id="<?= $meme['meme_id'] ?>">
                        <i class="bi <?= isset($meme['is_liked']) && $meme['is_liked'] ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                        <span class="action-count"><?= $meme['likes_count'] ?></span>
                      </button>
                      <button class="thread-action-btn"><i class="bi bi-chat"></i><span
                          class="action-count"><?= $meme['comments_count'] ?></span></button>
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