<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function index() {
        // Get Update
        dd(Telegram::getUpdates());
        // Validate to user exist
        // Save User
        // Process Update
        // Response update processed

    }
}
