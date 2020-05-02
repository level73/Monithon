<?php
    /** Set Namespaces **/
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    /** Require Classes **/
    /* Exception class. */
    require ROOT . DS . 'lib' .DS . 'vendor' . DS . 'PHPMailer/src/Exception.php';
    /* The main PHPMailer class. */
    require ROOT . DS . 'lib' .DS . 'vendor' . DS . 'PHPMailer/src/PHPMailer.php';
    /* SMTP class, needed if you want to use SMTP. */
    require ROOT . DS . 'lib' .DS . 'vendor' . DS . 'PHPMailer/src/SMTP.php';

    /* Simple Email class to send out emails */
    class Emailer {
        public $Email;

        public function __construct(){
            $this->Email = new PHPMailer(TRUE);

            $mail->isSMTP();
            $this->Email->Host = 'smtp.gmail.com';
            $this->Email->Port = 587;
            $this->Email->SMTPAuth = true;
            $this->Email->SMTPSecure = 'tls';
            $this->Email->Username = APPEMAIL;
            $this->Email->Password = APPEMAIL_PWD;
            $this->Email->isHTML(TRUE);
            $this->Email->setFrom(APPEMAIL, APPEMAIL_NAME);
        }

        public function compose($recipient, $subject, $body){
            $this->Email->addAddress($recipient);
            $this->Email->Subject =  $subject;
            $this->Email->Body = $body;
            $this->Email->AltBody = strip_tags($body);
        }

        public function send($to, $subject, $message){
            try {
                $this->Email->send();
            }
            catch (Exception $e) {
                /* PHPMailer exception. */
                echo $e->errorMessage();
            }
            catch (\Exception $e) {
                /* PHP exception (note the backslash to select the global namespace Exception class). */
                echo $e->getMessage();
            }
        }

    }
