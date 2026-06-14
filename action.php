<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Extension\Event;

if (!defined('DOKU_INC')) die();

/**
 * DokuWiki Plugin nosecedit (Action Component)
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps
 * @author  einhirn
 */
class action_plugin_nosecedit extends ActionPlugin
{
    /**
     * Register its handlers with the DokuWiki's event controller
     *
     * @param EventHandler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(EventHandler $controller)
    {
        $controller->register_hook('HTML_SECEDIT_BUTTON', 'BEFORE', $this, 'handleSeceditButton');
    }

    /**
     * Suppress section/table edit buttons on pages flagged with ~~NOSECTIONEDIT~~.
     *
     * Blanking the button name makes the core default handler
     * (html_secedit_get_button) return an empty string, so no button is output.
     *
     * @param Event $event HTML_SECEDIT_BUTTON event
     * @return void
     */
    public function handleSeceditButton(Event $event)
    {
        global $ID;

        $target = $event->data['target'] ?? '';
        if ($target !== 'section' && $target !== 'table') {
            return;
        }

        if (p_get_metadata($ID, 'plugin nosecedit', false)) {
            $event->data['name'] = '';
        }
    }
}
