<?php

namespace App\Console\Commands;

use App\Models\HelloWorld;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeHelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume-hello-world';
    private $channel = 'msg:hello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            HelloWorld::create(['msg' => $msg->body]);
        };

        $channel->exchange_declare('test_exchange', 'direct', false, false, false);

        // Mendeklarasikan antrean dengan nama 'test_queue'
        $channel->queue_declare('test_queue', false, false, false, false);

        // Mengikat antrean 'test_queue' ke pertukaran 'test_exchange' dengan kunci 'test_key'
        $channel->queue_bind('test_queue', 'test_exchange', 'test_key');

        $channel->basic_consume('test_queue', '', false, true, false, false, $callback);

        echo 'Waiting for new message on test_queue', " \n";

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
