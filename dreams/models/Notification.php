<?php

class Notification {
    private int $id_notification;
    private int $id_message;
    private int $from_user_id;
    private int $to_user_id;
    private string $message;
    private DateTime $date_created;
    private bool $is_read;

    public function __construct(int $id_notification, int $id_message, int $from_user_id, int $to_user_id, string $message, DateTime $date_created, bool $is_read) {
        $this->id_notification = $id_notification;
        $this->id_message = $id_message;
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->message = $message;
        $this->date_created = $date_created;
        $this->is_read = $is_read;
    }

    public function getIdNotification(): int {
        return $this->id_notification;
    }

    public function setIdNotification(int $id_notification): void {
        $this->id_notification = $id_notification;
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

    public function getDateCreated(): DateTime {
        return $this->date_created;
    }

    public function setDateCreated(DateTime $date_created): void {
        $this->date_created = $date_created;
    }

    public function isRead(): bool {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): void {
        $this->is_read = $is_read;
    }
}

?>