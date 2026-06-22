<?php

namespace App\Pinnio\Service;

use App\Pinnio\Exception\ValidationException;
use App\Pinnio\Model\MemeModel;
use App\Pinnio\Repository\MemeRepository;
use App\Pinnio\Utils\CensorString;

class MemeService
{
    private static MemeRepository $memeRepository;

    public function __construct(MemeRepository $memeRepository)
    {
        self::$memeRepository = $memeRepository;
    }

    public function createMeme(MemeModel $memeModel, string $file_tmp, string $file_name): bool
    {
        if (strlen($memeModel->caption) === 0) {
            throw new ValidationException("Caption tidak boleh kosong.");
        }

        // ===== PROSES SENSOR CAPTION BARU =====
        $memeModel->caption = CensorString::filter($memeModel->caption);

        if (!empty($file_tmp)) {
            move_uploaded_file($file_tmp, __DIR__ . "/../../public/uploads/meme_img/" . $file_name);
        } else {
            $memeModel->image_path = null;
        }

        return self::$memeRepository->saveMeme($memeModel);
    }

    public function getMemes(?int $user_id = null): array
    {
        return self::$memeRepository->getMemes($user_id);
    }

    public function getFollowingMemes(int $user_id): array
    {
        return self::$memeRepository->getFollowingMemes($user_id);
    }

    public function getMemeById(int $meme_id): array
    {
        return self::$memeRepository->getMemeById($meme_id);
    }

    public function deleteMeme(int $meme_id)
    {
        $meme = self::$memeRepository->getMemeById($meme_id);
        if (!empty($meme["image_url"])) {
            $imagePath = __DIR__ . "/../.." . $meme["image_url"];
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }
        return self::$memeRepository->deleteMeme($meme_id);
    }

    public function updateMeme(int $meme_id, string $caption): bool
    {
        if (strlen($caption) === 0) {
            throw new ValidationException("Caption tidak boleh kosong.");
        }

        // ===== PROSES SENSOR EDIT CAPTION =====
        $censoredCaption = CensorString::filter($caption);

        return self::$memeRepository->updateMeme($meme_id, $censoredCaption);
    }

    public function getTotalMemesCount(): int
    {
        return self::$memeRepository->getTotalMemesCount();
    }
}
