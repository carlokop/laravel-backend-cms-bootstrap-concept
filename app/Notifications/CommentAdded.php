<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class CommentAdded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return explode(',', $notifiable->notification_preference);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Someone posted an comment on a article')
                    ->line('This comment needs to be approved before it is puplished')
                    ->action('View comment', route('admin.comments'));
    }

    public function toDatabase($notifiable)
    {

        $user = User::findOrFail($this->comment->user->id);

        return [
            'notification' => 'Comment from',
            'commentId' => $this->comment->id,
            'post' => $this->comment->posts->first()->title,
            'userImg' => $user->get_gravatar($user->email, $s = 32, $d = 'mp', $r = 'g'),
            'userName' => $user->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            ''
        ];
    }






}
