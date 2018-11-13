<?php

namespace core;

class baseController
{
	public function validate($data, $rules)
	{
		$validator = new validator();
		$validator->make($data, $rules);
		if ($validator->getErrors()) {
			session::flush('errors', $validator->getErrors());
			session::flush('old', $data);
			redirect(session::get('previous_url'))->setHeader();
			exit;
		}
	}
}