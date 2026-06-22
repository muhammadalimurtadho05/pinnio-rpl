</div>

<?php if (isset($data["elements"])): ?>
  <?php foreach ($data["elements"] as $element): ?>
    <?php require_once __DIR__ . "/" . $element . ".php"; ?>
  <?php endforeach ?>
<?php endif ?>

<!-- Compose Modal -->
<div class="pin-modal-overlay" id="composeModal">
  <form action="/meme/create" method="POST" enctype="multipart/form-data" class="pin-modal">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <button type="button" onclick="closeModal('composeModal')" class="btn-pin-ghost p-1"><i class="bi bi-x-lg"></i></button>
      <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Thread Baru</h6>
      <button type="submit" class="btn btn-pin btn-sm">Post</button>
    </div>
    <div class="d-flex gap-3">
      <div
        style="width:42px;height:42px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
        🙂</div>
      <div class="flex-grow-1">
        <div style="font-weight:600;font-size:14px;margin-bottom:8px;"><?= $data["user"]["username"] ?></div>
        <textarea class="pin-input" name="caption" id="caption" placeholder="Apa yang kamu pikirkan?" rows="4" id="modalComposeText"></textarea>

        <!-- Image Preview Area -->
        <div id="imagePreviewContainer" style="display:none;margin-top:16px;">
          <div style="position:relative;border-radius:12px;overflow:hidden;background:var(--pin-card);border:1px solid var(--pin-border);">
            <img id="imagePreview" style="width:100%;height:auto;max-height:300px;object-fit:cover;display:block;" />
            <button onclick="clearImagePreview()" class="btn-close-preview" style="position:absolute;top:8px;right:8px;background:rgba(0,0,0,0.6);border:none;width:28px;height:28px;border-radius:50%;color:var(--pin-white);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0;"><i class="bi bi-x-lg"></i></button>
          </div>
        </div>

        <!-- Hidden File Input -->
        <input type="file" id="imageInput" name="meme_img" id="meme_img" accept="image/*" style="display:none;" onchange="handleImageSelect(event)" />

        <div class="d-flex gap-2 mt-3">
          <button type="button" class="btn-pin-ghost" onclick="document.getElementById('imageInput').click()"><i class="bi bi-image"></i></button>
        </div>
      </div>
    </div>
  </form>
</div>

</div>

<!-- Report Modal -->
<div class="pin-modal-overlay" id="reportModal">
  <div class="pin-modal" style="max-width:400px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Report Post</h6>
      <button type="button" onclick="closeModal('reportModal')" class="btn-pin-ghost p-1"><i class="bi bi-x-lg"></i></button>
    </div>
    <div>
      <input type="hidden" id="reportMemeId" value="">
      <p style="color:var(--pin-muted);font-size:14px;margin-bottom:16px;">Please tell us why you are reporting this post.</p>
      
      <div class="mb-3">
        <select id="reportReason" class="form-select bg-dark text-white border-secondary">
          <option value="" disabled selected>Select a reason...</option>
          <option value="spam">Spam</option>
          <option value="inappropriate">Inappropriate Content</option>
          <option value="harassment">Harassment</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-secondary me-2" onclick="closeModal('reportModal')">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="submitReport()">Report</button>
      </div>
    </div>
  </div>
</div>

<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/app.js"></script>
<?php if (isset($data["error_message"])): ?>
  <script>
    showToast("<?= $data["error_message"] ?>", "error")
  </script>
<?php endif ?>
<?php if (isset($data["script"])): ?>
  <?php foreach ($data["script"] as $script): ?>
    <script src="/public/js/<?= $script ?>"></script>
  <?php endforeach ?>
<?php endif ?>
</body>

</html>