====== NoSectionEdit Plugin for DokuWiki ======

Disable the section and table **edit buttons** on individual pages.

===== Usage =====

Place the following anywhere in a page:

  ~~NOSECTIONEDIT~~

That page will then render **without** its section edit buttons (the small
*Edit* links next to each heading) and **without** table edit buttons. The
token itself produces no visible output. Editing the whole page via the normal
page-edit button is unaffected.

Removing the token restores the buttons automatically the next time the page is
rendered.

===== How it works =====

  * The syntax component records a flag in the page's render metadata
    (''plugin.nosecedit'') whenever the token is present. The flag is stored in
    non-persistent (current) metadata, so it is rebuilt on every render and
    clears by itself once the token is removed.
  * The action component hooks ''HTML_SECEDIT_BUTTON'' and, for ''section'' and
    ''table'' targets on a flagged page, blanks the button name so DokuWiki
    outputs no button.

===== Changes =====

Reviewed for DokuWiki Librarian (PHP 8.3):

  * Removed disk I/O from the syntax constructor; the flag is now written only
    during the ''metadata'' render pass.
  * Switched the flag to non-persistent metadata so removing the token clears it
    automatically (previously it could stick to ''off'').
  * Namespaced the metadata under ''plugin.nosecedit''.
  * Modernized to namespaced ''SyntaxPlugin''/''ActionPlugin'' base classes,
    added ''DOKU_INC'' guards, docblocks, strict comparisons.

===== License =====

(c) 2013 by lisps

See LICENSE for license info.
