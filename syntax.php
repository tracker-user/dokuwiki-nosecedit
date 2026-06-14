<?php

use dokuwiki\Extension\SyntaxPlugin;

if (!defined('DOKU_INC')) die();

/**
 * DokuWiki Plugin nosecedit (Syntax Component)
 *
 * Flags a page in its render metadata so the action component can suppress
 * the page's section/table edit buttons.
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps
 * @author  einhirn
 */
class syntax_plugin_nosecedit extends SyntaxPlugin
{
    /**
     * @return string Syntax mode type
     */
    public function getType()
    {
        return 'substition';
    }

    /**
     * @return int Sort order in which the plugin is executed
     */
    public function getSort()
    {
        return 155;
    }

    /**
     * Connect lookup pattern to lexer
     *
     * @param string $mode Parser mode
     * @return void
     */
    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('~~NOSECTIONEDIT~~', $mode, 'plugin_nosecedit');
    }

    /**
     * Handle matches of the nosecedit syntax. Returns a non-false marker so
     * the instruction is kept; no payload is needed because render() only runs
     * when the token was present.
     *
     * @param string       $match   The text matched by the patterns
     * @param int          $state   The lexer state for the match
     * @param int          $pos     The character position of the matched text
     * @param Doku_Handler $handler The Doku_Handler object
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        return [];
    }

    /**
     * Record the flag in non-persistent (current) metadata. Current metadata is
     * rebuilt from the persistent baseline on every render
     * (Doku_Renderer_metadata::document_start), so removing the token clears the
     * flag automatically on the next render — no reset bookkeeping required.
     *
     * @param string        $format   Output format being rendered
     * @param Doku_Renderer $renderer The current renderer object
     * @param array         $data     Data created by handle()
     * @return bool If rendering was successful
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        if ($format === 'metadata') {
            $renderer->meta['plugin']['nosecedit'] = true;
        }
        return true;
    }
}
