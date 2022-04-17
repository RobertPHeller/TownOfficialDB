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
 *  Last Modified : <220417.1712>
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

use Joomla\String\StringHelper;

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
    
    return $this->_insertOfficials($item->text,$params);
    
  }
  /**
    * Insert Officials
    *
    * @param   string  &$text    The string to be updated.
    * @param   mixed   &$params  Additional parameters. Parameter "mode" (integer, default 1)
    *                             replaces addresses with "mailto:" links if nonzero.
    *
    * @return  boolean  True on success.
    */
  protected function _insertOfficials(&$text, &$params)
  {
    // Simple performance check to determine whether bot should process further.
    if (StringHelper::strpos($text, '{TownOfficial') === false)
    {
      return true;
    }
    $pattern = '/{TownOfficial[[:space:]]+([^}]*)}/';
    while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
    {
      file_put_contents("php://stderr","*** PlgContentTownOfficialDB::_insertOfficials: regs is ".print_r($regs,true)."\n");
      parse_str($regs[1][0],$officialParams);
      file_put_contents("php://stderr","*** -: officialParams is ".print_r($officialParams,true)."\n");
      // Dummy for now
      if (array_key_exists ('office', $officialParams))
      {
        switch ($officialParams['office'])
        {
        case 'Selectboard':
          $replacement = "<p>Laurie DiDonato: 2024<br />Gillian Budine 2022<br />Dan Keller 2023</p>";
          break;
        default:
          $replacement = "";
          break;
        }
      } else 
      {
        $replacement = "";
      }
      $text = substr_replace($text, $replacement, $regs[0][1], strlen($regs[0][0]));
    }
    return true;
  }
  
}

