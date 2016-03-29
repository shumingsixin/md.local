<?php

class IMrBookingPayment extends EViewModel {

    public $id;
    public $ref;
    public $status;
    public $payMethod;
    public $billAmount;
    public $billDate;
    public $paidAmount;
    public $paidDate;
    public $subject;
    public $desc;
    public $errorCode;
    public $errorMsg;
    public $buyer;       //IUser.
    public $booking;    //IMedicalRecordBooking.

    public function initModel(MrBookingPayment $payment) {
        $this->id = $payment->getId();
        $this->ref = $payment->getUID();
        $this->status = $payment->getStatus();
        $this->payMethod = $payment->getPayMethod();
        $this->billAmount = $payment->getBillAmount();
        $this->billDate = $payment->getBillDate();
        $this->paidAmount = $payment->getPaidAmount();
        $this->paidDate = $payment->getPaidDate();
        $this->subject = $payment->getSubject();
        $this->desc = $payment->getDescription();
        $this->errorCode = $payment->getErrorCode();
        $this->errorMsg = $payment->getErrorMsg();
        /*
          $user = $payment->getUser();
          if (isset($user)) {
          $iuser = new IUser();
          $iuser->initModel($user);
          $this->buyer = $iuser;
          }

          $booking = $payment->getBooking();
          if (isset($booking)) {
          $ibooking = new IMedicalRecordBooking();
          $ibooking->initModel($booking);
          $this->booking = $ibooking;
          }
         * 
         */
    }

    public function setBuyer($user) {
        if ($user instanceof User) {
            $iuser = new IUser();
            $iuser->initModel($user);
            $this->buyer = $iuser;
        } elseif ($user instanceof IUser) {
            $this->buyer = $user;
        }
    }

    public function setBooking($booking) {
        if ($booking instanceof MedicalRecordBooking) {
            $ibooking = new IMedicalRecordBooking();
            $ibooking->initModel($booking);
            $this->booking = $ibooking;
        } elseif ($booking instanceof IMedicalRecordBooking) {
            $this->booking = $booking;
        }
    }

    public function getRef() {
        return $this->ref;
    }

    public function getStatus() {
        return $this->status();
    }

    public function getPayMethod() {
        return $this->payMethod;
    }

    public function getPaidAmount() {
        return $this->paidAmount;
    }

    public function getPaidDate() {
        return $this->paidDate;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getDescription() {
        return $this->desc;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }

}
