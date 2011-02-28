<?php
  /*
   * COmanage Gears Standard Add View
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

  // Get a pointer to our model
  $model = $this->name;
  $req = Inflector::singularize($model);
  $modelpl = Inflector::tableize($req);
?>
<h1 class="ui-state-default"><?php echo _txt('op.add.new', array(_txt('ct.'.$modelpl.'.1'))); ?></h1>

<?php
  $submit_label = _txt('op.add');
  echo $this->Form->create($req,
                           array('action' => 'add',
                                 'inputDefaults' => array('label' => false, 'div' => false)));
  include("views/" . $modelpl . "/fields.inc");
  echo $this->Form->end();
?>