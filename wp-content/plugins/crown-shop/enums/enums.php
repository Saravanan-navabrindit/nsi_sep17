<?php
namespace CrownShop\Enums;

enum DualManagerMode: string {
    case ADMIN = 'admin';
    case SWITCHED_AS_USER = 'switched_as_user';
}

enum LogWooErrorType: string {
    case FATAL = 'fatal-errors';
    case HANDLED_FATAL = 'handled-fatal-errors';
    case NETSUITE_ERRORS = 'netsuite_errors';
}