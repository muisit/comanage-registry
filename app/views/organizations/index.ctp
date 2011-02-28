<!--
  /*
   * COmanage Gears Organization Index View
   *
   * Version: $Revision$
   * Date: $Date$
   *
   * Copyright (C) 2010-2011 University Corporation for Advanced Internet Development, Inc.
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
<h1 class="ui-state-default"><?php echo _txt('ct.organizations.pl'); ?></h1>

<?php
  if($permissions['add'])
    echo $this->Html->link(_txt('op.add'),
                           array('controller' => 'organizations', 'action' => 'add'),
                           array('class' => 'addbutton')) . '
    <br />
    <br />
    ';
?>

<table id="organizations" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php echo $this->Paginator->sort(_txt('fd.name'), 'name'); ?></th>
      <th><?php echo $this->Paginator->sort(_txt('fd.domain'), 'domain'); ?></th>
      <th><?php echo $this->Paginator->sort(_txt('fd.directory'), 'directory'); ?></th>
      <th><?php echo _txt('fd.searchbase'); ?></th>
      <th><?php echo _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($organizations as $o): ?>
    <tr class="line<?php print ($i % 2)+1; ?>">
      <td><?php echo $html->link($o['Organization']['name'],
                                 array('controller' => 'organizations', 'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')), $o['Organization']['id'])); ?></td>
      <td><?php echo Sanitize::html($o['Organization']['domain']); ?></td>
      <td><?php echo Sanitize::html($o['Organization']['directory']); ?></td>
      <td><?php echo Sanitize::html($o['Organization']['search_base']); ?></td>
      <td>
        <?php
          echo $html->link(_txt('op.edit'),
                           array('controller' => 'organizations', 'action' => 'edit', $o['Organization']['id']),
                           array('class' => 'editbutton')) . "\n";
            
          if($permissions['delete'])
            echo '<button class="deletebutton" title="' . _txt('op.delete') . '" onclick="javascript:js_confirm_delete(\'' . Sanitize::html($o['Organization']['name']) . '\', \'' . $html->url(array('controller' => 'organizations', 'action' => 'delete', $o['Organization']['id'])) . '\')";>' . _txt('op.delete') . '</button>';
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