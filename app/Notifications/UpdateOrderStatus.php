<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateOrderStatus extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
            'broadcast',
        ];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'title' => trans('titles.order_status_update') . ': #' . $this->order->code,
                'message' => ($this->order->order_status_id == config('app.confirmed')) ?
                    trans('messages.order_accepted_at') .
                    formatDate($this->order->updated_at) . '' :
                    trans('messages.order_canceled_at') . formatDate($this->order->updated_at) . ' ',
                'link' => route('viewDetailOrder', ['id' => $this->order->id]),
            ],
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => trans('titles.order_status_update') . ': #' . $this->order->code,
            'message' => ($this->order->order_status_id == config('app.confirmed')) ?
                trans('messages.order_accepted_at') .
                formatDate($this->order->updated_at) . '' :
                trans('messages.order_canceled_at') . formatDate($this->order->updated_at) . ' ',
            'link' => route('viewDetailOrder', ['id' => $this->order->id]),
        ];
    }
}
