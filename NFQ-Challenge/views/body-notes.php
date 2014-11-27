<article>
    <header>
        <h1>Notes</h1>
    </header>
    <section>
        <h2>Done</h2>
        <ul>
            <li>Responsive design MVP research and build ("initializr" found, "responsive" build made)</li>
            <li>Php Micro-framework research (tested 5 MF's, found best - FightPhp)</li>
            <li>Created DB Model diagram (DB_MODEL.jpeg)</li>
            <li>Created domain model - sketch (draw-io_NFQ-Domain-Model.jpg)</li>
            <li>DB structure &amp; data setup (MySQL)</li>
            <li>Local domain setup (localhost @ZendServer CE Free + PhpMyAdmin install)</li>
            <li>Remote domain setup (nfq.matuliauskas.lt)</li>
            <li>GitHub repo folder setup</li>
            <li>PhpStorm project setup (.idea)</li>
            <li>Added local files browser (FTPFileBrowser.php)</li>
            <li>Flight /tests/ added (based on PhpUnit)</li>
            <li>Flight /views/ added (based on Routing)</li>
            <li>MySQL PDO (all data is real)</li>
            <li>Configured URL router</li>
            <li>Back-End: Made API - to read calls (commands and data)</li>
            <li>Front-End: Users, user groups are now loaded via remote API [JSON]</li>
            <li>Front-End: JS debugger made (NFQInventoryDebug = true/false;)</li>
            <li>Front-End: JS API call - loading placeholder added ("LOADING..." and CSS3 spinner class [for-future-ref])</li>
        </ul>
    </section>
    <section>
        <h2>To-Do</h2>
        <ul>
            <li>Admin management ("as an admin ...")</li>
            <li>Add/remove users</li>
            <li>Add/remove user groups<br />
                <em>(1 - I
                can
                create
                groups)</em><br />
                <em>(2 - I
                can
                delete
                groups
                when
                they
                no
                longer
                have
                members)</em></li>
            <li>Future: make ORM instead of RAW PDO</li>
            <li>Cross-server API call support: JSONP instead of JSON</li>
        </ul>
    </section>
    <section>
        <h2>API Usage notes</h2>
        <p>[command: "get_users", data: ""], [command:"get_user", data: [id: 1] ]</p>
        <p>Demo 1: <a href="<?php print Flight::get('BASE'); ?>/api/?command=get_users&data=">/api/?command=get_users&data=</a></p>
        <p>Demo 2: <a href="<?php print Flight::get('BASE'); ?>/api/?command=get_groups&data=">/api/?command=get_groups&data=</a></p>
        </section>
</article>

<aside>
    <h3>More links</h3>
    <ul>
        <li><a href="<?php print Flight::get('BASE'); ?>/FTPFileBrowser.php">Local files browser</a></li>
        <li><a href="http://flightphp.com/learn">Learn Flight Php</a></li>
        <li><a href="http://verekia.com/initializr/responsive-template">Learn initializr responsive</a></li>
        <li><a href="<?php print Flight::get('BASE'); ?>/FILES/test.sql">SQL Backup file</a></li>
    </ul>
</aside>
