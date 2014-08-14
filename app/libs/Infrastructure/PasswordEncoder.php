<?php

class PasswordEncoder {
	/**
	 * @param string $password
	 * @return string
	 */
	public function encode($password) {
		return crypt($password, 'MF' . md5($password));
	}
}
