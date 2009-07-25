<?php
$CS_DB_HOST = "localhost";
$CS_DB_NAME = "crosswordsaver";
$CS_DB_UN = "root";
$CS_DB_PW = "";
$CONCEAL_ANS = 0;
$LOGGING = 0;
$LOG4PHP_DIR = "../Log4PHP/src/log4php/";
 if( !defined( 'CS_DB_HOST' ) ){
  define('CS_DB_HOST', 'localhost');
 }
 if( !defined( 'CS_DB_NAME' ) ){
  define('CS_DB_NAME', 'crosswordsaver');
 }
 if( !defined( 'CS_DB_UN' ) ){
  define('CS_DB_UN', 'root');
 }
 if( !defined( 'CS_DB_PW' ) ){
  define('CS_DB_PW', '');
 }
 if( !defined( 'CONCEAL_ANS' ) ){
  define('CONCEAL_ANS', '0');
 }
 if( !defined( 'LOGGING' ) ){
  define('LOGGING', '0');
 }
 if( !defined( 'LOG4PHP_DIR' ) ){
  define('LOG4PHP_DIR', '../Log4PHP/src/log4php/');
 }

?>