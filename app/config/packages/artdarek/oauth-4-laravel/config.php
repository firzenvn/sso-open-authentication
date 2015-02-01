<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '616393551790615',
            'client_secret' => '6242aca665709786b56ac23a960b4acc',
            'scope'         => array('email','read_friendlists','user_online_presence'),
        ),
		'Google' => array(
			'client_id'     => '509400699012-vo18vph8q341a3sj2klood5t0imq5m8l.apps.googleusercontent.com',
			'client_secret' => '0VBpQGj0CbITglt0DacYlqBi',
			'scope'         => array('userinfo_email', 'userinfo_profile'),
		),

	)

);