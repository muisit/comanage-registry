<?php
  /*
   * COmanage Gears Telephone Number Model
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

  class TelephoneNumber extends AppModel {
    // Define class name for cake
    var $name = "TelephoneNumber";
    
    // Association rules from this model to other models
    var $belongsTo = array("CoPerson",        // A telephone number may be attached to a CO person
                           "OrgPerson");      // A telephone number may be attached to an org person
    
    // Default display field for cake generated views
    var $displayField = "number";
    
    // Default ordering for find operations
    var $order = array("number");
    
    // Validation rules for table elements
    var $validate = array(
      // 'number' cake has telephone number validation, but US only
      // Don't require number or type since $belongsTo saves won't validate if they're empty
    );
    
    // Enum type hints
    
    var $cm_enum_types = array(
      'type' => 'contact_t'
    );
  }
?>