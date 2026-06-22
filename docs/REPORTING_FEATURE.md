# Reporting Feature Implementation Guide

The database schema and backend administrative interface for user and post reports are already implemented. To enable the end-user reporting functionality, you will need to complete the following steps in the frontend and controller.

## 1. Controller & Route

Create a `ReportController.php` or add a method inside `MemeController.php` / `UserController.php` to handle the incoming POST request when a user submits a report.

**Route Example (index.php):**
```php
Router::add("/report/submit", "POST", fn() => $reportController->submitReport(), [
  fn() => AuthMiddleware::isNotAuth()
]);
```

**Controller Method Example:**
```php
public function submitReport(): void
{
    try {
        $reportModel = new \App\Pinnio\Model\ReportModel();
        
        $reportModel->reporter_id = $_SESSION["auth"]["user_id"];
        // For reporting a post:
        $reportModel->target_meme_id = $_POST["target_meme_id"] ?? null;
        // For reporting a user (if you want to support profile reporting):
        $reportModel->target_user_id = $_POST["target_user_id"] ?? null;
        
        $reportModel->reason = $_POST["reason"] ?? '';
        $reportModel->status = 'pending';

        // Assuming you add a saveReport method to ReportService
        self::$reportService->saveReport($reportModel);

        // Redirect back with success message (or return JSON if using AJAX)
        \App\Pinnio\Config\View::redirect("/home"); 
    } catch (\Exception $e) {
        // Handle error
    }
}
```

*Note: You will need to implement `saveReport` in `src/Service/ReportService.php` which delegates to `$this->reportRepository->save($model)`.*

## 2. ReportService Update

To support saving reports from the client side, add this method to `src/Service/ReportService.php`:

```php
public function saveReport(\App\Pinnio\Model\ReportModel $model): void
{
    if (empty($model->reason)) {
        throw new \App\Pinnio\Exception\ValidationException("Alasan laporan harus diisi.");
    }
    
    if (empty($model->target_meme_id) && empty($model->target_user_id)) {
        throw new \App\Pinnio\Exception\ValidationException("Target laporan tidak valid.");
    }

    $this->reportRepository->save($model);
}
```

## 3. Frontend UI Integration

Add a "Report" button on the posts (or user profiles). You can either make it an interactive modal or a simple form.

**HTML Modal Example:**
```html
<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background:var(--pin-card);border:1px solid var(--pin-border);color:var(--pin-white);">
      <form action="/report/submit" method="POST">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="reportModalLabel">Laporkan Konten</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body border-0">
          <!-- Hidden input to hold the meme ID -->
          <input type="hidden" name="target_meme_id" id="reportTargetMemeId" value="">
          
          <div class="mb-3">
            <label for="reason" class="form-label">Alasan Pelaporan</label>
            <textarea class="form-control" id="reason" name="reason" rows="3" required placeholder="Jelaskan alasan mengapa Anda melaporkan konten ini..." style="background:var(--pin-bg);border:1px solid var(--pin-border);color:var(--pin-white);"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Kirim Laporan</button>
        </div>
      </form>
    </div>
  </div>
</div>
```

**Trigger Button:**
```html
<button type="button" class="btn btn-sm btn-pin-ghost text-danger" data-bs-toggle="modal" data-bs-target="#reportModal" onclick="document.getElementById('reportTargetMemeId').value = <?= $meme['meme_id'] ?>;">
  <i class="bi bi-flag"></i> Laporkan
</button>
```

By following this guide, users will be able to easily submit reports that will instantly appear in the newly constructed Admin Dashboard.
