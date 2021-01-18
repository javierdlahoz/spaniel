<?php

return [
    '^myroute/(.+)/(.+)/?' => [
        'target' => 'index.php?pagename=play&provider=$matches[1]&game=$matches[2]',
        'priority' => 'top',
        'tags' => [
            'param1',
            'param2'
        ]
    ]  
];