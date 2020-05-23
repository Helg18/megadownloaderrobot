<?php
namespace App\Objects;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Telegram\Bot\Objects\Update as Telegram;

class Update
{
    private int $update_id;
    private Collection $message;
        private int $message_id;
        private Collection $from;
            private int $from_id;
            private bool $is_bot;
            private string $first_name;
            private string $last_name;
            private string $username;
            private string $language_code;
        private Collection $chat;
            private int $chat_id;
            private string $chat_first_name;
            private string $chat_last_name;
            private string $chat_username;
            private string $type;
        private $date;
        private string $text;
        private Collection $entities;
            private int $offset;
            private int $length;
            private string $entities_type;
        private Collection $dice;
            private string $emoji;
            private int $value;

    public function __construct(Telegram $telegram)
    {
        self::setAllAttributes($telegram);
    }

    private function setAllAttributes(Telegram $update)
    {
        $this->setUpdateId($update->updateId);
        $this->setMessage($update->getMessage());
            $this->setMessageId($this->getMessage()->get('message_id'));
            $this->setFrom(collect($update['message']['from']));
                $this->setFromId($this->getFrom()->get('id'));
                $this->setIsBot($this->getFrom()->get('is_bot'));
                $this->setFirstName($this->getFrom()->get('first_name'));
                $this->setLastName($this->getFrom()->get('last_name'));
                $this->setUsername($this->getFrom()->get('username'));
                $this->setLanguageCode($this->getFrom()->get('language_code'));
            $this->setChat($update->getChat());
                $this->setChatId($this->getChat()->get('id'));
                $this->setChatFirstName($this->getChat()->get('first_name'));
                $this->setChatLastName($this->getChat()->get('last_name'));
                $this->setChatUsername($this->getChat()->get('username'));
                $this->setType($this->getChat()->get('type'));
            $this->setDate($update['message']['date']);
        if (isset($update['message']['text'])){
            $this->setText($update['message']['text']);
        }
        if(isset($update['message']['dice'])) {
            $this->setDice(collect($update['message']['dice']));
                $this->setEmoji($this->getDice()->get('emoji'));
                $this->setValue($this->getDice()->get('value'));
        }
        if (isset($update['message']['entities'])){
            $this->setEntities(collect(collect($update['message']['entities'])->first()));
                $this->setOffset($this->getEntities()->get('offset'));
                $this->setLength($this->getEntities()->get('length'));
                $this->setEntitiesType($this->getEntities()->get('type'));
        }
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->update_id;
    }

    /**
     * @param int $update_id
     */
    public function setUpdateId(int $update_id): void
    {
        $this->update_id = $update_id;
    }

    /**
     * @return Collection
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    /**
     * @param Collection $message
     */
    public function setMessage(Collection $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }

    /**
     * @param int $message_id
     */
    public function setMessageId(int $message_id): void
    {
        $this->message_id = $message_id;
    }

    /**
     * @return Collection
     */
    public function getFrom(): Collection
    {
        return $this->from;
    }

    /**
     * @param Collection $from
     */
    public function setFrom(Collection $from): void
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getFromId(): int
    {
        return $this->from_id;
    }

    /**
     * @param int $from_id
     */
    public function setFromId(int $from_id): void
    {
        $this->from_id = $from_id;
    }

    /**
     * @return bool
     */
    public function isIsBot(): bool
    {
        return $this->is_bot;
    }

    /**
     * @param bool $is_bot
     */
    public function setIsBot(bool $is_bot): void
    {
        $this->is_bot = $is_bot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->language_code;
    }

    /**
     * @param string $language_code
     */
    public function setLanguageCode(string $language_code): void
    {
        $this->language_code = $language_code;
    }

    /**
     * @return Collection
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    /**
     * @param Collection $chat
     */
    public function setChat(Collection $chat): void
    {
        $this->chat = $chat;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chat_id;
    }

    /**
     * @param int $chat_id
     */
    public function setChatId(int $chat_id): void
    {
        $this->chat_id = $chat_id;
    }

    /**
     * @return string
     */
    public function getChatFirstName(): string
    {
        return $this->chat_first_name;
    }

    /**
     * @param string $chat_first_name
     */
    public function setChatFirstName(string $chat_first_name): void
    {
        $this->chat_first_name = $chat_first_name;
    }

    /**
     * @return string
     */
    public function getChatLastName(): string
    {
        return $this->chat_last_name;
    }

    /**
     * @param string $chat_last_name
     */
    public function setChatLastName(string $chat_last_name): void
    {
        $this->chat_last_name = $chat_last_name;
    }

    /**
     * @return string
     */
    public function getChatUsername(): string
    {
        return $this->chat_username;
    }

    /**
     * @param string $chat_username
     */
    public function setChatUsername(string $chat_username): void
    {
        $this->chat_username = $chat_username;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return Carbon::createFromTimeString($this->date);
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $date = Carbon::createFromTimestampUTC($date);
        $this->date = $date->format("Y-m-d h:i:s");
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return Collection
     */
    public function getEntities(): Collection
    {
        return $this->entities;
    }

    /**
     * @param Collection $entities
     */
    public function setEntities(Collection $entities): void
    {
        $this->entities = $entities;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getEntitiesType(): string
    {
        return $this->entities_type;
    }

    /**
     * @param string $entities_type
     */
    public function setEntitiesType(string $entities_type): void
    {
        $this->entities_type = $entities_type;
    }

    /**
     * @return Collection
     */
    public function getDice(): Collection
    {
        return $this->dice;
    }

    /**
     * @param Collection $dice
     */
    public function setDice(Collection $dice): void
    {
        $this->dice = $dice;
    }

    /**
     * @return string
     */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    /**
     * @param string $emoji
     */
    public function setEmoji(string $emoji): void
    {
        $this->emoji = $emoji;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }


}
