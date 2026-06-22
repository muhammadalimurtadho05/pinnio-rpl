<!-- ===== MODAL: HAPUS POST ===== -->
<div class="pin-modal-overlay" id="deletePostModal">
  <div class="pin-modal delete-modal-inner">
    <div class="delete-icon-wrap">
      <i class="bi bi-trash3-fill"></i>
    </div>
    <h5 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:8px;">Hapus thread ini?</h5>
    <p style="color:var(--pin-muted);font-size:14px;margin-bottom:24px;">
      Thread yang dihapus tidak bisa dikembalikan. Semua komentar dan suka juga akan ikut terhapus.
    </p>
    <div class="d-flex flex-column gap-2">
      <a href="/meme/<?= $data["meme"]["meme_id"] ?>/delete" class="btn-danger-pin w-100">Ya, hapus thread</a>
      <button class="btn btn-pin-outline w-100" onclick="closeModal('deletePostModal')">Batal</button>
    </div>
  </div>
</div>

<!-- ===== MODAL: HAPUS KOMENTAR ===== -->
<div class="pin-modal-overlay" id="deleteCommentModal">
  <div class="pin-modal delete-modal-inner">
    <div class="delete-icon-wrap">
      <i class="bi bi-chat-left-x-fill"></i>
    </div>
    <h5 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:8px;">Hapus komentar ini?</h5>
    <p style="color:var(--pin-muted);font-size:14px;margin-bottom:24px;">
      Komentar yang dihapus tidak bisa dikembalikan dan tidak akan terlihat oleh siapapun.
    </p>
    <div class="d-flex flex-column gap-2">
      <a href="/comment/<?= $comment["comment_id"] ?>/delete" class="btn-danger-pin w-100" onclick="confirmDeleteComment()">Ya, hapus komentar</a>
      <button class="btn btn-pin-outline w-100" onclick="closeModal('deleteCommentModal')">Batal</button>
    </div>
  </div>
</div>