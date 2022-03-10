<?php

class cryption
{
  // konstante für Verschlüsselungsmethode
  const AES_256_CBC = 'aes-256-cbc';

  private $_secret_key = 'wod14fvpKKA@4GRqp#X!R7K!M^bY4QT1axDHQ';
  private $_secret_iv  = '!v6Qs45WGXtbeTr2aq*mwPLzp@QzTP1QlZ@';
  private $_encryption_key;
  private $_iv;

  // instanzvariablen initialisieren
  public function __construct()
  {
    $this->_encryption_key = hash('sha256', $this->_secret_key);
    $this->_iv             = substr(hash('sha256', $this->_secret_iv), 0, 16);
  }

  public function encryptString($data)
  {
    return base64_encode(openssl_encrypt($data, self::AES_256_CBC, $this->_encryption_key, 0, $this->_iv));
  }

  public function decryptString($data)
  {
    return openssl_decrypt(base64_decode($data), self::AES_256_CBC, $this->_encryption_key, 0, $this->_iv);
  }

  public function setEncryptionKey($key)
  {
    $this->_encryption_key = $key;
  }

  public function setInitVector($iv)
  {
    $this->_iv = $iv;
  }
}
