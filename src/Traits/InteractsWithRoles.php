<?php


namespace Jdlabs\Spaniel\Traits;


use Betsbrothers\Integration\Plugin;

trait InteractsWithRoles
{
    /**
     * Add the player role
     */
    public function addPlayerRole()
    {
        add_role(
            Plugin::PLAYER_ROLE,
            'Player'
        );
    }
}