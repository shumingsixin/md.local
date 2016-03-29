<?php

class SalesManager {

    public function createSalesTransaction(Booking $booking, $paymentMethod, $extRefNo=null) {
        
        $trip=$booking->getTrip();
        //Prepare SalesTransaction.
        $salesTran = new SalesTransaction();
        $salesTran->initModel($booking);

        //Prepare SalesPayment.
        $salesPayment = new SalesPayment();
        $salesPayment->user_id = $salesTran->getUserId();
        $salesPayment->ext_ref_no = $extRefNo;
        $salesPayment->setPaymentMethod($paymentMethod);
        /*
        $salesPayment->billing_amount = $salesTran->getTotalAmount();
        $salesPayment->billing_currency = $salesTran->getCurrency();
        */
        $salesPayment->setBillingAmount($salesTran->getTotalAmount());
        $salesPayment->setBillingCurrency($salesTran->getCurrency());
        $salesPayment->setDescription($trip->getTitle());

        $salesPayment->initModel();


        //Start a new db transaction.
        $dbTran = Yii::app()->db->beginTransaction();
        try {
            //Save SalesTransaction.
            if ($salesTran->save() === false) {
                throw new CException("Error saving sales transaction, receipt no: " . $salesTran->getReferenceNumber());
            }
            //Save SalesPayment.
            $salesPayment->setTranId($salesTran->getId());
            if ($salesPayment->save() === false) {
                $salesTran->addErrors($salesPayment->getErrors());
                throw new CException("Error saving sales payment, receipt no: " . $salesTran->getReferenceNumber());
            }

            $dbTran->commit();
        } catch (CDbException $e) {      var_dump($e);exit;
            $salesTran->addError('error', '操作失败');
            $dbTran->rollback();
            Yii::log("Error occurred while saving sales transaction. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            throw new CHttpException($e->getMessage());
        } catch (CException $e) {
            $salesTran->addError('error', '操作失败');
            $dbTran->rollback();
       
            Yii::log("Error occurred while saving sales transaction. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
            throw new CHttpException($e->getMessage());
        }

        return $salesTran;
    }
    

    public function loadSalesTransactionByReferenceNumber($refNo, $with=null) {
        return ISalesTransaction::model()->getByAttributes(array('reference_no' => $refNo), $with);
    }

    public function getExchangeRateByCurrency($curFrom, $curTo, $checkDate=true){
        return CurrencyExchangeRate::model()->getByCurrency($curFrom, $curTo, $checkDate);
    }
}

