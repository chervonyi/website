<?php
	return array (
		'^user/register$' => 'user/register',
		'^user/login$' => 'user/login',
		'^user/logout$' => 'user/logout',

		'^cabinet/edit$' => 'cabinet/edit',
		'^cabinet/password$' => 'cabinet/password',
		'^cabinet$' => 'cabinet/index',

		'^tickets/buy$' => 'ticket/buy',

		'^flights/([0-9]+)' => 'flight/view/$1',
		'^flights$' => 'flight/search',

		'^$' => 'site/index'
	);
?>
