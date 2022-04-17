<?php
/* -*- php -*- ****************************************************************
 *
 *  System        : 
 *  Module        : 
 *  Object Name   : $RCSfile$
 *  Revision      : $Revision$
 *  Date          : $Date$
 *  Author        : $Author$
 *  Created By    : Robert Heller
 *  Created       : Sun Apr 17 14:12:54 2022
 *  Last Modified : <220417.1414>
 *
 *  Description	
 *
 *  Notes
 *
 *  History
 *	
 ****************************************************************************
 *
 *    Copyright (C) 2022  Robert Heller D/B/A Deepwoods Software
 *			51 Locke Hill Road
 *			Wendell, MA 01379-9728
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * 
 *
 ****************************************************************************/

defined('_JEXEC') or die();

class PlgContentTownOfficialDB extends JPlugin
{
  /**
    * Plugin that shows a custom field
    *
    * @param   string  $context  The context of the content being passed to the plugin.
    * @param   object  &$item    The item object.  Note $article->text is also available
    * @param   object  &$params  The article params
    * @param   int     $page     The 'page' number
    *
    * @return void
    *
    * @since  3.7.0
    */
  public function onContentPrepare($context, &$item, &$params, $page = 0)
  {
    // If the item has a context, overwrite the existing one
    if ($context == 'com_finder.indexer' && !empty($item->context))
    {
      $context = $item->context;
    }
    elseif ($context == 'com_finder.indexer')
    {
      // Don't run this plugin when the content is being indexed and we have no real context
      return;
    }
    
    // Don't run if there is no text property (in case of bad calls) or it is empty
    if (empty($item->text))
    {
      return;
    }
    
    // Simple performance check to determine whether bot should process further
    if (strpos($item->text, 'field') === false)
    {
      return;
    }
    
  }
}

