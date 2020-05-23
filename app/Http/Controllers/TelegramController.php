<?php
namespace App\Http\Controllers;

use App\Objects\Update;
use App\Repositories\UserRepository;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * TelegramController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index() {
        // Get Update
        $msg = collect(Telegram::getUpdates())->last();

        // Set update Object
        $update = new Update($msg);

        // Validate to user exist
        self::createOrValidateUser($update);

        // Process Update
        // Response update processed

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
}
