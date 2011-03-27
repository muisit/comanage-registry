<!--
  /*
   * COmanage Gears CO Extended Attribute Index View
   *
   * Version: $Revision$
   * Date: $Date$
   *
   * Copyright (C) 2011 University Corporation for Advanced Internet Development, Inc.
   * 
   * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with
   * the License. You may obtain a copy of the License at
   * 
   * http://www.apache.org/licenses/LICENSE-2.0
   * 
   * Unless required by applicable law or agreed to in writing, software distributed under
   * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
   * KIND, either express or implied. See the License for the specific language governing
   * permissions and limitations under the License.
   *
   */
-->
<h1 class="ui-state-default"><?php echo $title_for_layout; ?></h1>

<?php
  if($permissions['add'])
    echo $this->Html->link(_txt('op.add') . ' ' . _txt('ct.co_extended_attributes.1'),
                           array('controller' => 'co_extended_attributes',
                                 'action' => 'add',
                                 'co' => $this->params['named']['co']),
                           array('class' => 'addbutton')) . '
    <br />
    <br />
    ';
?>

<table id="cos" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php echo $this->Paginator->sort(_txt('fd.name'), 'name'); ?></th>
      <th><?php echo $this->Paginator->sort(_txt('fd.name.d'), 'display_name'); ?></th>
      <th><?php echo $this->Paginator->sort(_txt('fd.type'), 'type'); ?></th>
      <th><?php echo $this->Paginator->sort(_txt('fd.index'), 'index'); ?></th>
      <th><?php echo _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($co_extended_attributes as $c): ?>
    <tr class="line<?php print ($i % 2)+1; ?>">
      <td>
        <?php
          echo $html->link($c['CoExtendedAttribute']['name'],
                           array('controller' => 'co_extended_attributes',
                                 'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')),
                                 $c['CoExtendedAttribute']['id'],
                                 'co' => $this->params['named']['co']));
        ?>
      </td>
      <td><?php echo Sanitize::html($c['CoExtendedAttribute']['display_name']); ?></td>
      <td><?php echo Sanitize::html($c['CoExtendedAttribute']['type']); ?></td>
      <td>
        <?php echo $c['CoExtendedAttribute']['index'] ? _txt('fd.yes') : _txt('fd.no'); ?>
      </td>
      <td>
        <?php
          if($permissions['edit'])
            echo $html->link(_txt('op.edit'),
                             array('controller' => 'co_extended_attributes',
                                   'action' => 'edit',
                                   $c['CoExtendedAttribute']['id'],
                                   'co' => $this->params['named']['co']),
                             array('class' => 'editbutton')) . "\n";
            
          if($permissions['delete'])
            echo '<button class="deletebutton" title="' . _txt('op.delete') . '" onclick="javascript:js_confirm_delete(\'' . Sanitize::html($c['CoExtendedAttribute']['name']) . '\', \'' . $html->url(array('controller' => 'co_extended_attributes', 'action' => 'delete', $c['CoExtendedAttribute']['id'], 'co' => $this->params['named']['co'])) . '\')";>' . _txt('op.delete') . '</button>';
        ?>
        <?php ; ?>
      </td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
  
  <tfoot>
    <tr class="ui-widget-header">
      <th colspan="5">
        <?php echo $this->Paginator->numbers(); ?>
      </td>
    </tr>
  </tfoot>
</table>