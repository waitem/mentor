<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'User');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
                    /*
                     * Tenant 1
                     */
                // The superadmin - if he/she can't log in, we've got big problems
		array(
			'id' => 1,
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 1,
			'user_status_id' => 7,
                        // Note that a superadmin doesn't have a parent, so the parent_id can be null
			'parent_id' => NULL,
			'second_mentor_id' => NULL,
			'email' => 'superadmin@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Superadmin1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
		array(
			'id' => 2,
                        // Inactive !
			'active' => 0,
			'tenant_id' => 1,
			'roletype_id' => 2,
			'user_status_id' => 8,
			'parent_id' => 1,
			'second_mentor_id' => NULL,
			'email' => 'admin1@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 3,
                        // Active admin
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 2,
			'user_status_id' => 9,
			'parent_id' => 1,
			'second_mentor_id' => NULL,
			'email' => 'admin2@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin2',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 6,
                        // Active coordinator
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 3,
			'user_status_id' => 9,
			'parent_id' => 3,
			'second_mentor_id' => NULL,
			'email' => 'coordinator1@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Coordinator1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 10,
                        // Inactive coordinator
			'active' => 0,
			'tenant_id' => 1,
			'roletype_id' => 3,
			'user_status_id' => 11,
			'parent_id' => 3,
			'second_mentor_id' => NULL,
			'email' => 'coordinator2@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Coordinator2',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 7,
                        // Active mentor
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 4,
			'user_status_id' => 15,
			'parent_id' => 6,
			'second_mentor_id' => NULL,
			'email' => 'mentor1@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Mentor1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 8,
                        // Active mentor
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 4,
			'user_status_id' => 15,
			'parent_id' => 6,
			'second_mentor_id' => NULL,
			'email' => 'mentor2@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Mentor2',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 9,
                        // Active mentee
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 5,
			'user_status_id' => 4,
			'parent_id' => 7,
			'second_mentor_id' => 8,
			'email' => 'mentee1@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Mentee1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),            
                    
                // TENANT 2
                // admin1
		array(
			'id' => 4,
			'active' => 1,
			'tenant_id' => 2,
			'roletype_id' => 2,
			'user_status_id' => 9,
			'parent_id' => 1,
			'second_mentor_id' => NULL,
			'email' => 'admin1@tenant2.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin1',
			'last_name' => 'Tenant2',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),            
                            // admin2
		array(
			'id' => 5,
			'active' => 1,
			'tenant_id' => 2,
			'roletype_id' => 2,
			'user_status_id' => 9,
			'parent_id' => 1,
			'second_mentor_id' => NULL,
			'email' => 'admin2@tenant2.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin2',
			'last_name' => 'Tenant2',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),            
	);
                
}
