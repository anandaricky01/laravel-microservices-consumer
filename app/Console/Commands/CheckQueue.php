<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CheckQueue extends Command
{
    protected $signature = 'queue:check';
    protected $description = 'Check messages in the queue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $queueName = 'msg:hello'; // Replace with your queue name

        $channel->queue_declare($queueName, false, true, false, false);

        $this->info("Messages in the '$queueName' queue:");

        $callback = function ($msg) {
            $this->line($msg->body);
        };

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
