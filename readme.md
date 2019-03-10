# Assesment

##### Coding task done as a requirement for the recruitment.

**Installation**

   1. Download / clone the repo.

**Run Task 1**

   1. To get help                      php user_upload.php --help

   2. To create table                  php user_upload.php --create_table -u root -o 8889 -h 127.0.0.1 -d database -p root
       where as username -u , database name -d is required.  

   3. For dry_run                      php user_upload.php --file users.csv -u root  -h 127.0.0.1 -o 8889 -p root -d database --dry_run
       where as filename -f , username -u and  database name -d is required.

   4. For insertion into databse       php user_upload.php --file users.csv -u root  -h 127.0.0.1 -o 8889 -p root -d database
       where as filename -f , username -u and  database name -d is required.


**Run Task 2**      

   php foobar.php