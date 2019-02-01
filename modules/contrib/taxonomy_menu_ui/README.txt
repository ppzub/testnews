INTRODUCTION
------------

The Taxonomy Menu UI module creates menu items on a Taxonomy term page in
Drupal 8. This functionality is similar to creating menu items for node. This
module enables the "Available Menus" options on the Taxonomy vocabulary page.
Then on the Taxonomy term add/edit form the user can set the menu item for that
term, just like on the node add/edit form.

 * For a full description of the module visit:
   https://www.drupal.org/project/taxonomy_menu_ui

 * To submit bug reports and feature suggestions, or to track changes visit:
   https://www.drupal.org/project/issues/taxonomy_menu_ui


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


INSTALLATION
------------

 * Install the Taxonomy Menu UI module as you would normally install a
   contributed Drupal module. Visit https://www.drupal.org/node/1897420 for
   further information.


CONFIGURATION
-------------

    1. Navigate to Administration > Extend and enable the module.
    2. Navigate to Administration > Structure > Taxonomy. Configure per Taxonomy
       vocabulary on the "Menu Settings" tab, editing your available menus and
       default parent item. Save.
    3. Navigate to Administration > Structure > Taxonomy. Configure per Taxonomy
       term on the "Menu Settings" tab, editing your menu link title, parent
       item and weight. Save.

The functionality is similar to the "Menu Settings" tab for node.


MAINTAINERS
-----------

 * Kirill Loboda (madlobz) - https://www.drupal.org/u/madlobz
