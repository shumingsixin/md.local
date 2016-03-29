<?php

class ErrorList {

    const ERROR_NONE = 0; // 没错误
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIME_OUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUEST_URI_TOO_LARGE = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const AUTH_UNKNOWN_TYPE = 1000;   // 未知 auth_type.
    const AUTH_TOKEN_INVALID = 1001;  // token 不正确.    
    const TOKEN_CREATE_FAILED = 1002;
    const AUTH_USERNAME_INVALID = 1003;
    const AUTH_PASSWORD_INVALID = 1004;
    const BOOKING_NOT_ONWER = 1010;

}
