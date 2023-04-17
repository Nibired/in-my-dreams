<?php

class Messages {
    private int $id_message;
    private int $from_user_id;
    private int $to_user_id;
    private string $message;
    private DateTime $date_sent;
    private bool $is_direct;

    public function __construct(int $id_message, int $from_user_id, int $to_user_id, string $message, DateTime $date_sent, bool $is_direct) {
        $this->id_message = $id_message;
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->message = $message;
        $this->date_sent = $date_sent;
        $this->is_direct = $is_direct;
    }

    public function getIdMessage(): int {
        return $this->id_message;
    }

    public function setIdMessage(int $id_message): void {
        $this->id_message = $id_message;
    }

    public function getFromUserId(): int {
        return $this->from_user_id;
    }

    public function setFromUserId(int $from_user_id): void {
        $this->from_user_id = $from_user_id;
    }

    public function getToUserId(): int {
        return $this->to_user_id;
    }

    public function setToUserId(int $to_user_id): void {
        $this->to_user_id = $to_user_id;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function getDateSent(): DateTime {
        return $this->date_sent;
    }

    public function setDateSent(DateTime $date_sent): void {
        $this->date_sent = $date_sent;
    }

    public function getIsDirect(): bool {
        return $this->is_direct;
    }

    public function setIsDirect(bool $is_direct): void {
        $this->is_direct = $is_direct;
    }
}

?>