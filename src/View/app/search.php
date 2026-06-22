<!-- Main -->
<div class="main-content">
  <div class="d-flex" style="min-height:100vh;">
    <!-- Feed -->
    <div class="flex-grow-1">
      <div class="page-header">
        <div class="feed-col">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;margin:0;">Search Users</h5>
          </div>
          
          <form id="searchForm" class="mb-4 d-flex gap-2">
            <input type="text" id="searchInput" class="form-control pin-input" style="background:var(--pin-card);border:1px solid var(--pin-border);color:var(--pin-white);" placeholder="Search by name or username" value="<?= htmlspecialchars($data['query'] ?? '') ?>">
            <button type="submit" class="btn btn-pin px-4">Search</button>
          </form>

          <script>
            document.getElementById('searchForm').addEventListener('submit', function(e) {
              e.preventDefault();
              const query = document.getElementById('searchInput').value.trim();
              if (query) {
                window.location.href = '/search/' + encodeURIComponent(query);
              } else {
                window.location.href = '/search';
              }
            });
          </script>

        </div>
      </div>

      <div class="feed-col pt-2">
        <div id="feedContainer">
          <?php if (isset($data['query']) && !empty($data['query'])): ?>
            <?php if (empty($data['users'])): ?>
              <div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:200px;">
                <p style="color:var(--pin-muted);text-align:center;">No users found matching "<?= htmlspecialchars($data['query']) ?>"</p>
              </div>
            <?php else: ?>
              <div class="list-group list-group-flush bg-transparent">
                <?php foreach ($data['users'] as $u): ?>
                  <div class="list-group-item bg-transparent text-white d-flex align-items-center justify-content-between py-3" style="border-bottom: 1px solid var(--pin-border);">
                    <a href="/u/<?= htmlspecialchars($u['username']) ?>" class="d-flex align-items-center gap-3" style="text-decoration:none;color:inherit;">
                      <div style="width:44px;height:44px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:22px;overflow:hidden;">
                        <?= empty($u['profile_picture']) ? '😊' : '<img src="'.htmlspecialchars($u['profile_picture']).'" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">' ?>
                      </div>
                      <div>
                        <h6 class="mb-0" style="font-weight:700;color:var(--pin-white);"><?= htmlspecialchars($u['name'] ?: $u['username']) ?></h6>
                        <small style="color:var(--pin-muted);">@<?= htmlspecialchars($u['username']) ?></small>
                      </div>
                    </a>
                    <?php if ($u['user_id'] !== $data['user']['user_id']): ?>
                      <button class="btn <?= $u['is_following'] ? 'btn-outline-light' : 'btn-pin' ?> btn-sm rounded-pill px-3 follow-btn" data-user-id="<?= $u['user_id'] ?>">
                        <?= $u['is_following'] ? 'Following' : 'Follow' ?>
                      </button>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
