<?php
    
namespace Api\Core;

/**
 * Class for declaring systemwide constant values
 */
class Constants{
    
    public static $_DATABASE_TABLE_ACCESS_TOKENS = "access_tokens";
    public static $_DATABASE_TABLE_SAMPLES = "samples";
    public static $_DATABASE_TABLE_USERS = "users";
    
    public static $_DATABASE_DATA_TYPE_INTEGER = "i";
    public static $_DATABASE_DATA_TYPE_STRING = "s";
    public static $_DATABASE_DATA_TYPE_BOOLEAN = "i";
    public static $_DATABASE_DATA_TYPE_DOUBLE = "d";
    
    public static $_USER_ACCOUNT_TYPE_ADMIN = "admin";
    public static $_USER_ACCOUNT_TYPE_USER = "user";
    public static $_USER_ACCOUNT_TYPE_GUEST = "guest";
    
    public static $_USER_PASSWORD_UPDATE_MAX_TRIES = 3;
    public static $_USER_LOGIN_MAX_TRIES = 3;
    
    public static $_DEFAULT_RESULTS_PER_PAGE = 30;
    public static $_DEFAULT_RESULTS_PER_PAGE_SAMPLES = 20;
    
    public static $_OPERATION_ERROR = 0;
    public static $_OPERATION_SUCCESS = 1;

}
