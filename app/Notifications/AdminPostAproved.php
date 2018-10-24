<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminPostAproved extends Notification implements ShouldQueue
{
    use Queueable;
    private  $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     0*/
    public function toMail($notifiable)
    {
        return (new MailMessage)
                     ->greeting('hello '. $this->post->user->name.'!')
                     ->subject('post approved')
                     ->line('your post has been aproved by Admin')
                    ->line('title : ' .$this->post->title)
                            ->action('See', url(route('author.post.show', $this->post->id)))
                    ->line('Thank you for posting your valuable posts');
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
            //
        ];
    }
}
