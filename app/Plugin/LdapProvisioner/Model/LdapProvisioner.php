<?php
/**
 * COmanage Registry LDAP Provisioner Model
 *
 * Portions licensed to the University Corporation for Advanced Internet
 * Development, Inc. ("UCAID") under one or more contributor license agreements.
 * See the NOTICE file distributed with this work for additional information
 * regarding copyright ownership.
 *
 * UCAID licenses this file to you under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License. You may obtain a copy of the License at:
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry-plugin
 * @since         COmanage Registry v0.8
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

class LdapProvisioner extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "provisioner";

  // Document foreign keys
  /* As of CO-950, we no longer use dependency delete. We delete the DN manually
   * when the CO Person or CO Group is finally deleted.
  public $cmPluginHasMany = array(
    "CoGroup"  => array("CoLdapProvisionerDn"),
    "CoPerson" => array("CoLdapProvisionerDn")
  );*/
  
  /**
   * Expose menu items.
   * 
   * @ since COmanage Registry v0.9.2
   * @ return Array with menu location type as key and array of labels, controllers, actions as values.
   */
  public function cmPluginMenus() {
  	return array();
  }
}
