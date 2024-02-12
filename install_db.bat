@echo off
set name_db=shop
echo ќќќќќќќќ! ќ? ќќ ќ ќќќќќќ %name_db% ? ќќќќќќќ, ќќќ ќ?ќ ?ќќќќ ќ ?ќќќќ ќќќќќќ!
echo ќќќ?ќ, ќ? ќ ќќќ ќќќќ ќќќќќ ќќќќќ ќ ќќ %name_db%, ќќќ ќќќќ?ќќќ ќќ?ќќ ?ќќќ 
echo ќќќќќќќ ќ?ќ (Ctrl+C) ќ ?ќќќќ ќќќќќќ ?ќ?ќќ ќќќќќ ќќ.
echo ====================================================================================
echo ќ? 1. ќќќќќќќќ ќќќќќќќ? ќќ %name_db%.
c:\xampp\mysql\bin\mysql -uroot -hlocalhost -vvv -e "DROP DATABASE IF EXISTS %name_db%"
echo ====================================================================================
echo ќ? 2. ќќќќќќќќ ќќќќќ ќќ %name_db%.
c:\xampp\mysql\bin\mysql -uroot -hlocalhost -vvv -e "SET NAMES 'utf8'"
c:\xampp\mysql\bin\mysql -uroot -hlocalhost -vvv -e "CREATE DATABASE %name_db%  CHARACTER SET utf8 COLLATE utf8_general_ci;"
echo ====================================================================================
echo ќ? 3. ќќќќќќ ќќќќќќ ќ ќќ %name_db% ќќ ?ќќ db_shop.sql.
c:\xampp\mysql\bin\mysql -uroot -hlocalhost -vvv %name_db% <db_shop.sql
echo ====================================================================================
echo ќќќќќќ ќ?? ќќќќќ?.
pause