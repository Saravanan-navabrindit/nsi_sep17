<?php
namespace Crown\Exceptions;
class DuplicatePONumberException extends \Exception {
    public function __construct($message = 'The PO number must be unique for this customer.') {
        parent::__construct(__($message, 'woocommerce'));
    }
}