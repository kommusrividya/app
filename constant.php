
<?php

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//define('DB_SERVER', 'localhost');
define('tDB_SERVER', '43.255.154.9');
define('tDB_USERNAME', 'sandbox_test');
define('tDB_PASSWORD', 'test4db');
define('tDB_NAME', 'urf_sandbox');

/* Attempt to connect to MySQL database */
$link_test = mysqli_connect(tDB_SERVER, tDB_USERNAME, tDB_PASSWORD, tDB_NAME);
// Check connection
if($link_test === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo ("test");
const CLIENT_ID = '3a7f34b8-8b0a-4271-ab7b-be60bc455576';
const CLIENT_SECRET = 'CWx8KQAKJF5I4WzOQZcTWvjmqMSf2qTswZ3pxxDF';

define ('PAYEE_CRUD', 2 ** 0); // 
define ('EXPENSE_CRU', 2 ** 1); // 
define ('EXPENSE_D', 2 ** 2); // 
define ('PERM_CRUD', 2 ** 3); // grant member permissions
define ('PERM_CRUD_ADMIN', 2 ** 4); // set somebody else as admin
define ('MEMBER_C', 2 ** 5); // 
define ('MEMBER_U_ANY', 2 ** 6); // excluding name, email, phone
define ('MEMBER_U_ADMIN', 2 ** 7); // update any member's name, email, phone
define ('MEMBER_D', 2 ** 8); // Member delete, deactivate, status change
define ('ATTEND_CRUD', 2 ** 9); // 
define ('ATTEND_C_ANY', 2 ** 10); // 
define ('RECOGN_CRUD', 2 ** 11); // only for admins
define ('RECOGN_C', 2 ** 12); // 
define ('NBV_CRUD_SELF', 2 ** 13); // 
define ('NBV_CRUD_ANY', 2 ** 14); // 
define ('CONTRIBUTION_REPORTS_ADMIN', 2 ** 15); // Contribution reports of all members
define ('JP_REGN', 2 ** 16); // self, daughter, son
define ('JP_REGN_ANY', 2 ** 17); // 
define ('JP_REPORTS', 2 ** 18); // 
define ('EVENT_CRUD', 2 ** 19); //
define ('T100', 2 ** 20); //MEMBER_C
define ('CASH_DESK_ADD', 2 ** 21);
define ('CASH_DESK_ADMIN', 2 ** 22);
define ('CSV_GENERATE', 2 ** 23);
define ('EVENT_REPORT_ADMIN', 2 ** 24);