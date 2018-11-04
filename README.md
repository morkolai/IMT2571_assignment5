
# Assignment 5
>IMT2571

## short explination

The XMLSkierLogs.php goes through the SkierLogs.xml and reads the data into the 
php-file's data structure. For moving around in the DOM-tree, I use xPath queries to 
sort out the specific list of nodes I want to work on. Then I use for-loops to move 
through the list and access the data I want through childNodes or attributes. I use 
item() to precisely pick out data. This is fragile and requiers no devation in the 
xml-file. I could make the code more robust with some if-statements, but for sake of
simplisity I avoided it.


## todo

Part I
- [x] Run xPath queries

Part II
- [x] Set up codeception
- [x] Implement Assignment5Test.php/TestOneYearlyDistance()
- [x] Implement Assignment5Test.php/TestOneYearlyDistance()

Part III
- [x] Implement XMLSkierLogs.php/getClubs()
- [x] Implement XMLSkierLogs.php/getSkiers()
- [x] Extend XMLSkierLogs.php/getSkiers() to get all affiliations
- [x] Extend XMLSkierLogs.php/getSkiers() to compute and retreve yearly distance