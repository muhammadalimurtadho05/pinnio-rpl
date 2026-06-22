<div class="main-content">

  <!-- HEADER -->
  <div class="page-header">

    <div class="feed-col">

      <div class="d-flex align-items-center gap-3">

        <a href="thread.html" class="btn-pin-ghost p-1">

          <i class="bi bi-arrow-left"></i>

        </a>

        <div>

          <div style="
              font-family:'Syne',sans-serif;
              font-weight:800;
              font-size:18px;
            ">
            Edit Postingan
          </div>

          <div style="
              color:var(--pin-muted);
              font-size:12px;
            ">
            Perbarui thread kamu
          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- CONTENT -->
  <div class="edit-wrapper">

    <form action="/meme/<?= $data["meme"]['meme_id'] ?>/edit" method="POST" class="edit-card">

      <!-- USER -->
      <div class="d-flex gap-3 mb-4">

        <div style="
            width:48px;
            height:48px;
            border-radius:50%;
            background:var(--pin-card);
            border:1.5px solid var(--pin-border);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            flex-shrink:0;
          ">
          🙂
        </div>

        <div>

          <div style="
              font-weight:700;
              font-size:15px;
            ">
            <?= strlen($data["user"]["username"]) === 0 ? $data["user"]["name"] : $data["user"]["username"] ?>
          </div>

          <div style="
              color:var(--pin-muted);
              font-size:13px;
            ">
            @<?= $data["user"]["username"] ?>
          </div>

        </div>

      </div>

      <!-- TEXTAREA -->
      <textarea class="edit-textarea" name="caption" id="caption" maxlength="500"
        onkeyup="updateCounter()"><?= $data["meme"]['caption'] ?></textarea>

      <!-- IMAGE -->
      <img src="<?= $data["meme"]['image_url'] ?>" class="edit-image">

      <!-- TOOLS -->
      <div class="edit-tools">

        <div class="d-flex align-items-center gap-3">

          <div class="char-count">
            <span id="charCount">108</span>/500
          </div>

          <button class="btn btn-pin" onclick="savePost()">

            Simpan Perubahan

          </button>

        </div>

      </div>

    </form>

  </div>