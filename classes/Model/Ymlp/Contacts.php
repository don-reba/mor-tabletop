<?php

require_once dirname(__FILE__).'/../../Ymlp.php';

class Model_Ymlp_Contacts extends Ymlp
{
	public function add($email, $groupId, $overruleUnsubscribedBounced = 1, array $fields = array() )
	{
		$this->_method = 'Contacts.Add';

		$this->_params = array(
			'Email' => &$email,
			'GroupID' => $groupId,
			'OverruleUnsubscribedBounced' => $overruleUnsubscribedBounced,
		);

		if (FALSE === empty($fields) )
		{
			foreach ($fields as $key => &$value)
			{
				$this->params[$key] = &$value;
			}
		}

		return $this->execute();
	}

	public function delete($email, $groupId)
	{
		$this->_method = 'Contacts.Delete';

		$this->_params = array
		(
			'Email' => &$email,
			'GroupID' => $groupId,
		);

		return $this->execute();
	}
};
