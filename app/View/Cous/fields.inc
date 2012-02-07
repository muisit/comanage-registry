<!--
/**
 * COmanage Registry COU Fields
 *
 * Copyright (C) 2011-12 University Corporation for Advanced Internet Development, Inc.
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
 * @copyright     Copyright (C) 2011-12 University Corporation for Advanced Internet Development, Inc.
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry
 * @since         COmanage Registry v0.2
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version       $Id$
 */
-->
<?php

  // Determine if fields are editable
  $e = false;
  
  if(($this->action == "add" && $permissions['add']) || ($this->action == "edit" && $permissions['edit']))
    $e = true;
    
  // We shouldn't get here if we don't have at least read permission, but check just in case
  
  if(!$e && !$permissions['view'])
    return(false);
    
  if($e)
    print $this->Html->link(
      _txt('op.cancel'),
      array('controller' => 'cous', 'action' => 'index', 'co' => $cur_co['Co']['id']),
      array('class' => 'cancelbutton')
    );
  else
    print $this->Html->link(
      _txt('op.back'),
      array('controller' => 'cous', 'action' => 'index', 'co' => $cur_co['Co']['id']),
      array('class' => 'backbutton')
    );
    
  echo '
    <br />
    <br />
    ';
    
  if(isset($cur_co))
    print $this->Form->hidden('co_id', array('default' => $cur_co['Co']['id'])) . "\n";
?>
<table id="<?php echo $this->action; ?>_cou" class="ui-widget">
  <tbody>
    <tr class="line1">
      <td>
        <?php echo _txt('fd.name'); ?><font class="required">*</font>
      </td>
      <td>
        <?php echo ($e ? $this->Form->input('name') : Sanitize::html($cous[0]['Cou']['name'])); ?>
      </td>
    </tr>
    <tr class="line2">
      <td>
        <?php echo _txt('fd.desc'); ?>
      </td>
      <td>
        <?php echo ($e ? $this->Form->input('description') : Sanitize::html($cous[0]['Cou']['description'])); ?>
      </td>
    </tr>
    <tr class="line1">
      <td>
        <?php echo _txt('fd.parent'); ?>
      </td>
      <td>
        <?php
          print ($e ? $this->Form->select('parent_id', $this->viewVars['parent_options'])
                    : Sanitize::html($cous[0]['Cou']['parent_id']));
          
          if($this->Form->isFieldError('status')) {
            print $this->Form->error('status');
          }
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <i><font class="required"><?php echo _txt('fd.req'); ?></font></i><br />
      </td>
      <td>
        <?php
          if($e)
            echo $this->Form->submit($submit_label);
        ?>
      </td>
    </tr>
  </tbody>
</table>