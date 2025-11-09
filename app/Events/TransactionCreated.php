<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // 👈 important
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated implements ShouldBroadcast // 👈 implement interface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Channel name to broadcast to.
     */
    public function broadcastOn(): array
    {
        // You can change this to 'branch.'.$this->transaction->branch_id if you want branch-specific updates
        return [new Channel('transactions')];
    }

    /**
     * Event name for frontend
     */
    public function broadcastAs(): string
    {
        return 'transaction.created';
    }
}
