<?php
namespace Crown\Exceptions;
class EmptyPONumberException extends \Exception {
    public function __construct($message = 'The PO number must be assigned to the order.') {
        parent::__construct(__($message, 'woocommerce'));
    }
}