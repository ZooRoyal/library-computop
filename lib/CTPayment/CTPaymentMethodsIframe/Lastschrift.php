<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;
use Fatchip\CTPayment\CTEnums\CTEnumCapture;

abstract class Lastschrift extends CTPaymentMethodIframe
{

  /**
   * Name der XSLT-Datei mit Ihrem individuellen Layout für das Bezahlformular.
   * Wenn Sie das neugestaltete und abwärtskompatible Computop-template nut-zen möchten,
   * übergeben Sie den Templatenamen „ct_compatible“.
   * Wenn Sie das Responsive Computop-template für mobile Endgeräte nutzen möchten,
   * übergeben Sie den Templatenamen „ct_responsive“.
   *
   * @var string
   */
    protected $Template;

    /**
     * Bestimmt Art und Zeitpunkt der Buchung (engl. Capture).
     * AUTO: Buchung so-fort nach Autorisierung (Standardwert).
     * MANUAL: Buchung erfolgt durch den Händler.
     * <Zahl>: Verzögerung in Stunden bis zur Buchung (ganze Zahl; 1 bis 696).
     *
     * @var string
     */
    protected $Capture; //AUTO, MANUAL, ZAHL

    /**
     * Über welchen Dienst wird Lastschrift angebunden`:
     * Direktanbindung
     * EVO Payments
     * Intercard
     *
     * @var
     */
    protected $dienst;

    /**
     * für SEPA: SEPA-Mandatsnummer (Pflicht bei SEPA) sollte eindeutig sein, ist nicht case-sensitive
     *
     * @var string
     */
    protected $MandateID;

    /**
     * für SEPA: Datum der Mandatserteilung im Format DD.MM.YYYY
     * Pflicht bei Übergabe von MandateID
     *
     * @var string
     */
    protected $DtOfSgntr;

    /**
     * Bezeichnung Bank
     * @var string
     */
    protected $AccBank;

    /**
     * Kontoinhaber
     * @var string
     */
    protected $AccOwner;

    /**
     * International Bank Account Number
     *
     * @var string
     */
    protected $IBAN;


    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData,
        $capture
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);


        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);
        $this->setMandateID($this->createMandateID($order->getAmount()));


        if ($config['lastschriftCaption'] == CTEnumCapture::DELAYED && is_numeric($config['lastschriftDelay'])) {
            $this->setCapture($config['lastschriftDelay']);
        } else {
            $this->setCapture($config['lastschriftCaption']);
        }
    }

    /**
     * @param string $capture
     */
    public function setCapture($capture)
    {
        $this->Capture = $capture;
    }

    /**
     * @return string
     */
    public function getCapture()
    {
        return $this->Capture;
    }

    /**
     * @param mixed $dienst
     */
    public function setDienst($dienst)
    {
        $this->dienst = $dienst;
    }

    /**
     * @return mixed
     */
    public function getDienst()
    {
        return $this->dienst;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->Template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->Template;
    }

    /**
     * @param string $mandateID
     */
    public function setMandateID($mandateID)
    {
        $this->MandateID = $mandateID;
        //if we set MandateID, also dtOfSgntr is obligatory
        $this->setDtOfSgntr(date('d-m-Y'));
    }

    /**
     * @return string
     */
    public function getMandateID()
    {
        return $this->MandateID;
    }

    /**
     * @param string $dtOfSgntr
     */
    public function setDtOfSgntr($dtOfSgntr)
    {
        $this->DtOfSgntr = $dtOfSgntr;
    }

    /**
     * @return string
     */
    public function getDtOfSgntr()
    {
        return $this->DtOfSgntr;
    }

    /**
     * @param string $AccBank
     */
    public function setAccBank($AccBank) {
        $this->AccBank = $AccBank;
    }

    /**
     * @return string
     */
    public function getAccBank() {
        return $this->AccBank;
    }

    /**
     * @param string $AccOwner
     */
    public function setAccOwner($AccOwner) {
        $this->AccOwner = $AccOwner;
    }

    /**
     * @return string
     */
    public function getAccOwner() {
        return $this->AccOwner;
    }

    /**
     * @param string $IBAN
     */
    public function setIBAN($IBAN) {
        $this->IBAN = $IBAN;
    }

    /**
     * @return string
     */
    public function getIBAN() {
        return $this->IBAN;
    }



    /**
     * Each ELV payment needs a unique mandateID.
     * For now, it is the ordernumber plus date
     * @param $orderID
     * @return string
     */
    public function createMandateID($orderID)
    {
        return $orderID . date('yzGis');
    }

    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/edddirect.aspx';
    }
}
