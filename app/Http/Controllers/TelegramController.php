<?php
namespace App\Http\Controllers;

use App\Objects\Update;
use App\Repositories\UserRepository;
use App\Services\MegaDownloaderService;
use Exception;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    /**
     * @var MegaDownloaderService
     */
    private MegaDownloaderService $megaDownloaderService;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * TelegramController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(MegaDownloaderService $megaDownloaderService,
                                UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->megaDownloaderService = $megaDownloaderService;
    }

    public function index() {
        // Get Update
        $msg = collect(Telegram::getUpdates())->last();

        // Set update Object
        $update = new Update($msg);

        // Validate to user exist
        self::createOrValidateUser($update);

        // Process Update
        try {
            $path = null;
            // Download from mega
            if (!empty($update->getText())) {
                $path = $this->megaDownloaderService->download($update->getText());
            } else

            // Send animated emoji
            if (empty($update->getEmoji())) {
                Telegram::sendDice([
                    'chat_id' => $update->getChatId(),
                    'emoji' => $update->getEmoji()
                ]);
            }

            // Response update processed
            if (!is_null($path)){
                self::sendResponse($path, $update);
            }

        } catch (Exception $e) {
            Log::error($e->getCode() ." | ". $e->getMessage());
            Telegram::sendMessage([
                'chat_id' => $update->getChatId(),
                'text' => $e->getCode() ." | ". $e->getMessage()
            ]);
        } finally {
            // Deleting File in local storage
            if (!is_null($path)) { unlink($path); }
        }
        die(404);

    }

    private function createOrValidateUser(Update $telegram)
    {
        $user = $this->userRepository->getTelegramID($telegram->getFromId());

        if (!isset($user)) {
            $params = [
                'telegram_id' => $telegram->getFromId(),
                'is_bot' => $telegram->isIsBot(),
                'first_name' => $telegram->getFirstName(),
                'last_name' => $telegram->getLastName(),
                'username' => $telegram->getUsername(),
                'language_code' => $telegram->getLanguageCode()
            ];
            $this->userRepository->create($params);
        }

        return true;
    }

    private function sendResponse(string $path, Update $update)
    {
        $filename = collect(explode('storage/', $path))->last();
        Telegram::sendDocument([
            'chat_id' => $update->getChatId(),
            'document' => InputFile::create($path,$filename),
            'caption' => $filename
        ]);
    }
}
