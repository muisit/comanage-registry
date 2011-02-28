<?php
  /*
   * COmanage Gears Names Model
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

  class Name extends AppModel {
    // Define class name for cake
    var $name = "Name";
    
    // Association rules from this model to other models
    var $belongsTo = array("CoPerson",            // A name is attached to a CO Person
                           "OrgPerson");          // A name is attached to an Org Person
    
    // Default display field for cake generated views
    var $displayField = "family";
    
    // Default ordering for find operations
    var $order = array("family", "given");
    
    // Validation rules for table elements
    var $validate = array(
      'given' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'A given name must be provided'
      )
    );
  }
?>