<?php

class EmailManager {

    private $view_directory = '//mail/';
    private $email_sender;
    private $view_payment_receipt = 'paymentReceipt';
    private $view_refund = 'refundNotice';

    /*     * ****** Constructor ******* */

    public function __construct() {
        
    }

    /**
     * 支付完成 发送邮件提醒
     * @param type $data
     * @return type
     */
    public function sendEmailSalesOrderPaid($data) {
        $view = 'bookingSalesOrder';
        $booking = $data->booking;
        $order = $data->salesOrder;
        $subject = "【重要】 订单已支付！ - " . $order->refNo . " - " . $booking->mobile;
        $contactName = $booking->patientName;
        if (!empty($contactName)) {
            $subject.= "[" . $contactName . "]";
        }
        $to = array(Yii::app()->params['csadminEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);
        $bodyParams = array();
        $bodyParams['data'] = $data;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    /**
     *  医生修改其擅长病情 发送邮件提醒
     * @param type $model
     * @return type
     */
    public function sendEmailDoctorUpateContract($model) {
        $view = 'doctorContract';
        $doctor = $model->doctorProfile;
        //数据过滤
        $data = new stdClass();
        $data->id = $doctor->id;
        $data->name = $doctor->name;
        $data->mobile = $doctor->mobile;
        $data->dateUpdate = $model->dateUpdated;
        $data->preferredPatient = $doctor->preferred_patient;
        $subject = '【医生擅长疾病';
        if ($model->scenario == 'new') {
            $subject .= '创建】';
            $data->oldPreferredPatient = '无';
        } else {
            $subject .='修改】';
        }
        $subject .= '- ' . $data->name . ' - ' . $data->mobile;
        $data->oldPreferredPatient = $model->oldPreferredPatient;
        $to = array(Yii::app()->params['csadminEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);
        $bodyParams = array();
        $bodyParams['data'] = $data;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    /**
     * 上传医生证明后 发送电邮
     * @param type $model
     */
    public function sendEmailDoctorUploadCert($model) {
        $data = new stdClass();
        $data->id = $model->id;
        $data->name = $model->name;
        $data->mobile = $model->mobile;
        $data->dateUpdate = date('Y-m-d H:i:s');
        $data->message = '该医生上传了医生证明,请尽快审核!';
        $view = "doctorUploadCert";
        $subject = "【上传医生证明】 -" . $data->name . ' - ' . $data->mobile;
        $to = array(Yii::app()->params['csadminEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['data'] = $data;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailDoctorUpdateInfo($model) {
        $view = "doctorUpdateInfo";
        $subject = "【医生信息补全/修改】 -" . $model->name . ' - ' . $model->mobile;
        $to = array(Yii::app()->params['csadminEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);
        $bodyParams = array();
        $bodyParams['data'] = $model;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailDoctorRegister(IDoctor $model) {
        $view = "doctorRegister";
        $subject = "【新的医生注册】 - " . $model->name . ' - ' . $model->mobile;
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $model;

        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailBookingNew($data) {
        $view = 'bookingNew';
        $subject = "【重要】 新的预约 - " . $data->mobile . " - [" . $data->patientName . ']';
        //$subject = "\u3010\u65b0\u7684\u9884\u7ea6\u3011  - " . $data->mobile . " - [" . $data->patientName.']';
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $data;

        //    var_dump($subject);
        //    Yii::app()->controller->render($this->view_directory .$view, array('model'=>$data));
        //    return $this->renderView($view, $bodyParams);
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailQuickBooking(IBooking $model) {
        $view = 'quickBooking';
        // $fName = $model->getFacultyName();
        $subject = "【重要】 新的预约！ [" . $model->mobile . "] ";
        if (isset($model->cName)) {
            $subject.= "[" . $model->cName . "]";
        }
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $model;

        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    /**
     * app 发送新预约邮件
     * @param Booking $model
     * @return int
     */
    public function sendEmailAppBooking(Booking $model) {
        $view = 'appBookingNew';
        $subject = "【重要】 新的预约！ [" . $model->getMobile() . "] ";
        $contactName = $model->getContactName();
        if (!empty($contactName)) {
            $subject.= "[" . $contactName . "]";
        }
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $model;

        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailMrBooking(IMedicalRecordBooking $model) {
        $view = 'mrBooking';
        $subject = '【重要】 新的预约！ [科室： ' . $model->getFacultyName() . ']  [手机： ' . $model->getContactMobile() . ']';
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $model;

        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailEnquiry(ContactEnquiry $model) {
        $view = 'siteEnquiry';
        $subject = '新的快速咨询!!! 来自 - ' . $model->getMobile();
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $model;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendEmailContactUs(Contactus $contactus) {
        $view = 'siteContactUs';
        $subject = '新的联系我们!!! 来自 - ' . $contactus->mobile;
        $to = array(Yii::app()->params['contactEmail']);
        $from = array('noreply@mingyihz.com' => Yii::app()->name);

        $bodyParams = array();
        $bodyParams['model'] = $contactus;
        return $this->sendEmail($from, $to, $subject, $bodyParams, $view);
    }

    public function sendTestEmail(array $recipients, $from = null) {
        // $from = array($this->getAdminSenderEmail()=>'Admin');
        if ($from === null) {
            $from = array('noreply@mingyihz.com' => '名医会诊网');
        }
        $subject = 'Test Email';
        $view = 'testEmail';
        $bodyParams = array();

        return $this->sendEmail($from, $recipients, $subject, $bodyParams, $view);
    }

    /*     * ****** Old Start ******* */

    private function createMessageQueue(EmailTemplate $et, $toEmail, $message) {
        $msgqueue = new MessageQueue();
        $msgqueue->max_attempts = 3;
        $msgqueue->attempts = 0;
        $msgqueue->from_name = $et->getSenderName();
        $msgqueue->from_email = $et->getSenderEmail();
        $msgqueue->subject = $et->getSubject();
        $msgqueue->to_email = $toEmail;
        $msgqueue->message = $message;

        return $msgqueue->save();
    }

    private function renderView($view, $params) {
        return Yii::app()->controller->renderPartial($this->view_directory . $view, $params, true); // Make sure to return true since we want t
    }

    public function createMessageQueueUserRegister(User $user) {
        $emailTemplate = $this->getEmailTemplateByName('User.Register');
        if (isset($emailTemplate)) {
            $toEmail = $user->getEmail();
            $params = array('user' => $user);
            $message = $this->renderView($emailTemplate->getView(), $params);
            return $this->createMessageQueue($emailTemplate, $toEmail, $message);
        }
        return false;
    }

    public function createMessageQueueTripPublish(Trip $trip) {
        $emailTemplate = $this->getEmailTemplateByName('Trip.Publish');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' - ' . $trip->getTitle();
            $user = $trip->getCreator();
            $toEmail = $user->getEmail();
            $params = array('user' => $user, 'trip' => $trip);
            $message = $this->renderView($emailTemplate->getView(), $params);
            return $this->createMessageQueue($emailTemplate, $toEmail, $message);
        }
        return false;
    }

    /**
     * sends email to tourguide after tourist has made a booking.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function createMessageQueueBookingNew(Booking $booking) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.New');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getTourGuide();
            $trip = $booking->getTrip();
            $toEmail = $user->getEmail();
            $params = array('user' => $user, 'booking' => $booking, 'trip' => $trip);
            $message = $this->renderView($emailTemplate->getView(), $params);
            return $this->createMessageQueue($emailTemplate, $toEmail, $message);
        }
        return false;
    }

    public function createMessageQueueBookingConfirmed(Booking $booking) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.Confirm');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getOwner();
            $trip = $booking->getTrip();
            $toEmail = $user->getEmail();
            $params = array('user' => $user, 'booking' => $booking, 'trip' => $trip);
            $message = $this->renderView($emailTemplate->getView(), $params);
            return $this->createMessageQueue($emailTemplate, $toEmail, $message);
        } else
            return 0;
    }

    /**
     * sends email to tourguide after tourist has made a booking.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function sendEmailNewBooking(Booking $booking) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.New');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getTourGuide();
            $trip = $booking->getTrip();
            $to = array($user->getEmail() => $user->getNickname());
            $bodyParams['booking'] = $booking;
            $bodyParams['user'] = $user;
            $bodyParams['trip'] = $trip;

            return $this->sendEmailTemplate($emailTemplate, $to, $bodyParams);
        } else
            return 0;
    }

    /**
     * sends email to tourist after tourguide has confirmed the booking.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function sendEmailBookingConfirmed(Booking $booking) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.Confirm');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getOwner();
            $trip = $booking->getTrip();
            $to = array($user->getEmail() => $user->getNickname());
            $bodyParams['booking'] = $booking;
            $bodyParams['user'] = $user;
            $bodyParams['trip'] = $trip;

            return $this->sendEmailTemplate($emailTemplate, $to, $bodyParams);
        } else
            return 0;
    }

    /**
     * sends email to both tourist and tourguide.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function sendEmailBookingPaid(Booking $booking, $tranRefNo) {
        $count = $this->sendEmailBookingReceipt($booking, $tranRefNo);
        $count+=$this->sendEmailBookingPaidTG($booking, $tranRefNo);

        return $count;
    }

    /**
     * sends email to tourist for the booking payment receipt.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function sendEmailBookingReceipt(Booking $booking, $tranRefNo) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.Receipt');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getOwner();
            $trip = $booking->getTrip();
            $to = array($user->getEmail() => $user->getNickname());
            $bodyParams['booking'] = $booking;
            $bodyParams['user'] = $user;
            $bodyParams['trip'] = $trip;
            $bodyParams['tranRefNo'] = $tranRefNo;
            $emailTemplate->subject .= ' #' . $tranRefNo;
            return $this->sendEmailTemplate($emailTemplate, $to, $bodyParams);
        } else
            return 0;
    }

    /**
     * sends email to tourguide after tourist has paid the booking.
     * @param Booking $booking
     * @return type int no. of emails sent.
     */
    public function sendEmailBookingPaidTG(Booking $booking, $tranRefNo) {
        $emailTemplate = $this->getEmailTemplateByName('Booking.Paid');
        if (isset($emailTemplate)) {
            $emailTemplate->subject.= ' #' . $booking->getReferenceNumber();
            $user = $booking->getTourGuide();
            $trip = $booking->getTrip();
            $to = array($user->getEmail() => $user->getNickname());
            $bodyParams['booking'] = $booking;
            $bodyParams['user'] = $user;
            $bodyParams['trip'] = $trip;
            $bodyParams['tranRefNo'] = $tranRefNo;
            $emailTemplate->subject .= ' #' . $tranRefNo;
            return $this->sendEmailTemplate($emailTemplate, $to, $bodyParams);
        } else
            return 0;
    }

    /*     * ****** Old End ******* */

    public function sendAccountActivateEmail(User $user, $actionLink, $bodyParams = array()) {
        $emailTemplate = $this->getEmailTemplateByName('User.Activate');
        if (isset($emailTemplate)) {
            $recipients = array($user->getEmail());
            $bodyParams['model'] = $user;
            $bodyParams['actionLink'] = $actionLink;

            return $this->sendEmailTemplate($emailTemplate, $recipients, $bodyParams);
        } else
            return 0;
    }

    public function sendEmailPasswordReset(User $user, $actionLink, $bodyParams = array()) {
        $emailTemplate = $this->getEmailTemplateByName('User.PasswordReset');
        if (isset($emailTemplate)) {
            $to = array($user->getEmail());
            $bodyParams['model'] = $user;
            $bodyParams['actionLink'] = $actionLink;

            return $this->sendEmailTemplate($emailTemplate, $to, $bodyParams);
        } else
            return 0;
    }

    private function sendEmailTemplate(EmailTemplate $et, array $recipients, array $bodyParams) {
        return $this->sendEmail($et->getSender(), $recipients, $et->subject, $bodyParams, $et->view);
    }

    private function sendEmail($sender, array $recipients, $subject, $bodyParams, $view) {
        $count = 0;
        $bodyParams['sender'] = $sender;
        try {
            $mail = new YiiMailMessage;
            $mail->view = $view;
            $mail->setSubject($subject);
            $mail->setBody($bodyParams, 'text/html');
            $mail->setFrom($sender);

            foreach ($recipients as $address => $name) {
                if (is_int($address)) {
                    $mail->setTo($name);
                } else {
                    // $mail->addTo($to);
                    $mail->setTo(array($address => $name));
                }
                $count+= Yii::app()->mail->send($mail);
            }
        } catch (Swift_TransportException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            return $count;
        } catch (Swift_RfcComplianceException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);

            return $count;
        }
        return $count;
    }

    public function sendEmailMessageQueue(MessageQueue $msgqueue) {
        $message = new YiiMailMessage();
        $message->setTo($msgqueue->to_email);
        $message->setFrom(array($msgqueue->from_email => $msgqueue->from_name));
        $message->setSubject($msgqueue->subject);
        $message->setBody($msgqueue->message, 'text/html');
        return $this->sendMailMessage($message) === 1;
    }

    public function getEmailTemplateByName($name) {
        return EmailTemplate::model()->getByName($name);
    }

    /**
     * Sends an email to the user.
     * This methods expects a complete message that includes to, from, subject, and body
     *
     * @param YiiMailMessage $message the message to be sent to the user
     *  @return integer returns 1 if the message was sent successfully or 0 if unsuccessful
     */
    private function sendMailMessage(YiiMailMessage $message) {
        $count = 0;
        try {
            $count = Yii::app()->mail->send($message);
        } catch (Swift_TransportException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        } catch (Swift_RfcComplianceException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        }
        return $count;
    }

}
