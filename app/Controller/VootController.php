<?php
/**
 * COmanage Registry CO VOOT Controller **EXPERIMENTAL**
 *
 * Copyright (C) 2012 University Corporation for Advanced Internet Development, Inc.
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
 * @copyright     Copyright (C) 2012 University Corporation for Advanced Internet Development, Inc.
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry
 * @since         COmanage Registry v0.6
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version       $Id$
 */

App::import('Sanitize');
App::uses("StandardController", "Controller");

/* This is an experimental controller that implements basic read-only support
 * for the VOOT protocol. The protocol itself (which is based on OpenSocial)
 * is evolving, so the functionality in this Controller should not be relied on
 * in a production fashion. (July 2012)
 *
 * This controller only supports REST transactions.
 */

class VootController extends StandardController {
  // Class name, used by Cake
  public $name = "Voot";
  
  public $uses = array('CoGroup', 'CoGroupMember', 'CoPerson');
  
  // The subject of this request
  private $coPersonIdReq = null;
  private $coGroupIdReq = null;
  
  /**
   * Callback before other controller methods are invoked or views are rendered.
   *
   * @since  COmanage Registry v0.6
   * - postcondition: On error HTTP status returned (REST)
   * - postcondition: VOOT identifiers mapped
   */   
  
  function beforeFilter() {
    // Force restful, since by definition we are
    $this->restful = true;
    
    // Run the auth check
    parent::beforeFilter();
    
    if(isset($this->params['memberid'])) {
      // Map the provided identifier to one or more CO Person IDs.
      
      try {
        // XXX We should really provide an identifier type. Instead, we'll just
        // take the first person returned.
        $coppl = $this->CoPerson->idsForIdentifier($this->params['memberid'], null);
        
        if(!empty($coppl)) {
          $this->coPersonIdReq = $coppl[0];
        }
      }
      catch(InvalidArgumentException $e) {
        if($e->getMessage() == _txt('er.id.unk')) {
          $this->restResultHeader(404, "Identifier Unknown");
        } else {
          $this->restResultHeader(404, "CO Person Unknown");
        }
        $this->response->send();
        exit;
      }
    } else {
      $this->restResultHeader(400, "Bad Request");
      $this->response->send();
      exit;
    }
    
    // We just copy the Group ID if set
    if(isset($this->params['groupid'])) {
      $this->coGroupIdReq = $this->params['groupid'];
    }
  }

  /**
   * Callback before views are rendered.
   * - precondition: None
   * - postcondition: content and permissions for menu are set
   *
   * @since  COmanage Registry v0.6
   */
  
  function beforeRender() {
    parent::beforeRender();
    
    // Force the response to json (Cake wants to set it to text/html since our requests don't have a .json extension)
    $this->RequestHandler->renderAs($this, 'json');
  }
  
  /**
   * Obtain CO Groups as per a VOOT request.
   * - postcondition: $co_people, $co_group_members set (REST)
   * - postcondition: HTTP status returned (REST)
   *
   * @since  COmanage Registry v0.6
   */

  function groups() {
    $groups = array();
    
    if(isset($this->coPersonIdReq)) {
      // Pull member/owner status for this person's groups.
      $memberships = $this->CoGroupMember->findCoPersonGroupRoles($this->coPersonIdReq);
      
      if(isset($this->coGroupIdReq)) {
        // Just see if this person is a member of this group. We can check $memberships
        
        if((isset($memberships['member']) && in_array($this->coGroupIdReq, $memberships['member']))
           || (isset($memberships['owner']) && in_array($this->coGroupIdReq, $memberships['owner']))) {
          $args = array();
          $args['conditions']['CoGroup.id'] = $this->coGroupIdReq;
          $args['contain'] = false;
          
          $groups = $this->CoGroup->find('all', $args);
        }
      } else {
        // Pull all groups this person is a member of
        
        $count = isset($this->params->query['count']) ? $this->params->query['count'] : null;
        $startIndex = isset($this->params->query['startIndex']) ? $this->params->query['startIndex'] : null;
        $sortBy = null;
        
        if(isset($this->params->query['sortBy'])) {
          // Map the provided VOOT label to the COmanage field name
          
          switch($this->params->query['sortBy']) {
            case 'description':
              $sortBy = 'CoGroup.description';
              break;
            case 'id':
              $sortBy = 'CoGroup.id';
              break;
            case 'title':
              $sortBy = 'CoGroup.name';
              break;
            default:
              // Do no sort
              break;
          }
        }
        
        $groups = $this->CoGroup->findForCoPerson($this->coPersonIdReq,
                                                  $count,
                                                  $startIndex,
                                                  $sortBy);
      }
      
      // Always set co_groups, even if empty
      $this->set('co_groups', $groups);
      
      // We also need to pass member/ownership in these groups for the view
      $this->set('co_group_members', $memberships);
      $this->restResultHeader(200, "OK");
    } else {
      $this->restResultHeader(400, "Bad Request");
    }
  }
  
  /**
   * Obtain CO People as per a VOOT request.
   * - postcondition: $co_people, $co_group_members, $co_group_owners set (REST)
   * - postcondition: HTTP status returned (REST)
   *
   * @since  COmanage Registry v0.6
   */

  function people() {
    $people = array();
    
    if(isset($this->coGroupIdReq)) {
      $people = $this->CoPerson->findForCoGroup($this->coGroupIdReq,
                                                isset($this->params->query['count']) ? $this->params->query['count'] : null,
                                                isset($this->params->query['startIndex']) ? $this->params->query['startIndex'] : null);
      
      // Always set co_people, even if empty
      $this->set('co_people', $people);
      
      // We also need to pass member/ownership in these groups for the view.
      // Note we do this differently than above for no particular reason.
      $args = array();
      $args['conditions']['CoGroupMember.co_group_id'] = $this->coGroupIdReq;
      $args['conditions']['CoGroupMember.member'] = true;
      $args['fields'][] = 'CoGroupMember.co_person_id';
      
      $this->set('co_group_members', array_values($this->CoGroupMember->find('list', $args)));
      
      $args = array();
      $args['conditions']['CoGroupMember.co_group_id'] = $this->coGroupIdReq;
      $args['conditions']['CoGroupMember.owner'] = true;
      $args['fields'][] = 'CoGroupMember.co_person_id';
      
      $this->set('co_group_owners', array_values($this->CoGroupMember->find('list', $args)));
      $this->restResultHeader(200, "OK");
    } else {
      $this->restResultHeader(400, "Bad Request");
    }
  }
  
  /**
   * Authorization for this Controller, called by Auth component
   * - precondition: Session.Auth holds data used for authz decisions
   * - postcondition: $permissions set with calculated permissions
   *
   * @since  COmanage Registry v0.6
   * @return Array Permissions
   */
  
  function isAuthorized() {
    $cmr = $this->calculateCMRoles();                      // What was authenticated
    
    // Perform various VOOT retrievals?
    $p['groups'] = ($cmr['cmadmin'] || $cmr['coadmin'] || $cmr['comember']);
    $p['people'] = ($cmr['cmadmin'] || $cmr['coadmin'] || $cmr['comember']);
    
    $this->set('permissions', $p);
    return($p[$this->action]);
  }
}
