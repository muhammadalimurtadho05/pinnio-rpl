<!-- Main -->
<div class="main-content" style="height: 100vh; display: flex; flex-direction: column;">
  <div class="page-header flex-shrink-0" style="padding-top:24px;">
    <div class="feed-col">
      <div class="d-flex align-items-center gap-3">
        <a href="/chat" class="btn-pin-ghost p-1"><i class="bi bi-arrow-left"></i></a>
        <a href="/u/<?= htmlspecialchars($data['partner']['username']) ?>" class="d-flex align-items-center gap-2" style="text-decoration:none;color:inherit;">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:18px;overflow:hidden;">
            <?php if (!empty($data['partner']['profile_picture'])): ?>
              <img src="<?= htmlspecialchars($data['partner']['profile_picture']) ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
              😊
            <?php endif; ?>
          </div>
          <div>
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin:0;color:var(--pin-white);"><?= htmlspecialchars($data['partner']['name'] ?: $data['partner']['username']) ?></h6>
            <div style="font-size:12px;color:var(--pin-muted);">@<?= htmlspecialchars($data['partner']['username']) ?></div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="flex-grow-1 position-relative" style="overflow:hidden; display:flex; flex-direction:column; max-width:600px; margin:0 auto; width:100%;">
    <!-- Chat messages area -->
    <div id="chatMessages" class="flex-grow-1 overflow-auto p-3" style="display:flex; flex-direction:column; gap:16px;">
      <?php foreach ($data['messages'] as $msg): ?>
        <?php $isMine = $msg['sender_id'] === $data['user']['user_id']; ?>
        <div class="message-bubble-wrapper d-flex <?= $isMine ? 'justify-content-end' : 'justify-content-start' ?>">
          <div class="message-bubble" style="max-width:75%; padding:10px 16px; border-radius:18px; font-size:15px; <?= $isMine ? 'background:var(--pin-yellow);color:var(--pin-dark);border-bottom-right-radius:4px;' : 'background:var(--pin-card);color:var(--pin-white);border:1px solid var(--pin-border);border-bottom-left-radius:4px;' ?>">
            <?= htmlspecialchars($msg['message_text']) ?>
            <div style="font-size:11px; opacity:0.7; text-align: <?= $isMine ? 'right' : 'left' ?>; margin-top:4px;">
              <?= date('H:i', strtotime($msg['sent_at'])) ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Chat input area -->
    <div class="p-3 bg-transparent border-top" style="border-color: var(--pin-border) !important;">
      <form id="chatForm" class="d-flex gap-2" onsubmit="sendChatMessage(event)">
        <input type="hidden" id="partnerId" value="<?= $data['partner']['user_id'] ?>">
        <input type="hidden" id="partnerUsername" value="<?= htmlspecialchars($data['partner']['username']) ?>">
        <input type="hidden" id="currentUserId" value="<?= $data['user']['user_id'] ?>">
        <input type="text" id="chatInput" class="form-control pin-input flex-grow-1 rounded-pill" placeholder="Tulis pesan..." autocomplete="off" style="background:var(--pin-card);border:1px solid var(--pin-border);color:var(--pin-white);">
        <button type="submit" class="btn btn-pin rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;padding:0;">
          <i class="bi bi-send-fill" style="margin-left:-2px;"></i>
        </button>
      </form>
    </div>
  </div>
</div>
