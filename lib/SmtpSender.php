<?
// $Id$
/**
 * SMTP Sender
 * 
 */
class SmtpSender{
  var $_smtp_server = '';
  var $_mail_from   = '';
  var $_sender      = '';
  var $_subject     = '';
  var $_to_array    = array();
  var $_cc_array    = array();
  var $_bcc_array   = array();
  var $_options     = array();
  var $x_mailer     = 'my_smtp_class';
  var $isError      = false;
  var $error        = array();
  /**
   * constructor
   * 
   * @param string $smtp_server 使用するSMTPサーバ。
   *                            任意。指定がない場合、php.iniの'SMTP'を使用する
   * @param array $options オプション。連想配列形式で、メールヘッダの内容を指定可能
   * @return object 
  */
  function SmtpSender($smtp_server, $option){
    $this->_smtp_server = $smtp_server;
    ini_set("SMTP", $this->_smtp_server);
    if (isset($option['To'])) {
      $this->setTo($option['To']);
    }
    if (isset( $option['From'])) {
      $this->setFrom($option['From']);
    }
    if (isset($option['Cc'])) {
      $this->setCc($option['Cc']);
    }
    if (isset($option['Bcc'])) {
      $this->setBcc($option['Bcc']);
    }
    if (isset($option['Sender'])) {
      $this->setSender($option['Sender']);
    }
    if (isset($option['Subject'])) {
      $this->setSubject($option['Subject']);
    }
    if (isset($option['Header'])){
      foreach ($option['Header'] as $key => $val) {
        $this->setHeader($key, $val);
      }
    }
  }
  
  /**
   * Set TO field
   * 
   * @param string $to Toアドレスを設定する。
   *                   無指定、またはnullを指定すると初期化する
  */
  function setTo($to = null) {
    if (is_null($to)) {
      $this->_to_array = array();
    } else {
      if (is_array($to)) {
        $_to = join(',', $to);
      } else {
        $_to = $to;
      }
      $this->_to_array += preg_split('/,/', $_to);
    }
  }
  /**
   * Get to field
   * 
   * @return string 設定済みToフィールドの値
  */
  function getTo() {
    return join(', ', $this->_to_array);
  }

  /**
   * Set CC field
   * 
   * @param string $to Toアドレスを設定する。
   *                   無指定、またはnullを指定すると初期化する
  */
  function setCc($cc = null) {
    if (is_null($cc)) {
      $this->_cc_array = array();
    } else {
      if (is_array($cc)) {
        $_cc = join(',', $cc);
      } else {
        $_cc = $cc;
      }
      $this->_cc_array += preg_split('/,/', $_cc);
    }
  }
  /**
   * Get to field
   * 
   * @return string 設定済みToフィールドの値
  */
  function getCc() {
    return join(', ', $this->_cc_array);
  }

  /**
   * Set BCC field
   * 
   * @param string $bcc BCCアドレスを設定する。
   *                   無指定、またはnullを指定すると初期化する
  */
  function setBcc($bcc = null) {
    if (is_null($bcc)) {
      $this->_bcc_array = array();
    } else {
      if (is_array($bcc)) {
        $_bcc = join(',', $bcc);
      } else {
        $_bcc = $bcc;
      }
      $this->_bcc_array += preg_split('/,/', $_bcc);
    }
  }
  /**
   * Get BCC field
   * 
   * @return string 設定済みToフィールドの値
  */
  function getBcc() {
    return join(', ', $this->_bcc_array);
  }
  
  /**
   * Set From field
   * 
   * @param string $from Fromアドレスを設定する。
   *                   無指定、またはnullを指定すると初期化する
  */
  function setFrom($from = null) {
    if (is_null($from)) {
      $this->_mail_from = null;
    } else {
      $this->_mail_from = $from;
    }
  }
  /**
   * Get From field
   * 
   * @return string 設定済みFromフィールドの値
  */
  function getFrom() {
    return $this->_mail_from;
  }

  /**
   * Set ENVELOPE From
   * 
   * @param string $sender envelope Fromアドレスを設定する。
   *
  */
  function setSender($sender = null) {
    if (is_null($sender)) {
      $this->_sender = null;
    } else {
      $this->_sender = $sender;
    }
  }
  /**
   * Get ENVELOPE From
   * 
   * @return string 設定済み envelope Fromアドレスの値
  */
  function getSender() {
    return $this->_sender;
  }
  
