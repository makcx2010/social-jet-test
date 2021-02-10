<?php

return [
    \core\events\telegram\InviteToResourceIsSentEvent::class => [
        \core\listeners\telegram\InviteToResourceIsSentListener::class
    ]
];
