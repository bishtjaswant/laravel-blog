<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class newAuthorPost extends Notification implements  ShouldQueue
{
    use Queueable;
    private $post;

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
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                  ->greeting('Hello admin')
                     ->subject('new post aproval needed')
                    ->line('your approval needed')
                    ->line('New Post upload by'. $this->post->user->name . '.!')
                    ->line('The introduction to the notification.')
                   ->line('to approve this post clivck thde view button')
                    ->line('Title :'. $this->post->title)
                    ->action('View', url(route('admin.post.show', $this->post->id)))
                    ->line('Thank you !');
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