  /**
   * Set Sebject
   * 
   * @param string $subject メールの件名を指定
   *
  */
  function setSubject($subject = null) {
    if (is_null($subject)) {
      $this->_subject = null;
    } else {
      $this->_subject = $subject;
    }
  }
  /**
   * Get Subject
   * 
   * @return string 設定済みの件名を取得
  */
  function getSubject() {
    return $this->_subject;
  }
  
  /**
   * Set Header
   * 
   * @param string $name ヘッダフィールド名
   * @param string $vavalue ヘッダフィールド値
   *
  */
  function setHeader($name, $value = null) {
    if (is_null($value)) {
      unset($this->_options[$name]);
    } else {
      $this->_options[$name] = $value;
    }
  }
  
  /**
   * Get Header
   * 
   * @param string $name ヘッダフィールド名
   *
   * @return string 設定済みのヘッダフィールド値を取得
   *                指定された名前のヘッダフィールに値が設定されていない場合はnull値を返却
   *         array  $name無指定の場合は、ヘッダフィールド全体を連想配列として返却
  */
  function getHeader($name = null) {
    if (is_null($value)) {
      return $this->_options;
    } else if (isset($this->_options[$name])) {
      return $this->_options[$name];
    } else {
      return null;
    }
  }

  /**
   * Send Mail
   * 
   * @param string $message メール本文
   *
   * @return bool 送信に成功した場合true。失敗した場合にfalseを返却
  */
  function sendMail($message){
    $to_count = count($this->_to_array) + count($this->_cc_array) + count($this->_bcc_array);
    if (! $to_count){
      $this->isError = true;
      $this->error['ErrorMessage'] = 'no rcpt_to error.';
      return false;
    }
    $message = preg_replace("/\n/", "\r\n", $message);
    if (! $this->_sender){ $this->_sender = $this->_mail_from; }
    $connect = fsockopen (ini_get("SMTP"), 25, $errno, $errstr, 30);
    if( !$connect ){
      $this->isError = true;
      $this->error['ErrorMessage'] = $errstr;
      $this->error['ErrorCode']    = $errno;
      return false;
    }
    $rcv = fgets($connect, 1024);
    fputs ($connect, "HELO " . getenv('HOSTNAME') ."\r\n");
    fputs ($connect, "MAIL FROM:".$this->_sender."\r\n");
    $rcv = fgets ($connect, 1024);
    //RCPT TO
    $to_array = array_merge($this->_to_array, $this->_cc_array, $this->_bcc_array);
    foreach($to_array as $rcptTo) {
      if($rcptTo){
        fputs ($connect, "RCPT TO:$rcptTo\r\n");
        $rcv = fgets ($connect, 1024);
      }
    }
    fputs ($connect, "DATA\n");
    $rcv = fgets ($connect, 1024);
    $this->_subject = mb_convert_encoding(mb_convert_kana($this->_subject, 'KV'), "iso-2022-jp", "UTF8");
    fputs ($connect, "Subject: =?ISO-2022-JP?B?". base64_encode($this->_subject) . "?=\r\n" );
    fputs ($connect, "From: ".$this->_mail_from."\r\n" );
    if(count($this->_to_array) > 0){fputs ($connect, "To: ". join(", ",$this->_to_array) . "\r\n" );}
    if(count($this->_cc_array) > 0){fputs ($connect, "Cc: ". join(", ",$this->_cc_array) . "\r\n" );}
    fputs ($connect, "Date: " . date ("r") . "\r\n");
    fputs ($connect, "Content-type: text/plain; charset=\"ISO-2022-JP\"\r\n");
    fputs ($connect, "Content-Transfer-Encoding: 7bit\r\n");
    fputs ($connect, "MIME-Version: 1.0\r\n");
    foreach( $this->_options as $_key=>$_val ){
      fputs ($connect, "$_key: $_val\r\n");
    }
    fputs ($connect, "\r\n" );
    fputs ($connect, mb_convert_encoding(mb_convert_kana($message, 'KV') . "\r\n", "iso-2022-jp", "UTF8"));
    fputs ($connect, ".\r\n");
    $rcv = fgets ($connect, 1024);
    fputs ($connect, "QUIT\n");
    $rcv = fgets ($connect, 1024);
    fclose($connect);
    return( true );
  }
}
