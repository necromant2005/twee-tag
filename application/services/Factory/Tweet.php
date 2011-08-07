<?php
namespace Application\Service\Factory;

use Application\Model as Model;

class Tweet
{
    public function create(\stdClass $data)
    {
        $tweet = new Model\Tweet;
        $tweet->setCreated($data->created_at);
        $tweet->setFrom($data->from_user);
        $tweet->setText($data->text);

        if ($data->geo) {
            $tweet->setLocation(new Model\Location($data->geo->coordinates[0], $data->geo->coordinates[1]));
        }
        return $tweet;
    }
}

