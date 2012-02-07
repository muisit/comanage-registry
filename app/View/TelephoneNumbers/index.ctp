<!--
/**
 * COmanage Registry Telephone Number Index View
 *
 * Copyright (C) 2010-12 University Corporation for Advanced Internet Development, Inc.
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
 * @since         COmanage Registry v0.1
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version       $Id$
 */
-->
<h1 class="ui-state-default"><?php echo _txt('ct.telephone_numbers.pl'); ?></h1>

<table id="telephone_numbers" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php echo $this->Paginator->sort('number', _txt('fd.phone')); ?></th>
      <th><?php echo $this->Paginator->sort('type', _txt('fd.type')); ?></th>
      <!-- XXX Following needs to be I18N'd, and also render a full name, if index view sticks around -->
      <th><?php echo $this->Paginator->sort('OrgIdentity.Name.family', 'Org Identity'); ?></th>
      <th><?php echo $this->Paginator->sort('CoPersonRole.Name.family', 'CO Person Role'); ?></th>
      <th><?php echo _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($telephone_numbers as $t): ?>
    <tr class="line<?php print ($i % 2)+1; ?>">
      <td>
        <?php
          echo $this->Html->link($t['TelephoneNumber']['number'],
                                 array('controller' => 'telephone_numbers',
                                       'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')), $t['TelephoneNumber']['id']));
        ?>
      </td>
      <td>
        <?php echo _txt('en.contact', null, $t['TelephoneNumber']['type']); ?>
      </td>
      <td>
        <?php
          if(!empty($t['TelephoneNumber']['org_identity_id']))
          {
            // Generally, someone who has view permission on a telephone number can also see a person
            if($permissions['view'])
              echo $this->Html->link(generateCn($t['OrgIdentity']['Name']),
                                     array('controller' => 'org_identities', 'action' => 'view', $t['OrgIdentity']['id'])) . "\n";
          }
        ?>
      </td>
      <td>
        <?php
          if(!empty($t['TelephoneNumber']['co_person_role_id']))
          {
            // Generally, someone who has view permission on a telephone number can also see a person
            if($permissions['view'])
              echo $this->Html->link(generateCn($t['CoPersonRole']['Name']),
                                     array('controller' => 'co_person_roles', 'action' => 'view', $t['CoPersonRole']['id'])) . "\n";
          }
        ?>
      </td>    
      <td>    
        <?php
          if($permissions['edit'])
            echo $this->Html->link('Edit',
                                   array('controller' => 'telephone_numbers', 'action' => 'edit', $t['TelephoneNumber']['id']),
                                   array('class' => 'editbutton')) . "\n";
            
            
          if($permissions['delete'])
            echo '<button class="deletebutton" title="' . _txt('op.delete') . '" onclick="javascript:js_confirm_delete(\'' . _jtxt(Sanitize::html($t['TelephoneNumber']['number'])) . '\', \'' . $this->Html->url(array('controller' => 'telephone_numbers', 'action' => 'delete', $t['TelephoneNumber']['id'])) . '\')";>' . _txt('op.delete') . '</button>';
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