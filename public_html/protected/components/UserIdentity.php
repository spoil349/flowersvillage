<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	

		
		$user=Users::model()->findByAttributes(array('username'=>$this->username));
		if($user == NULL)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($user->password !=md5($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->errorCode=self::ERROR_NONE; 
			Yii::app()->user->setState( 'isAdmin', $user->superuser );
			Yii::app()->user->setState( 'auth', true);
		}
		return !$this->errorCode;
	}
	
	public function authenticateforpass($password)
	{
		$user=Users::model()->findAll('status = 1');
		if($user == NULL)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else {
			if(count($user) > 0 ){
				$auth = false;				
				foreach ($user as $V){
					if ( $V['password'] == md5($password.$V['so'])){
						$this->errorCode=self::ERROR_NONE;
						Yii::app()->user->setState( 'isAdmin', $V['superuser'] );
						Yii::app()->user->setState( 'auth', true);
						Yii::app()->user->setState( 'edit', false);
						Yii::app()->user->setState( 'username', $V['username']);
					}
				} 				

			} else $this->errorCode=self::ERROR_USERNAME_INVALID;
						
		}
		return !$this->errorCode;
	}
}